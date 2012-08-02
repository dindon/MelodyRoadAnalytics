$(document).ready(function(){
	$('.makeGraph').each(function(){
		var id = 'graph'+(new Date()).getTime();
		var obj = $.parseJSON($(this).children('span').html());
		var arr = [];
		var maxVisite = 0;
		
		$(this).children('span').remove();
		$(this).removeClass('makeGraph');
		$(this).attr('id', id);
		$.each(obj, function(date, nbvisitor){ arr.push([date,nbvisitor]); if(nbvisitor > maxVisite) maxVisite = nbvisitor });
		
		var graph = $.jqplot(id, [arr], {
			/*seriesDefaults: { 
		    	showMarker:true,
		    	pointLabels:{ show:true },
		    	formatString:'%d'
		    },*/
	   		axes:{
		        xaxis:{
		        	renderer:$.jqplot.DateAxisRenderer, 
		          	tickOptions:{formatString:'%d/%m/%Y'},
		          	min:arr[0][0],
		          	max:arr[arr.length-1][0]
		        },
		        yaxis:{
					max: Number(maxVisite),
					min: 0,
					tickInterval: Math.ceil(Number(maxVisite)/2),
					tickOptions:{formatString:'%d'}
		        }
	    	},
	    	highlighter: {
        		show: true,
        		sizeAdjust: 20
      		},
	    	series:[{lineWidth:2}]
	  	});
	});
});