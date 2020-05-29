$(function () {
	$('.ptogtitle').click(function () {
		if ($(this).hasClass('vsble')) {
			$(this).removeClass('vsble');
			$('#main-table-box').slideDown("slow");
		}
		else {
			$(this).addClass('vsble');
			$('#main-table-box').slideUp("slow");
		}
	});

	var save_and_close = false;
	var reload_datagrid = function () {
		$('.refresh-data').trigger('click');
	};

	$('#save-and-go-back-button').click(function () {
		save_and_close = true;

		$('#crudForm').trigger('submit');
	});

	$('#crudForm').submit(function () {
		$(this).ajaxSubmit({
			url: validation_url,
			dataType: 'json',
			beforeSend: function () {
				$("#FormLoading").show();
			},
			success: function (data) {
				$("#FormLoading").hide();
				if (data.success) {
					$('#crudForm').ajaxSubmit({
						dataType: 'text',
						cache: 'false',
						beforeSend: function () {
							$("#FormLoading").show();
						},
						success: function (result) {
							$("#FormLoading").fadeOut("slow");
							data = $.parseJSON(result);
							if (data.success) {
								if (save_and_close) {
									if ($('#save-and-go-back-button').closest('.ui-dialog').length === 0) {
										window.location = data.success_list_url;
									} else {
										$(".ui-dialog-content").dialog("close");
										success_message(data.success_message);
										reload_datagrid();
									}

									return true;
								}

								$('.field_error').removeClass('field_error');

								form_success_message(data.success_message);
								reload_datagrid();

								clearForm();
							}
							else {
								form_error_message('An error has been occured at the insert.');
							}
						}
					});
				}
				else {
					$('.field_error').removeClass('field_error');
					form_error_message(data.error_message);
					$.each(data.error_fields, function (index, value) {
						$('#crudForm input[name=' + index + ']').addClass('field_error');
					});

				}
			}
		});
		return false;
	});

	$('#crudForm').change(function() {
		modified = true;
	 });

	if ($('#cancel-button').closest('.ui-dialog').length === 0) {

		$('#cancel-button').click(function () {
			if ($(this).hasClass('back-to-list') || !modified ) {
				window.location = list_url;
			} else {
				bootbox.confirm({
					message: '<br><h3>' + message_alert_add_form + '</h3>',
					buttons: {
						confirm: {
							label:  '<i class="fas fa-arrow-alt-circle-left"></i> ' + back_to_list, 
							className: 'btn-danger'
						},
						cancel: {
							label:  edit_cancel,
							className: 'btn-default'
						}
					},
					callback: function (result) {
						if (result) {
							window.location = list_url;
						}
					}
				});
			}

			return false;
		});
	}
});

function clearForm() {
	$('#crudForm').find(':input').each(function () {
		switch (this.type) {
			case 'password':
			case 'select-multiple':
			case 'select-one':
			case 'text':
			case 'textarea':
				$(this).val('');
				break;
			case 'checkbox':
			case 'radio':
				this.checked = false;
		}
	});

	/* Clear upload inputs  */
	$('.open-file,.gc-file-upload,.hidden-upload-input').each(function () {
		$(this).val('');
	});

	$('.upload-success-url').hide();
	$('.fileinput-button').fadeIn("normal");
	/* -------------------- */

	$('.remove-all').each(function () {
		$(this).trigger('click');
	});

	$('.chosen-multiple-select, .chosen-select, .ajax-chosen-select').each(function () {
		$(this).trigger("liszt:updated");
	});
	
}

function SwTFbutton(value, type) {
	var target = "r-" + value + (type ? "-true" : "-false"); 
	var target2 = "field-" + value + (type ? "-false" : "-true"); 
	var target3 = "r-" + value + (type ? "-false" : "-true");
	$("#" + target).prop("hidden", true); 
	$("#" + target2).click(); 
	$("#" + target3).removeAttr('hidden');
}


