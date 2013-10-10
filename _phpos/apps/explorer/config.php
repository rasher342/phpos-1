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


	
	$app_id = 'explorer';
	
	$plugin = 'app';
	$access_level = 1;	
	$hidden = 0;
	$default_action = 'index';	
	$default_section = 'list';
	$multiple_windows = true;	
	
	$version = '1.0';
	$build = '13.09.20';
	$author = 'PHPOS / Marcin Szczyglinski';
	$website = 'http://phpos.rox.pl';
	$email = 'szczyglis83@gmail.com';
	
	$title = 'Explorer';
	$desc = 'Files manager';
	$icon = 'explorer.png';


	$actions['index'] = array(
		'name' => 'Files explorer',
		'access_level' => 1
	);
	
	$actions['my_server'] = array(
		'name' => 'My server',
		'access_level' => 1
	);
	
	$actions['cp'] = array(
		'name' => 'Control Panel',
		'access_level' => 1
	);
	
	$app_param['fs'] = array(
		'name' => 'Filesystem',
		'required' => true,
		'values' => 'local_files,db_mysql',
		'default' => 'local_files'
	);
	
	
	
	$css = 'resources/css/app.css';	
	$js = 'resources/js/scripts.js';	

?>