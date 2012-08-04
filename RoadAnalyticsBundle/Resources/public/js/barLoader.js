$(document).ready(function(){
	$('.makeBar').each(function(){
		var id = 'bar'+(new Date()).getTime();
		var datas = $.parseJSON($(this).children('span').html());

		$(this).children('span').remove();
		$(this).removeClass('makeGraph');
		$(this).attr('id', id);

		var data = google.visualization.arrayToDataTable(datas);
        var options = {
        	backgroundColor: 'transparent',
        	legend: { position: 'none' },
        	hAxis: { textStyle: { fontSize: 12 } },
        	vAxis: { textStyle: { fontSize: 12 } },
        };
        var chart = new google.visualization.SteppedAreaChart(document.getElementById(id));
        chart.draw(data, options);
	});
});