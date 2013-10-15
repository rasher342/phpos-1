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


define('PHPOS_EXPLORER_PLUGIN', true);
	
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
 	
	foreach($explorer_plugins as $plugin)
	{
		include(PHPOS_DIR.'plugins/explorer/'.$plugin);	
	}

?>