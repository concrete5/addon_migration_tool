<table id="migration-tree-table-<?=$identifier?>" class="migration-table table table-bordered table-striped">
    <colgroup>
        <col width="300"></col>
        <col width="*"></col>
        <col width="120px"></col>
        <col width="120px"></col>
        <col width="30px"></col>
        <col width="30px"></col>
    </colgroup>
    <thead>
    <tr> <th><?=t('Name')?></th> <th><?=t('Handle')?></th> <th><?=t('Type')?></th> <th><?=t('Category')?></th> <th> </th> <th><input type="checkbox" data-checkbox="toggle-all"></th> </tr>
    </thead>
    <tbody>
    </tbody>
</table>

<script type="text/javascript">
    $(function() {
        $("#migration-tree-table-<?=$identifier?>").migrationBatchTableTree({
            columnKey: 'attribute_key',
            renderInitialColumnData: function(cells, data) {
                var node = data.node;
                cells.eq(1).html(node.data.handle);
                cells.eq(2).text(node.data.type);
                cells.eq(3).text(node.data.category);
                cells.eq(4).html('<i class="' + node.data.statusClass + '"></i>');
            },
            source: {
                url: '<?=$view->action('load_batch_collection')?>',
                data: {'id': '<?=$collection->getID()?>'}
            }
        });
    });
</script>