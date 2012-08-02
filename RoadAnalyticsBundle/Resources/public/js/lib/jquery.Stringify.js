jQuery.stringify = function(jsonData)
{ 
	/*
	 * by Melody - http://www.melody-script.com
	 * 
	 */	
	function Stringify(jsonData)
	{
		var strJsonData = '{';
	    var itemCount = 0;
	    for (var item in jsonData) {
	        if (itemCount > 0) {
	            strJsonData += ', ';
	        }
	    temp = jsonData[item];
	    if (typeof(temp) == 'object') {
	        s =  Stringify(temp);    
	    } else {
	        s = '"' + temp + '"';
	    }    
	    strJsonData += '"' + item + '":' + s;
	        itemCount++;
	    }
	    strJsonData += '}';
	    return strJsonData;
	}

	return Stringify(jsonData);
};