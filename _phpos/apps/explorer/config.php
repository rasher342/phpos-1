<?php
/*
**********************************

	PHPOS Web Operating system
	MIT License
	(c) 2013 Marcin Szczyglinski
	szczyglis83@gmail.com
	GitHUB: https://github.com/phpos/
	File version: 1.0.0, 2013.10.10
 
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
	
	
	$version = '1.0.0 beta';
	$build = '2013.10.10';
	$author = 'Marcin Szczyglinski';
	$website = 'http://www.phpos.pl';
	$github = 'https://github.com/phpos/phpos/';
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

?>