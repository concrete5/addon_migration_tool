<?php
namespace PortlandLabs\Concrete5\MigrationTool\Exporter\Item\SearchResult;

defined('C5_EXECUTE') or die("Access Denied.");

interface FormatterInterface
{
    public function hasSearchForm();
    public function hasSearchResults();
    public function displaySearchForm();
    public function getRequest();
    public function displaySearchResults();
    public function displayBatchResults();
}
