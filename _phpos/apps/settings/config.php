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

	
	$app_id = 'settings';
	
	$plugin = 'app';
	$access_level = 2;
	$cp_access_level = 2;
	$hidden = 1;
	$default_action = 'index';	
	$default_section = 'new_account';
	$multiple_windows = true;
	
	$version = '1.0';
	$build = '13.09.20';
	$author = 'PHPOS / Marcin Szczyglinski';
	$website = 'http://phpos.rox.pl';
	$email = 'szczyglis83@gmail.com';
	
	$title = txt('cp_settings_title');
	$desc = txt('cp_settings_desc');
	$icon = 'settings_icon.png';

	
	$control_panels = array(
		array('index', txt('cp_settings_title'), 'settings_icon.png', txt('cp_settings_desc'), 2),					
	);		
	
	$section['config_site'] = array(		
		'access_level' => 2
	);	
	
	$section['config_themes'] = array(		
		'access_level' => 2
	);
	
	$section['config_wallpapers'] = array(		
		'access_level' => 2
	);
	
	$section['config_updater'] = array(	
		'access_level' => 3
	);
	
	$section['config_security'] = array(	
		'access_level' => 3
	);
	
	$section['config_other'] = array(	
		'access_level' => 1
	);

	$actions['index'] = array(		
		'access_level' => 2
	);

?>