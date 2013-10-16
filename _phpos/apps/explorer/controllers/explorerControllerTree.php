<?php
/*
**********************************

	PHPOS Web Operating System
	MIT License
	(c) 2013 Marcin Szczyglinski
	szczyglis83@gmail.com
	GitHUB: https://github.com/phpos/
	File version: 1.2.6, 2013.10.16
 
**********************************
*/
	if(!defined('PHPOS'))	die();	

	define('PHPOS_EXPLORER_PLUGIN', true);
	
	// Default plugins
	
	$explorer_plugins = array(
	'explorer_favs.php',
	'explorer_myserver.php',
	'explorer_cloud.php',
	'explorer_ftp.php',
	'explorer_workgroups.php',
	'explorer_shared.php'
	);
	
	$server_plugins = $explorer_plugins;
	
	$plugins_path = PHPOS_DIR.'plugins/explorer/explorer_*.php';
	$plugins_dir = glob($plugins_path);
		 
/*
**************************
*/
 	
	// Get explorer plugins list
	
	foreach($plugins_dir as $plugin)
	{
		$plugin_file = basename($plugin);
		
		if(!in_array($plugin_file, $explorer_plugins))
		{
			$explorer_plugins[] = $plugin_file;
			if(file_exists(PHPOS_DIR.'plugins/explorer/server.'.$plugin_file)) $server_plugins[] = $plugin_file; 
		}
	}
		 
/*
**************************
*/
 	// Include plugins
	
	foreach($explorer_plugins as $plugin)
	{
		include(PHPOS_DIR.'plugins/explorer/'.$plugin);	
	}

?>