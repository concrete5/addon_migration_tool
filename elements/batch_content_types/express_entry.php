<table id="migration-tree-table-<?=$identifier?>" class="migration-table table table-bordered table-striped">
    <colgroup>
        <col width="100"></col>
        <col width="100"></col>
        <col width="*"></col>
        <col width="30px"></col>
        <col width="30px"></col>
    </colgroup>
    <thead>
    <tr> <th><?=t('Entity')?></th>  <th><?=t('Import ID')?></th> <th><?=t('Label')?></th> <th><input type="checkbox" data-checkbox="toggle-all"></th> </tr>
    </thead>
    <tbody>
    </tbody>
</table>

<script type="text/javascript">
    $(function() {
        $("#migration-tree-table-<?=$identifier?>").migrationBatchTableTree({
            columnKey: 'express_entry',
            renderInitialColumnData: function(cells, data) {
                var node = data.node;
                cells.eq(1).html(node.data.importID);
                cells.eq(2).html(node.data.label);
                cells.eq(3).html('<i class="' + node.data.statusClass + '"></i>');
            },
            source: {
                url: '<?=$view->action('load_batch_collection')?>',
                data: {'id': '<?=$collection->getID()?>'}
            },
            lazyLoad: function(event, data) {
                data.result = {
                    url: '<?=$view->action('load_batch_express_entry_data')?>',
                    data: {'id': data.node.data.id}
                }
            }
        });
    });
</script>