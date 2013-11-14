<?php
/*
**********************************

	PHPOS Web Operating system
	MIT License
	(c) 2013 Marcin Szczyglinski
	szczyglis83@gmail.com
	GitHUB: https://github.com/phpos/
	File version: 1.2.5, 2013.10.15
 
**********************************
*/

if(!defined('PHPOS'))	die();	


if(!defined('PHPOS_PLUGIN'))
{
	die();
}

// Load controller:
if(file_exists(PHPOS_APPS_DIR.$app_name.'/controllers/'.$app_name.'Controller.php'))
{		
// Define HELPER PATHS for my app:
	define('PHPOS', true);
	define('PHPOS_APP_SYS', true);
	define('MY_APP_DIR', PHPOS_APPS_DIR.$app_name.'/');
	define('MY_APP_PATH', PHPOS_DIR.'_phpos/apps/'.$app_name.'/');
	define('MY_RESOURCES', PHPOS_DIR.'apps/'.$app_name.'/resources/');
	define('MY_RESOURCES_DIR', PHPOS_DIR.'apps/'.$app_name.'/resources/');
	define('MY_RESOURCES_URL', PHPOS_URL.'apps/'.$app_name.'/resources/');  // check _
		 
/*
**************************
*/
 	
	if($app_name == 'explorer')
	{
		// Define security const for explorer 
		define('PHPOS_FS', true);		
		define('PHPOS_IN_EXPLORER', true);
	
	}
			 
/*
**************************
*/
 	
	
	
	// If ajax and loaded with POST:	
	if(!empty($_POST['ajax_include']))
	{
		$_GET['ajax_include'] = $_POST['ajax_include'];
		$_GET['ajax_file'] = $_POST['ajax_file'];
	}	
		
	// Get POST data for forms
		if($_POST)
		{
			$_SESSION['post'] = $_POST;
			$clear_post=1;
		}

		if(is_array($_SESSION['post']))	$_POST = $_SESSION['post'];
		
		if($app_action == 'desktop')	define('DESKTOP', true);
				 
/*
**************************
*/
 	

	if($my_app->user_have_access())
	{
		define('PHPOS_HAVE_ACCESS', $app_name);
		$layout = new phpos_layout;	
		
		// NO AJAX:	
			if(!defined('IN_AJAX') && $my_app->get_param('api_dialog') != 1)
			{	
				include PHPOS_APPS_DIR.$app_name.'/controllers/'.$app_name.'Controller.php';
				
					// Load view for Action
					if(file_exists(PHPOS_APPS_DIR.$app_name.'/views/'.$app_action.'Action.php'))
					{				
						include PHPOS_APPS_DIR.$app_name.'/views/'.$app_action.'Action.php';
						
					}	elseif(file_exists(PHPOS_APPS_DIR.$app_name.'/views/indexAction.php'))
					{
						helper::alert('info', 'App view not found: '.$app_action);					
						include PHPOS_APPS_DIR.$app_name.'/views/indexAction.php';		
						
					// If any view not found:
					} else {
					
						helper::alert('error', 'App view not found: '.$app_action);
						helper::window('close');		
					}
				
			} else {
			
				// AJAX window:					
					require PHPOS_APPS_DIR.$app_name.'/controllers/'.$app_name.'Controller.php';
					$ajax_file = PHPOS_APPS_DIR.$app_name.'/views/'.strip_tags($_GET['ajax_file']);
					
					if(!empty($ajax_file) && file_exists($ajax_file))
					{
						$layout = new phpos_layout;
						$ajax_file = PHPOS_APPS_DIR.$app_name.'/views/'.$_GET['ajax_file'];
						require $ajax_file;
						
					}	
			}
	// else no access:		
	} else {
	
		helper::alert('error', 'No access to application: '.$app_name);
		helper::window('close');
	}
				 
/*
**************************
*/
 	
	
// If controller not exists:
} else {

		helper::alert('error', 'App controller not found: '.$app_name);
		helper::window('close');		
}
	
		unset($_SESSION['post']);
?>