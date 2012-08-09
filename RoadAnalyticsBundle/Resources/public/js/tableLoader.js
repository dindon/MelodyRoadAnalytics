$(document).ready(function(){	
	$('.makeTable').each(function(){
		var id = 'table'+(new Date()).getTime();
		var idHBar = 'hbar'+(new Date()).getTime();
		var datas = $.parseJSON($(this).children('span').html());
		$(this).children('span').remove();
		$(this).removeClass('makeTable');
		$(this).attr('id', id);
		$(this).next('.hbar').attr('id', idHBar);

		var data = new google.visualization.DataTable();
		data.addColumn('string', 'Lien');
		data.addColumn('string', 'Route');
		data.addColumn('string', 'Groupe');
		data.addColumn('number', 'Visite');
		data.addColumn('number', 'Tab');
		data.addColumn('number', 'Mob');
		data.addColumn('number', 'Ord');

		data.addRows(datas.length);
		$.each(datas, function(key,item){
			data.setCell(key, 0, item[0]);
			data.setCell(key, 1, item[1]);
			data.setCell(key, 2, item[2]);
			data.setCell(key, 3, item[3]);
			data.setCell(key, 4, item[4]);
			data.setCell(key, 5, item[5]);
			data.setCell(key, 6, item[6]);
		});
		
		var formatterLinks = new google.visualization.PatternFormat('<a href="{0}" target="_blank" class="tableLinks">{0}</a>');
		var formatterContents = new google.visualization.PatternFormat('<p class="tableContents">{0}</p>');
		var formatterContentsImportant = new google.visualization.PatternFormat('<p class="tableContentsImportant">{0}</p>');
		var formatterContentsSmall = new google.visualization.PatternFormat('<p class="tableContentsSmall">{0}</p>');
		formatterLinks.format(data, [0]);
		formatterContents.format(data, [1]);
		formatterContents.format(data, [2]);
		formatterContentsImportant.format(data, [3]);
		formatterContentsSmall.format(data, [4]);
		formatterContentsSmall.format(data, [5]);
		formatterContentsSmall.format(data, [6]);

		var view = new google.visualization.DataView(data);
		var table = new google.visualization.Table(document.getElementById(id));
		var cssClassNames = {headerRow: 'table_first_line', tableCell: 'table_all_cells', headerCell: 'table_first_cells', oddTableRow: 'table_all_odd'};
		table.draw(view, {sortColumn: 3, sortAscending: false, allowHtml: true, width: '1000px', cssClassNames: cssClassNames});
	});
});