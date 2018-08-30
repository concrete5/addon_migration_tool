<table class="migration-table table table-bordered table-striped">
    <thead>
    <tr>
        <th><?=t('Handle')?></th>
        <th width="1"><input type="checkbox" data-checkbox="toggle-all"></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($collection->getJobs() as $job) {
    $validator = $job->getPublisherValidator();
    ?>
    <tr <?php if ($validator->skipItem()) {
    ?>class="migration-item-skipped"<?php 
}
    ?>>
        <td><?=$job->getHandle()?></td>
        <td><input data-checkbox="select-item" type="checkbox" name="item[job][]" value="<?=$job->getID()?>"></td>
    <?php
} ?>
    </tbody>
</table>
