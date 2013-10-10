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


	$app_id = 'system_info';
	
	$plugin = 'app';
	$access_level = 3;
	$cp_access_level = 3;
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
	
	$title = txt('cp_system_info_title');
	$desc = txt('cp_system_info_desc');
	$icon = 'system_info_icon.png';

	
	$control_panels = array(
		array('index', 'System info', 'system_info_icon.png', txt('cp_system_info_desc_cp'), 3),					
	);		
	
	$section['system_info_phpos'] = array(		
		'access_level' => 3
	);
	
	$section['system_info_php'] = array(		
		'access_level' => 3
	);
	
	$section['system_info_db'] = array(		
		'access_level' => 3
	);
	
	$section['system_info_server'] = array(		
		'access_level' => 3
	);
	
	$section['system_info_key'] = array(		
		'access_level' => 3
	);
	

	$actions['index'] = array(		
		'access_level' => 3,
		'name' => 'System info',
	);

?>