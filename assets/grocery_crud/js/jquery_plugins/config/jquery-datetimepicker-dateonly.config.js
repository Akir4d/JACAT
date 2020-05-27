$(function(){
	var fmdate = js_date_format.toUpperCase().replace('YY', 'YYYY');
	$('.datepicker-input').datetimepicker({
			format: fmdate,
			locale: grocery_crud_language,
			icons: {
                time: 'fas fa-clock',
                date: 'fas fa-calendar',
                up: 'fas fa-arrow-up',
                down: 'fas fa-arrow-down',
                previous: 'fas fa-chevron-left',
                next: 'fas fa-chevron-right',
                today: 'fas fa-calendar-check-o',
                clear: 'fas fa-trash',
                close: 'fas fa-times'
            }
	});
	
	$('.datepicker-input-clear').click(function(){
		$(this).parent().parent().find('.datePicker').val("");
		return false;
	});

	//$('.datepicker-input-clear').removeClass("ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only").addClass('btn btn-default');
});