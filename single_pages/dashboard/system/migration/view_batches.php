<?php defined('C5_EXECUTE') or die("Access Denied.");
$dh = Core::make('helper/date');
/* @var \Concrete\Core\Localization\Service\Date $dh */
?>

<div class="ccm-dashboard-header-buttons">
    <a href="javascript:void(0)" data-dialog="add-batch" class="btn btn-primary"><?=t("Add Batch")?></a>
</div>

<?php if (count($batches)) {
    ?>

    <table class="table">
        <thead>
        <tr>
            <th><?=t('Batch')?></th>
            <th><?=t('Name')?></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($batches as $batch) {
    ?>
            <tr>
                <td style="white-space: nowrap"><a href="<?=$view->action('view_batch', $batch->getID())?>"><?=$dh->formatDateTime($batch->getDate(), true)?></a></td>
                <td width="100%"><?=$batch->getName()?></td>
            </tr>
        <?php 
}
    ?>
        </tbody>
    </table>


<?php 
} else {
    ?>
    <p><?=$batchEmptyMessage?></p>
<?php 
} ?>

<div style="display: none">
    <div id="ccm-dialog-add-batch" class="ccm-ui">
        <form method="post" action="<?=$view->action('add_batch')?>" enctype="multipart/form-data">
            <?=Loader::helper("validation/token")->output('add_batch')?>
            <div class="form-group">
                <?=Loader::helper("form")->label('date', t('Date'))?>
                <?=Loader::helper('form')->text('date',
                    Core::make('date')->formatDateTime('now', true),
                    array('disabled' => 'disabled')
                )?>
            </div>
            <?php if (count($sites) > 1) { ?>
            <div class="form-group">
                <?=Loader::helper("form")->label('siteID', t('Site'))?>
                <select name="siteID" class="form-control">
                    <?php foreach($sites as $site) { ?>
                         <option value="<?=$site->getSiteID()?>"><?=$site->getSiteName()?></option>
                    <?php } ?>
                </select>
            </div>
            <?php } ?>
            <div class="form-group">
                <?=Loader::helper("form")->label('name', t('Name'))?>
                <?=Loader::helper('form')->text('name', '')?>
            </div>

            <?php if ($batchType == 'import') { ?>
            <fieldset>
                <legend><?=t('Advanced')?></legend>
                <div class="form-group">
                    <?=Loader::helper("form")->label('mappingFile', t('Provide Mapping Presets'))?>
                    <?=Loader::helper('form')->file('mappingFile')?>
                </div>
            </fieldset>
            <?php } ?>
        </form>
        <div class="dialog-buttons">
            <button class="btn btn-default pull-left" onclick="jQuery.fn.dialog.closeTop()"><?=t('Cancel')?></button>
            <button class="btn btn-primary pull-right" onclick="$('#ccm-dialog-add-batch form').submit()"><?=t('Add Batch')?></button>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(function() {
        $('a[data-dialog=add-batch]').on('click', function() {
            jQuery.fn.dialog.open({
                element: '#ccm-dialog-add-batch',
                modal: true,
                width: 320,
                title: '<?=t("Add Batch")?>',
                height: 'auto'
            });
        });
    });
</script>