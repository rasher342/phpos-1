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


	 @set_time_limit(0);
/*
**************************
*/
 	
	if(!defined("PHPOS_IN_EXPLORER"))
	{
		die();
	}
	
/*
**************************
*/
 	
	require MY_APP_DIR.'classes/class.explorer.php';
	
	param('folder_root', $fsROOT_ID);
	param('navigation_id', null);	
	param('ftp_id', null);
	param('cloud_id', null);
	param('APP_ACTION', null);
	param('dir_id', null);
	param('desktop_location', null);
	param('root_id', null);
	param('workgroup_id', null);
	param('workgroup_user_id', null);
	param('shared_id', null);
	param('parent_id', null);
	param('action_id', null);
	param('noindex', null);
	param('this_index', null);
	param('prev_index', null);
	param('readonly', null);
	param('action_param', null);
	param('action_param2', null);
	param('tmp_shared_id', null);
	param('reset_shared', null);
	param('error_no_dir', null);
	param('in_shared', null);
	param('icon_size', 'medium');
	param('reset_google_token', null);
	param('dir_navigation_history', array());
	param('dir_navigation_index', 0);
	param('minus_index', null);
	param('set_index', null);
	param('navigation_history', array());
	param('dir_navigation_index', null);
	param('no_increment', 0);
	param('action_status', null);
	param('action_status_msg', null);
	param('fs', '');	
	param('delete_id', '');
	param('view_files_types', 'all');
	
	// API
	param('api_dialog', null);
	param('api_open_id', null);
	param('api_dialog_type', null);
	param('win_id', null);
	param('opened_file_id', null);
	param('opened_file_name', null);
	param('opened_file_extension', null);
	param('opened_file_app_id', null);
	param('explorer_save_as_filename', null);
	param('api_file_ext', null);
	param('api_action', null);
	param('allowed_ext', null);
	
	$my_app->using('params');
				
/*.............................................. */		
	
	cache_param('allowed_ext');	
	cache_param('cloud_id');	
	cache_param('reset_google_token');
	cache_param('view_files_types');	

/*
**************************
*/	
	
	// Load filesystems classes
	
	$filesystems_classes = glob(PHPOS_DIR.'plugins/filesystems/*/fs.*.php');
	$c = count($filesystems_classes);
	if($c != 0)
	{
		foreach($filesystems_classes as $fs_plugin_class)
		{
			include $fs_plugin_class;
		}	
	}
	
/*
**************************
*/	

	 if(APP_ACTION != 'index') 
	 {
			param('dir_id', null);
			param('root_id', null);		
			
			cache_param('dir_id');
			cache_param('root_id');
	 }	
			 
/*
**************************
*/
 	
	$no_index = null;	
	$index = param('this_index');
	$no_index = param('noindex');
	
/*
**************************
*/ 	

	// Actions results	
	
	include MY_APP_DIR.'controllers/explorerControllerResults.php';
		 
/*
**************************
*/

	// Filesystems init codes (all)
	
	$filesystems_glob = glob(PHPOS_DIR.'plugins/filesystems/*/init.always.php');
	$c = count($filesystems_glob);
	if($c != 0)
	{
		foreach($filesystems_glob as $fs_init_code)
		{
			include $fs_init_code;
		}	
	}
					
/*.............................................. */		
		
	// Filesystems init code (only this FS)
	
	if(file_exists(PHPOS_DIR.'plugins/filesystems/'.param('fs').'/init.me.php'))
	{
		include PHPOS_DIR.'plugins/filesystems/'.param('fs').'/init.me.php';
	}	
	

		
/*.............................................. */		                                                                                                                                 	
	include MY_APP_DIR.'controllers/explorerControllerShared.php';
					
/*.............................................. */		
	
	include MY_APP_DIR.'controllers/explorerControllerFS.php';
					
/*.............................................. */		
	
	include MY_APP_DIR.'controllers/explorerControllerAPI.php';
					
/*.............................................. */		
	
	include MY_APP_DIR.'controllers/explorerInitialize.php';
					
/*.............................................. */		
	


	// Actions (new dir, upload, etc)
 	
	include MY_APP_DIR.'controllers/explorerControllerActions.php';
		 
	
/* 
****************************
====== GET ELEMENTS ====== 
***************************
*/		
	
		
// Get left tree	

	include MY_APP_DIR.'controllers/explorerControllerTree.php';
				
/*.............................................. */		
		
	include MY_APP_DIR.'controllers/explorer_my_server.php';
				
/*.............................................. */		
		
	include MY_APP_DIR.'controllers/explorer_workgroup.php';
				
/*.............................................. */		
		
	include MY_APP_DIR.'controllers/explorer_shared.php';
				
/*.............................................. */		
		
	include MY_APP_DIR.'controllers/explorer_ftp.php';		
					
/*.............................................. */		
		
	include MY_APP_DIR.'controllers/explorer_clouds.php';		
				
/*.............................................. */		
		
	include MY_APP_DIR.'controllers/explorer_cp.php';		

		 
/*
**************************
*/ 	
	
	// Get address bars, nav bar and footer
		
	include MY_APP_DIR.'controllers/explorerControllerNavBar.php';
		

/*
***************************
========== ICONS =========
***************************
*/	

		if(APP_ACTION == 'index' || APP_ACTION == 'desktop') 
		{
			include MY_APP_DIR.'controllers/explorerControllerIcons.php';
			
		} else {

			$js = "$('.phpos_server_icon').addClass('phpos_server_icon_mouseleave');
			
			$('.phpos_server_icon').mouseleave(function() {	    
				$(this).removeClass('phpos_server_icon_mouseenter').removeClass('phpos_server_icon_mouseclick').addClass('phpos_server_icon_mouseleave');					
			});			
			
			// == When mouseover on icon
			$('.phpos_server_icon').mouseenter(function() {	
				$(this).removeClass('phpos_server_icon_mouseleave').addClass('phpos_server_icon_mouseenter');				
			});
			
			$('.phpos_server_icon').click(function() {	
				$(this).addClass('phpos_server_icon_mouseclick');				
			});
			";		
		}
		 
/*
**************************
*/
 	
	//JS:
	
	jquery_onready($js);			
	$my_app->jquery_onready(msg::showMessages());
				 
/*
**************************
*/

	include MY_APP_DIR.'controllers/explorerControllerRight.php';		
	
	// Get menu:
	
	$my_app->using('menu');
	$html['menu'] = $my_app->window->get_layout_menu_html();		

?>