<table data-migration-tree="<?=$identifier?>" class="migration-table table table-bordered table-striped">
    <colgroup>
        <col width="300"></col>
        <col width="*"></col>
        <col width="120px"></col>
        <col width="30px"></col>
        <col width="30px"></col>
    </colgroup>
    <thead>
    <tr> <th><?=t('Page')?></th> <th><?=t('Path')?></th> <th><?=t('Type')?></th> <th> </th> <th><input type="checkbox" data-checkbox="toggle-all"></th> </tr>
    </thead>
    <tbody>
    </tbody>
</table>

<script type="text/javascript">
    $(function() {
        $("[data-migration-tree=<?=$identifier?>]").migrationBatchTableTree({
            columnKey: 'page',
            init: function() {
                $('[data-editable-property=path]').editable({
                    container: '#ccm-dashboard-content',
                    url: '<?=$view->action('update_page_path')?>'
                });
            },
            lazyLoad: function(event, data) {
                data.result = {
                    url: '<?=$view->action('load_batch_page_data')?>',
                    data: {'id': data.node.data.id}
                }
            },
            renderInitialColumnData: function(cells, data) {
                var node = data.node;
                cells.eq(1).html(node.data.pagePath);
                cells.eq(2).text(node.data.pageType);
                cells.eq(3).html('<i class="' + node.data.statusClass + '"></i>');
            },
            source: {
                url: '<?=$view->action('load_batch_collection')?>',
                data: {'id': '<?=$collection->getID()?>'}
            }
        });
    });
</script>