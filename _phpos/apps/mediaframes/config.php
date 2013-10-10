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


	$app_id = 'mediaframes';
	
	$plugin = 'app';
	$access_level = 1;	
	$hidden = 1;
	$default_action = 'youtube';		
	$multiple_windows = true;
	
	$version = '1.0';
	$build = '13.09.21';
	$author = 'PHPOS / Marcin Szczyglinski';
	$website = 'http://phpos.rox.pl';
	$email = 'szczyglis83@gmail.com';
	
	$title = txt('ftp_folders');
	$desc = txt('ftp_folders_desc');
	$icon = 'link_icon.png';

	$actions['youtube'] = array(		
		'name' => 'YouTube',
		'access_level' => 1
	);
	
	$actions['vimeo'] = array(		
		'name' => 'Vimeo',
		'access_level' => 1
	);

?>