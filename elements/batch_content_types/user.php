<table data-migration-tree="<?=$identifier?>" class="migration-table table table-bordered table-striped">
    <colgroup>
        <col width="300"></col>
        <col width="*"></col>
        <col width="30px"></col>
        <col width="30px"></col>
    </colgroup>
    <thead>
    <tr> <th><?=t('Username')?></th> <th><?=t('Email')?></th> <th> </th> <th><input type="checkbox" data-checkbox="toggle-all"></th> </tr>
    </thead>
    <tbody>
    </tbody>
</table>

<script type="text/javascript">
    $(function() {
        $("[data-migration-tree=<?=$identifier?>]").migrationBatchTableTree({
            columnKey: 'user',
            lazyLoad: function(event, data) {
                data.result = {
                    url: '<?=$view->action('load_batch_user_data')?>',
                    data: {'id': data.node.data.id}
                }
            },
            renderInitialColumnData: function(cells, data) {
                var node = data.node;
                cells.eq(1).html(node.data.uEmail);
                cells.eq(2).html('<i class="' + node.data.statusClass + '"></i>');
            },
            source: {
                url: '<?=$view->action('load_batch_collection')?>',
                data: {'id': '<?=$collection->getID()?>'}
            }
        });
    });
</script>