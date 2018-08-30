<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Queue;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;

class QueueFactory
{

    public function getMapperQueue(Batch $batch)
    {
        $identifier = sprintf('target-item-processor/%s', $batch->getId());
        return new MapperQueue($identifier);
    }

    public function getTransformerQueue(Batch $batch)
    {
        $identifier = sprintf('untransformed-item-processor/%s', $batch->getId());
        return new TransformerQueue($identifier);
    }

    public function getPublisherQueue(Batch $batch)
    {
        $identifier = sprintf('publisher-routine-processor/%s', $batch->getId());
        return new PublisherQueue($identifier);
    }

    public function getActiveQueue(Batch $batch)
    {
        $queue = $this->getMapperQueue($batch);
        if ($queue->count() >0 ) {
            return $queue;
        }
        $queue = $this->getTransformerQueue($batch);
        if ($queue->count() >0 ) {
            return $queue;
        }
        $queue = $this->getPublisherQueue($batch);
        if ($queue->count() >0 ) {
            return $queue;
        }
        return null;
    }

}