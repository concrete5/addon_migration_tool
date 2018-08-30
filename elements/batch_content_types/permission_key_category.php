<table class="migration-table table table-bordered table-striped">
    <thead>
    <tr>
        <th><?=t('Handle')?></th>
        <th width="1"><input type="checkbox" data-checkbox="toggle-all"></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($collection->getCategories() as $category) {
    $validator = $category->getPublisherValidator();
    ?>
        <tr <?php if ($validator->skipItem()) {
    ?>class="migration-item-skipped"<?php 
}
    ?>>
            <td><?=$category->getHandle()?></td>
            <td><input data-checkbox="select-item" type="checkbox" name="item[permission_key_category][]" value="<?=$category->getID()?>"></td>
        </tr>
    <?php 
} ?>
    </tbody>
</table>
