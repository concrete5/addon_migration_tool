<table class="migration-table table table-bordered table-striped">
    <thead>
    <tr>
        <th><?=t('Handle')?></th>
        <th><?=t('Name')?></th>
        <th><?=t('Active')?></th>
        <th width="1"><input type="checkbox" data-checkbox="toggle-all"></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($collection->getEditors() as $editor) {
    $validator = $editor->getPublisherValidator();
    ?>
        <tr <?php if ($validator->skipItem()) {
    ?>class="migration-item-skipped"<?php 
}
    ?>>
            <td><?=$editor->getHandle()?></td>
            <td><?=$editor->getName()?></td>
            <td><?=$editor->getIsActive() ? t('Yes') : t('No') ?></td>
            <td><input data-checkbox="select-item" type="checkbox" name="item[conversation_editor][]" value="<?=$editor->getID()?>"></td>
        </tr>
    <?php 
} ?>
    </tbody>
</table>
