<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Logger;

use Concrete\Core\Search\ItemList\EntityItemList;
use Concrete\Core\Search\Pagination\Pagination;
use Doctrine\ORM\EntityManagerInterface;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use PortlandLabs\Concrete5\MigrationTool\Entity\Publisher\Log\Log;

defined('C5_EXECUTE') or die("Access Denied.");

class LogList extends EntityItemList
{

    protected $entityManager;
    protected $itemsPerPage = 50;
    protected $autoSortColumns = ['l.date_started', 'l.date_completed', 'l.batch_name'];

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        parent::__construct();
        $this->sortBy('l.date_started', 'desc');
    }

    public function getEntityManager()
    {
        return $this->entityManager;
    }

    public function createQuery()
    {
        $this->query->select('l')->from(Log::class, 'l')
            ->join('l.site', 's')
            ->join('l.user', 'u');
    }

    public function getResult($result)
    {
        return $result;
    }

    protected function createPaginationObject()
    {
        $adapter = new DoctrineORMAdapter($this->query, function ($query) {
            $query->select('count(distinct l.id)')->setMaxResults(1);
        });
        $pagination = new Pagination($this, $adapter);
        return $pagination;
    }

    public function getTotalResults()
    {
        return $this->query->select('count(distinct l.jID)')->setMaxResults(1)->execute()->fetchColumn();
    }


}
