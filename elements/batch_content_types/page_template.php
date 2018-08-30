<table class="migration-table table table-bordered table-striped">
    <thead>
    <tr>
        <th><?=t('Handle')?></th>
        <th style="width: 100%"><?=t('Name')?></th>
        <th><?=t('Icon')?></th>
        <th width="1"><input type="checkbox" data-checkbox="toggle-all"></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($collection->getTemplates() as $template) {
    $validator = $template->getPublisherValidator();
    ?>
    <tr <?php if ($validator->skipItem()) {
    ?>class="migration-item-skipped"<?php 
}
    ?>>
        <td><?=$template->getHandle()?></td>
        <td><?=$template->getName()?></td>
        <td><?=$template->getIcon()?></td>
        <td><input data-checkbox="select-item" type="checkbox" name="item[page_template][]" value="<?=$template->getID()?>"></td>
    <?php
} ?>
    </tbody>
</table>
