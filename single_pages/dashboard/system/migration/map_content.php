<?php defined('C5_EXECUTE') or die("Access Denied.");
$dh = Core::make('helper/date');
/* @var \Concrete\Core\Localization\Service\Date $dh */
?>
    <div class="ccm-dashboard-header-buttons">
        <a href="<?= $view->action('view_batch', $batch->getID()) ?>" class="btn btn-default"><i
                class="fa fa-angle-double-left"></i> <?= t('Back to Batch') ?></a>
    </div>


    <h2><?= t('Batch') ?>
        <small><?= $dh->formatDateTime($batch->getDate(), true) ?></small>
    </h2>

<form method="post" action="<?= $view->action('save_mapping') ?>">
    <?= $form->hidden('id', $batch->getID()) ?>
    <?= $token->output('save_mapping') ?>


<?php
$empty = true;

foreach ($mappers->getDrivers() as $mapper) {
    $items = $mapper->getItems($batch);
    $targetItemList = $mappers->createTargetItemList($batch, $mapper);
    ?>
    <?php if (count($items)) {

        $empty = false;

        ?>

        <div>

        <button class="btn btn-default btn-sm pull-right" data-action="set-unmapped-to-ignored" type="button"><?=t("Set Un-Mapped to Ignored")?></button>

        <h4><?= $mapper->getMappedItemPluralName() ?></h4>

         <table class="table table-striped">
                <thead>
                <tr>
                    <th style="white-space: nowrap"><?= t('Batch Item') ?></th>
                    <th style="width: 100%"><?= t('Maps To') ?></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($items as $item) {
                    $selectedTargetItem = $targetItemList->getSelectedTargetItem($item);
                    ?>
                    <tr>
                        <td style="white-space: nowrap; vertical-align: middle"><?= $item->getDisplayName() ?></td>
                        <td>
                            <select name="targetItem[<?=$mapper->getHandle()?>][<?= $item->getIdentifier() ?>]" data-selector="target-item">
                                <optgroup label="<?=t('Unknown')?>">
                                    <?php foreach ($targetItemList->getInternalTargetItems() as $targetItem) {
                                        ?>
                                        <option
                                            <?php if (is_object($selectedTargetItem) && $selectedTargetItem->matches($targetItem)) {
                                            ?>selected="selected" <?php
                                        }
                                        ?>
                                            value="<?= $targetItem->getItemID() ?>"><?= $targetItem->getItemName() ?></option>
                                        <?php
                                    }
                                    ?>
                                </optgroup>

                                <?php if (count($targetItemList->getMapperCorePropertyTargetItems())) {
                                    ?>
                                    <optgroup label="<?= t('Installed %s',
                                        $mapper->getMappedItemPluralName()) ?>">
                                    <?php foreach ($targetItemList->getMapperCorePropertyTargetItems() as $targetItem) {
                                        ?>
                                        <option
                                            <?php if (is_object($selectedTargetItem) && $selectedTargetItem->matches($targetItem)) {
                                            ?>selected="selected" <?php

                                        }
                                        ?>
                                            value="<?= $targetItem->getItemID() ?>"><?= $targetItem->getItemName() ?></option>
                                        <?php

                                    } ?>
                                    </optgroup>
                                <?php
                                }
                                ?>


                                <?php if (count($targetItemList->getMapperInstalledTargetItems())) {
                                    ?>
                                    <optgroup label="<?= t('Installed %s',
                                        $mapper->getMappedItemPluralName()) ?>">
                                    <?php foreach ($targetItemList->getMapperInstalledTargetItems() as $targetItem) {
                                        ?>
                                        <option
                                            <?php if (is_object($selectedTargetItem) && $selectedTargetItem->matches($targetItem)) {
                                            ?>selected="selected" <?php
                                        }
                                        ?>
                                            value="<?= $targetItem->getItemID() ?>"><?= $targetItem->getItemName() ?></option>
                                        <?php
                                    }
                                    ?>
                                    </optgroup>

                                    <?php
                                }
                                ?>
                                <?php if (count($targetItemList->getMapperBatchTargetItems())) {
                                    ?>
                                    <optgroup
                                        label="<?= t('Batch %s', $mapper->getMappedItemPluralName()) ?>">
                                    <?php foreach ($targetItemList->getMapperBatchTargetItems() as $targetItem) {
                                        ?>
                                        <option
                                            <?php if (is_object($selectedTargetItem) && $selectedTargetItem->matches($targetItem)) {
                                            ?>selected="selected" <?php
                                        }
                                        ?>
                                            value="<?= $targetItem->getItemID() ?>"><?= $targetItem->getItemName() ?></option>
                                        <?php
                                    }
                                    ?>
                                    </optgroup>
                                    <?php
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <?php
                }
                ?>
                </tbody>
            </table>
            </div>

            <div class="ccm-dashboard-form-actions-wrapper">
                <div class="ccm-dashboard-form-actions">
                    <a href="<?= $view->action('view_batch', $batch->getID()) ?>"
                       class="btn btn-default"><?= t('Cancel') ?></a>
                    <button class="pull-right btn btn-primary" type="submit"><?= t('Save') ?></button>
                </div>
            </div>

    <?php
    }

}
?>

<script type="text/javascript">
    $(function() {
        $('select[data-selector=target-item]').selectize();
        $('button[data-action=set-unmapped-to-ignored]').on('click', function() {
            $(this).parent().find('select').each(function() {
                if ($(this).val() == '0') {
                    $(this).selectize()[0].selectize.setValue('-1')
                }
            });
        });
    });
</script>

<?php if ($empty) { ?>
    <p><?=t('There are no mappable items found in this batch.')?></p>

<?php } ?>

</form>

