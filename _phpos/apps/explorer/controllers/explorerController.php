<?php
/*
**********************************

	PHPOS Web Operating system
	MIT License
	(c) 2013 Marcin Szczyglinski
	szczyglis83@gmail.com
	GitHUB: https://github.com/phpos/
	File version: 1.0.0, 2013.10.08
 
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
					
/*.............................................. */		
	
	
	if(!empty($_FILES))    
	{
		$_SESSION['upload_zone'] = 'yeeeees';
	}
					
/*.............................................. */		
	
	
	/*
	$fs_plugins_path = PHPOS_DIR.'plugins/fs.*Plugin.php';
	$fs_plugins_dir = glob($fs_plugins_path);	
	foreach($fs_plugins_dir as $fs_plugin)
	{		
		require $fs_plugin;	
	}*/
	
	require PHPOS_DIR.'plugins/fs.db_mysqlPlugin.php';
	require PHPOS_DIR.'plugins/fs.local_filesPlugin.php';
	require PHPOS_DIR.'plugins/fs.ftpPlugin.php';
	require PHPOS_DIR.'plugins/fs.clouds_google_drivePlugin.php';
		 
/*
**************************
*/
 	
	require MY_APP_DIR.'classes/class.explorer.php';



	$my_app->set_param('folder_root', $fsROOT_ID);
	$my_app->set_param('navigation_id', NULL);	
	$my_app->set_param('ftp_id', NULL);
	$my_app->set_param('cloud_id', NULL);
	$my_app->set_param('APP_ACTION', NULL);
	$my_app->set_param('dir_id', NULL);
	$my_app->set_param('desktop_location', NULL);
	$my_app->set_param('root_id', NULL);
	$my_app->set_param('workgroup_id', NULL);
	$my_app->set_param('workgroup_user_id', NULL);
	$my_app->set_param('shared_id', NULL);
	$my_app->set_param('action_id', NULL);
	$my_app->set_param('noindex', NULL);
	$my_app->set_param('this_index', NULL);
	$my_app->set_param('prev_index', NULL);
	$my_app->set_param('readonly', NULL);
	$my_app->set_param('action_param', NULL);
	$my_app->set_param('action_param2', NULL);
	$my_app->set_param('tmp_shared_id', NULL);
	$my_app->set_param('reset_shared', NULL);
	$my_app->set_param('error_no_dir', NULL);
	$my_app->set_param('in_shared', NULL);
	$my_app->set_param('icon_size', 'medium');
	$my_app->set_param('reset_google_token', NULL);
	$my_app->set_param('dir_navigation_history', array());
	$my_app->set_param('dir_navigation_index', 0);
	$my_app->set_param('minus_index', null);
	$my_app->set_param('set_index', null);
	$my_app->set_param('navigation_history', array());
	$my_app->set_param('dir_navigation_index', null);
	$my_app->set_param('no_increment', 0);
	$my_app->set_param('action_status', null);
	$my_app->set_param('action_status_msg', null);
	$my_app->set_param('fs', '');	
	$my_app->set_param('delete_id', '');
	$my_app->set_param('view_files_types', 'all');
	
	// API
	$my_app->set_param('api_dialog', NULL);
	$my_app->set_param('api_open_id', NULL);
	$my_app->set_param('api_dialog_type', NULL);
	$my_app->set_param('win_id', NULL);
	$my_app->set_param('opened_file_id', NULL);
	$my_app->set_param('opened_file_name', NULL);
	$my_app->set_param('opened_file_extension', NULL);
	$my_app->set_param('opened_file_app_id', NULL);
	$my_app->set_param('explorer_save_as_filename', NULL);
	$my_app->set_param('api_file_ext', NULL);
	$my_app->set_param('api_action', NULL);
	$my_app->set_param('allowed_ext', NULL);
	
	$my_app->using('params');
				
/*.............................................. */		
	
	cache_param('allowed_ext');	
	cache_param('cloud_id');	
	cache_param('reset_google_token');
	cache_param('view_files_types');	
	
	if($my_app->get_param('allowed_ext') !== null)
	{
		$allowed_extensions = explode(';', $my_app->get_param('allowed_ext'));	
	}
	
	/*
	echo '<pre>';
	print_r($allowed_extensions);
	echo '</pre>';
	*/
			 
/*
**************************
*/
 	
	$no_index = null;
	
	$index = $my_app->get_param('this_index');
	$no_index = $my_app->get_param('noindex');
			 
/*
**************************
*/
 	// Reset Google Token
	
	if($_SESSION['google_refresh'])
	{
		unset($_SESSION['google_refresh']);
		//echo '<script>'.winreload(WIN_ID, array('root_id' => '.', 'dir_id' => '.', 'reset_google_token' => 1)).'</script>';
	}
	
	
	if($my_app->get_param('reset_google_token') == 1)
	{
		if(isset($_SESSION['token']) && isset($_SESSION['google_token'])) 
		{
			unset($_SESSION['google_token']);
			//$_SESSION['google_refresh'] = true;
		}
	}
	
/*
**************************
*/	
 	

	// Clipboard
 	
	$clipboard = new phpos_clipboard;
	$clipboard->debug_clipboard();
	//echo 'action_id:'.$action_id.', action_param:'.$my_app->get_param('action_param').' action_param2:'.$my_app->get_param('action_param2').'<br>'; 
	
		
			 
/*
**************************
*/ 	
	// Actions results	
	$action_id = $my_app->get_param('action_id');
	$action_status = $my_app->get_param('action_status');
	$action_status_msg = $my_app->get_param('action_status_msg');
	
	if(!empty($action_status))
	{
		if($action_status == 'error')
		{
			msg::error($action_status_msg);
			
		} else {		
			
			msg::ok($action_status_msg);
		}
		
		$my_app->set_param('action_status', null);
		$my_app->set_param('action_status_msg', null);
		cache_param('action_status');	
		cache_param('action_status_msg');	
	}
			 
/*
**************************
*/
 	
	// FTP		 
	if($my_app->get_param('fs') != 'ftp')
	{
		$my_app->set_param('ftp_id', null);
		cache_param('ftp_id');	
		
	} else {
	
		cache_param('ftp_id');	
	} 
	
/*
**************************
*/

	// Clouds		 
	if($my_app->get_param('fs') != 'clouds_google_drive')
	{
		$my_app->set_param('cloud_id', null);
		cache_param('cloud_id');	
		
	} else {
	
		cache_param('cloud_id');	
	} 
		 
		 
/*
**************************
*/

	                                                                                                                                       if(APP_ACTION != 'index') 
	 {
			$my_app->set_param('dir_id', NULL);
			$my_app->set_param('root_id', NULL);
			
		// Desktop dir
			
			if(APP_ACTION == 'desktop' && $my_app->get_param('fs') == 'local_files') 
			{			
				$dir_hash = $my_user->get_home_dir_hash();
				$home_dir = PHPOS_HOME_DIR.$dir_hash.'/_Desktop';
				
				if(is_dir($home_dir)) 
				{
					$my_app->set_param('root_id', $home_dir);
					//$this->root_directory_id = $home_dir;		
				}					
			}
	 }	
		
			
/*
**************************
*/
 	
	include MY_APP_DIR.'controllers/explorerControllerShared.php';
	
		 
/*
**************************
*/
 	
	include MY_APP_DIR.'controllers/explorerControllerFS.php';
	
			 
/*
**************************
*/
 	
	include MY_APP_DIR.'controllers/explorerControllerAPI.php';


		
/*
**************************
*/
 	// Start explorer
	
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
		 
/*
**************************
*/	
	
	// Shortcucts for params
	
	$action_id = $my_app->get_param('action_id');
	$dir_id = $my_app->get_param('dir_id');
	$root_id = $my_app->get_param('root_id');
	
		 
	
/*
**************************
*/
	
	
	if(globalconfig('readonly') && !is_root()) 
	{
		$my_app->set_param('readonly', 1);
		$readonly = 1;
		cache_param('readonly');
	}
	
	
/*
**************************
*/

	// Actions (new dir, upload, etc)
 	
	include MY_APP_DIR.'controllers/explorerControllerActions.php';
		 
/*
**************************
*/ 	
	
	// Reset params
	
	$my_app->set_param('action_id', null);
	$my_app->set_param('action_param', null);
	cache_param('action_id');
	cache_param('action_param');	
	
		
/* 
****************************
====== GET ELEMENTS ====== 
***************************
*/		
	
		
// Get left tree	

	include MY_APP_DIR.'controllers/explorerControllerTree.php';
		 
/*
**************************
*/
 	
	include MY_APP_DIR.'controllers/explorer_my_server.php';
		 
/*
**************************
*/
 	
	include MY_APP_DIR.'controllers/explorer_workgroup.php';
	
		 
/*
**************************
*/
 	
	include MY_APP_DIR.'controllers/explorer_shared.php';
	
		 
/*
**************************
*/
 	
	
	include MY_APP_DIR.'controllers/explorer_ftp.php';		
	
		include MY_APP_DIR.'controllers/explorer_clouds.php';		
	
		 
/*
**************************
*/
 	
	include MY_APP_DIR.'controllers/explorer_cp.php';		

		 
/*
**************************
*/ 	
	
	// Get address bars, nav bar and footer
		
	$html['addressbar'] = $explorer->render_address_url();
	$html['footer_address'] = $explorer->render_address_links();
	$html['footer_protocol_icon'] = $explorer->get_icon_protocol();
	$html['protocol_icon'] = $explorer->get_icon_protocol();
		 
/*
**************************
*/
 	
	// Protocol icon
	
	if(!empty($address_icon)) 
	{
		$html['protocol_icon'] = $address_icon;
		$html['footer_protocol_icon'] = $address_icon;
	}
	
	$html['protocol_bg'] = '';	
	$html['navbar'] = $explorer->render_nav_bar();
		

/*
***************************
========== ICONS =========
***************************
*/	

		if(APP_ACTION == 'index' || APP_ACTION == 'desktop') include MY_APP_DIR.'controllers/explorerControllerIcons.php';
			 
/*
**************************
*/
 	
		
	$js = "$('.phpos_server_icon').addClass('phpos_server_icon_mouseleave').addClass('easyui-tooltip');
	
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
		 
/*
**************************
*/
 	
	jquery_onready($js);
	
		
	$my_app->jquery_onready(msg::showMessages());
				 
/*
**************************
*/

	include MY_APP_DIR.'controllers/explorerControllerRight.php';	
	
	
	$my_app->using('menu');
	$html['menu'] = $my_app->window->get_layout_menu_html();		

?>