!function(global, $) {

	function MigrationBatchTableTree($table, options) {
		var my = this;
		options = options || {};
		options = $.extend({
			source: {},
			init: false,
			lazyLoad: false,
			columnKey: false,
			renderInitialColumnData: false,
			renderColumns: function(event, data) {
				my.renderColumns(event, data);
			}
		}, options);
		my.$table = $table;
		my.options = options;
		my.$table.fancytree({
			extensions: ["glyph","table"],
			toggleEffect: false,
			source: options.source,
			init: options.init,
			table: {
				checkboxColumnIdx: null,
				customStatus: false,
				indentation: 16,         // indent every node level by 16px
				nodeColumnIdx: 0
			},
			lazyLoad: options.lazyLoad,
			renderColumns: options.renderColumns,
			clickFolderMode: 2,
			focusOnSelect: false,
			glyph: {
				map: {
					doc: "fa fa-file-o",
					docOpen: "fa fa-file-o",
					checkbox: "fa fa-square-o",
					checkboxSelected: "fa fa-check-square-o",
					checkboxUnknown: "fa fa-share-square",
					dragHelper: "fa fa-play",
					dropMarker: "fa fa-angle-right",
					error: "fa fa-warning",
					expanderClosed: "fa fa-plus-square-o",
					expanderLazy: "fa fa-plus-square-o",  // glyphicon-expand
					expanderOpen: "fa fa-minus-square-o",  // glyphicon-collapse-down
					folder: "fa fa-folder-o",
					folderOpen: "fa fa-folder-open-o",
					loading: "fa fa-spin fa-refresh"
				}
			},
			beforeActivate: function(event, data) {
				return false;
			}
		});
	}

	MigrationBatchTableTree.prototype.renderColumns = function(event, data) {
		var my = this,
			node = data.node,
			cells = $(node.tr).find(">td");

		if (node.data.exists) {
			$(node.tr).addClass('migration-item-skipped');
		}
		if (node.data.nodetype == my.options.columnKey) {
			my.options.renderInitialColumnData(cells, data);
			cells.eq(cells.length - 1).html('<input data-checkbox="select-item" type="checkbox" name="item[' + my.options.columnKey + '][]" value="' + data.node.data.id + '">');
		} else if (node.data.itemvalue) {
			var colspan = cells.length - 1;
			cells.eq(1).html(node.data.itemvalue);
			cells.eq(1).prop("colspan", colspan).nextAll().remove();
		} else {
			var colspan = cells.length;
			cells.eq(0).prop("colspan", colspan).nextAll().remove();
		}
		$('.launch-tooltip').tooltip({'container': '#ccm-tooltip-holder'});
	}

	// jQuery Plugin
	$.fn.migrationBatchTableTree = function(options) {
		return $.each($(this), function(i, obj) {
			new MigrationBatchTableTree($(this), options);
		});
	}

	global.MigrationBatchTableTree = MigrationBatchTableTree;


}(window, jQuery);