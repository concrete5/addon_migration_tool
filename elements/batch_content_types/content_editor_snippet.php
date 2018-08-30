<table class="migration-table table table-bordered table-striped">
    <thead>
    <tr>
        <th><?=t('Handle')?></th>
        <th><?=t('Name')?></th>
        <th><?=t('Activated')?></th>
        <th width="1"><input type="checkbox" data-checkbox="toggle-all"></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($collection->getSnippets() as $snippet) {
    $validator = $snippet->getPublisherValidator();
    ?>
        <tr <?php if ($validator->skipItem()) {
    ?>class="migration-item-skipped"<?php 
}
    ?>>
            <td><?=$snippet->getHandle()?></td>
            <td><?=$snippet->getName()?></td>
            <td><?=$snippet->getIsActivated() ? t("Yes") : t("No") ?></td>
            <td><input data-checkbox="select-item" type="checkbox" name="item[content_editor_snippet][]" value="<?=$snippet->getID()?>"></td>
        </tr>
    <?php 
} ?>
    </tbody>
</table>
