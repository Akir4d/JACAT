  $(function(){
	var fmdate = js_date_format.toUpperCase().replace('YY', 'YYYY') + ' ' + 'HH:mm:ss';
    $('.datetime-input').datetimepicker({
		format: fmdate,
		locale: cibs_language
	});
    
	$('.datetime-input-clear').button();
	
	$('.datetime-input-clear').click(function(){
		$(this).parent().find('.datetime-input').val("");
		return false;
	});	

	$('.ui-button').removeClass("datetime-input-clear ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only").addClass('btn btn-default');

  });