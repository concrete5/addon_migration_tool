<table id="migration-tree-table-<?=$identifier?>" class="migration-table table table-bordered table-striped">
    <colgroup>
        <col width="*"></col>
        <col width="*"></col>
        <col width="*"></col>
        <col width="30px"></col>
        <col width="30px"></col>
    </colgroup>
    <thead>
    <tr>
        <th><?=t('Name')?></th>
        <th><?=t('Handle')?></th>
        <th><?=t('Types')?></th>
        <th></th>
        <th><input type="checkbox" data-checkbox="toggle-all"></th>
    </tr>
    </thead>
    <tbody>
    </tbody>
</table>


<script type="text/javascript">
    $(function() {
        $("#migration-tree-table-<?=$identifier?>").migrationBatchTableTree({
            columnKey: 'block_type_set',
            renderInitialColumnData: function(cells, data) {
                var node = data.node;
                cells.eq(1).html(node.data.handle);
                cells.eq(2).text(node.data.blockTypes);
                cells.eq(3).html('<i class="' + node.data.statusClass + '"></i>');
            },
            source: {
                url: '<?=$view->action('load_batch_collection')?>',
                data: {'id': '<?=$collection->getID()?>'}
            }
        });
    });
</script>