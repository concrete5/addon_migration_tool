<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher;

interface PublishableInterface
{
    public function getPublisherValidator();
    public function getCollection();
}
