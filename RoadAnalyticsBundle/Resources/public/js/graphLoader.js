$(document).ready(function(){
	
	$('.makeGraph').each(function(){
		var id = 'graph'+(new Date()).getTime();
		var datas = $.parseJSON($(this).children('span').html());
		var showAxisEvery = ((datas.length-1)-((datas.length-1)%6))/6;
		
		$(this).children('span').remove();
		$(this).removeClass('makeGraph');
		$(this).attr('id', id);

        var data = google.visualization.arrayToDataTable(datas);
        var options = {
        	backgroundColor: 'transparent',
        	pointSize: 7,
        	hAxis: { showTextEvery: showAxisEvery, textStyle: { fontSize: 12 } },
        	vAxis: { textStyle: { fontSize: 12 } },
        	legend: { position: 'none' }
        };

        var chart = new google.visualization.AreaChart(document.getElementById(id));
        chart.draw(data, options);
	});
});