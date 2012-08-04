google.load('visualization', '1.0', {'packages':['corechart']});

$(document).ready(function(){
	$('.makePie').each(function(){
		var id = 'pie'+(new Date()).getTime();
		var datas = $.parseJSON($(this).children('span').html());
		$(this).children('span').remove();
		$(this).removeClass('makePie');
		$(this).attr('id', id);

		var data = new google.visualization.DataTable();
        data.addColumn('string', 'Navigateur');
        data.addColumn('number', 'Visiteurs');
        data.addRows(datas);

        var options = {
        	chartArea: {left: 0, top: '5%', width: '100%', height: '90%'},
        	backgroundColor: 'transparent'
        };

        var chart = new google.visualization.PieChart(document.getElementById(id));
        chart.draw(data, options);
	});
});