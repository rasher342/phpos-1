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
	$explorer = new app_explorer;
	$explorer->set_fs($fs);
	$explorer->assign_filesystem($phposFS);
	$explorer->assign_window($apiWindow);
	$explorer->assign_my_app($my_app);	
	
	
	$explorer->config('filetypes_icons_folder_url', PHPOS_WEBROOT_URL.'_phpos/icons/filetypes/80x80/');
	$explorer->config('filetypes_icons_folder_dir', PHPOS_WEBROOT_DIR.'_phpos/icons/filetypes/80x80/');	
	$explorer->config('div_prefix', 'phpos_icon'.$apiWindow->getParam('id'));
	$explorer->config('div_contener', 'phpos_icons_contener'.$apiWindow->getParam('id'));
			
					
/*.............................................. */		
	
	switch($my_app->get_param('icon_size'))
	{
		case 'medium':
			$explorer->config('icon_size_class', 'phpos_icon_window_size_medium');	
		break;
		
		case 'small':
			$explorer->config('icon_size_class', 'phpos_icon_window_size_small');
		break;	
	}
	
	if(defined('DESKTOP')) $explorer->config('icon_size_class', 'phpos_icon_desktop_size_medium');	
	
	
		// Shortcucts for params
	
	$action_id = $my_app->get_param('action_id');
	$dir_id = $my_app->get_param('dir_id');
	$root_id = $my_app->get_param('root_id');	 
	
/*
**************************
*/
	
	// Set readonly status
	
	if(globalconfig('readonly') && !is_root()) 
	{
		$my_app->set_param('readonly', 1);
		$readonly = 1;
		cache_param('readonly');
	}	
?>