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

	
	$app_id = 'shortcuts';
	
	$plugin = 'app';
	$access_level = 1;	
	$hidden = 1;
	$default_action = 'index';	
	$default_section = 'list';
	$multiple_windows = true;	
	
	
	$version = '1.0.0 beta';
	$build = '2013.10.10';
	$author = 'Marcin Szczyglinski';
	$website = 'http://www.phpos.pl';
	$github = 'https://github.com/phpos/phpos/';
	$email = 'szczyglis83@gmail.com';
	
	$title = 'Shortcuts';
	$desc = 'Shortuts and files administration';
	$icon = 'shortcuts.png';
	
	$install_sql = false;
	$db_schema = 'sql/database.sql';
	$installer = 'install.php';	


	$actions['index'] = array(
		'name' => 'Users management',
		'access_level' => 3
	);

?>