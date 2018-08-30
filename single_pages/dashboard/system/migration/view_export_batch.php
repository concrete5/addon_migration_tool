<?php defined('C5_EXECUTE') or die("Access Denied.");
$dh = Core::make('helper/date');
/* @var \Concrete\Core\Localization\Service\Date $dh */
?>
<div class="ccm-dashboard-header-buttons">
<div class="btn-group" role="group">
    <a href="<?=$view->action('add_to_batch', $batch->getId())?>" class="btn btn-default"><?=t("Add Content to Batch")?></a>
    <button data-action="remove-from-batch" disabled class="btn btn-default"><?=t('Remove Selected')?></button>
    <a href="<?=$view->action('export_batch', $batch->getId())?>" class="btn btn-primary"><?=t("Export Batch")?></a>
    <a href="javascript:void(0)" data-dialog="delete-batch" data-dialog-title="<?=t('Delete Batch')?>" class="btn btn-danger"><?=t("Delete Batch")?></a>
</div>
</div>

<div style="display: none">

    <div data-dialog-wrapper="delete-batch"">
    <div id="ccm-dialog-delete-batch" class="ccm-ui">
        <form method="post" action="<?=$view->action('delete_batch')?>">
            <?=Loader::helper("validation/token")->output('delete_batch')?>
            <input type="hidden" name="id" value="<?=$batch->getID()?>">
            <p><?=t('Are you sure you want to delete this export batch? This cannot be undone.')?></p>
            <div class="dialog-buttons">
                <button class="btn btn-default pull-left" onclick="jQuery.fn.dialog.closeTop()"><?=t('Cancel')?></button>
                <button class="btn btn-danger pull-right" onclick="$('#ccm-dialog-delete-batch form').submit()"><?=t('Delete Batch')?></button>
            </div>
        </form>
    </div></div>

</div>


<?php if ($batch) {
    ?>

    <h2><?=t('Batch')?>
        <small><?=$dh->formatDateTime($batch->getDate(), true)?></small></h2>

    <h3><?=t('Name')?></h3>

    <?php if ($batch->getName()) {
    ?>
        <p><?=$batch->getName()?></p>
    <?php 
} else {
    ?>
        <p><?=t('None')?></p>
    <?php } ?>

    <?php if ($batch->hasRecords()) {
    ?>

        <form method="post" action="<?=$view->action('remove_batch_items')?>" data-form="remove-batch-items">
            <?=$token->output('remove_batch_items')?>
            <?=$form->hidden('batch_id', $batch->getId())?>


            <?php foreach ($batch->getObjectCollections() as $collection) {
    if ($collection->hasRecords()) {
        $itemType = $collection->getItemTypeObject();
        $formatter = $itemType->getResultsFormatter($batch);
        ?>

                    <h3><?=$itemType->getPluralDisplayName()?></h3>
                    <?php echo $formatter->displayBatchResults()?>
                <?php 
    }
    ?>
            <?php 
}
    ?>

        </form>

    <?php

} else {
    ?>
        <p><?=t('This export batch is empty.')?></p>
    <?php 
}
    ?>

<?php 
} ?>



<script type="text/javascript">
    $(function() {
        $('input[data-action=select-all]').on('click', function() {
            if ($(this).is(':checked')) {
                $(this).closest('table').find('tbody input[type=checkbox]:enabled').prop('checked', true);
            } else {
                $(this).closest('table').find('tbody input[type=checkbox]:enabled').prop('checked', false);
            }
            $(this).closest('table').find('tbody input[type=checkbox]:enabled').trigger('change');
        });

        $('tbody input[type=checkbox]').on('change', function() {
            if ($(this).closest('table').find('tbody input[type=checkbox]:checked').length) {
                $('button[data-action=remove-from-batch]').prop('disabled', false);
            } else {
                $('button[data-action=remove-from-batch]').prop('disabled', true);
            }
        });

        $('button[data-action=remove-from-batch]').on('click', function() {
            $('form[data-form=remove-batch-items]').submit();
        });

    });
</script>