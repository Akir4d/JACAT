<?php if ($success_message !== null) : ?>
	<div class="alert alert-success alert-dismissible">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		<p><i class="icon fas fa-check"></i> <?php echo $success_message; ?></p>

	</div>
<?php endif; ?>
<a class="d-none refresh-data">
	<i class="fas fa-sync-alt"></i>
</a>
<div class="grocerycrud-container card">
	<?php if (!$unset_add) : ?>
		<div class="card-header">
			<?php if (!$unset_add) : ?>
				<a role="button" class="btn btn-default" onclick='dtOpen("<?php echo $add_url ?>")'>
					<i class="fa fa-plus"></i>
					<?php echo $this->l('list_add'); ?> <?php echo $subject ?>
				</a>
			<?php endif; ?>
		</div>
	<?php endif; ?>
	<div class="grocerycrud-container-spinner m-2">
		<div class="progress">
			<div class="progress-bar progress-bar-striped" role="progressbar" style="width: 1%" aria-valuenow="1" aria-valuemin="100" aria-valuemax="100"></div>
		</div>
	</div>
	<div class="dataTablesContainer dt-bootstrap4 invisible">
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

$this->set_css($this->default_theme_path . '/datatables4/css/datatables.css?v=0.35');



if ($dialog_forms) {
}

$this->set_js_lib($this->default_javascript_path . '/common/list.js');

$this->set_js($this->default_theme_path . '/datatables4/js/datatables.js?v=0.4.18');
//$this->set_js($this->default_theme_path.'/datatables4/js/dataTables.responsive.min.js');
//$this->set_js($this->default_theme_path.'/datatables4/js/dataTables.searchPanes.min.js');

?>
<script type='text/javascript'>
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
	var export_single = '<?php echo $this->l('list_single_export') ?>';
	var export_multiple = '<?php echo $this->l('list_multiple_export') ?>';
	var use_storage = supports_html5_storage();
	var list_search_all = '<?php echo $this->l('list_search_all') ?>';
	var list_clear_filtering = '<?php echo $this->l('list_clear_filtering') ?>';
	<?php
	$ordering = 0;
	$sorting = 'asc';
	if (!empty($order_by)) {
		foreach ($columns as $num => $column) {
			if ($column->field_name == $order_by[0]) {
				$ordering = $num;
				$sorting = isset($order_by[1]) && $order_by[1] == 'asc' || $order_by[1] == 'desc' ? $order_by[1] : $sorting;
			}
		}
	}
	?>
	var datatables_aaSorting = [
		[<?php echo $ordering; ?>, "<?php echo $sorting; ?>"]
	];

	var DTSearch = '&nbsp;&nbsp;<b class="btn btn-small btn-outline-primary" onclick="changeExport()"><input id="allPagesExport" hidden type="checkbox"><span id="allPagesExportText" data-toggle="tooltip" data-placement="right" title="' + export_single + '"><i class="far fa-file"></i></span></b>&nbsp;&nbsp;<div class="dropdown d-inline" style="overflow: scroll">';
	DTSearch += '<button class="btn btn-primary dropdown-toggle" type="button" id="DTdropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
	DTSearch += '<span><i class="fas fa-columns"></i></span></button><div class="dropdown-menu sm" aria-labelledby="DTdropdownMenuButton" style=""><b>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $this->l('show_columns'); ?></b>';
	<?php $a = -1;
	if (!$unset_delete || !$unset_edit || !$unset_read || !empty($actions)) : $a++; ?>
		DTSearch += '<div onclick="showColumns(0, \'action\', !$(\'[name=vscolunm0]\').prop(\'checked\'));" class="dropdown-item"><input type="checkbox"';
		DTSearch += ' name="vscolunm0" ><label  for="vscolunm0" checked>&nbsp;&nbsp;'
		DTSearch += list_action + '</label></div>';
	<?php endif; ?>
	<?php


	if ($unset_show_columns ? 'true' : 'false') foreach ($columns as $column) :
		if ($column->field_name !== 'jobStatus' && strlen($column->field_name) > 0) : ?>
			DTSearch += '<div onclick="showColumns(<?php echo ++$a ?>, \'<?php echo $column->display_as; ?>\', !$(\'[name=vscolunm<?php echo $a ?>]\').prop(\'checked\'));" class="dropdown-item"><input type="checkbox"';
			DTSearch += ' name="vscolunm<?php echo $a ?>" checked><label  for="vscolunm<?php echo $a ?>">&nbsp;&nbsp;'
			DTSearch += '<?php echo $column->display_as; ?></label></div>';
		<?php else : $a++;
		endif; ?>

	<?php endforeach; ?>
	DTSearch += '</div></div>';
	var columnsCount = <?php echo count($columns); ?>;


	function tableSettings() {
		let settings = {
			"serverSide": true,
			"stateSave": true,
			"ajax": {
				type: 'POST',
				url: "<?php echo $ajax_list_info_url; ?>", //,success: (r) => console.log(r)
				xhr: function() {
					let xhr = $.ajaxSettings.xhr();
					let a = 0;
					xhr.onprogress = function (e) {
						// For downloads
						if (e.lengthComputable) {
							let per = (e.loaded / e.total * 100 | 0);
							$('.grocerycrud-container-spinner .progress-bar').css('width', per + '%').attr('aria-valuenow', per);
						}  else {
							a += 40;
							if (a > 99) a = 50;
							$('.grocerycrud-container-spinner .progress-bar').css('width', a + '%').attr('aria-valuenow', a);
						}
					};
					return xhr;
				},
			},
			columnDefs: [
				<?php
				$arrlist = '';
				$a = -1;
				if (!$unset_delete || !$unset_edit || !$unset_read || !empty($actions)) {
					$a = 0;
					$arrlist .= PHP_EOL . '{ className: "actions th' . $a . 'Nu", targets: ' . $a . ' },';
				}
				foreach ($columns as $column) {
					if ($column->field_name !== 'jobStatus' && strlen($column->field_name) > 0)
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
					<a onclick="chooseId(\'' . $field . '\', \'less\')" class="btn btn-small  btn-default sel less">
					<i class="fas fa-less-than"></i>
					</a>
					<a onclick="chooseId(\'' . $field . '\', \'equals\')" class="btn btn-primary sel equals">
					<i class="fas fa-equals"></i>
					</a>
					<a onclick="chooseId(\'' . $field . '\', \'greater\')" class="btn btn-small btn-default sel greater">
					<i class="fas fa-greater-than"></i>
					</a>
					</div><hr class="dt-ci-input-add d-none">
					';
					return str_replace('"', '\"', str_replace("\t", '', str_replace("\r", '', str_replace("\n", '', $dateadder))));
				}

				function additional_action($that)
				{
					$ret = '';
					return str_replace('"', '\"', str_replace("\t", '', str_replace("\r", '', str_replace("\n", '', $ret))));
				}


				if (!$unset_delete || !$unset_edit || !$unset_read || !empty($actions)) {

					$arrlist .= '{ title: "' . $this->l('list_actions') . '<br class=\"dt-ci-input-add d-none\">' . additional_action($this) . '", name: "action", data: (e)=>format_fields(e, "action"), searchable: false, orderable: false },';
				}
				foreach ($columns as $column) {
					if ($column->field_name !== 'jobStatus' && strlen($column->field_name) > 0) {
						$type = 'search';
						$additional = '';
						switch (@$types[$column->field_name]->crud_type) {
							case 'date':
								$type = 'date';
								$additional = dateAdder($column->field_name);
								break;
							case 'datetime':
								$type = 'date';
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
			"sPaginationType": "full_numbers",
			"aaSorting": datatables_aaSorting,
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
					"sFirst": '<i class="fas fa-fast-backward"></i>',
					"sPrevious": '<i class="fas fa-step-backward"></i>',
					"sNext": '<i class="fas fa-step-forward"></i>',
					"sLast": '<i class="fas fa-fast-forward"></i>',
				}
			},
			"buttons": bButtons,
			"fnDrawCallback": function() {
				$('td').removeClass('printable');
			},
			footerCallback: footerCallbackOverride,
			"dom": domSettings
		};
		settings.scrollX = true;
		return settings;
	}

	function tableInit() {

		$('table.groceryCrudTable thead tr th').each(function(index) {
			if (!$(this).hasClass('actions')) {
				mColumns[index] = index;
			}
		});

		if (!unset_export) {
			bButtons.push({
				extend: 'copy',
				text: '<i class="fas fa-clipboard"></i>',
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
				},
				"action": newexportaction
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
				},
				"action": newexportaction
			});

		}

		if (!unset_print) {
			bButtons.push({
				extend: 'print',
				text: '<i class="fas fa-print"></i>',
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
				},
				"action": newexportaction
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
		if ($('#DTdropdownMenuButton').length == 0) $('.dt-buttons').after(DTSearch);
		showColumns(0, 'action', <?php echo ($action_button) ? 'true' : 'false'; ?>, false, 400);
		$('.dt-buttons button').removeClass('btn-secondary').addClass('btn-primary');
	};


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
						ret += `<a onclick='dtOpen("` + value + `")' class="btn btn-default spacesOpt margin-stop">
                                        <i class="` + actionsCss[key] + `"></i>
                                    </a>`;
					}
				}
			}
		}
		return ret;
	}


	function actionButton(id, actions = null) {
		return `<div class="btn-group btn-group-sm tid` + id + `">
						    ` + actionsLink(actions) + `
                            <?php if (!$unset_read) { ?>
                                <a onclick='dtOpen("<?php echo ar($row->read_url) ?>` + id + `")' class="btn spacesOpt  btn-default margin-stop">
                                    <i class="fas fa-eye text-info"></i>
                                </a>
                            <?php } ?>

                            <?php if (!$unset_clone) { ?>
                                <a onclick='dtOpen("<?php echo ar($row->clone_url) ?>` + id + `")' class="btn spacesOpt btn-default margin-stop">
                                    <i class="fas fa-copy text-primary"></i>
                                </a>
                            <?php } ?>

                            <?php if (!$unset_edit) { ?>
                                <a onclick='dtOpen("<?php echo ar($row->edit_url) ?>` + id + `")' class="btn spacesOpt  btn-default margin-stop">
                                    <i class="fas fa-pencil-alt text-success"></i>
                                </a>
                            <?php } ?>

                            <?php if (!$unset_delete) { ?>
                                <a onclick="javascript: return delete_row('<?php echo ar($row->delete_url) ?>` + id + `', '` + id + `')" href="javascript:void(0)" class="btn spacesOpt btn-default margin-stop">
                                    <i class="fas fa-trash-alt text-danger"></i>
                                </a>
                            <?php } ?>
                        </div>
						`
	}


	function actionMenu(id, value, actions = null) {
		value = value.replaceAll('&nbsp;', ' ').replaceAll('&thinsp;', '&nbsp;');
		let result = `
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
		let noAction = <?php echo ($unset_read && $unset_clone && $unset_edit && $unset_delete) ? 'true' : 'false'; ?>;
		if (!noAction && (actions != null || actions != '')) {
			return result;
		} else {
			return value;
		}
	}



	$(document).on('onInit.fb', function(e, instance) {
		if (!!instance.opts.rotate) {
			instance.Rotate = new RotateImage(instance);
		}
	});

	$(document).on('collapsed.lte.pushmenu', fix_table_size);
	$(document).on('shown.lte.pushmenu', fix_table_size);



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




	$(document).ready(tableInit);
	$(window).on('resize', function() {
		//ok, I will wait all animations end
		$(window).one("webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend", fix_table_size);
	});
</script>