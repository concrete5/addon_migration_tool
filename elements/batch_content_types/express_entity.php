<table id="migration-tree-table-<?=$identifier?>" class="migration-table table table-bordered table-striped">
    <colgroup>
        <col width="300"></col>
        <col width="*"></col>
        <col width="30px"></col>
        <col width="30px"></col>
    </colgroup>
    <thead>
    <tr> <th><?=t('Name')?></th> <th><?=t('Handle')?></th> <th><input type="checkbox" data-checkbox="toggle-all"></th> </tr>
    </thead>
    <tbody>
    </tbody>
</table>

<script type="text/javascript">
    $(function() {
        $("#migration-tree-table-<?=$identifier?>").migrationBatchTableTree({
            columnKey: 'express_entity',
            renderInitialColumnData: function(cells, data) {
                var node = data.node;
                cells.eq(1).html(node.data.handle);
                cells.eq(2).html('<i class="' + node.data.statusClass + '"></i>');
            },
            source: {
                url: '<?=$view->action('load_batch_collection')?>',
                data: {'id': '<?=$collection->getID()?>'}
            }
        });
    });
</script>