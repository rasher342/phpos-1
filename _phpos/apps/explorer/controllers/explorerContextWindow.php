<?php
/*
**********************************

	PHPOS Web Operating system
	MIT License
	(c) 2013 Marcin Szczyglinski
	szczyglis83@gmail.com
	GitHUB: https://github.com/phpos/
	File version: 1.2.6, 2013.10.16
 
**********************************
*/
if(!defined('PHPOS'))	die();	

if(!defined("PHPOS_IN_EXPLORER"))
{
	die();
}
	if(APP_ACTION == 'index' || APP_ACTION == 'desktop')
	{
		// Get static context menu for this filesystem
		if(file_exists(PHPOS_DIR.'plugins/filesystems/'.$my_app->get_param('fs').'/context.static.php'))
		{
			include PHPOS_DIR.'plugins/filesystems/'.$my_app->get_param('fs').'/context.static.php';	
		}		


		// clipboard
		$clipboard= new phpos_clipboard;
	
		if($my_app->get_param('fs') != 'ftp2')
		{					
			if($clipboard->is_clipboard($my_app->get_param('fs')))
			{
				if($clipboard->is_my_clipboard($my_app->get_param('fs')))
				{
					if(!$readonly || is_root())
					{
						$contextMenus['WINDOW'][] = '---';
						if(APP_ACTION != 'desktop')
						{
							$contextMenus['WINDOW'][] = 'paste::'.txt('paste').'::explorer_paste("'.WIN_ID.'", "'.$my_app->get_param('dir_id').'", null);::paste';
							
						} else {
						
							$contextMenus['WINDOW'][] = 'paste::'.txt('paste').'::explorer_paste("'.WIN_ID.'", "'.$my_app->get_param('dir_id').'", "desktop");::paste';
						}
					}
				}
			}					
		}

		//echo $my_app->get_param('dir_id');

	
/*.............................................. */		

			
		$free_area_menu = $contextMenus['WINDOW'];			
		
		$apiWindow->setContextMenu($free_area_menu);
		$js.= $apiWindow->contextMenuRender('phpos_explorer_div'.div(1), 'td');	
		$apiWindow->resetContextMenu();	
	}		
?>