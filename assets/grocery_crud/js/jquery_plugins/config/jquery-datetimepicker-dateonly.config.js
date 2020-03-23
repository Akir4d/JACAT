$(function(){
	var forceLocale = 'en';
	if (typeof ciLocaleOverride !== "undefined") {
		forceLocale = ciLocaleOverride;
	}
	var fmdate = js_date_format.toUpperCase().replace('YY', 'YYYY');
	$('.datepicker-input').datetimepicker({
			format: fmdate,
			locale: forceLocale
	});
	
	$('.datepicker-input-clear').button();
	
	$('.datepicker-input-clear').click(function(){
		$(this).parent().find('.datepicker-input').val("");
		return false;
	});
	$('.ui-button').removeClass("datetime-input-clear ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only").addClass('btn btn-default');
});