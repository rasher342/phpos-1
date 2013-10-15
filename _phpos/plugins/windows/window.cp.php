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

	// If ajax and loaded with POST:	
	if(!empty($_POST['ajax_include']))
	{
		$_GET['ajax_include'] = $_POST['ajax_include'];
		$_GET['ajax_file'] = $_POST['ajax_file'];
	}	
		
	

	if($my_app->user_have_access_cp())
	{
		define('PHPOS_HAVE_ACCESS', $app_name);
		define('CP_ACCESS', true);
		$layout = new phpos_layout;				
		// NO AJAX:	
			if(!$_GET['ajax_include'])
			{	
				include PHPOS_APPS_DIR.$app_name.'/controllers/'.$app_name.'Controller.php';
				
					// Load view for Action
					if(file_exists(PHPOS_APPS_DIR.$app_name.'/views/'.$app_action.'Cp.php'))
					{				
						include PHPOS_APPS_DIR.$app_name.'/views/'.$app_action.'Cp.php';
						
					}	elseif(file_exists(PHPOS_APPS_DIR.$app_name.'/views/indexCp.php'))
					{
						helper::alert('info', 'App view not found, using default: '.$app_name);					
						include PHPOS_APPS_DIR.$app_name.'/views/indexCp.php';		
						
					// If any view not found:
					} else {
					
						helper::alert('error', 'App view not found: '.$app_name);
						helper::window('close');		
					}
				
			} else {
			
				// AJAX window:					
					require PHPOS_APPS_DIR.$app_name.'/controllers/'.$app_name.'Controller.php';
					$ajax_file = PHPOS_APPS_DIR.$app_name.'/views/'.strip_tags($_GET['ajax_file']);
					
					if(file_exists($ajax_file))
					{
						$layout = new phpos_layout;
						$ajax_file = PHPOS_APPS_DIR.$app_name.'/views/'.$_GET['ajax_file'];
						require $ajax_file;
						
					}	else {	
					
						helper::alert('error', 'AJAX file not found: '.$ajax_file);
					}		
			}
	// else no access:		
	} else {
	
		helper::alert('error', 'No access to control panel: '.$app_name);
		helper::window('close');
	}
		
	
// If controller not exists:
} else {

		helper::alert('error', 'App controller not found: '.$app_name);
		helper::window('close');		
}
?>