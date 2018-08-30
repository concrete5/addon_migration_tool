<table class="migration-table table table-bordered table-striped">
    <thead>
    <tr>
        <th><?=t('Handle')?></th>
        <th width="1"><input type="checkbox" data-checkbox="toggle-all"></th>
\    </tr>
    </thead>
    <tbody>
    <?php foreach ($collection->getPackages() as $pkg) {
    $validator = $pkg->getPublisherValidator();
    ?>
    <tr <?php if ($validator->skipItem()) {
    ?>class="migration-item-skipped"<?php 
}
    ?>>
        <td><?=$pkg->getHandle()?></td>
        <td><input data-checkbox="select-item" type="checkbox" name="item[package][]" value="<?=$pkg->getID()?>"></td>
    <?php
} ?>
    </tbody>
</table>
