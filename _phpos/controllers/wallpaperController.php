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

	header('Content-Type: text/plain'); 

	if (!isset($_SESSION)) {
		session_start();
	}
	
  define('PHPOS', true);	
 
 // Define PATHS
	define('PHPOS', true);	
	define('PHPOS_DIR','../');
	define('PHPOS_URL','../_phpos/');
	define('PHPOS_WEBROOT','');	
	define('PHPOS_WEBROOT_URL','');
	define('PHPOS_WEBROOT_DIR', '../../web/');
	define('PHPOS_APPS_DIR',PHPOS_DIR.'apps/');	
	define('PHPOS_APPS_URL',PHPOS_DIR.'apps/');		
	define('PHPOS_IN_LOADER', true);  
 
 	require_once(PHPOS_DIR.'config/core.php');	
	require_once(PHPOS_DIR.'config/database.php');
	
// Load all classes and functions
	require_once(PHPOS_DIR.'controllers/databaseController.php');	
	require_once(PHPOS_DIR.'classes/class.users.php');
	
	require_once(PHPOS_DIR.'classes/class.phpos_config.php');
	$config = new phpos_config;
	//$config->get_logged_user();
	$config->set_id_user();
	
	require_once(PHPOS_DIR.'classes/class.helpers.php');	
	
	define("PHPOS_SYSTEM_LANG", cfg::get('lang'));	
	define("PHPOS_USER_LANG", cfg::uget('lang'));
	
 require_once(PHPOS_DIR.'classes/class.api_wintask.php');
 require_once(PHPOS_DIR.'classes/class.api_processes.php');
 require_once(PHPOS_DIR.'classes/class.languages.php');
 require_once(PHPOS_DIR.'controllers/languageController.php');
 require_once(PHPOS_DIR.'controllers/helpersController.php');	
 require_once(PHPOS_DIR.'classes/class.phpos_tasks.php'); 


	if(!empty($_GET['action'])) 
	{
		switch(filter::alfas($_GET['action'])) 
		{		
			case 'update':	
			
				if(globalconfig('demo_mode') != 1 || is_root())
				{		
					$config->update_user('wallpaper', filter::fname($_GET['wallpaper']));		
					$config->update_user('wallpaper_type', filter::fname($_GET['wallpaper_type']));					
				}				
			break;

			default:
			break;
		} 
	} 
	
?>