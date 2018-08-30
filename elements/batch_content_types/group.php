<table class="migration-table table table-bordered table-striped">
    <thead>
    <tr>
        <th><?=t('Name')?></th>
        <th><?=t('Path')?></th>
        <th width="1"><input type="checkbox" data-checkbox="toggle-all"></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($collection->getGroups() as $group) {
    $validator = $group->getPublisherValidator();
    ?>
    <tr <?php if ($validator->skipItem()) {
    ?>class="migration-item-skipped"<?php 
}
    ?>>
        <td><?=$group->getName()?></td>
        <td><?=$group->getPath()?></td>
        <td><input data-checkbox="select-item" type="checkbox" name="item[group][]" value="<?=$group->getID()?>"></td>
    <?php

} ?>
    </tbody>
</table>
