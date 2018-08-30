<?php
namespace PortlandLabs\Concrete5\MigrationTool\Exporter\Item\SearchResult;

use Concrete\Core\Foundation\Environment;
use PortlandLabs\Concrete5\MigrationTool\Entity\Export\Batch;
use Symfony\Component\HttpFoundation\Request;

defined('C5_EXECUTE') or die("Access Denied.");

class StandardFormatter implements FormatterInterface
{
    protected $itemType;
    protected $batch;
    protected $collection;
    protected $request;

    public function __construct(StandardFormatterTypeInterface $type, Batch $batch)
    {
        $this->itemType = $type;
        $this->batch = $batch;
        $this->collection = $this->batch->getObjectCollection($type->getHandle());
        $this->request = Request::createFromGlobals();
    }

    /**
     * @return mixed
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @param mixed $request
     */
    public function setRequest(Request $request)
    {
        $this->request = $request;
    }

    public function hasSearchForm()
    {
        $env = Environment::get();
        $rec = $env->getRecord(
            DIRNAME_ELEMENTS . '/export/search/' . $this->itemType->getHandle() . '.php',
            'migration_tool');

        return $rec->exists();
    }

    public function hasSearchResults()
    {
        if (!is_object($this->getRequest())) {
            throw new \RuntimeException(t('Request must be passed to the StandardFormatter'));
        }

        if (!$this->hasSearchForm()) {
            return true;
        } elseif ($this->getRequest()->query->has('search_form_submit')) {
            return true;
        }
    }

    public function displaySearchForm()
    {
        echo \View::element('export/search/' . $this->itemType->getHandle(), array(
            'formatter' => $this,
            'batch' => $this->batch,
            'collection' => $this->collection,
            'type' => $this->itemType,
        ), 'migration_tool');
    }

    public function displayBatchResults()
    {
        echo \View::element('export/results/standard_list', array(
            'formatter' => $this,
            'batch' => $this->batch,
            'collection' => $this->collection,
            'mode' => 'results',
            'type' => $this->itemType,
            'headers' => $this->itemType->getHeaders(),
            'results' => $this->collection->getItems(),
        ), 'migration_tool');
    }

    public function displaySearchResults()
    {
        echo \View::element('export/results/standard_list', array(
            'formatter' => $this,
            'batch' => $this->batch,
            'collection' => $this->collection,
            'mode' => 'search',
            'type' => $this->itemType,
            'headers' => $this->itemType->getHeaders(),
            'results' => $this->itemType->getResults($this->getRequest()),
        ), 'migration_tool');
    }
}
