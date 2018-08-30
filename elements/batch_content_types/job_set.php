<table class="migration-table table table-bordered table-striped">
    <thead>
    <tr>
        <th><?=t('Name')?></th>
        <th><?=t('Categories')?></th>
        <th width="1"><input type="checkbox" data-checkbox="toggle-all"></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($collection->getSets() as $set) {
    $validator = $set->getPublisherValidator();
    ?>
    <tr <?php if ($validator->skipItem()) {
    ?>class="migration-item-skipped"<?php 
}
    ?>>
        <td><?=$set->getName()?></td>
        <td><?=implode(', ', $set->getJobs())?></td>
        <td><input data-checkbox="select-item" type="checkbox" name="item[job_set][]" value="<?=$set->getID()?>"></td>
        <?php
} ?>
    </tbody>
</table>