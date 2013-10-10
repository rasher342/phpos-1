
function api_debugger_update(debug_title, debug_data, debug_object)
{
	var debugger_div_header = '#api_desktop-debugger-header-data div[title="'+debug_title+'"]';
	var debugger_div_window = '#api_desktop-debugger-window-data_'+debug_object;
	
	if($.isArray(debug_data)) {	
		var debug_parsed = api_debugger_parse_data(debug_data);
		$(debugger_div_header).html('<b>'+debug_title+':</b> ' + debug_parsed[0]);
		$(debugger_div_window).html(debug_parsed[1]);
	
	} else {
		
		$(debugger_div_header).html('<b>'+debug_title+':</b> ' + debug_data);
		$(debugger_div_window).html(debug_parsed[1]);
	}
}


function api_debugger_parse_data(data_array)
{
	if($.isArray(data_array)) {
	
		array_count = data_array.length;		
		str = new Array('','');
		var j = 0;
		for(i=0; i<array_count; i++)
		{
			array_item = data_array[i].split(':');	
			j = i + 1;
			// str[0] = header debugger, str[1] = window debugger
			
			str[0] = str[0] + ' <span class="api_debug_title">'+array_item[0]+':</span> <span class="api_debug_value">'+array_item[1]+'</span>,';	
			str[1] = str[1] + ' '+j+') <span class="api_debug_title">'+array_item[0]+':</span> <span class="api_debug_value">'+array_item[1]+'</span><br />';	
				
		}	
		return str;
	} 
}

