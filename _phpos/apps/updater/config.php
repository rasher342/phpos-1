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

	
	$app_id = 'updater';
	
	$plugin = 'app';
	$access_level = 3;	
	$hidden = 0;
	$default_action = 'index';		
	$multiple_windows = true;	
	
	
	$version = '1.0.0 beta';
	$build = '2013.10.10';
	$author = 'Marcin Szczyglinski';
	$website = 'http://www.phpos.pl';
	$github = 'https://github.com/phpos/phpos/';
	$email = 'szczyglis83@gmail.com';
	
	$title = txt('updater_app_title');
	$icon = 'logo.png';
	
	$actions['index'] = array(		
		'access_level' => 3,
		'name' => 'Updates',
	);

?>