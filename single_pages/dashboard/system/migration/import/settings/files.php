<?php defined('C5_EXECUTE') or die("Access Denied.");
$dh = Core::make('helper/date');
/* @var \Concrete\Core\Localization\Service\Date $dh */
?>

<form method="post" action="<?=$view->action('save_files_settings')?>" enctype="multipart/form-data">
    <?=$token->output('save_files_settings')?>
    <?=$form->hidden('id', $batch->getID())?>

<fieldset>

    <div class="form-group">
        <label class="control-label"><?=t('Folder')?></label>

        <?php
            $selector = new \Concrete\Core\Form\Service\Widget\FileFolderSelector();
            print $selector->selectFileFolder('folderID', $folderID);
        ?>

    </div>

</fieldset>

    <div class="ccm-dashboard-form-actions-wrapper">
        <div class="ccm-dashboard-form-actions">
            <a href="<?=URL::to('/dashboard/system/migration/import', 'view_batch', $batch->getID())?>" class="btn btn-default"><?=t('Cancel')?></a>
            <button class="pull-right btn btn-primary" type="submit"><?=t('Save')?></button>
        </div>
    </div>
</form>