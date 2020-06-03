<?php
//super-lazy workaround for "ajax_list issue with this theme"
if ($success_message !== null) {
	echo  "<script> var loc = location.href + '/../..'; location.replace(loc.replace('/index', ''));</script>";
}

$this->set_css($this->default_theme_path . '/datatables-bootstrap3/css/datatables.css?v=0.31');



if ($dialog_forms) {
}

$this->set_js_lib($this->default_javascript_path . '/common/list.js');

$this->set_js($this->default_theme_path . '/datatables-bootstrap3/js/datatables.js?v=0.4.15');
//$this->set_js($this->default_theme_path.'/datatables-bootstrap3/js/dataTables.responsive.min.js');
//$this->set_js($this->default_theme_path.'/datatables-bootstrap3/js/dataTables.searchPanes.min.js');

?>
<script type='text/javascript'>
	var base_url = '<?php echo base_url(); ?>';
	var subject = '<?php echo addslashes($subject); ?>';

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
	var DTSearch = '&nbsp;&nbsp;<div class="dropdown d-inline">';
	DTSearch += '<button class="btn btn-secondary dropdown-toggle" type="button" id="DTdropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
	DTSearch += '<?php echo $this->l('show_columns'); ?></button><div class="dropdown-menu text-sm" aria-labelledby="DTdropdownMenuButton" style="">';
	DTSearch += '<div onclick="showColumns(0, \'action\', !$(\'[name=vscolunm0]\').prop(\'checked\'));" class="dropdown-item"><input type="checkbox"';
	DTSearch += ' name="vscolunm0" ><label  for="vscolunm0" checked>&nbsp;&nbsp;'
	DTSearch += list_action + '</label></div>';
	$(document).ready(function() {
		$('#multiSearchToggle input').each(function(e) {
			let index = $(this).attr('data-index');
			let rname = $(this).attr('name');
			let name = $('.th' + index + 'Nu').text();
			if (index !== undefined && rname !== 'jobStatus') {
				if (parseInt(getCookieDT(name)) == 0) {
					$(document).ready(function() {
						showColumns(index, name, 0, true);
					});
				} /* else if (++numTemp > 12) { //<-- limit number of visible columns
					$(document).ready(function() {
						showColumns(index, name, 0, true);
					});
				}*/
				DTSearch += '<div onclick="showColumns(' + index + ', \'' + name + '\', !$(\'[name=vscolunm' + index + ']\').prop(\'checked\'));" class="dropdown-item"><input type="checkbox"';
				DTSearch += ' name="vscolunm' + index + '" checked><label  for="vscolunm' + index + '">&nbsp;&nbsp;'
				DTSearch += '' + name + '</label></div>';
			}
		});
		DTSearch += '</div></div>';
		$('.dt-buttons').after(DTSearch);
		showColumns(0, 'action', <?php echo ($action_button)?'true':'false'; ?>, false, 400);
		
	});

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
		$('[name=vscolunm' + index + ']').prop('checked', onOff);
		target = '.th' + index + 'Nu';
		$(target).removeClass('printable');
		setCookieDT(name, onOff, 2);
		oTable.fnSetColumnVis(index, onOff);
		if (onOff == true) {
			$(target).addClass('printable');
		}
		if (!nofix) fix_table_size(true, timeout);
		if(!nofix) setTimeout(function(){$('tbody td[tabindex]').removeAttr('tabindex');}, timeout);
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
							if(!$('.viewOnlyButton').length) {
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
	<?php
	//A work around for method order_by that doesn't work correctly on datatables theme
	//@todo remove PHP logic from the view to the basic library
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
</script>
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
		<?php echo $list_view ?>
	</div>
</div>