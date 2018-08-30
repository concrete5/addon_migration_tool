<?php
$queueIdentifier = t('Unknown');
$activeQueueTitle = '';
if ($queue instanceof \PortlandLabs\Concrete5\MigrationTool\Batch\Queue\PublisherQueue) {
    $queueIdentifier = t('publishing');
    $activeQueueTitle = t('Publishing Content...');
    $activeQueueAction = 'create_content_from_batch';
} else if ($queue instanceof \PortlandLabs\Concrete5\MigrationTool\Batch\Queue\TransformerQueue) {
    $queueIdentifier = t('transforming');
    $activeQueueTitle = t('Transforming Content Types...');
    $activeQueueAction = 'run_batch_content_transform_content_types_task';
} else if ($queue instanceof \PortlandLabs\Concrete5\MigrationTool\Batch\Queue\MapperQueue) {
    $queueIdentifier = t('mapping');
    $activeQueueTitle = t('Mapping Content Types...');
    $activeQueueAction = 'run_batch_content_map_content_types_task';
}
?>

<h3><?=t('Status')?></h3>
<div class="alert alert-warning" style="text-align: center">
    <i class="fa fa-2x fa-exclamation-triangle"></i>
    <p class="lead"><?=t('The %s process has been started for this batch.', $queueIdentifier)?></p>
    <p><?=t('If you started this process, and accidentally left the page you may continue it or reset it.<br/>If someone else started this process, resetting it could impact their work or the site – use caution.')?></p>
</div>


<?php if ($activeQueueAction) { ?>

<script type="text/javascript">
    launchActiveQueue = function() {
        ccm_triggerProgressiveOperation(
            '<?=$view->action($activeQueueAction)?>',
            [
                {'name': 'id', 'value': '<?=$batch->getID()?>'},
                {'name': 'ccm_token', 'value': '<?=Core::make('token')->generate($activeQueueAction)?>'}
            ],
            '<?=$activeQueueTitle?>',
            function () {
                window.location.reload()
            }
        );
    }
</script>

<?php } ?>