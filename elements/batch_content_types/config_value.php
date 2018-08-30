<table class="migration-table table table-bordered table-striped">
    <thead>
    <tr>
        <th><?=t('Key')?></th>
        <th><?=t('Value')?></th>
        <th width="1"><input type="checkbox" data-checkbox="toggle-all"></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($collection->getValues() as $config) {
    $validator = $config->getPublisherValidator();
    ?>
    <tr <?php if ($validator->skipItem()) {
    ?>class="migration-item-skipped"<?php 
}
    ?>>
        <td><?=$config->getConfigKey()?></td>
        <td><?=$config->getConfigValue()?></td>
        <td><input data-checkbox="select-item" type="checkbox" name="item[config_value][]" value="<?=$config->getID()?>"></td>
    <?php
} ?>
    </tbody>
</table>
