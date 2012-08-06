$(document).ready(function(){
	$('.changeDate').datepicker();
	$('.changeDate').change(function(){
		var d1 = $('#changeDateStart').val();
		var d2 = $('#changeDateEnd').val();
		var route = $('#dashboardRoute').val();
		$('#middle_dash').html($.melodyLoad());
		$.post(route, { 'd1': d1, 'd2': d2 }, function(data){
			$('#middle_dash').html(data);
		});
	});
});