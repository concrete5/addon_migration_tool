<?php defined('C5_EXECUTE') or die("Access Denied.");
$dh = Core::make('helper/date');
/* @var \Concrete\Core\Localization\Service\Date $dh */
?>

<form method="post" action="<?=$view->action('save_batch_settings')?>" enctype="multipart/form-data">

    <div class="ccm-dashboard-form-actions-wrapper">
        <div class="ccm-dashboard-form-actions">
            <a href="<?=$view->url('/dashboard/system/migration/import', 'view_batch', $batch->getID())?>" class="btn btn-default"><?=t('Cancel')?></a>
            <button class="pull-right btn btn-primary" type="submit"><?=t('Save')?></button>
        </div>
    </div>

    <?=$token->output('save_batch_settings')?>
    <?=$form->hidden('id', $batch->getID())?>

<fieldset>
    <legend><?=t('Basics')?></legend>

    <?php if (count($sites) > 1) { ?>
        <div class="form-group">
            <?=Loader::helper("form")->label('siteID', t('Site'))?>
            <select name="siteID" class="form-control">
                <?php foreach($sites as $site) { ?>
                    <option value="<?=$site->getSiteID()?>" <?php if ($batch->getSite()->getSiteID() == $site->getSiteID()) { ?>selected<?php } ?>><?=$site->getSiteName()?></option>
                <?php } ?>
            </select>
        </div>
    <?php } ?>
    <div class="form-group">
        <?=Loader::helper("form")->label('name', t('Name'))?>
        <?=Loader::helper('form')->text('name', $batch->getName())?>
    </div>
</fieldset>

<fieldset>
    <legend><?=t('Mapping Definitions')?></legend>
    <div class="form-group">
        <label class="control-label launch-tooltip" title="<?=t('Downloads all the current mappings as an XML file. This file can then be reused across multiple batches to save time.')?>"><?=t('Download Mappings')?></label>
        <div><button type="submit" name="download_mappings" value="1" class="btn btn-default"><?=t('Download Current Definitions')?></div>
    </div>


    <div class="form-group">
        <label class="control-label"><?=t('Upload Mapping File')?></label>

        <?php if (count($presetMappings)) { ?>

            <div class="alert alert-info"><?=t2('You have uploaded a preset mapping file containing %s preset', 'You have uploaded a preset mapping file containing %s presets', count($presetMappings))?>
                <button class="btn btn-xs btn-default pull-right" type="submit" name="delete_mapping_presets" value="1"><?=t('Clear Presets')?></button>
            </div>
        <?php } else { ?>
            <?=$form->file('mappingFile')?>

        <?php } ?>
    </div>

</fieldset>

</form>