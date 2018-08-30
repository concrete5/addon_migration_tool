<table class="migration-table table table-bordered table-striped">
    <thead>
    <tr>
        <th><?=t('Library')?></th>
        <th width="1"><input type="checkbox" data-checkbox="toggle-all"></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($collection->getLibraries() as $library) {
    $validator = $library->getPublisherValidator();
    ?>
        <tr <?php if ($validator->skipItem()) {
    ?>class="migration-item-skipped"<?php 
}
    ?>>
            <td><?=$library->getHandle()?></td>
            <td><input data-checkbox="select-item" type="checkbox" name="item[captcha_library][]" value="<?=$library->getID()?>"></td>
        </tr>
    <?php 
} ?>
    </tbody>
</table>
