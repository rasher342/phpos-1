<?php
/*
**********************************

	PHPOS Web Operating system
	MIT License
	(c) 2013 Marcin Szczyglinski
	szczyglis83@gmail.com
	GitHUB: https://github.com/phpos/
	File version: 1.2.7, 2013.10.24
 
**********************************
*/
if(!defined('PHPOS'))	die();	

		$context_location = 'db';
		if(defined('DESKTOP')) $context_location = 'desktop';
		$context_fs = $my_app->get_param('fs');
		$context_dir_id = $my_app->get_param('dir_id');
						
/*.............................................. */		
	
	
		// Load filesystem plugin preloader
		if(file_exists(PHPOS_DIR.'plugins/filesystems/'.$my_app->get_param('fs').'/explorer.preload.php'))
		{
			include PHPOS_DIR.'plugins/filesystems/'.$my_app->get_param('fs').'/explorer.preload.php';	
		}			
					
/*.............................................. */				
			
	$icons = $phposFS->get_files_list();		
	$hidden_icons = $explorer->get_hidden_icons();
	$c = count($icons);
		
	if($c != 0)
	{	
		usort($icons, 'explorer_sort_icons');
	}	
	
	$plugin = new phpos_plugins;
	$plugin->load_plugins();			
				
/*.............................................. */		
			
			$html['icons'].= '<div class="phpos_explorer_list_toolbar">
			<a href="javascript:void(0);" title="Cut selected files/folders" onclick="phpos.list_cut(\''.WIN_ID.'\');"><img src="'.ICONS.'/explorer_toolbar/cut.png" /></a>
			<a href="javascript:void(0);" title="Copy selected files/folders" onclick="phpos.list_copy(\''.WIN_ID.'\');"><img src="'.ICONS.'/explorer_toolbar/copy.png" /></a>
			<a href="javascript:void(0);" title="Delete selected files/folders" onclick="phpos.list_delete(\''.WIN_ID.'\');"><img src="'.ICONS.'/explorer_toolbar/delete.png" /></a><br /><span><a href="javascript:void(0);" title="Select all files/folders" onclick="phpos.list_select_all(\''.WIN_ID.'\');">Select All</a> / <a href="javascript:void(0);" title="Unselect all files/folders" onclick="phpos.list_unselect_all(\''.WIN_ID.'\');">Unselect All</a>  / <a href="javascript:void(0);" title="Reverse selection" onclick="phpos.list_reverse_select(\''.WIN_ID.'\');">Reverse</a></span>
			</div><table class="phpos_explorer_filelist" id="phpos_list_table_'.WIN_ID.'">';
			
			$index = 0;
			
			for($i=0; $i<$c; $i++)
			{					
				$j = $i+1;
				$render_icon = true;
				if(in_array($icons[$i]['basename'], $hidden_icons)) $render_icon = false;				
				
				if(is_array($allowed_extensions) && !$phposFS->is_directory($icons[$i]) && $my_app->get_param('view_files_types') != 'all')
				{
					if(!in_array($icons[$i]['extension'], $allowed_extensions)) $render_icon = false;				
				}
				
/*.............................................. */		
					
				if($render_icon)
				{
					$index++;	
					$is_icons = true;					
					if(is_root()) $icons[$i] = $explorer->root_homedir_parse($icons[$i]);		
				
					$iconDIV = $explorer->config('div_prefix').$j; // Generate unique ID for icon div			
					$icons[$i]['div'] = $explorer->config('div_prefix').$j;
					$icons[$i]['index'] = $index;
					
				
/*.............................................. */		
						
					if(APP_ACTION == 'index' || APP_ACTION == 'desktop')
					{
						// Get static context menu for this filesystem
						if(file_exists(PHPOS_DIR.'plugins/filesystems/'.$my_app->get_param('fs').'/context.static.php'))
						{
							include PHPOS_DIR.'plugins/filesystems/'.$my_app->get_param('fs').'/context.static.php';	
						}								
						
						if($phposFS->is_directory($icons[$i]))
						{
							$my_context_menu = $contextMenus['DIR'];
							
						} else {
						
							$my_context_menu = $contextMenus['FILE'];
						}
					}			
							
					$plugged_context_menu = $my_context_menu;					
					
				
/*.............................................. */		
						
					// Clipboard
					
					include MY_APP_DIR.'controllers/explorerContextClipboard.php';
				
/*.............................................. */								
					
					// Add to startmenu
					
					include MY_APP_DIR.'controllers/explorerContextStartmenu.php';					
				
/*.............................................. */		
						
					// Delete					
					
					include MY_APP_DIR.'controllers/explorerContextDelete.php';					
				
/*.............................................. */							
					
					// Share/unshare folders
					
					include MY_APP_DIR.'controllers/explorerContextShare.php';
				
/*.............................................. */		
						
					// File properties
					
					include MY_APP_DIR.'controllers/explorerContextProperties.php';
				
/*.............................................. */		
						
					// Get dblclick action from context menu:
					
					include MY_APP_DIR.'controllers/explorerContextOpen.php';	
				
/*.............................................. */		
						
					// Plugins rewrite render icon and context menu
					
					include MY_APP_DIR.'controllers/explorerContextPlugins.php';					
					
/*.............................................. */							
					
					// Set context menu for file/folder
					
					$apiWindow->setContextMenu($plugged_context_menu);	// apply to window				
					$js.=$apiWindow->contextMenuRender($iconDIV, 'a');				
					$apiWindow->resetContextMenu();	
				}		
			}	// end loop (icons)
			
			$html['icons'].= '</table>';
			
			
			$js_ready.='
			$("#phpos_list_table_'.WIN_ID.' tr").mouseenter(function() {
				$(this).addClass("tr_hover");			
			});
			
			$("#phpos_list_table_'.WIN_ID.' tr").mouseleave(function() {				
				var tr_index = $(this).attr("phpos_index");
				if(!$("#phpos_list_checkbox_'.WIN_ID.'_" + tr_index).is(":checked"))
				{				
					$(this).removeClass("tr_hover");		
				}
			});			
			
			$(".phpos_explorer_list_toolbar img").mouseenter(function() {
				$(this).addClass("img_hover");			
			});
			
			$(".phpos_explorer_list_toolbar img").mouseleave(function() {				
				$(this).removeClass("img_hover");			
			});	
			
			';
			
			
			
				
/* =============================================== */		
	
				// Context menu for RMB click on folder area
				
				include MY_APP_DIR.'controllers/explorerContextWindow.php';				
				
				// Render JS context menu:
				jquery_function($js);		
				jquery_onready($js_ready);		
		
						
/*.............................................. */		
	
		// If empty folder:
		
		if(!$is_icons) $html['icons'].= txt('folder_is_empty');

?>