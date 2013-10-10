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

	
	$app_id = 'webframes';
	
	$plugin = 'app';
	$access_level = 1;
	$hidden = 1;
	$default_action = 'index';		
	$multiple_windows = true;
	
	$version = '1.0';
	$build = '13.09.20';
	$author = 'PHPOS / Marcin Szczyglinski';
	$website = 'http://phpos.rox.pl';
	$email = 'szczyglis83@gmail.com';
	
	$title = txt('ftp_folders');
	$desc = txt('ftp_folders_desc');
	$icon = 'webframe_icon.png';


	$actions['index'] = array(		
		'name' => 'Webframe',
		'access_level' => 1
	);

?>