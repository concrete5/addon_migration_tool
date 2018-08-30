<?php
namespace PortlandLabs\Concrete5\MigrationTool\Importer\Wordpress\Element;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Area;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Block;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageObjectCollection;
use PortlandLabs\Concrete5\MigrationTool\Importer\Sanitizer\PagePathSanitizer;
use PortlandLabs\Concrete5\MigrationTool\Importer\Wordpress\ElementParserInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class Page implements ElementParserInterface
{
    private $simplexml;
    private $namespaces;

    public function __construct()
    {
        $this->blockImporter = \Core::make('migration/manager/import/wordpress_block');
    }

    public function getObjectCollection(\SimpleXMLElement $element, array $namespaces)
    {
        $this->simplexml = $element;
        $this->namespaces = $namespaces;

        $collection = new PageObjectCollection();
        $pages = $this->createParentPages();
        foreach ($this->getPageNodes() as $node) {
            $pages[] = $this->parsePage($node);
        }

        // Order pages by its path so parent pages are created first
        usort($pages, array($this, 'comparePath'));

        $i = 0;
        foreach ($pages as $page) {
            $page->setPosition($i);
            ++$i;
            $collection->getPages()->add($page);
            $page->setCollection($collection);

            // Do not Normalize path when processing the batch later on
            $page->setNormalizePath(false);
        }

        return $collection;
    }

    public function getPageNodes()
    {
        $pages = array();
        foreach ($this->simplexml->channel->item as $item) {
            $pageType = $this->getPageType($item);
            if ($pageType == 'page' || $pageType == 'blog_entry') {
                $pages[] = $item;
            }
        }

        return $pages;
    }

    private function getItemType(\SimpleXMLElement $node)
    {
        $wp = $node->children($this->namespaces['wp']);

        return (string) $wp->post_type;
    }

    private function getPageType($node)
    {
        $itemType = $this->getItemType($node);

        switch ($itemType) {
            case 'post':
                $pageType = 'blog_entry';
                break;
            case 'page':
                $pageType = 'page';
                break;
        }

        return isset($pageType) ? $pageType : $itemType;
    }

    protected function parsePage($node)
    {
        $pageType = $this->getPageType($node);

        $page = new \PortlandLabs\Concrete5\MigrationTool\Entity\Import\Page();
        $page->setName((string) html_entity_decode($node->title));
        $page->setPublicDate((string) $node->xpath('wp:post_date_gmt')[0]);
        $page->setDescription((string) html_entity_decode($node->description));
        $page->setType($pageType);
        $page->setTemplate('blank');

        $page->setOriginalPath($this->createOriginalPath($node));
        $page->setBatchPath($this->createBatchPath($page->getOriginalPath(), $pageType));

//        $page->setUser($this->getUser($node));
        // TODO remove temporary user assignment
        $page->setUser('admin');

        $area = $this->parseArea($node);
        $area->setPage($page);
        $page->areas->add($area);

        return $page;
    }

    private function createOriginalPath($node)
    {
        $path = parse_url($node->link, PHP_URL_PATH);
        $path = rtrim($path, '/');

        if (!$path) {
            // TODO create validation warning on items that have a generated path
            $path = '/imported-item-without-original-path-' . (string) $node->xpath('wp:post_id')[0];
        }

        return strtolower($path);
    }

    private function createBatchPath($originalPath, $pageType)
    {
        $sanitizer = new PagePathSanitizer();
        $originalPath = $sanitizer->sanitize($originalPath);
        $URIParts = explode('/', $originalPath);
        $URIParts = array_filter($URIParts);

        if ($pageType == 'blog_entry') {
            $batchPath = '/posts/' . end($URIParts);
        } elseif ($pageType == 'page') {
            // TODO construct the page path looking at the <wp:post_parent> link + the current item's name
            $batchPath = '/pages' . $originalPath;
        }

        return $batchPath;
    }

    private function createParentPages()
    {
        $pages = array();
        $parentPages = array(
            'posts' => 'Posts',
            'pages' => 'Pages',
        );

        foreach ($parentPages as $parentPagePath => $parentPageName) {
            $page = new \PortlandLabs\Concrete5\MigrationTool\Entity\Import\Page();
            $page->setName('Wordpress ' . $parentPageName . ' (Auto-generated)');
            $page->setDescription('Auto-generated parent page to hold Wordpress ' . $parentPageName);
            $page->setPublicDate(date('Y-m-d H:i:s'));
            $page->setType('page');
            $page->setOriginalPath('/' . $parentPagePath);
            $page->setBatchPath('/' . $parentPagePath);
            $page->setTemplate('blank');
            $page->setUser('admin');
            $pages[] = $page;
        }

        return $pages;
    }

    private function comparePath($a, $b)
    {
        return strcmp($a->getBatchPath(), $b->getBatchPath());
    }

    private function getUser(\SimpleXMLElement $node)
    {
        $dc = $node->children('http://purl.org/dc/elements/1.1/');

        return (string) $dc->creator;
    }

    private function parseArea($node)
    {
        $area = new Area();
        $area->setName('Main');

        $block = $this->parseBlocks($node);
        $block->setArea($area);
        $area->blocks->add($block);

        return $area;
    }

    private function parseBlocks($node)
    {
        // TODO parse content, detect other blocks and create them
        $block = new Block();
        $block->setType('Content');
        $block->setName('Content');
        $value = $this->blockImporter->driver('unmapped')->parse($node);
        $block->setBlockValue($value);
        $block->setPosition(1);

        return $block;
    }
}
