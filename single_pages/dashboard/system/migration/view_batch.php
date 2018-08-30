<?php defined('C5_EXECUTE') or die("Access Denied.");
$dh = Core::make('helper/date');
/* @var \Concrete\Core\Localization\Service\Date $dh */
?>
    <div class="ccm-dashboard-header-buttons">

        <?php if ($activeQueue) { ?>
            <div class="btn-group btn-group">
                <button class="btn btn-default" onclick="launchActiveQueue()"><?=t('Resume Active Process')?></button>
                <a href="javascript:void(0)" class="btn btn-danger" data-dialog="clear-batch-queues"
                   data-dialog-title="<?= t('Reset All Processes') ?>"><?= t("Reset All Processes") ?></a>
            </div>

        <?php } else {  ?>
            <div class="btn-group btn-group-sm" role="group" aria-label="...">
                <a href="javascript:void(0)" data-dialog="add-to-batch" data-dialog-title="<?= t('Add Content') ?>"
                   class="btn btn-default"><?= t("Add Content to Batch") ?></a>
                <a href="<?= $view->action('batch_files', $batch->getID()) ?>" class="btn btn-default"><?= t('Files') ?></a>
                <div class="btn-group btn-group-sm" role="group">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                        <?= t('Edit') ?>
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a href="<?= $view->action('map_content', $batch->getId())?>"><?=t('Map Content')?></a></li>
                        <li class="divider"></li>
                        <li class="dropdown-header"><?= t('Settings') ?></li>
                        <li><a href="<?=URL::to('/dashboard/system/migration/import/settings/basics', $batch->getID())?>" class=""><?= t("Basics") ?></a>
                            <?php foreach($settings as $setting) { ?>
                        <li><a href="<?=URL::to($setting, $batch->getID())?>" class=""><?= t($setting->getCollectionName())?></a>
                            <?php } ?>
                        <li class="divider"></li>
                        <li><a href="javascript:void(0)" data-dialog="clear-batch-mappings"
                               data-dialog-title="<?= t('Clear Batch Mappings') ?>" class=""><?= t("Clear Batch Mappings") ?></a>
                        <li><a href="javascript:void(0)" data-action="rescan-batch"
                               data-dialog-title="<?= t('Rescan Batch') ?>" class=""><?= t("Rescan Batch") ?></a>
                    </ul>
                </div>
                <div class="btn-group btn-group-sm" role="group">
                    <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                        <?= t('Delete') ?>
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">
                        <li class="disabled"><a disabled="disabled" href="javascript:void(0)" data-dialog="delete-batch-items"
                                                data-dialog-title="<?= t('Delete Selected') ?>"><?= t("Delete Selected") ?></a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="javascript:void(0)" data-dialog="clear-batch"
                               data-dialog-title="<?= t('Clear Batch') ?>" class=""><?= t("Clear Batch") ?></a>
                        </li>
                        <li><a href="javascript:void(0)" data-dialog="delete-batch"
                               data-dialog-title="<?= t('Delete Batch') ?>"><?= t("Delete Batch") ?></a></li>
                    </ul>
                </div>

                <a href="javascript:void(0)" class="btn btn-primary" data-dialog="create-content"
                   data-dialog-title="<?= t('Import Batch to Site') ?>" class=""><?= t("Import Batch to Site") ?></a>

            </div>

        <?php } ?>
    </div>

    <div style="display: none">

        <div data-progress-bar="rescan">
            <div class="ccm-ui">
                <h4 data-progress-bar-title="rescan"></h4>
                <div data-progress-bar-wrapper="rescan">
                    <div class="progress progress-bar-striped progress-striped active">
                        <div class="progress-bar" style="width: 100%;"></div>
                    </div>
                </div>
            </div>
        </div>

        <div data-dialog-wrapper="delete-batch"">
        <div id="ccm-dialog-delete-batch" class="ccm-ui">
            <form method="post" action="<?= $view->action('delete_batch') ?>">
                <?= Loader::helper("validation/token")->output('delete_batch') ?>
                <input type="hidden" name="id" value="<?= $batch->getID() ?>">
                <p><?= t('Are you sure you want to delete this import batch? This cannot be undone.') ?></p>
                <div class="dialog-buttons">
                    <button class="btn btn-default pull-left"
                            onclick="jQuery.fn.dialog.closeTop()"><?= t('Cancel') ?></button>
                    <button class="btn btn-danger pull-right"
                            onclick="$('#ccm-dialog-delete-batch form').submit()"><?= t('Delete Batch') ?></button>
                </div>
            </form>
        </div>
        </div>


        <div data-dialog-wrapper="clear-batch">
        <div id="ccm-dialog-clear-batch" class="ccm-ui">
            <form method="post" action="<?= $view->action('clear_batch') ?>">
                <?= Loader::helper("validation/token")->output('clear_batch') ?>
                <input type="hidden" name="id" value="<?= $batch->getID() ?>">
                <p><?= t('Are you sure you remove all content from this import batch? This cannot be undone.') ?></p>
                <div class="dialog-buttons">
                    <button class="btn btn-default pull-left"
                            onclick="jQuery.fn.dialog.closeTop()"><?= t('Cancel') ?></button>
                    <button class="btn btn-danger pull-right"
                            onclick="$('#ccm-dialog-clear-batch form').submit()"><?= t('Clear Batch') ?></button>
                </div>
            </form>
        </div>
        </div>

        <div data-dialog-wrapper="delete-batch-items">
        <div id="ccm-dialog-delete-batch-items" class="ccm-ui">
            <form method="post" action="<?= $view->action('delete_batch_items') ?>">
                <?= Loader::helper("validation/token")->output('delete_batch_items') ?>
                <input type="hidden" name="id" value="<?= $batch->getID() ?>">
                <p><?= t('Are you sure you remove selected content from this import batch? This cannot be undone.') ?></p>
                <div class="dialog-buttons">
                    <button class="btn btn-default pull-left"
                            onclick="jQuery.fn.dialog.closeTop()"><?= t('Cancel') ?></button>
                    <button class="btn btn-danger pull-right"
                            data-action="remove-selected-items"><?= t('Delete Selected') ?></button>
                </div>
            </form>
        </div>
        </div>


        <div data-dialog-wrapper="clear-batch-mappings">
        <div id="ccm-dialog-clear-batch-mappings" class="ccm-ui">
            <form method="post" action="<?= $view->action('clear_batch_mappings') ?>">
                <?= Loader::helper("validation/token")->output('clear_batch_mappings') ?>
                <input type="hidden" name="id" value="<?= $batch->getID() ?>">
                <p><?= t('Are you sure you reset all mapped content items for this batch? Any presets you have uploaded will not be removed.') ?></p>
                <div class="dialog-buttons">
                    <button class="btn btn-default pull-left"
                            onclick="jQuery.fn.dialog.closeTop()"><?= t('Cancel') ?></button>
                    <button class="btn btn-danger pull-right"
                            onclick="$('#ccm-dialog-clear-batch-mappings form').submit()"><?= t('Clear Batch Mappings') ?></button>
                </div>
            </form>
        </div>
        </div>

        <div data-dialog-wrapper="clear-batch-queues">
            <div id="ccm-dialog-clear-batch-queues" class="ccm-ui">
                <form method="post" action="<?= $view->action('clear_batch_queues') ?>">
                    <?= Loader::helper("validation/token")->output('clear_batch_queues') ?>
                    <input type="hidden" name="id" value="<?= $batch->getID() ?>">
                    <p><?= t('Are you sure you reset all running processes for this batch? If someone else is actively importing content into the site it could affect them.') ?></p>
                    <div class="dialog-buttons">
                        <button class="btn btn-default pull-left"
                                onclick="jQuery.fn.dialog.closeTop()"><?= t('Cancel') ?></button>
                        <button class="btn btn-danger pull-right"
                                onclick="$('#ccm-dialog-clear-batch-queues form').submit()"><?= t('Reset Processes') ?></button>
                    </div>
                </form>
            </div>
        </div>



<div data-dialog-wrapper="create-content">
        <div id="ccm-dialog-create-content" class="ccm-ui">
            <form method="post">
                <p data-description="create-content"><?= t('Create site content from the contents of this batch?') ?></p>
                <div data-progress-bar="create-content" style="display: none">
                    <h4 data-progress-bar-title="create-content"></h4>
                    <div data-progress-bar-wrapper="create-content">
                        <div class="progress progress-striped active">
                            <div class="progress-bar" style="width: 0%;"></div>
                        </div>
                    </div>
                </div>

                <div class="dialog-buttons">
                    <button class="btn btn-default pull-left"
                            onclick="jQuery.fn.dialog.closeTop()"><?= t('Cancel') ?></button>
                    <button class="btn btn-primary pull-right"
                            data-action="publish-content"><?= t('Publish Batch') ?></button>
                </div>
            </form>
        </div>
        </div>


        <div data-dialog-wrapper="add-to-batch">
        <div id="ccm-dialog-add-to-batch" class="ccm-ui">
            <form method="post" action="<?= $view->action('add_content_to_batch') ?>" enctype="multipart/form-data">
                <?= Loader::helper("validation/token")->output('add_content_to_batch') ?>
                <input type="hidden" name="id" value="<?= $batch->getID() ?>">
                <div class="form-group">
                    <?= Loader::helper("form")->label('file', t('Content File')) ?>
                    <?= Loader::helper('form')->file('file') ?>
                </div>
                <div class="form-group">
                    <?= Loader::helper("form")->label('format', t('File Format')) ?>
                    <?= Loader::helper('form')->select('format', $formats) ?>
                </div>
                <div class="form-group">
                    <?= Loader::helper("form")->label('method', t('Records')) ?>
                    <div class="radio">
                        <label><input type="radio" name="importMethod" value="replace"
                                      checked> <?= t('Replace all batch content.') ?></label>
                    </div>
                    <div class="radio">
                        <label><input type="radio" name="importMethod" value="append"> <?= t('Add content to batch.') ?>
                        </label>
                    </div>
                </div>
                <div data-progress-bar="add-to-batch" style="display: none">
                    <h4 data-progress-bar-title="add-to-batch"></h4>
                    <div data-progress-bar-wrapper="add-to-batch">
                        <div class="progress progress-striped active">
                            <div class="progress-bar" style="width: 100%;"></div>
                        </div>
                    </div>
                </div>
            </form>
            <div class="dialog-buttons">
                <button class="btn btn-default pull-left"
                        onclick="jQuery.fn.dialog.closeTop()"><?= t('Cancel') ?></button>
                <button class="btn btn-primary pull-right" data-action="add-content"><?= t('Add Content') ?></button>
            </div>
        </div>
        </div>
    </div>


    <h2><?= t('Batch') ?>
        <small><?= $dh->formatDateTime($batch->getDate(), true) ?></small>
    </h2>

    <h3><?=t('Name')?></h3>
    <?php if ($batch->getName()) { ?>
        <p><?= $batch->getName() ?></p>
    <?php } else { ?>
        <p><?=t('None')?></p>
    <?php }

    $site = $batch->getSite();
    if (is_object($site) && !$site->isDefault()) { ?>
        <h3><?= t('Site') ?></h3>
        <p><?= $site->getSiteName() ?></p>
    <?php } ?>

<?php if ($activeQueue) { ?>
    <?php Loader::element('active_queue', array('batch' => $batch, 'queue' => $activeQueue), 'migration_tool'); ?>

<?php } else { ?>
    <?php Loader::element('batch', array('batch' => $batch), 'migration_tool'); ?>
<?php } ?>

<script type="text/javascript">
    showRescanDialog = function () {
        $('[data-progress-bar=rescan]').jqdialog({
            autoOpen: true,
            height: 'auto',
            width: 400,
            modal: true,
            dialogClass: 'ccm-ui',
            title: '<?=t("Scanning Batch")?>',
            closeOnEscape: false,
            open: function (e, ui) {

            }
        });
    }

    rescanBatchItems = function ($element) {

        $('h4[data-progress-bar-title]').html('<?=t('Normalizing Page Paths...')?>');


        $.concreteAjax({
            loader: false,
            url: '<?=$view->action('run_batch_content_normalize_page_paths_task')?>',
            type: 'POST',
            data: [
                {'name': 'id', 'value': '<?=$batch->getID()?>'},
                {
                    'name': 'ccm_token',
                    'value': '<?=Core::make('token')->generate('run_batch_content_normalize_page_paths_task')?>'
                }
            ],
            success: function (r) {
                $('h4[data-progress-bar-title]').html('<?=t('Mapping Content Types...')?>');
                ccm_triggerProgressiveOperation(
                    '<?=$view->action('run_batch_content_map_content_types_task')?>',
                    [
                        {'name': 'id', 'value': '<?=$batch->getID()?>'},
                        {
                            'name': 'ccm_token',
                            'value': '<?=Core::make('token')->generate('run_batch_content_map_content_types_task')?>'
                        }
                    ],
                    '',
                    function () {
                        $('h4[data-progress-bar-title]').html('<?=t('Transforming Content Types...')?>');
                        ccm_triggerProgressiveOperation(
                            '<?=$view->action('run_batch_content_transform_content_types_task')?>',
                            [
                                {'name': 'id', 'value': '<?=$batch->getID()?>'},
                                {
                                    'name': 'ccm_token',
                                    'value': '<?=Core::make('token')->generate('run_batch_content_transform_content_types_task')?>'
                                }
                            ],
                            '',
                            function () {
                                window.location.reload();
                            },
                            false,
                            $element
                        );
                    },
                    false,
                    $element
                );
            }
        });
    }

    $(function () {

        $('a[data-action=rescan-batch]').on('click', function (e) {
            e.preventDefault();
            showRescanDialog();
            rescanBatchItems($('div[data-progress-bar-wrapper=rescan]'));
        });

        $('button[data-action=publish-content]').on('click', function (e) {
            $('p[data-description=create-content]').hide();
            $('div[data-progress-bar=create-content]').show();
            $('div[data-progress-bar=create-content] h4').html('<?=t('Publishing Content...')?>');

            ccm_triggerProgressiveOperation(
                '<?=$view->action('create_content_from_batch')?>',
                [
                    {'name': 'id', 'value': '<?=$batch->getID()?>'},
                    {'name': 'ccm_token', 'value': '<?=Core::make('token')->generate('create_content_from_batch')?>'}
                ],
                '',
                function () {
                    window.location.reload()
                },
                false,
                $('div[data-progress-bar-wrapper=create-content]')
            );
        });

        $('button[data-action=remove-selected-items]').on('click', function (e) {
            var data = $('input[data-checkbox=select-item]').serializeArray();
            jQuery.fn.dialog.showLoader();
            data.push({'name': 'id', 'value': '<?=$batch->getID()?>'});
            data.push({'name': 'ccm_token', 'value': '<?=Loader::helper('validation/token')->generate('delete_batch_items')?>'});
            $.concreteAjax({
                data: data,
                url: '<?=$view->action('delete_batch_items')?>',
                success: function() {
                    window.location.reload();
                }
            });
        });


        var uploadErrors = [];


        $("button[data-action=add-content]").on('click.uploadFile', function () {
            var submitSuccess = false;
            $('div[data-progress-bar=add-to-batch]').show();
            $('div[data-progress-bar=add-to-batch] h4').html('<?=t('Uploading File...')?>');
            $('#ccm-dialog-add-to-batch form').concreteAjaxForm({
                beforeSubmit: function () {
                    // Nothing - we don't want the loader
                },
                success: function (r) {
                    submitSuccess = true;
                    rescanBatchItems($('div[data-progress-bar-wrapper=add-to-batch]'));
                },
                complete: function () {
                    if (!submitSuccess) {
                        $('div[data-progress-bar=add-to-batch]').hide();
                        $('div[data-progress-bar=add-to-batch] h4').html('');
                    }
                }
            }).submit();

        });

    });

</script>

<style type="text/css">
    div#ccm-tab-content-batch-content {
        padding-top: 0px;
    }

    #ccm-migration-batch-bulk-errors li {
        position: relative;
        padding-left: 35px
    }

    #ccm-migration-batch-bulk-errors li i {
        position: absolute;
        top: 5px;
        left: 0px;
        width: 30px;
        text-align: center;
    }
</style>