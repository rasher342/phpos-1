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

	
	$app_id = 'users';
	
	$plugin = 'app';
	$access_level = 1;
	$cp_access_level = 1;
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
	
	$title = txt('users');
	$desc = txt('users_desc');
	$icon = 'user-icon.png';
	
	$control_panels = array(
		array('index', txt('usr_cp_account'), 'user-icon.png', txt('usr_cp_account_desc'), 1),
		array('users_admin', txt('usr_cp_admin'), 'users.png', txt('usr_cp_admin_desc'), 3)			
	);
	
	$section['account'] = array(		
		'access_level' => 1
	);
	
	$section['wallpapers'] = array(		
		'access_level' => 1
	);
	
	$section['groups'] = array(	
		'access_level' => 1
	);

	$section['edit_account'] = array(		
		'access_level' => 2
	);
	
	$section['new_user'] = array(	
		'access_level' => 2
	);	
	
	$section['list'] = array(		
		'access_level' => 2
	);

	$actions['index'] = array(		
		'access_level' => 1
	);
	
	$actions['users_admin'] = array(		
		'access_level' => 2
	);

?>