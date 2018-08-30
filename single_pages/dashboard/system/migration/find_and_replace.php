<?php defined('C5_EXECUTE') or die("Access Denied.");
$dh = Core::make('helper/date');
/* @var \Concrete\Core\Localization\Service\Date $dh */

?>
    <div class="ccm-dashboard-header-buttons">
        <a href="<?=$view->action('view_batch', $batch->getID())?>" class="btn btn-default"><i class="fa fa-angle-double-left"></i> <?=t('Back to Batch')?></a>
    </div>


    <h2><?=t('Batch')?>
        <small><?=$dh->formatDateTime($batch->getDate(), true)?></small></h2>
