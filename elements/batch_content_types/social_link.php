<table class="migration-table table table-bordered table-striped">
    <thead>
    <tr>
        <th><?=t('Service')?></th>
        <th><?=t('URL')?></th>
        <th width="1"><input type="checkbox" data-checkbox="toggle-all"></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($collection->getLinks() as $link) {
    $validator = $link->getPublisherValidator();
    ?>
        <tr <?php if ($validator->skipItem()) {
    ?>class="migration-item-skipped"<?php 
}
    ?>>
            <td><?=$link->getService()?></td>
            <td><?=$link->getURL()?></td>
            <td><input data-checkbox="select-item" type="checkbox" name="item[social_link][]" value="<?=$link->getID()?>"></td>
        </tr>
    <?php 
} ?>
    </tbody>
</table>
