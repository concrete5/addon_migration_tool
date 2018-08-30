<?php

defined('C5_EXECUTE') or die(_("Access Denied."));

$ag = \Concrete\Core\Http\ResponseAssetGroup::get();
$ag->requireAsset('selectize');

$form = Core::make('helper/form');
$datetime = Loader::helper('form/date_time')->translate('datetime', $_GET);

$groups = array();
$list = new \Concrete\Core\User\Group\GroupList();
$groups = array('' => t('** Choose a group'));
foreach ($list->getResults() as $group) {
    $groups[$group->getGroupID()] = $group->getGroupDisplayName();
}

?>
<div class="form-group">
    <label class="control-label"><?=t('Keywords')?></label>
    <?=$form->text('keywords')?>
</div>

<div class="form-group">
    <label class="control-label"><?=t('Added on or After')?></label>
    <?=Loader::helper('form/date_time')->datetime('datetime', $datetime, true)?>
</div>

<div class="form-group">
    <label class="control-label"><?=t('Filter by Group')?></label>
    <select name="gID" style="display: none">
        <?php foreach($groups as $key => $value) {  ?>
            <option value="<?=$key?>" <?php if ($_GET['gID'] == $key) { ?> selected <?php } ?>><?=$value?></option>
        <?php } ?>
    </select>
</div>


<script type="text/javascript">
    $(function() {
        $('select[name=gID]').selectize();
    });
</script>