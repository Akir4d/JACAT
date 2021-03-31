<div class="grocerycrud-container card">
	<div class="card-header">
		<?php if (!$unset_add) { ?>
			<a role="button" class="btn btn-default" onclick='dtOpen("<?php echo $add_url ?>")'>
				<i class="fa fa-plus"></i>
				<?php echo $this->l('list_add'); ?> <?php echo $subject ?>
			</a>
		<?php } ?>
	</div>
	<div class="dataTablesContainer dt-bootstrap4">
		<div id='list-report-error' class='report-div error report-list'></div>
		<div id='list-report-success' class='report-div success report-list' <?php if ($success_message !== null) { ?>style="display:block" <?php } ?>></div>
		<?php if ($success_message !== null) : ?>
			<p><?php echo $success_message; ?></p>
		<?php endif; ?>
		<?php echo  $list_view ?>
	</div>

</div>
<?php
//echo '<pre>', var_dump($list[0]), '</pre>';
//super-lazy workaround for "ajax_list issue with this theme"
function ar($arg)
{
	$let = explode('/', $arg);
	$end = end($let);
	return substr($arg, 0, -strlen($end));
}

$this->set_css($this->default_theme_path . '/datatables4/css/datatables.css?v=0.31');



if ($dialog_forms) {
}

$this->set_js_lib($this->default_javascript_path . '/common/list.js');

//$this->set_js($this->default_theme_path . '/datatables4/js/datatables.js?v=0.4.15');
//$this->set_js($this->default_theme_path.'/datatables4/js/dataTables.responsive.min.js');
//$this->set_js($this->default_theme_path.'/datatables4/js/dataTables.searchPanes.min.js');

?>
<script type='text/javascript'>
	$.fn.dataTable.ext.errMode = function(settings, helpPage, message) {
		console.log(message);
	};
	var base_url = '<?php echo base_url(); ?>';
	var subject = '<?php echo addslashes($subject); ?>';
	var dialog_url = '<?php echo $ajax_list_info_url; ?>';
	var unique_hash = '<?php echo $unique_hash; ?>';
	var displaying_paging_string = "<?php echo str_replace(array('{start}', '{end}', '{results}'), array('_START_', '_END_', '_TOTAL_'), $this->l('list_displaying')); ?>";
	var filtered_from_string = "<?php echo str_replace('{total_results}', '_MAX_', $this->l('list_filtered_from')); ?>";
	var show_entries_string = "<?php echo str_replace('{paging}', '_MENU_', $this->l('list_show_entries')); ?>";
	var search_string = "<?php echo $this->l('list_search'); ?>";
	var list_no_items = "<?php echo $this->l('list_no_items'); ?>";
	var list_zero_entries = "<?php echo $this->l('list_zero_entries'); ?>";

	var list_loading = "<?php echo $this->l('list_loading'); ?>";

	var paging_first = "<?php echo $this->l('list_paging_first'); ?>";
	var paging_previous = "<?php echo $this->l('list_paging_previous'); ?>";
	var paging_next = "<?php echo $this->l('list_paging_next'); ?>";
	var paging_last = "<?php echo $this->l('list_paging_last'); ?>";

	var message_alert_delete = "<?php echo $this->l('alert_delete'); ?>";

	var default_per_page = <?php echo $default_per_page; ?>;

	var unset_export = <?php echo ($unset_export ? 'true' : 'false'); ?>;
	var unset_print = <?php echo ($unset_print ? 'true' : 'false'); ?>;

	var export_text = '<?php echo $this->l('list_export'); ?>';
	var print_text = '<?php echo $this->l('list_print'); ?>';
	var export_url = '<?php echo $export_url; ?>'
	var list_delete = '<?php echo $this->l('list_delete'); ?>';
	var list_cancel = '<?php echo $this->l('form_cancel'); ?>';
	var list_action = '<?php echo $this->l('list_actions') ?>';

	var numTemp = 0;
	var DTSearch = '&nbsp;&nbsp;<div class="dropdown d-inline" style="overflow: scroll">';
	DTSearch += '<button class="btn btn-primary dropdown-toggle" type="button" id="DTdropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
	DTSearch += '<?php echo $this->l('show_columns'); ?></button><div class="dropdown-menu text-sm" aria-labelledby="DTdropdownMenuButton" style="">';
	<?php if (!$unset_delete || !$unset_edit || !$unset_read || !empty($actions)) : ?>
		DTSearch += '<div onclick="showColumns(0, \'action\', !$(\'[name=vscolunm0]\').prop(\'checked\'));" class="dropdown-item"><input type="checkbox"';
		DTSearch += ' name="vscolunm0" ><label  for="vscolunm0" checked>&nbsp;&nbsp;'
		DTSearch += list_action + '</label></div>';
	<?php endif; ?>
	<?php
	$a = 0;

	if ($unset_show_columns ? 'true' : 'false') foreach ($columns as $column) :
		if ($column->field_name !== 'jobStatus') : ?>
			DTSearch += '<div onclick="showColumns(<?php echo ++$a ?>, \'<?php echo $column->display_as; ?>\', !$(\'[name=vscolunm<?php echo $a ?>]\').prop(\'checked\'));" class="dropdown-item"><input type="checkbox"';
			DTSearch += ' name="vscolunm<?php echo $a ?>" checked><label  for="vscolunm<?php echo $a ?>">&nbsp;&nbsp;'
			DTSearch += '<?php echo $column->display_as; ?></label></div>';
		<?php else : $a++;
		endif; ?>

	<?php endforeach; ?>
	DTSearch += '</div></div>';
	var default_per_page = typeof default_per_page !== 'undefined' ? default_per_page : 25;
	var oTable;
	var oTableArray = [];
	var oTableMapping = [];
	var examSS;
	var oResizeLauched = false;
	var responsiveTable = 'auto';
	var columnsCount = <?php echo count($columns); ?>;
	var searchTimeout;

	function chooseId(id, type) {
		$('.choose-group-' + id + ' .sel').removeClass('btn-primary').addClass('btn-default').removeClass('text-white');
		$('.choose-group-' + id + ' .' + type).removeClass('btn-default').addClass('text-white').addClass('btn-primary');
		let value = $('.choose-group-' + id).parent().find('input').val();
		if (value.length > 6) {
			let column = getColumn($('.choose-group-' + id).parent());
			$('.choose-group-' + id).parent().unbind('click.DT');
			let compval = getId(column) + value;
			clearTimeout(searchTimeout);
			searchTimeout = setTimeout(() => {
				oTable.fnSortListener($('.choose-group-' + id).parent(), column);
				oTable.api().column(column).search(compval).draw()
			}, 1000);
		}

	}

	function getId(id) {
		let res = '';
		$('th.th' + id + 'Nu .sel').each((i, e) => {
			if ($(e)
				.hasClass('btn-primary') && e.classList.length == 5) {
				e.classList.forEach((g) => {
					if (g == 'equals' || g == 'greater' || g == 'less') res = g
				})
			}
		});
		switch (res) {
			case 'equals':
				return '=^';
			case 'greater':
				return '>^';
			case 'less':
				return '<^';
		}
		return res;
	}

	function switchId(id) {

		let types = ['datetime-local', 'date', 'month'];
		let target = $('.choose-group-' + id).parent().find('input');
		let index = types.indexOf(target.attr('type'));
		index++;
		if (index == types.length) index = 0;
		target.attr('type', types[index]);
		target.val('');
		updateValues(id);
	}

	function updateValues(id, val = '') {
		let column = getColumn($('.choose-group-' + id).parent());
		updateFilter(column, val);
	}

	function updateFilter(column, val) {
		clearTimeout(searchTimeout);
		oTable.api().column(column).search(val);
		searchTimeout = setTimeout(() => {
			oTable._fnReDraw();
			setTimeout(() => oTable.fnSortListener($('th.th' + column + 'Nu'), column), 300);
		}, 1000);
	}

	function resetFilters(that) {
		oTable.api().search('');
		$('.groceryCrudTable').find('thead tr th input').val('');
		$('.groceryCrudTable').find('thead tr th').each((i, e) => {
			setTimeout(() => updateFilter(getColumn(e), ''), Math.floor(Math.random() * 10));
		});
	}

	function resetId(id) {
		$('.choose-group-' + id).parent().find('input').val('');
		updateValues(id);
		chooseId(id, 'equals');
	}

	function tableSettings() {
		let settings = {
			"processing": true,
			"serverSide": true,
			"deferLoading": 57,
			"ajax": {
				type: 'POST',
				url: "<?php echo $ajax_list_info_url; ?>" //,success: (r) => console.log(r)
			},
			columnDefs: [
				<?php
				$arrlist = '';
				$a = 0;
				if (!$unset_delete || !$unset_edit || !$unset_read || !empty($actions)) {
					$arrlist .= PHP_EOL . '{ className: "actions th' . $a . 'Nu", targets: ' . $a . ' },';
				}
				foreach ($columns as $column) {
					if ($column->field_name !== 'jobStatus')
						$arrlist .= PHP_EOL . '{ className: "printable th' . ++$a . 'Nu", targets: ' . $a . ' },';
				}
				echo trim($arrlist, ',');
				?>
			],
			"columns": [
				<?php
				$arrlist = '';
				function dateAdder($field)
				{
					$a = 0;
					$dateadder = '
					<div class="btn-group btn-group-sm float-right dt-ci-input-add d-none">
					<a onclick="switchId(\'' . $field . '\')" class="btn btn-outline-warning">
					<i class="fas fa-calendar-alt"></i>
					</a>
					<a onclick="resetId(\'' . $field . '\')" class="btn btn-outline-danger">
					<i class="fas fa-times"></i>
					</a>
					</div>
					<div class="btn-group btn-group-sm dt-ci-input-add d-none choose-group-' . $field . '">
					<a onclick="chooseId(\'' . $field . '\', \'less\')" class="btn btn-default sel less">
					<i class="fas fa-less-than"></i>
					</a>
					<a onclick="chooseId(\'' . $field . '\', \'equals\')" class="btn btn-primary text-white sel equals">
					<i class="fas fa-equals"></i>
					</a>
					<a onclick="chooseId(\'' . $field . '\', \'greater\')" class="btn btn-default sel greater">
					<i class="fas fa-greater-than"></i>
					</a>
					</div><hr class="dt-ci-input-add d-none">
					';
					return str_replace('"', '\"', str_replace("\t", '', str_replace("\r", '', str_replace("\n", '', $dateadder))));
				}

				function additional_action()
				{
					$ret = '<div class="dt-ci-input-add-block d-none btn-group" style="min-width: 90px" >
					<a class="btn btn-default refresh-data">
                        <i class="fas fa-sync-alt"></i>
                    </a>
                    <a class="clear-filtering btn btn-default">
                        <i class="fas fa-times"></i> <i class="fas fa-long-arrow-alt-right"></i>
                    </a>
                    </duv>';
					return str_replace('"', '\"', str_replace("\t", '', str_replace("\r", '', str_replace("\n", '', $ret))));
				}

				$a = 0;
				if (!$unset_delete || !$unset_edit || !$unset_read || !empty($actions)) {

					$arrlist .= '{ title: "' . $this->l('list_actions') . '<br class=\"dt-ci-input-add d-none\">' . additional_action() . '", name: "action", data: (e)=>format_fields(e, "action"), searchable: false, orderable: false },';
				}
				foreach ($columns as $column) {
					if ($column->field_name !== 'jobStatus') {
						$type = 'search';
						$additional = '';
						switch (@$types[$column->field_name]->crud_type) {
							case 'date':
								$type = 'date';
								$additional = dateAdder($column->field_name);
								break;
							case 'datetime':
								$type = 'datetime-local';
								$additional = dateAdder($column->field_name);
								break;
						}
						$arrlist .= PHP_EOL . '{ title: "' . $additional . '<span texthead=\"true\">' . $column->display_as . '</span>' . '<br class=\"dt-ci-input-add d-none\"><input class=\"form-control dt-ci-input d-none\" type=\"' . $type . '\" placeholder=\"' . $this->l('list_search') . '\" />", name: "' . $column->field_name . '", data: (e)=>format_fields(e, "' . $column->field_name . '")},';
					} else {
						$arrlist .= PHP_EOL . '{ "searchable": false, "orderable": false, "searchable": false,  data: (e)=>color_field(e)},';
					}
				}
				echo trim($arrlist, ',');
				?>
			],
			"iDisplayLength": default_per_page,
			"stateSave": true,
			"sPaginationType": "full_numbers",
			"bStateSave": true,

			"stateSaveCallback": function(oSettings, oData) {
				localStorage.setItem('DataTables_' + unique_hash, JSON.stringify(oData).replace('columns', 'colunms_disable'));
			},
			"stateLoadCallback": function(oSettings) {
				return JSON.parse(localStorage.getItem('DataTables_' + unique_hash));
			},
			"fnInitComplete": function() {
				let currenTable = this;
				this.api().columns().every(function() {
					var that = this;
					$('thead .dt-ci-input-add').on('click mouseover', function() {
						$(this).parent().unbind('click.DT')
					}).on('mouseleave', function() {
						$(this).parent().unbind('click.DT');
						currenTable.fnSortListener($(this).parent(), getColumn($(this).parent()));
					});
					$('thead input.dt-ci-input').on('click mouseover', function() {
						$(this).parent().unbind('click.DT')
					}).on('mouseleave', function() {
						$(this).parent().unbind('click.DT');
						currenTable.fnSortListener($(this).parent(), getColumn($(this).parent()));
					});
					$('thead input.dt-ci-input').off('click').on('keyup change clear input ', function() {
						let column = getColumn($(this).parent());
						if (that.search() !== this.value) {
							$(this).parent().unbind('click.DT');
							let compval = getId(column) + this.value;
							clearTimeout(searchTimeout);
							searchTimeout = setTimeout(() => {
								currenTable.fnSortListener($(this).parent(), column);
								currenTable.api().column(column).search(compval).draw()
							}, 1000);
						}
					})
				});
				after_draw_callback();
			},
			"oLanguage": {
				"sProcessing": list_loading,
				"sLengthMenu": show_entries_string,
				"sZeroRecords": list_no_items,
				"sInfo": displaying_paging_string,
				"sInfoEmpty": list_zero_entries,
				"sInfoFiltered": filtered_from_string,
				"sSearch": search_string + ":",
				"oPaginate": {
					"sFirst": paging_first,
					"sPrevious": paging_previous,
					"sNext": paging_next,
					"sLast": paging_last
				}
			},

			"bDestory": true,
			"bRetrieve": true,
			"buttons": bButtons,
			"fnDrawCallback": function() {
				$('td').removeClass('printable');
			},
			"dom": '<"card-body"B<"float-right"f>t><"card-footer"lr<"float-right"p>i>'
		};
		switch (responsiveTable) {
			case 'true':
				settings.responsive = true;
				break;
			case 'false':
				settings.scrollX = true;
				break;
			default:
				if (columnsCount < 6) {
					settings.responsive = true;
				} else {
					settings.scrollX = true;
				}
		}
		return settings;
	}

	function color_field(e) {
		setTimeout(() =>
			$('.tid' + e.primary_key_value).parent().parent().addClass('tr-' + e.jobStatus.v), 200);
	}

	function getColumn(let) {
		let result = 0;
		$(let).attr('class').split(' ').forEach((e) => {
			if (e.startsWith('th') && e.endsWith('Nu')) result = parseInt(e.replace('th', '').replace('Nu', ''))
		});
		return result;
	}


	<?php
	$elements = array();
	$labels = array();
	$row = $list[0];
	if (!empty($row->action_urls)) {
		foreach ($row->action_urls as $action_unique_id => $action_url) {
			$action = $actions[$action_unique_id];
			$elements[$action_unique_id] = $action->css_class;
			$labels[$action_unique_id] = $action->label;
		}
	}
	echo 'var actionsCss = ' . json_encode($elements, JSON_PRETTY_PRINT) . ';' . PHP_EOL;
	echo 'var actionsLabel = ' . json_encode($labels, JSON_PRETTY_PRINT) . ';' . PHP_EOL;
	?>

	function actionsLink(actions, menu = false) {
		ret = '';
		if (actions !== null) {
			for (const [key, value] of Object.entries(actions)) {
				if (value !== undefined) {
					if (menu) {
						ret += ` <li> <a class="dropdown-item" onclick='dtOpen("` + value + `")'>
                                            <i class="` + actionsCss[key] + `"></i> ` + actionsLabel[key] + `
                                        </a></li>`;
					} else {
						ret += `<a onclick='dtOpen("` + value + `")' class="btn btn-default margin-stop">
                                        <i class="` + actionsCss[key] + `"></i>
                                    </a>`;
					}
				}
			}
		}
		return ret;
	}


	function actionButton(id, actions = null) {
		return `<div class="btn-group tid` + id + `">
						    ` + actionsLink(actions) + `
                            <?php if (!$unset_read) { ?>
                                <a onclick='dtOpen("<?php echo ar($row->read_url) ?>` + id + `")' class="btn btn-default margin-stop">
                                    <i class="fas fa-eye text-info"></i>
                                </a>
                            <?php } ?>

                            <?php if (!$unset_clone) { ?>
                                <a onclick='dtOpen("<?php echo ar($row->clone_url) ?>` + id + `")' class="btn btn-default margin-stop">
                                    <i class="fas fa-copy text-primary"></i>
                                </a>
                            <?php } ?>

                            <?php if (!$unset_edit) { ?>
                                <a onclick='dtOpen("<?php echo ar($row->edit_url) ?>` + id + `")' class="btn btn-default margin-stop">
                                    <i class="fas fa-pencil-alt text-success"></i>
                                </a>
                            <?php } ?>

                            <?php if (!$unset_delete) { ?>
                                <a onclick="javascript: return delete_row('<?php echo ar($row->delete_url) ?>` + id + `', '` + id + `')" href="javascript:void(0)" class="btn btn-default margin-stop">
                                    <i class="fas fa-trash-alt text-danger"></i>
                                </a>
                            <?php } ?>
                        </div>
						`
	}


	function actionMenu(id, value, actions = null) {
		return `
		<div class="dropdown">
                            <span texttogo="true" class="black-text" type="button" style="min-width: 50px; min-height: 20px" data-toggle="dropdown" aria-expanded="false">
							` + value + `
                            </span>
                            <ul class="dropdown-menu">

							` + actionsLink(actions, true) + `
                                <?php if (!$unset_read) { ?>
                                    <li> <a class="dropdown-item" onclick='dtOpen("<?php echo ar($row->read_url) ?>` + id + `")'>
                                            <i class="fa fa-eye text-info"></i> <?php echo $this->l('list_view'); ?>
                                        </a></li>
                                <?php } ?>

                                <?php if (!$unset_clone) { ?>
                                    <li> <a class="dropdown-item" onclick='dtOpen("<?php echo ar($row->clone_url) ?>` + id + `")'>
                                            <i class="fa fa-copy text-primary"></i> <?php echo $this->l('list_clone'); ?>
                                        </a></li>
                                <?php } ?>

                                <?php if (!$unset_edit) { ?>
                                    <li> <a class="dropdown-item" onclick='dtOpen("<?php echo ar($row->edit_url) ?>` + id + `")'>
                                            <i class="fas fa-pencil-alt text-success"></i> <?php echo $this->l('list_edit'); ?>
                                        </a></li>
                                <?php } ?>

                                <?php if (!$unset_delete) { ?>
                                    <li> <a class="dropdown-item" onclick="javascript: return delete_row('<?php echo ar($row->delete_url) ?>` + id + `', '` + id + `')" href="javascript:void(0)">
                                            <i class="fas fa-trash-alt text-danger"></i>
                                            <b class="text-danger"><?php echo $this->l('list_delete') ?></b>
                                        </a></li>
                                <?php } ?>
                            </ul>
                        </div>
		`
	}



	function supports_html5_storage() {
		try {
			JSON.parse("{}");
			return 'localStorage' in window && window['localStorage'] !== null;
		} catch (e) {
			return false;
		}
	}

	function success_message(message) {
		$('#list-report-success').html(message);
		$('#list-report-success').slideDown();
	}

	function error_message(message) {
		$('#list-report-error').html(message);
		$('#list-report-error').slideDown();
	}

	var use_storage = supports_html5_storage();

	var aButtons = [];
	var bButtons = [];
	var mColumns = [];

	$(document).ready(function() {

		$('table.groceryCrudTable thead tr th').each(function(index) {
			if (!$(this).hasClass('actions')) {
				mColumns[index] = index;
			}
		});

		if (!unset_export) {
			bButtons.push({
				extend: 'copy',
				text: '<i class="far fa-clipboard"></i>',
				exportOptions: {
					columns: ['.printable'],
					format: {
						body: (e) => {
							if (e !== null) {
								let res = capture_span(e);

								if (typeof res !== 'undefined') {
									return res;
								} else {
									return '';
								}
							} else {
								return '';
							}
						},
						header: (e) => {
							if (e !== null) {
								let res = capture_span(e);
								if (typeof res !== 'undefined') {
									return res;
								} else {
									return '';
								}
							} else {
								return '';
							}
						}
					}
				}
			}, {
				extend: 'excel',
				text: '<i class="far fa-file-excel"></i>',
				exportOptions: {
					columns: ['.printable'],
					format: {
						body: (e) => {
							if (e !== null) {
								let res = capture_span(e);

								if (typeof res !== 'undefined') {
									return res;
								} else {
									return '';
								}
							} else {
								return '';
							}
						},
						header: (e) => {
							if (e !== null) {
								let res = capture_span(e);
								if (typeof res !== 'undefined') {
									return res;
								} else {
									return '';
								}
							} else {
								return '';
							}
						}
					}
				}
			});

		}

		if (!unset_print) {
			bButtons.push({
				extend: 'print',
				text: '<i class="fas fa-print"></i>',
				exportOptions: {
					columns: ['.printable'],
					modifier: {
						// DataTables core
						order: 'current', // 'current', 'applied', 'index',  'original'
						page: 'all', // 'all',     'current'
						search: 'none', // 'none',    'applied', 'removed'

						// Extension - KeyTable (v2.1+) - cells only
						focused: undefined, // true, false, undefined

						// Extension - Select (v1.0+)
						selected: undefined // true, false, undefined
					},
					format: {
						body: (e) => {
							if (e !== null) {
								let res = capture_span(e);

								if (typeof res !== 'undefined') {
									return res;
								} else {
									return '';
								}
							} else {
								return '';
							}
						},
						header: (e) => {
							if (e !== null) {
								let res = capture_span(e);
								if (typeof res !== 'undefined') {
									return res;
								} else {
									return '';
								}
							} else {
								return '';
							}
						}
					}
				}
			});
		}

		//For mutliplegrids disable bStateSave as it is causing many problems
		if ($('.groceryCrudTable').length > 1) {
			use_storage = true;
		}

		$('.groceryCrudTable').each(function(index) {
			if (typeof oTableArray[index] !== 'undefined') {
				return false;
			}
			oTableMapping[$(this).attr('id')] = index;
			oTableArray[index] = loadDataTable(this);
		});

		$(".groceryCrudTable thead input").keyup(function() {
			oTable.fnFilter(this.value, parseInt($(this).attr('data-index')));
		});
		/*
		var search_values = localStorage.getItem('datatables_search_' + unique_hash);

		if (search_values !== null) {
			$.each($.parseJSON(search_values), function(num, val) {
				if (val !== '') {
					$(".groceryCrudTable thead tr th:eq(" + num + ")").children(':first').val(val);
				}
			});
		}
        */
		$('.clear-filtering').click(function() {
			localStorage.removeItem('DataTables_' + unique_hash);
			localStorage.removeItem('datatables_search_' + unique_hash);

			resetFilters(this);
		});

		loadListenersForDatatables();

		$('a.ui-button').on("mouseover mouseout", function(event) {
			if (event.type == "mouseover") {
				$(this).addClass('ui-state-hover');
			} else {
				$(this).removeClass('ui-state-hover');
			}
		});

		$('th.actions').unbind('click');
		$('th.actions>div .DataTables_sort_icon').remove();
		fix_table_size();
		$('.dt-buttons').after(DTSearch);
		showColumns(0, 'action', <?php echo ($action_button) ? 'true' : 'false'; ?>, false, 400);
		$('.dt-buttons button').removeClass('btn-secondary').addClass('btn-primary');
	});

	function loadListenersForDatatables() {
		$('.refresh-data').click(function() {
			location.reload();
		});
	}

	function capture_span(input) {
		if (input !== null) {
			let res = JSON.stringify(input.replace((/  |\r\n|\n|\r|\t/gm), "")).replace(/[\\']+/g, '').match(/<span text.+?span>/g);
			if (res === null) {
				return input;
			} else {
				return strip_tags(res[0]);
			}
		} else {
			return '';
		}
	}

	function strip_tags(input, allowed) {
		allowed = (((allowed || "") + "").toLowerCase().match(/<[a-z][a-z0-9]*>/g) || []).join(''); // making sure the allowed arg is a string containing only tags in lowercase (<a><b><c>)
		var tags = /<\/?([a-z][a-z0-9]*)\b[^>]*>/gi,
			commentsAndPhpTags = /<!--[\s\S]*?-->|<\?(?:php)?[\s\S]*?\?>/gi;
		if (input !== null) {
			return input.replace(commentsAndPhpTags, '').replace(tags, function($0, $1) {
				return allowed.indexOf('<' + $1.toLowerCase() + '>') > -1 ? $0 : '';
			});
		} else {
			return '';
		}
	}





	function format_fields(e, name) {
		if (name == "action") return actionButton(e.primary_key_value, e.action_urls);
		let value = e[name];
		if (typeof e[name] === 'object' && e[name] !== null) {
			switch (e[name].t) {
				case 'true_false':
					if (e[name].v !== null) {
						let val = strip_tags(e[name].v);
						if (val == 1) {
							value = actionMenu(e.primary_key_value, '<i class="fas fa-check ci_btOn" style="color:#00a65a"><b class="invisible">1</b></i>', e.action_urls);
						} else if (val == 0) {
							value = actionMenu(e.primary_key_value, '<i class="fas fa-times ci_btOff" style="color:#f56954"><b class="invisible">0</b></i>', e.action_urls);
						} else {
							value = '';
						}
					} else {
						value = e[name].v;
					}
					break;
				default:
					value = actionMenu(e.primary_key_value, (e[name].v !== null) ? e[name].v : '', e.action_urls);
			}
		} else {
			value = actionMenu(e.primary_key_value, (value !== null) ? value : '', e.action_urls);
		}

		return value;
	}




	function loadDataTable(this_datatables) {
		return oTable = $(this_datatables).dataTable(tableSettings());
	}

	function datatables_get_chosen_table(table_as_object) {
		//chosen_table_index = oTableMapping[table_as_object.attr('id')];
		return oTable; //Array[chosen_table_index];
	}

	function reset_dataTable_filters() {


	}

	function delete_row(delete_url, row_id) {
		bootbox.confirm({
			message: message_alert_delete,
			buttons: {
				confirm: {
					label: list_delete + ' <i class="fas fa-trash-alt"></i>',
					className: 'btn-danger'
				},
				cancel: {
					label: list_cancel + ' <i class="fas fa-times"></i>',
					className: 'btn-default'
				}
			},
			callback: function(result) {
				if (result) {
					$.ajax({
						url: delete_url,
						dataType: 'json',
						success: function(data) {
							if (data.success) {
								chosen_table = datatables_get_chosen_table($('tr#row-' + row_id).closest('.groceryCrudTable'));

								$('tr#row-' + row_id).addClass('row_selected');
								var anSelected = fnGetSelected(chosen_table);
								chosen_table.fnDeleteRow(anSelected[0]);
								$(".refresh-data").trigger("click");
							} else {
								error_message(data.error_message);
							}
						}
					});
				}
			}
		});
		return false;
	}

	function fnGetSelected(oTableLocal) {
		var aReturn = new Array();
		var aTrs = oTableLocal.fnGetNodes();

		for (var i = 0; i < aTrs.length; i++) {
			if ($(aTrs[i]).hasClass('row_selected')) {
				aReturn.push(aTrs[i]);
			}
		}
		return aReturn;
	}



	$(window).on('resize', function() {
		//ok, I will wait all animations end
		$(window).one("webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend", fix_table_size);
	});


	function after_draw_callback() {
		//If there is no thumbnail this means that the fancybox library doesn't exist
		if ($('.image-thumbnail').length > 0) {
			$('.image-thumbnail').fancybox({
				'transitionIn': 'elastic',
				'transitionOut': 'elastic',
				'speedIn': 600,
				'speedOut': 200,
				'rotate': true,
				'buttons': [
					"zoom",
					"share",
					"slideShow",
					"fullScreen",
					"download",
					"thumbs",
					"close"
				]
			});
		}
		$('.add-menu-class').each(function(e) {
			var sID = $(this).attr('data-row');
			var tmod = $('#row-' + sID + ' div.d-none a.black-text').text($(this).text());
			var timpH = $('#row-' + sID + ' div.d-none').html();
			$(this).html(timpH).attr('class', 'dropdown').removeAttr('data-row');
		});
		// $('td>div.invisible').remove();

		//add_edit_button_listener();


		if (!$('.more-searchOption').length) {
			$('.dataTables_filter').addClass('d-inline').parent().append(' <a class="more-searchOption btn btn-default d-inline"><i class="fas fa-search-plus"></i></a>');
			$('.more-searchOption').click(function() {
				if (!$('.form-control.dt-ci-input').first().hasClass('d-none')) {
					$('.form-control.dt-ci-input').addClass('d-none');
					$('div.dt-ci-input-add').addClass('d-none').removeClass('d-inline');
					$('br.dt-ci-input-add').addClass('d-none').removeClass('d-block');
					$('hr.dt-ci-input-add').addClass('d-none').removeClass('d-block');
					$('div.dt-ci-input-add-block').addClass('d-none');
				} else {
					$('.form-control.dt-ci-input').removeClass('d-none');
					$('div.dt-ci-input-add').removeClass('d-none').addClass('d-inline');
					$('br.dt-ci-input-add').removeClass('d-none').addClass('d-block');
					$('hr.dt-ci-input-add').removeClass('d-none').addClass('d-block');
					$('div.dt-ci-input-add-block').removeClass('d-none');
				}
				oTable._fnReDraw();
			});
			$('.dataTables_length').addClass('d-inline').append('&emsp;&emsp;');
			$('.dataTables_info').addClass('d-inline').append('&emsp;');
			$('.dataTables_length select').append('<option value="-1">∞</option>');
		}
	}

	//Fancybox Hack https://github.com/fancyapps/fancybox/issues/1100#issuecomment-462074860 to add Rotate
	var RotateImage = function(instance) {
		this.instance = instance;

		this.init();
	};

	$.extend(RotateImage.prototype, {
		$button_left: null,
		$button_right: null,
		transitionanimation: true,

		init: function() {
			var self = this;
			self.$button_right = $('<button data-rotate-right class="fancybox-button fancybox-button--rotate" title="">' +
					'<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">' +
					'  <path d="M11.074,9.967a4.43,4.43,0,1,1-4.43-4.43V8.859l5.537-4.43L6.644,0V3.322a6.644,6.644,0,1,0,6.644,6.644Z" transform="translate(10.305 1) rotate(30)"/>' +
					'</svg>' +
					'</button>')
				.prependTo(this.instance.$refs.toolbar)
				.on('click', function(e) {
					self.rotate('right');
				});
			self.$button_left = $('<button data-rotate-left class="fancybox-button fancybox-button--rotate" title="">' +
					'<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">' +
					'  <path d="M11.074,6.644a4.43,4.43,0,1,0-4.43,4.43V7.752l5.537,4.43-5.537,4.43V13.289a6.644,6.644,0,1,1,6.644-6.644Z" transform="translate(21.814 15.386) rotate(150)"/>' +
					'</svg>' +
					'</button>')
				.prependTo(this.instance.$refs.toolbar)
				.on('click', function(e) {
					self.rotate('left');
				});


		},

		rotate: function(direction) {
			var self = this;
			var image = self.instance.current.$image[0];
			var angle = parseInt(self.instance.current.$image.attr('data-angle')) || 0;

			if (direction == 'right') {
				angle += 90;
			} else {
				angle -= 90;
			}

			if (!self.transitionanimation) {
				angle = angle % 360;
			} else {
				$(image).css('transition', 'transform .3s ease-in-out');
			}

			self.instance.current.$image.attr('data-angle', angle);

			$(image).css('webkitTransform', 'rotate(' + angle + 'deg)');
			$(image).css('mozTransform', 'rotate(' + angle + 'deg)');
		}

	});

	function fix_table_size_real() {
		clearTimeout(fixTableTiemout);
		clearTimeout(fixTableTiemout);
		clearTimeout(fixTableTiemout);
		clearTimeout(fixTableTiemout);
		clearTimeout(fixTableTiemout);
		// put table in oversize
		$('table.groceryCrudTable').first().attr('style', 'width: ' + parseInt($('div.dataTablesContainer').first().width() - 40) + 'px');
		// fit table
		oTable.fnAdjustColumnSizing();
		// redraw table
		oTable.fnDraw();
	}

	var fixTableTiemout;

	function fix_table_size(force = false, timeout = 200) {
		clearTimeout(fixTableTiemout);
		if (!oResizeLauched || force) {
			if (!force) oResizeLauched = true;
			fixTableTiemout = setTimeout(function() {
				$(window).one("webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend", fix_table_size_real);
				fix_table_size_real();
				if (!force) oResizeLauched = false;
			}, timeout + Math.floor(Math.random() * 101));
		}
	}

	$(document).on('onInit.fb', function(e, instance) {
		if (!!instance.opts.rotate) {
			instance.Rotate = new RotateImage(instance);
		}
	});

	$(document).on('collapsed.lte.pushmenu', fix_table_size);
	$(document).on('shown.lte.pushmenu', fix_table_size);



	function setCookieDT(cname, cvalue, hour) {
		let d = new Date();
		let value = (cvalue == false || cvalue == 0) ? 0 : 1;
		d.setTime(d.getTime() + (hour * 60 * 60 * 1000));
		let expires = "expires=" + d.toUTCString();
		document.cookie = 'DT' + cname.replace(/[^A-Z0-9]/ig, "_") + "=" + value + ";" + expires + ";path=/";
	}

	function getCookieDT(cname) {
		let name = 'DT' + cname.replace(/[^A-Z0-9]/ig, "_") + "=";
		let decodedCookie = decodeURIComponent(document.cookie);
		let ca = decodedCookie.split(';');
		for (var i = 0; i < ca.length; i++) {
			var c = ca[i];
			while (c.charAt(0) == ' ') {
				c = c.substring(1);
			}
			if (c.indexOf(name) == 0) {
				return c.substring(name.length, c.length);
			}
		}
		return 1;
	}

	function getCookie(cname) {
		let name = cname + "=";
		let decodedCookie = decodeURIComponent(document.cookie);
		let ca = decodedCookie.split(';');
		for (var i = 0; i < ca.length; i++) {
			var c = ca[i];
			while (c.charAt(0) == ' ') {
				c = c.substring(1);
			}
			if (c.indexOf(name) == 0) {
				return c.substring(name.length, c.length);
			}
		}
		return '';
	}

	function showColumns(index, name, onOff, nofix = false, timeout = 310) {
		//disabled for now
		$('[name=vscolunm' + index + ']').prop('checked', onOff);
		target = 'th.th' + index + 'Nu';
		$(target).removeClass('printable');
		setCookieDT(name, onOff, 2);
		oTable.fnSetColumnVis(index, onOff);
		if (onOff == true) {
			if (!$(target).hasClass('action')) $(target).addClass('printable');
		}
		if (!nofix) fix_table_size(true, timeout);
		if (!nofix) setTimeout(function() {
			$('tbody td[tabindex]').removeAttr('tabindex');
		}, timeout);
	}

	function dtOpen(link, modal = <?php echo ($use_modal) ? 'true' : 'false'; ?>) {
		if (modal) {
			let fix = "<script> setTimeout(function(){$('.chosen-container').css('width', '100%');}, 500); <\/script>";
			$.ajax({
				type: 'get',
				url: link,
				success: function(data) {
					bootbox.dialog({
						message: data + fix,
						size: 'xl',
						onHide: function() {
							if (!$('.viewOnlyButton').length) {
								$('.cardType').remove();
							}
						}
					});
				},
				error: function(xhr, textStatus, errorThrown) {
					bootbox.alert(xhr.responseText);
				}
			});
		} else {
			window.location.href = link;
		}
	}
	//bootbox.setLocale(moment.locale(navigator.language));
	function ciBsOnHandler(el) {
		console.log($(el).closest('tr').attr('id'))
	};

	function ciBsOffHandler(el) {
		console.log($(el).closest('tr').attr('id'))
	};
</script>