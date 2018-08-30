<?php
namespace PortlandLabs\Concrete5\MigrationTool\Importer\Sanitizer;

defined('C5_EXECUTE') or die("Access Denied.");

class PagePathSanitizer
{
    public function sanitize($path)
    {
        $parts = explode('/', $path);
        $full = '';
        foreach ($parts as $part) {
            $txt = \Core::make('helper/text');
            $part = $txt->slugSafeString($part);
            $part = str_replace('-', \Config::get('concrete.seo.page_path_separator'), $part);
            $full .= $part . '/';
        }

        return rtrim($full, '/');
    }
}
