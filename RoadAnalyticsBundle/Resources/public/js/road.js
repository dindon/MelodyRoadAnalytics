$(document).ready(function(){
	$('.changeDate').datepicker();
	$('.changeDate').change(function(){
		var d1 = $('#changeDateStart').val();
		var d2 = $('#changeDateEnd').val();
		var route = $('#roadRoute').val();
		$('#middle_road').html($.melodyLoad());
		$.post(route, { 'd1': d1, 'd2': d2 }, function(data){
			$('#middle_road').html(data);
		});
	});
});