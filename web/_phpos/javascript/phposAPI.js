	/* ***************************
		 phpos API jQUery
		 v.1.3.5		
		 ***************************
	*/ 
		 
/*
**************************
*/
 	
	window.PHPOS_ACTIVE_WINDOW = 0;

	var phposAPI = function() {
	
	
// =================== WINDOWS ===================
	
		 
/*
**************************
*/
 	

// AJAX load controller
		 this.controllerWindows = function(params) {
		
				$('#' + phposConfig.divTasks).panel('refresh',	phposConfig.controllerWindows + '?' + params);	 			
			};	
		 
/*
**************************
*/
 	

// AJAX load manager	
		 this.managerWindows = function(params) {
		 
				$('#' + phposConfig.divWinManager).panel('refresh',	phposConfig.controllerWindows + '?' + params);	
		 };
		 
/*
**************************
*/
 	

// wallpaper manager	
		 this.managerWallpaper = function(params) {
		 
				$('#' + phposConfig.divWallpaperManager).panel('refresh',	phposConfig.controllerWallpaper + '?' + params);	
		 };	 
		 
/*
**************************
*/
 	
	 
// wallpaper update		 
		 this.wallpaperUpdate = function(wallpaper_url, wallpaper_name, wallpaper_type) {			
			this.managerWallpaper('action=update&wallpaper_type='+wallpaper_type+'&wallpaper='+encodeURIComponent(wallpaper_name));	
			$.wallpaper("update", wallpaper_url + wallpaper_name);
		 };		 
			 
/*
**************************
*/
 	
	 	 
		 this.clearConsole = function(witch) {			
			if(witch == 'events') this.managerWindows('action=clear_console_events');
			if(witch == 'clipboard') this.managerWindows('action=clear_console_clipboard');
			if(witch == 'params') this.managerWindows('action=clear_console_params');
		 };	
		 
/*
**************************
*/
 	

// AJAX load loader	
		 this.windowLoader = function(id, json_params) {		
		 
				$('#' + id).panel('refresh',	phposConfig.loaderWindows + '?' + json_params);			
		 };
			 
/*
**************************
*/
 	
 

// Window show/hide when click on menu start task		 
		 this.windowShowHide = function(id) {
		 
				//alert('aaa');
					
				var minimized = $('#' + id).window('options').minimized;
				if(minimized == true)
				{	
					$('#' + id).window('open');		
				} else {
					$('#' + id).window('minimize');
				};			
		 };
		 
/*
**************************
*/
 	

// Window show/hide when click on menu start task		 
		 this.windowMaximize = function(id) {
		 
				//alert('aaa');
					
				var maximized = $('#' + id).window('options').maximized;
				if(maximized == true)
				{	
					$('#' + id).window('restore');		
				} else {
					$('#' + id).window('maximize');
				};			
		 };	
		 
/*
**************************
*/
 	
	 
		 this.windowCenter = function(id) {
		 
				$('#' + id).window('center');							
		 };	
	
		 
/*
**************************
*/
 	

// Parse JSON params	
		 this.windowGetJSONparams = function(id) {
			
				var w = $(id);	
				var params = new Array(
				'id:' + w.window('options').id,
				'title:' + w.window('options').title,
				'wintype:' + w.window('options').wintype,
				'parent_id:' + w.window('options').parent_id,
				'user_id:' + w.window('options').user_id,	
				'hash:' + w.window('options').hash,
				'width:' + w.window('options').width,
				'height:' + w.window('options').height,
				'top:' + w.window('options').top,
				'left:' + w.window('options').left,
				'timestamp:' + w.window('options').timestamp,
				'created_at:' + w.window('options').created_at,
				'updated_at:' + w.window('options').updated_at,
				'zindex:' + w.window('options').zIndex,
				'css:' + w.window('options').css,
				'authlevel:' + w.window('options').authlevel,
				'destroyed:' + w.window('options').destroyed,
				'hidden:' + w.window('options').hidden,
				'minimized:' + w.window('options').minimized,
				'maximized:' + w.window('options').maximized,
				'collapsed:' + w.window('options').collapsed,	
				'app_id:' + w.window('options').app_id
				);		
				
				// Join array to json string			
				var json = params.join(',');					
				return encodeURIComponent(json);		 
		 };	 
		 
/*
**************************
*/
 	
	 
// Window update		 
		 this.windowUpdate = function(id) {
		 		  
			//alert('aaa');
			var json_parameters = this.windowGetJSONparams(id);
			this.managerWindows('action=update&id=' + $(id).window('options').id + '&parameters_parsed=' + json_parameters);		 
		 };
			 
/*
**************************
*/
 	
 
// Window close		 
		 this.windowClose = function(id) {
		 
			$('#' + id).window('close');		 
		 };
			 
/*
**************************
*/
 	
 
// Calculate default start position (in center)		 
		 this.windowDefaultPosition = function() {
		 
			var tmp_height = $(window).height(); // browser window height		
			var startmenu_height = $('#' + phposConfig.divMenuStart).layout().panel('options').height;	// startmenu height			
			var window_height = tmp_height - startmenu_height;		// minus starmenu height
			var window_width = $(window).width();	// browser window width			
			
			// Set left and top padding
			var height_padding = phposConfig.windowHeightPadding;
			var width_padding = phposConfig.windowWidthPadding;
			
			var my_win = Array();			
			// Set height & width
			my_win[0] = window_height - ( height_padding * 2); // height
			my_win[1] = window_width - ( width_padding * 2); // width
			
			// Set left & top
			my_win[2] = width_padding; // left
			my_win[3] = height_padding; // top

			// return array
			return my_win;	 
		 };
			 
/*
**************************
*/
 	
 
// Window restore 
		 this.windowRestore = function() {		 
		 	
				this.controllerWindows('action=restore');			
		 };
	 
/*
**************************
*/
 	
		 
// Window refresh		 
		 this.windowRefresh = function(id, app_json_params) {
		 
		  
			if(app_json_params)
			{				
				this.windowLoader(id, 'id=' + id + '&app_params=' + app_json_params);					
			} else {				
				this.windowLoader(id, 'id=' + id);
			};			 
		 };
		 			 
/*
**************************
*/
		 // Window refresh		 
		 this.windowAjax = function(id, app_json_params) {
		 
		  
			if(app_json_params)
			{				
				this.windowLoader('phpos_ajax_contener_' + id, 'id=' + id + '&ajax_include=1&ajax_file=&app_params=' + app_json_params);					
			} else {				
				this.windowLoader('phpos_ajax_contener_' + id, 'id=' + id + '&ajax_include=1&ajax_file=');
			};	

			this.waiting_show();		
			
		 };
			 
/*
**************************
*/
 	
 
		 this.windowActionChange = function(id, action, app_json_params) {
		 
		  if(app_json_params)
			{				
				this.windowLoader(id, 'id=' + id + '&action=' + action + '&app_params=' + app_json_params);		
				//alert(app_json_params);				
			} else {				
				this.windowLoader(id, 'id=' + id + '&action=' + action);
			};			 
		 };
			 
/*
**************************
*/
 	
 
// Window change action	 
		 this.windowAction = function(id, action, app_json_params) {
		 
		  if(app_json_params)
			{				
				this.windowLoader(id, 'id=' + id + '&action=new&app_params=' + app_json_params);					
			} else {				
				this.windowLoader(id, 'id=' + id + '&action=new');
			};			 
		 };
	
		 
/*
**************************
*/
 	

// Window create		 
		 this.windowCreate = function(title, wintype, json_params, json_app_params) {
		 	
			var title_encode = encodeURIComponent(title);
			var type_encode = encodeURIComponent(wintype);
			var json_params_encode = encodeURIComponent(json_params);	
			
			var app_params_url = '';
			
			if(json_app_params) 
			{
				var json_app_params_encode = encodeURIComponent(json_app_params);
				var app_params_url = '&app_params=' + json_app_params_encode;
			}	
				this.controllerWindows('action=create&title=' + title_encode + '&wintype=' + type_encode + '&params=' + json_params_encode + app_params_url);
						
		 };	 		
		
// Window create		 
		 this.windowCreateModal = function(title, wintype, json_params, json_app_params) {
		 	
			var title_encode = encodeURIComponent(title);
			var type_encode = encodeURIComponent(wintype);
			var json_params_encode = encodeURIComponent(json_params);	
			
			var app_params_url = '';
			
			if(json_app_params) 
			{
				var json_app_params_encode = encodeURIComponent(json_app_params);
				var app_params_url = '&app_params=' + json_app_params_encode;
			}	
				this.controllerWindows('action=create&modal=1&title=' + title_encode + '&wintype=' + type_encode + '&params=' + json_params_encode + app_params_url);
						
		 };	 		
		 	  	 
/*
**************************
*/
 	

// Window create		 
		 this.windowDesktopCreate = function(title, wintype, json_params, json_app_params) {
		 	
			var title_encode = encodeURIComponent(title);
			var type_encode = encodeURIComponent(wintype);
			var json_params_encode = encodeURIComponent(json_params);	
			
			var app_params_url = '';
			
			if(json_app_params) 
			{
				var json_app_params_encode = encodeURIComponent(json_app_params);
				var app_params_url = '&app_params=' + json_app_params_encode;
			}	
				this.controllerWindows('action=create&desktop=1&title=' + title_encode + '&wintype=' + type_encode + '&params=' + json_params_encode + app_params_url);
						
		 };		
		 
			 
/*
**************************
*/
 	
 
// =================== MENU START ===================
		 
		 	 
/*
**************************
*/
 	
	 
// Menu start auto set height		 
		 this.menustartSetHeight = function() {
		 				
			var windowHeight = $(window).height();
			var documentHeight = $(document).height();
			var menustartHeight = $('#' + phposConfig.divMenuStart).layout().panel('options').height;			
			
			var desktopHeight = windowHeight - menustartHeight;			
			var menustartHeightNOW = $('#' + phposConfig.divMenuStartWindow).window('options').height;	
						
			// If menustart is hightest then desktop icons area			
			if(menustartHeightNOW > desktopHeight || menustartHeightNOW == desktopHeight)
			{
				$('#' + phposConfig.divMenuStartWindow).window('resize',{ height: desktopHeight	});	
				menustartHeightNOW = desktopHeight;
			
			}	else {
			
				// else set default values
				$('#' + phposConfig.divMenuStartWindow).window('resize',{ height: phposConfig.menustartStartHeight });	
				menustartHeightNOW = phposConfig.menustartStartHeight;
			}	
			
			// Set TOP css value
			var menustartTop = desktopHeight - menustartHeightNOW;
			
			if(menustartTop < 0)
			{
				menustartTop = 0;
			}				
			$('#' + phposConfig.divMenuStartWindow).window('move',{ top: menustartTop });  	
		};
			 
/*
**************************
*/
 	

// Menu start open		
		this.menustartOpen = function() {		
		
			$('#' + phposConfig.divMenuStartWindow).window('open');
			$('#' + phposConfig.divMenuStartWindow).window('refresh', phposConfig.loaderMenuStart); 		
		};
			 
/*
**************************
*/
 	

// Menu start close
		this.menustartClose = function() {		
		
			$('#' + phposConfig.divMenuStartWindow).window('close');	
			$('#phpos-menustart_WindowApps_container').css('display', 'none');
			
		};
	 
/*
**************************
*/
 	

// Menu start /when clickout		
		this.api_startmenu_close_clickout = function() {	
		
			if($('#' + phposConfig.divMenuStartWindow).window('options').closed == true)
			{
				$('#' + phposConfig.divMenuStartWindow).window('close');
			}	
		};
			 
/*
**************************
*/
 	// winset
		this.winset = function(window_id, mode, param) {	
		
			if(mode == 'width')
			{
				$('#' + window_id).window('resize', { width: param });
				//this.windowUpdate(window_id);
				return true;
			}
			
			if(mode == 'height')
			{
				$('#' + window_id).window('resize', { height: param });
				//this.windowUpdate(window_id);
				return true;
			}
			
			$('#' + window_id).window(mode, param);
			//this.windowUpdate(window_id);
			//alert('aaaa');
		};
			 
			 
/*
**************************
*/
 	// winset
		this.wincenter = function(window_id) {			
			
			$('#' + window_id).window('center');
			
			//this.windowUpdate(window_id);
			//alert('aaaa');
		};
/*
**************************
*/

// Menu start show/hide		
		this.menustartShowHide = function() {						
			
		
			
			if($('#' + phposConfig.divMenuStartWindow).window('options').closed == true)
			{
				phpos.menustartOpen();				
			} else {
				phpos.menustartClose();
			}		
		}
		
		
			 
/*
**************************
*/
 	

		
// ============== DESKTOP ICONS ===============
	 
/*
**************************
*/
 	


// Icons get free verical space
	this.desktopAvailableHeight = function ()
	{		
		var windowHeight = $(window).height();		
		var menustartHeight = $('#' + phposConfig.divMenuStart).layout().panel('options').height;	
		var freeSpace = windowHeight - menustartHeight;	
		return freeSpace;	
	}	
		 
/*
**************************
*/
 	

// Icons get free horizontal space
	this.desktopAvailableWidth = function ()
	{		
		return $(window).width();	
	}
		 
/*
**************************
*/
 	

	this.menustartAppsSwitch = function ()
	{
	//$('#phpos_startmenu_layout').css('width', '600px');
	//$('#phpos_startmenu_layout_right').css('width', '300px');
	//$('#phpos-menustart_Window_container').css('width', '600px');
	var menustart_width = $('#phpos-menustart_Window_container').css('width'); 
	var menustart_height = $('#phpos-menustart_Window_container').css('height'); 
	var menustart_bottom = $('#phpos-menustart_container').css('height'); 
	
	var display = $('#phpos-menustart_WindowApps_container').css('display');	
	$('#phpos-menustart_WindowApps_container').css('z-index', '999999999').css('height', menustart_height).css('left', menustart_width).css('bottom', menustart_bottom);
	
	if(display == 'none')
	{
		$('#phpos-menustart_WindowApps_container').css('display', 'block');
	} else {
		$('#phpos-menustart_WindowApps_container').css('display', 'none');
	}
	
	//alert(menustart_bottom);
	
	}
		 
/*
**************************
*/
 	

	this.desktopSwitch = function (desktop_type)
	{
				
		if(desktop_type == 'local_files')
		{
			this.windowLoader('1', 'id=1&app_params=fs:local_files,desktop:1');
		}
		if(desktop_type == 'database')
		{
			this.windowLoader('1', 'id=1&app_params=fs:db_mysql,desktop:1');
		}
		
		//alert(desktop_type);	
	}
		 
/*
**************************
*/
 	

// Icons reposition vertical/horizontal
	this.iconsReposition = function (iconsContainerDiv, sortDirection, iconsContainerHeight, iconsContainerWidth, inWindow)
	{	
		if(!sortDirection)
		{
			var sortDirection = 'horizontal'; // Default repositioning = horizontal
		}		
		
		// Prepare free space for icons
		if(!iconsContainerHeight)
		{
			var iconsContainerHeight = parseInt($('#' + iconsContainerDiv).css('height'));
			
		}
		
	//	alert(iconsContainerDiv+iconsContainerHeight);
		
		if(!iconsContainerWidth)
		{		
			var iconsContainerWidth = parseInt($('#' + iconsContainerDiv).css('width'));
			//alert(iconsContainerWidth);
		}			
		
		// DEFAULT VALUES				
		var leftPosStart = 30;		
		var topPosStart = 20;		
		
		// If true then I know we are in window, not in the desktop
		if(inWindow == true)
		{	
			var leftPosStart = parseInt($('#' + iconsContainerDiv).css('left'));
			var topPosStart = parseInt($('#' + iconsContainerDiv).css('top'));	
		//	alert(leftPosStart);
				
		}
		
		var topPos = topPosStart;	
		var leftPos = leftPosStart;		
		
		var iconWidth = 100;
		var iconHeight = 80;
		
		var paddingWidth = 100;
		var paddingHeight = 100;	
		
		var usedWidth = 0;
		var usedHeight = 0;
		
		var availableWidth = iconsContainerWidth - 100;
		var availableHeight = iconsContainerHeight;
		
		var unusedWidth = availableWidth;
		var unusedHeight = availableHeight; 		
		
		// Set DIV for container with icons
		var iconDIVs = '#' + iconsContainerDiv + ' div';
		
		// Place icons in container:
		$(iconDIVs).each(function() {		
			
			// HORIZONTAL SORT
			if(sortDirection == 'horizontal')
			{			
					usedWidth = leftPos + iconWidth;			
					var leftCSS = leftPos + 'px';
					var topCSS = topPos + 'px';
					
					$(this).css({left:leftCSS}).css({top:topCSS});	
				
					leftPos = leftPos + paddingWidth;	// next top					
					unusedWidth = availableWidth - usedWidth; // calculate free space
					
					if(unusedWidth < iconWidth) // if no more space
					{
						topPos = topPos + paddingHeight; // next column
						leftPos = leftPosStart;	// reset top
						unusedWidth = availableWidth; // reset free space
						usedWidth = 0; // reset used height
					}		
			}		
		
			// VERTICAL SORT
			if(sortDirection == 'vertical')
			{			
					usedHeight = topPos + iconHeight;			
					var leftCSS = leftPos + 'px';
					var topCSS = topPos + 'px';
					
					$(this).css({left:leftCSS}).css({top:topCSS});	
				
					topPos = topPos + paddingHeight;	// next top					
					unusedHeight = availableHeight - usedHeight; // calculate free space
					
					if(unusedHeight < iconHeight) // if no more space
					{
						leftPos = leftPos + paddingWidth; // next column
						topPos = topPosStart;	// reset top
						unusedHeight = availableHeight; // reset free space
						usedHeight = 0; // reset used height
					}		
			}			
		});	
	}
				 
/*
**************************
*/	
		
	
			this.list_select_all = function(win_id) {		
				var i =0;
				$("#phpos_list_table_"+win_id+" tr input[type='checkbox']").each(function(i){					
					$(this).prop("checked","checked");
				});
				return false;
			};
					 
/*
**************************
*/	
		
	
			this.list_unselect_all = function(win_id) {			
				var i =0;
				$("#phpos_list_table_"+win_id+" tr input[type='checkbox']").each(function(i){
					
					$(this).prop("checked",false);	
				});
				return false;
			};
				 
/*
**************************
*/	
		
		
			this.list_reverse_select = function(win_id) {			
				var i =0;
				$("#phpos_list_table_"+win_id+" tr input[type='checkbox']").each(function(i){
					
					if($(this).is(":checked")) 
					{	
						$(this).prop("checked",false);
					} else {
						$(this).prop("checked","checked");			
					}				
				});
				return false;
			};
			 
/*
**************************
*/	
		
			
			this.list_delete = function(win_id) {

				var a = new Array();
				$("#phpos_list_table_"+win_id+" tr input[type='checkbox']").each(function(){
				
						if($(this).is(":checked")) 
						{				
							a.push($(this).val());					
						}	        
      });
			
			if(a.length != 0)
			{
				var file_ids = a.join(";;");	
				this.waiting_show();
				explorer_delete_files(win_id, file_ids);
				
			} else {	
			
				alert('Nothing selected!');
			}				
		 };	
		 
/*
**************************
*/	
			this.list_copy = function(win_id) {

				var a = new Array();
				$("#phpos_list_table_"+win_id+" tr input[type='checkbox']").each(function(){
				
						if($(this).is(":checked")) 
						{				
							a.push($(this).val());					
						}	        
      });
			
			if(a.length != 0)
			{
				var file_ids = a.join(";;");
				this.waiting_show();				
				explorer_copy_multiple(win_id, file_ids);
				
			} else {	
			
				alert('Nothing selected!');
			}				
		 };	
		 
/*
**************************
*/	
	this.list_cut = function(win_id) {

				var a = new Array();
				$("#phpos_list_table_"+win_id+" tr input[type='checkbox']").each(function(){
				
						if($(this).is(":checked")) 
						{				
							a.push($(this).val());					
						}	        
      });
			
			if(a.length != 0)
			{
				var file_ids = a.join(";;");	
				this.waiting_show();
				explorer_cut_multiple(win_id, file_ids);
				
				
			} else {	
			
				alert('Nothing selected!');
			}				
		 };	
		 
		 		 
/*
**************************
*/	
	this.list_zip = function(win_id) {

				var a = new Array();
				$("#phpos_list_table_"+win_id+" tr input[type='checkbox']").each(function(){
				
						if($(this).is(":checked")) 
						{				
							a.push($(this).val());					
						}	        
      });
			
			if(a.length != 0)
			{
				var file_ids = a.join(";;");		
				this.waiting_show();
				explorer_pack_multiple(win_id, file_ids);
				
			} else {	
			
				alert('Nothing selected!');
			}				
		 };	
		 
		 		 
/*
**************************
*/	
	this.list_download = function(win_id) {

				var a = new Array();
				$("#phpos_list_table_"+win_id+" tr input[type='checkbox']").each(function(){
				
						if($(this).is(":checked")) 
						{				
							a.push($(this).val());					
						}	        
      });
			
			if(a.length != 0)
			{
				var file_ids = a.join(";;");		
				this.waiting_show();
				explorer_download_multiple(win_id, file_ids);
				
			} else {	
			
				alert('Nothing selected!');
			}				
		 };	
		 		 		 
/*
**************************
*/	
	this.applyStatus = function(status, msg) {
	
		$('#waiting_info').prop('status_finish', status);	
		$('#waiting_info').prop('status_msg', msg);	
	};
	
		 		 		 
/*
**************************
*/	
		
	this.showStatus = function() {
	
		var s = $('#waiting_info').prop('status_finish');	
		var m = $('#waiting_info').prop('status_msg');	
		//alert(s);
		
		$(document).ready(function() {
		
		if(s == 'ok')
		{
			jSuccess(
				m,
				{
					autoHide : true, 
					clickOverlay : false,
					MinWidth : 300,
					TimeShown : 4000,
					ShowTimeEffect : 1000,
					HideTimeEffect : 600,
					LongTrip :20,
					HorizontalPosition : "right",
					VerticalPosition : "bottom",
					ShowOverlay : false
				});
		}	
		
		if(s == 'error')
		{
			jSuccess(
				m,
				{
					autoHide : true, 
					clickOverlay : false,
					MinWidth : 300,
					TimeShown : 4000,
					ShowTimeEffect : 1000,
					HideTimeEffect : 600,
					LongTrip :20,
					HorizontalPosition : "right",
					VerticalPosition : "bottom",
					ShowOverlay : false
				});
		}	
		
		$('#waiting_info').prop('status_finish', '');	
		$('#waiting_info').prop('status_msg', '');	
			
		});
	};

		 		 		 
/*
**************************
*/
	this.waiting_show = function(msg) {
			
			if(msg == null) msg = window.waiting_str;	
			
			window.hide_waiting = 0;			
			$('#waiting_info').html('<img src="' + PHPOS_WEBROOT_URL + '_phpos/icons/loading.gif" />' + msg);
			$('#waiting_info').delay(20).show('fast');			
	};	
		 		 		 		 
/*
**************************
*/	
	this.waiting_hide = function() {
			
			window.hide_waiting = 1;	
	};	
		 
/*
**************************
*/	
	this.waiting_hide_execute = function() {
			
			if(window.hide_waiting == 1)
			{			
				var status = $('#waiting_info').css('display');
				
				if(status != 'none')
				{
					$('#waiting_info').fadeIn('slow').delay(20).fadeOut('fast');	
					this.showStatus();
				}
			};
	};	
	
	this.console_show_params_body = function(div_id) {
	
		var d = $('#console_params_'+div_id).html();
		$('#phpos_console_params_body').html(d);	
	};
	
	this.console_clear = function() {
			
			var display_data = $('#phpos_console_data').css('display');	
			var display_clipboard = $('#phpos_console_clipboard').css('display');
			var display_params = $('#phpos_console_params').css('display');
		
			if(display_data == 'block')
			{
				$('#phpos_console_data').html('');				
				this.clearConsole('events');
			}
			
			if(display_clipboard == 'block')
			{
				$('#phpos_console_clipboard').html('');
				this.clearConsole('clipoard');
			}
			
			if(display_params == 'block')
			{
				$('#phpos_console_params').html('');			
				this.clearConsole('params');
			}			
			
	};
	
	this.console_showhide = function() {
			
		var win_width = $(window).width() + 'px';		
		$('#phpos_console').css('width', win_width);
		
		if($('#phpos_console').css('display') == 'none')
		{
			$('#phpos_console').css('display', 'block');
			
			var display_data = $('#phpos_console_data').css('display');			
			var display_clipboard = $('#phpos_console_clipboard').css('display');
			var display_params = $('#phpos_console_params').css('display');
		
			if(display_data == 'none' && display_clipboard == 'none' && display_params == 'none')
			{
				this.console_show_content('data');
			}
			
		} else {
		
			$('#phpos_console').css('display', 'none');		
		}		
	};
	
	this.console_show_content = function(content_type) {
			
		$('#phpos_console_data').css('display', 'none');	
		$('#phpos_console_clipboard').css('display', 'none');
		$('#phpos_console_params').css('display', 'none');
		
		$('#console_btn_data').css('font-weight', 'normal').css('color', '#2a2a2a');
		$('#console_btn_clipboard').css('font-weight', 'normal').css('color', '#2a2a2a');
		$('#console_btn_params').css('font-weight', 'normal').css('color', '#2a2a2a');
		
		
		$('#phpos_console_' + content_type).css('display', 'block');	
		$('#console_btn_' + content_type).css('font-weight', 'bold').css('color', '#be551c');	
	
	};
	
	this.console_minmax = function() {
			
			var h = $('#phpos_console').css('height');
			
			if(h == '500px')
			{
				$('#phpos_console').css('height', '130px');
				$('#phpos_console_data').css('height', '80px');
				$('#phpos_console_clipboard').css('height', '80px');
				$('#phpos_console_params').css('height', '80px');
				
			} else {
			
				$('#phpos_console').css('height', '500px');
				$('#phpos_console_data').css('height', '450px');
				$('#phpos_console_clipboard').css('height', '450px');
				$('#phpos_console_params').css('height', '450px');
			}			
	};
	
	
	this.task_callendar_showhide = function() {	
		
		
		if($('#task_callendar').css('display') == 'none')
		{
			$('#task_callendar').css('display', 'block');		
			
		} else {
		
			$('#task_callendar').css('display', 'none');		
		}		
	};
	
	this.tray_clock_numbers = function(i) {	
		
		if (i<10)
		{
			i="0" + i;
		}
		return i;	
	};
	
	this.tray_clock = function() {	
		
		var today=new Date();
		var h=today.getHours();
		var m=today.getMinutes();
		var s=today.getSeconds();
		
		m=this.tray_clock_numbers(m);
		s=this.tray_clock_numbers(s);
		
		var c = '';
		c = h+":"+m+":"+s;
		$('#tray_clock').html(c);		
		var t = setTimeout(function(){phpos.tray_clock()},500);
	};
	
	
	
/*
**************************
*/		
	}; // end of class phposAPI
	
		 
/*
**************************
*/
 	
	
	
		
	
// ================================ RENDERERS ========================================
		 
/*
**************************
*/
 	

var phpos = new phposAPI;	

// =================== Windows renderer ===================
	 
/*
**************************
*/
 	

// Window render
function phposRenderWindow(
	//this.waiting_show();
	window_id, 
	window_title, 
	window_type, 
	window_parent_id,
	window_user_id,
	window_hash,
	window_width, 
	window_height, 
	window_top, 
	window_left, 	
	window_timestamp,
	window_created_at,
	window_updated_at,
	window_zindex,
	window_css,
	window_authlevel,
	window_destroyed,
	window_hidden,	
	window_minimized, 
	window_maximized, 
	window_collapsed,
	window_closed,
	window_app_id) {	
	
	// Create new window DIV and append it to DOM
	$("<div></div>").prop('id',window_id).addClass('easyui-window').appendTo('body');  
	var new_win = '#' + window_id;
		
		
	// Set default position of window	
	var start_pos = phpos.windowDefaultPosition();	
	if(!window_height) window_height = start_pos[0];		
	if(!window_width)	window_width = start_pos[1];		
	if(!window_left) window_left = start_pos[2];
	if(!window_top)	window_top = start_pos[3];		
	
	// Define window
	$('#' + window_id).window(
	{  
		title: window_title,
		id: window_id,
		wintype: window_type,
		parent_id: window_parent_id,
		user_id: window_user_id,			
		hash: window_hash,
		width: window_width,  
		height: window_height, 
		top: window_top, 
		left: window_left, 
		timestamp: window_timestamp,
		created_at: window_created_at,
		updated_at: window_updated_at,			
		css: window_css,
		authlevel: window_authlevel,
		destroyed: window_destroyed,
		hidden: window_hidden,
		minimized: window_minimized,
		maximized: window_maximized,
		collapsed: window_collapsed,
		closed: window_closed,			
		app_id: window_app_id,					
		windowID: window_id,
		cache: false,
		modal: false,
		shadow: false,
		loadingMessage: '',
		zIndex: 9000,
		iconCls:'phpos_window_icon'+window_id,
		
		tools:[{  
        iconCls:'icon-reload',  
        handler:function(){  
            phpos.windowRefresh(window_id);
        }  
    }],  
		
		
		
		onMove:function() { 
		
		// phpos.windowUpdate(new_win);
		 phpos.menustartClose();
		 window.PHPOS_ACTIVE_WINDOW = window_id;	 
		},
		
		onOpen:function() { 
		
			//phpos.windowUpdate(new_win);
			
			if(window_maximized == 'true') $(this).window('maximize');
			if(window_collapsed == 'true') $(this).window('collapse');
			//alert('o');
				
			$(this).click(function() {				
				phpos.menustartClose();
			});			
		},
		
		onMinimize:function() { 
		
			//phpos.windowUpdate(new_win);
			phpos.menustartClose();
		},
		
		onMaximize:function() { 
		
			//phpos.windowUpdate(new_win);
			phpos.menustartClose();
			//$("#icons_contener"+window_id).css("width", "300px");
			//phpos.iconsReposition("icons_contener"+window_id, "horizontal", null, null, true);
		},
		
		onCollapse:function() { 
		
			//phpos.windowUpdate(new_win);
			phpos.menustartClose();
		},
		
		onExpand:function() { 
		
			//phpos.windowUpdate(new_win);			
			phpos.menustartClose();
			//phpos.iconsReposition("icons_contener"+window_id, "horizontal", null, null, true);
		},
		
		onResize:function() { 
		
			//phpos.windowUpdate(new_win);
			phpos.menustartClose();
			//$("#icons_contener"+window_id).css("width", "auto");
		//phpos.iconsReposition("icons_contener"+window_id, "horizontal", null, null, true);
			//alert($(this).css("width"));
		},
		
		onRestore:function() {
		
			//phpos.windowUpdate(new_win);				
			phpos.menustartClose();
			//phpos.iconsReposition("icons_contener"+window_id, "horizontal", null, null, true);
		},
		
		onClose:function() { 				
					
			phpos.controllerWindows('action=destroy&id=' + window_id);
			phpos.menustartClose();		
			$(this).empty();	
			$(this).remove();				
		}		
	}
	); 
	
	
	// Open window and load content with Ajax
	$('#' + window_id).window('open');	
	$('#' + window_id).window('refresh', phposConfig.loaderWindows + '?id=' + window_id);
}

	 
/*
**************************
*/
 	
// Window render
function phposRenderModal(
	window_id, 
	window_title, 
	window_type, 
	window_parent_id,
	window_user_id,
	window_hash,
	window_width, 
	window_height, 
	window_top, 
	window_left, 	
	window_timestamp,
	window_created_at,
	window_updated_at,
	window_zindex,
	window_css,
	window_authlevel,
	window_destroyed,
	window_hidden,	
	window_minimized, 
	window_maximized, 
	window_collapsed,
	window_closed,
	window_app_id) {	
	
	// Create new window DIV and append it to DOM
	$("<div></div>").prop('id',window_id).addClass('easyui-window').appendTo('body');  
	var new_win = '#' + window_id;
		
		
	// Set default position of window	
	var start_pos = phpos.windowDefaultPosition();	
	if(!window_height) window_height = start_pos[0];		
	if(!window_width)	window_width = start_pos[1];		
	if(!window_left) window_left = start_pos[2];
	if(!window_top)	window_top = start_pos[3];		
	
	// Define window
	$('#' + window_id).window(
	{  
		title: window_title,
		id: window_id,
		wintype: window_type,
		parent_id: window_parent_id,
		user_id: window_user_id,			
		hash: window_hash,
		width: window_width,  
		height: window_height, 
		top: window_top, 
		left: window_left, 
		timestamp: window_timestamp,
		created_at: window_created_at,
		updated_at: window_updated_at,			
		css: window_css,
		authlevel: window_authlevel,
		destroyed: window_destroyed,
		hidden: window_hidden,
		minimized: window_minimized,
		maximized: window_maximized,
		collapsed: window_collapsed,
		closed: window_closed,			
		app_id: window_app_id,					
		windowID: window_id,
		cache: false,
		modal: true,
		shadow: false,
		loadingMessage: '',
		zIndex: 9000,
		iconCls:'phpos_window_icon'+window_id,
		
		tools:[{  
        iconCls:'icon-reload',  
        handler:function(){  
            phpos.windowRefresh(window_id);
        }  
    }],  
		
		
		
		onMove:function() { 
		
		 //phpos.windowUpdate(new_win);
		 phpos.menustartClose();
		  window.PHPOS_ACTIVE_WINDOW = window_id;	 
	 
		},
		
		onOpen:function() { 
		
			//phpos.windowUpdate(new_win);
			
			if(window_maximized == 'true') $(this).window('maximize');
			if(window_collapsed == 'true') $(this).window('collapse');
			
				
			$(this).click(function() {				
				phpos.menustartClose();
			});			
		},
		
		onMinimize:function() { 
		
			//phpos.windowUpdate(new_win);
			phpos.menustartClose();
		},
		
		onMaximize:function() { 
		
			//phpos.windowUpdate(new_win);
			phpos.menustartClose();
			//$("#icons_contener"+window_id).css("width", "300px");
			//phpos.iconsReposition("icons_contener"+window_id, "horizontal", null, null, true);
		},
		
		onCollapse:function() { 
		
			//phpos.windowUpdate(new_win);
			phpos.menustartClose();
		},
		
		onExpand:function() { 
		
			//phpos.windowUpdate(new_win);			
			phpos.menustartClose();
			//phpos.iconsReposition("icons_contener"+window_id, "horizontal", null, null, true);
		},
		
		onResize:function() { 
		
			//phpos.windowUpdate(new_win);
			phpos.menustartClose();
			//$("#icons_contener"+window_id).css("width", "auto");
		//phpos.iconsReposition("icons_contener"+window_id, "horizontal", null, null, true);
			//alert($(this).css("width"));
		},
		
		onRestore:function() {
		
			//phpos.windowUpdate(new_win);				
			phpos.menustartClose();
			//phpos.iconsReposition("icons_contener"+window_id, "horizontal", null, null, true);
		},
		
		onClose:function() { 				
					
			phpos.controllerWindows('action=destroy&id=' + window_id);
			phpos.menustartClose();		
			$(this).empty();	
			$(this).remove();				
		}		
	}
	); 
	
	
	// Open window and load content with Ajax
	$('#' + window_id).window('open');	
	$('#' + window_id).window('refresh', phposConfig.loaderWindows + '?id=' + window_id);
}

	


function phposRenderDesktop(
	window_id, 
	window_title, 
	window_type, 
	window_parent_id,
	window_user_id,
	window_hash,
	window_width, 
	window_height, 
	window_top, 
	window_left, 	
	window_timestamp,
	window_created_at,
	window_updated_at,
	window_zindex,
	window_css,
	window_authlevel,
	window_destroyed,
	window_hidden,	
	window_minimized, 
	window_maximized, 
	window_collapsed,
	window_closed,
	window_app_id) {	
	
	// Create new window DIV and append it to DOM
	$("<div></div>").prop('id',window_id).addClass('easyui-window').appendTo('body');  
	var new_win = '#' + window_id;
		
		
	// Set default position of window	
	var start_pos = phpos.windowDefaultPosition();	
	if(!window_height) window_height = start_pos[0];		
	if(!window_width)	window_width = start_pos[1];		
	if(!window_left) window_left = start_pos[2];
	if(!window_top)	window_top = start_pos[3];		
	
	// Define window
	$('#' + window_id).window(
	{  
		title: window_title,
		id: window_id,
		wintype: window_type,
		parent_id: window_parent_id,
		user_id: window_user_id,			
		hash: window_hash,
		width: window_width,  
		height: window_height, 
		top: 0, 
		left: 0, 
		timestamp: window_timestamp,
		created_at: window_created_at,
		updated_at: window_updated_at,			
		css: window_css,
		authlevel: window_authlevel,
		destroyed: window_destroyed,
		hidden: window_hidden,
		minimized: window_minimized,
		maximized: true,
		collapsed: window_collapsed,
		closed: window_closed,			
		app_id: window_app_id,					
		windowID: window_id,
		cache: false,
		modal: false,
		shadow: false,
		loadingMessage: '',
		iconCls:'phpos_window_icon'+window_id,
		minimizable: false,
		closable: false,
		resizalble: false,
		border:false,
		noheader:true,
		fit:true,
		zIndex: 8999,
		
		tools:[{  
        iconCls:'icon-reload',  
        handler:function(){  
            phpos.windowRefresh(window_id);
        }  
    }],  
		
		
		
		onMove:function() { 
		
		 //phpos.windowUpdate(new_win);
		 phpos.menustartClose();
phpos.iconsReposition("icons_contener"+window_id, "horizontal", null, null, true);		 
		},
		
		onOpen:function() { 
		
			//phpos.windowUpdate(new_win);
			
			if(window_maximized == 'true') $(this).window('maximize');
			if(window_collapsed == 'true') $(this).window('collapse');
			
				
			$(this).click(function() {				
				phpos.menustartClose();
			});			
		},
		
		onMinimize:function() { 
		
			//phpos.windowUpdate(new_win);
			phpos.menustartClose();
		},
		
		onMaximize:function() { 
		
			//phpos.windowUpdate(new_win);
			phpos.menustartClose();
			//$("#icons_contener"+window_id).css("width", "300px");
			//phpos.iconsReposition("icons_contener"+window_id, "horizontal", null, null, true);
		},
		
		onCollapse:function() { 
		
			//phpos.windowUpdate(new_win);
			phpos.menustartClose();
		},
		
		onExpand:function() { 
		
			//phpos.windowUpdate(new_win);			
			phpos.menustartClose();
			//phpos.iconsReposition("icons_contener"+window_id, "horizontal", null, null, true);
		},
		
		onResize:function() { 
		
			//phpos.windowUpdate(new_win);
			phpos.menustartClose();
			//$("#icons_contener"+window_id).css("width", "auto");
		//phpos.iconsReposition("icons_contener"+window_id, "horizontal", null, null, true);
			//alert($(this).css("width"));
		},
		
		onRestore:function() {
		
			//phpos.windowUpdate(new_win);				
			phpos.menustartClose();
			//phpos.iconsReposition("icons_contener"+window_id, "horizontal", null, null, true);
		},
		
		onClose:function() { 				
					
			phpos.controllerWindows('action=destroy&id=' + window_id);
			phpos.menustartClose();		
			$(this).empty();	
			$(this).remove();				
		}		
	}
	); 
	
	
	// Open window and load content with Ajax
	$('#' + window_id).window('open');	
	$('#' + window_id).window('refresh', phposConfig.loaderWindows + '?id=' + window_id);
}


	 
/*
**************************
*/
 	



// =================== MenuStart renderer ===================
	 
/*
**************************
*/
 	

// Menu start render
function phposMenuStart()
{
		var new_win = '#' + phposConfig.divMenuStartWindow;
			
			$(new_win).window(
			{  
				title: '',			
				width: phposConfig.menustartStartWidth,  
				height: phposConfig.menustartStartHeight, 
				top: 1, 
				left: 1, 
				hidden: false,
				minimized: false,
				maximized: false,
				collapsed: false,
				closed: true,			
				animated: true,				
				cache: false,
				modal: false,
				
				shadow: true,
				border: false,
				noHeader: true,
				
				draggable: false,
				resizable: false,
				minimizable: false,
				collapsible: false,
				maximizable: false,
				closable: false,
				
				onMove:function() { 				
					
				},				
				
				onOpen:function() { 				
					
				},
				
				onMinimize:function() { 
					
				},
				
				onMaximize:function() { 
					
				},
				
				onCollapse:function() { 
					
				},
				
				onExpand:function() { 
					
				},
				
				onResize:function() { 
				
					
				},
				onRestore:function() { 
				
				},
				
				onClose:function() { 			
					
				}		
			}); 
	}
	
		
	 
/*
**************************
*/
 	


// Session destroy helper - to del
function window_sessiondestroy() {	
	phpos.controllerWindows('action=sessiondestroy');
}


	 
/*
**************************
*/

// ============= ON DOCUMENT READY =============
	 
/*
**************************
*/
 	

$(document).ready(function() { 	

	phpos.windowRestore(); // Restore saved windows
	phposMenuStart(); // Render menu start		
	
	// MenuStart Events ===
		
	 
/*
**************************
*/
 	

			
// Menu start - button start click
	$('#' + phposConfig.divMenuStartButton).click(function() {		
		phpos.menustartShowHide();
		phpos.menustartSetHeight();
	});
		 
/*
**************************
*/
 	

// Menu start hide
	$('#' + phposConfig.divDesktopIconsContainer).click(function() {		
		phpos.menustartClose();
		phpos.menustartSetHeight();
	});
	 
/*
**************************
*/
 	

// Menu start hide
	$('#' + phposConfig.divMenuStartTasksContainer).click(function() {		
		phpos.menustartClose();
		phpos.menustartSetHeight();
	});
		 
/*
**************************
*/
 	

// Menu start hide
	$('#' + phposConfig.divMenuStartTrayContainer).click(function() {		
		phpos.menustartClose();
		phpos.menustartSetHeight();
	});		
		 
/*
**************************
*/
 	

// Menu start - start button tooltip
	$('#' + phposConfig.divMenuStartButton).tooltip({ position: 'top' });  	
		 
/*
**************************
*/
 	

// Menu start - resize startmenu when window resize
	$(window).resize(function() {
	
			phpos.menustartSetHeight(); // resize startmenu container				
			
			// Desktop Icons reposition
			var repositionHeight = phpos.desktopAvailableHeight();	// Free space without startmenu
			var repositionWidth = phpos.desktopAvailableWidth();	// Free space without startmenu				
			var reposition = phpos.iconsReposition(phposConfig.divDesktopIconsContainer, "vertical", repositionHeight, repositionWidth);				
	});
		 
/*
**************************
*/
 	

// Menu start - onResize startmenu area
	$('#' + phposConfig.divMenuStart).panel(
	{
		onResize:function() { 
			phpos.menustartSetHeight();
				
			// Desktop Icons reposition
			var repositionHeight = phpos.desktopAvailableHeight() - 20;	// Free space without startmenu
			var repositionWidth = phpos.desktopAvailableWidth() - 20;	// Free space without startmenu					
			var reposition = phpos.iconsReposition(phposConfig.divDesktopIconsContainer, "vertical", repositionHeight, repositionWidth);				
		}		
	}); 

	
 	

}); // end of document.ready