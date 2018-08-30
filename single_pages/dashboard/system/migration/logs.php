<?php

defined('C5_EXECUTE') or die("Access Denied.");

/**
 * @var $list \PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\LogList
 */

$dateHelper = new \Concrete\Core\Localization\Service\Date();
?>

<?php if (count($results)) { ?>

<div class="ccm-dashboard-content-full">
    <div data-search-element="results">
        <div class="table-responsive">
            <table id="ccm-conversation-messages" class="ccm-search-results-table">
                <thead>
                <tr>
                    <th class="<?=$list->getSortClassName('l.batch_name')?>"><a href="<?=$list->getSortURL('l.batch_name', 'asc')?>"><?=t('Batch Name')?></a></th>
                    <th class="<?=$list->getSortClassName('l.date_started')?>"><a href="<?=$list->getSortURL('l.date_started', 'desc')?>"><?=t('Date Started')?></a></th>
                    <th class="<?=$list->getSortClassName('l.date_completed')?>"><a href="<?=$list->getSortURL('l.date_completed', 'desc')?>"><?=t('Date Completed')?></a></th>
                    <th><span><?=t('Site')?></span></th>
                    <th><span><?=t('User')?></span></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($results as $log) {
                    ?>
                    <tr data-details-url="<?=$view->action('view_log', $log->getID())?>">
                        <td><?=$log->getBatchName() ? $log->getBatchName() : t('None') ?></td>
                        <td><?=$log->getDateStarted() ? $dateHelper->formatDateTime($log->getDateStarted(), 'long') : t('N/A') ?></td>
                        <td><?=$log->getDateCompleted() ? $dateHelper->formatDateTime($log->getDateCompleted(), 'long') : t('N/A') ?></td>
                        <td><?=$log->getSite() ? $log->getSite()->getSiteName() : t('N/A') ?></td>
                        <td><?=$log->getUser() ? $log->getUser()->getUserName() : t('N/A') ?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php } else { ?>

    <p><?=t('There are no batch publishing logs.')?></p>

<?php } ?>
