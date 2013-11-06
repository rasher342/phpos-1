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


define("PHPOS_MY_HOME_ROOT", true);	
	
	$filesystem_class = 'phpos_fs_plugin_'.$my_app->get_param('fs');	
	$phposFS = new $filesystem_class; // start filesytem	
	
	$dir_id = $my_app->get_param('dir_id');
	$fs = $my_app->get_param('fs');
	
	
	 
/*
**************************
*/
 		
	// Root ID
	
	$tmp_root_id = $my_app->get_param('root_id');
	
	if(empty($tmp_root_id))
	{
		$root_id = $phposFS->get_root_directory_id();
		$my_app->set_param('root_id', $root_id);
		
	} else {
	
		$root_id = $tmp_root_id;
		$phposFS->set_root_directory_id($tmp_root_id);
		
	}
		 
/*
**************************
*/
 	// Set start DIR ID
	
	if(!empty($dir_id))
	{
		$phposFS->set_directory_id($dir_id);	
		
	} else {
	
		$my_app->set_param('dir_id', $root_id);
		$phposFS->set_directory_id($root_id);		
	}	
	
	$log = array(
	'fs' => $my_app->get_param('fs'), 
	'dir_id' => $my_app->get_param('dir_id'), 
	'root_id' => $my_app->get_param('root_id')
	);
	console::log($log);	 
	unset($log);
	
/*
**************************
*/
 	// Chceck for DIR exists
	
	$dir_id = $phposFS->get_directory_id();
	
	if($fs == 'local_files' && APP_ACTION == 'index')
	{
		if(!is_dir($dir_id)) 
		{
			$my_app->set_param('error_no_dir', 1);		
		}
	}
		 
/*
**************************
*/
 	// If DIR not found
	
	if($my_app->get_param('error_no_dir')) 
	{
		jquery_onready(link_action('my_server', ''));
		msg::error('Folder not found');		
		$my_app->set_param('error_no_dir', null);
		$my_app->set_param('dir_id', null);
		$my_app->set_param('root_dir', null);
		cache_param('error_no_dir');
		cache_param('dir_id');
		cache_param('root_id');
	}
?>