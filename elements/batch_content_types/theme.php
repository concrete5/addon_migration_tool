<table class="migration-table table table-bordered table-striped">
    <thead>
    <tr>
        <th><?=t('Handle')?></th>
        <th><?=t('Activated')?></th>
        <th width="1"><input type="checkbox" data-checkbox="toggle-all"></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($collection->getThemes() as $theme) {
    $validator = $theme->getPublisherValidator();
    ?>
        <tr <?php if ($validator->skipItem()) {
    ?>class="migration-item-skipped"<?php 
}
    ?>>
            <td><?=$theme->getHandle()?></td>
            <td><?=$theme->getIsActivated() ? t("Yes") : t("No") ?></td>
            <td><input data-checkbox="select-item" type="checkbox" name="item[theme][]" value="<?=$theme->getID()?>"></td>
        </tr>
    <?php 
} ?>
    </tbody>
</table>
