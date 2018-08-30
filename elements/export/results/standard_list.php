<?php
defined('C5_EXECUTE') or die(_("Access Denied."));
?>
<?php if (count($results)) {
    ?>

<table class="migration-table table table-bordered table-striped">
    <thead>
    <tr>
        <th><input type="checkbox" data-action="select-all"></th>
        <?php foreach ($headers as $header) {
    ?>
            <th><?=$header?></th>
        <?php 
}
    ?>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($results as $result) {
    /* @var $result PortlandLabs\Concrete5\MigrationTool\Entity\Export\ExportItem */?>
    <tr>
        <td style="width: 30px">
            <input <?php if ($mode == 'search' && is_object($collection) && $collection->contains($result)) {
    ?>disabled<?php 
}
    ?> data-checkbox="batch-item" type="checkbox" name="id[<?=$type->getHandle()?>][]" value="<?=$result->getItemIdentifier()?>">
        </td>
        <?php foreach ($type->getResultColumns($result) as $column) {
    ?>
            <td><?=$column?></td>
        <?php 
}
    ?>
    </tr>
    <?php 
}
    ?>
    </tbody>
</table>

<?php 
} else {
    ?>

    <p><?=t('No results found.')?></p>

<?php 
} ?>