<table id="migration-tree-table-<?=$identifier?>" class="migration-table table table-bordered table-striped">
    <colgroup>
        <col width="*"></col>
        <col width="*"></col>
        <col width="30px"></col>
        <col width="30px"></col>
    </colgroup>
    <thead>
    <tr>
        <th><?=t('Title')?></th>
        <th><?=t('Handle')?></th>
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
            columnKey: 'page_feed',
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