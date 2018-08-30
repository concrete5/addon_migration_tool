<?php defined('C5_EXECUTE') or die("Access Denied."); ?>

    <div class="ccm-dashboard-header-buttons">
        <a href="<?=$view->action('view_batch', $batch->getID())?>" class="btn btn-default"><i class="fa fa-angle-double-left"></i> <?=t('Back to Batch')?></a>
    </div>


    <form method="get" action="<?=$view->action('add_to_batch', $batch->getID())?>">
    <div class="form-group">
        <?=$form->label('item_type', t('Choose Item Type'))?>
        <div style="padding-right: 80px; position: relative"">
        <select name="item_type" class="form-control">
            <option value=""><?=t('** Select Item')?></option>
            <?php foreach ($drivers as $itemType) {
    ?>
                <option value="<?=$itemType->getHandle()?>"
                    <?php if (isset($selectedItemType) && $selectedItemType->getHandle() == $itemType->getHandle()) {
    ?>selected<?php 
}
    ?>><?=$itemType->getPluralDisplayName()?></option>
            <?php 
} ?>
        </select>
        <button type="submit" style="position: absolute; top: 0px; right: 0px"name="submit" class="btn btn-primary"><?=t('Go')?></button>
        </div>
    </div>
</form>


<?php if (isset($selectedItemType)) {
    ?>


    <?php $formatter = $selectedItemType->getResultsFormatter($batch);
    ?>

    <?php if ($formatter->hasSearchForm()) {
    ?>

        <form method="get" action="<?=$view->action('add_to_batch', $batch->getID())?>" class="clearfix">
            <?=$form->hidden('item_type', $selectedItemType->getHandle())?>
            <?=$form->hidden('search_form_submit', 1)?>

            <?=$formatter->displaySearchForm();
    ?>
            <div class="form-actions">
                <button type="submit" name="submit" class="btn pull-right btn-default"><?=t('Search')?></button>
            </div>
        </form>
    <?php 
}
    ?>

    <?php if ($formatter->hasSearchResults($request)) {
    ?>
        <?php if ($formatter->hasSearchForm()) {
    ?>
            <hr/>
        <?php 
}
    ?>

        <h3><?=$selectedItemType->getPluralDisplayName()?></h3>



        <div class="clearfix">
            <button disabled class="pull-right btn-default btn btn-sm" data-action="add-to-batch" type="button"><?=t('Add to Batch')?></button>
            <h4><?=t('Results')?></h4>
        </div>


        <?php echo $formatter->displaySearchResults();
    ?>

    <?php 
}
    ?>

    <script type="text/javascript">
        $(function() {
            $('input[data-action=select-all]').on('click', function() {
                if ($(this).is(':checked')) {
                    $('tbody input[type=checkbox]:enabled').prop('checked', true);
                } else {
                    $('tbody input[type=checkbox]:enabled').prop('checked', false);
                }
                $('tbody input[type=checkbox]:enabled').trigger('change');
            });

            $('tbody input[type=checkbox]').on('change', function() {
                if ($('tbody input[type=checkbox]:checked').length) {
                    $('button[data-action=add-to-batch]').prop('disabled', false);
                } else {
                    $('button[data-action=add-to-batch]').prop('disabled', true);
                }
            });

            $('button[data-action=add-to-batch]').on('click', function() {
                var $checkboxes = $('input[data-checkbox=batch-item]');
                if ($checkboxes.length) {
                    var data = $checkboxes.serializeArray();
                    jQuery.fn.dialog.showLoader();
                    data.push({'name': 'batch_id', 'value': '<?=$batch->getID()?>'});
                    data.push({'name': 'item_type', 'value': '<?=$selectedItemType->getHandle()?>'});
                    data.push({'name': 'ccm_token', 'value': '<?=Loader::helper('validation/token')->generate('add_items_to_batch')?>'});
                    $.concreteAjax({
                        data: data,
                        url: '<?=$view->action('add_items_to_batch')?>',
                        success: function() {
                            ConcreteAlert.notify({message: '<?=t('Items added successfully.')?>'});
                        }
                    });
                }
            });

        });
    </script>

<?php 
} ?>