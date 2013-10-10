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


	$app_id = 'ftp';
	
	$plugin = 'app';
	$access_level = 1;
	$cp_access_level = 1;
	$hidden = 1;
	$default_action = 'index';	
	$default_section = 'new_account';
	$multiple_windows = true;	
	
	$version = '1.0.0 beta';
	$build = '2013.10.10';
	$author = 'Marcin Szczyglinski';
	$website = 'http://www.phpos.pl';
	$github = 'https://github.com/phpos/phpos/';
	$email = 'szczyglis83@gmail.com';
	
	$title = txt('ftp_folders');
	$desc = txt('ftp_folders_desc');
	$icon = 'ftp.png';

	
	$control_panels = array(
		array('index', txt('ftp_folders'), 'icon.png', txt('ftp_folders_desc'), 1),					
	);		
	
	$section['new_account'] = array(		
		'access_level' => 1
	);	
	
	$section['edit_account'] = array(		
		'access_level' => 1
	);
	
	$section['list'] = array(	
		'access_level' => 1
	);

	$actions['index'] = array(		
		'access_level' => 3
	);

?>