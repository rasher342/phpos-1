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


	$app_id = 'logs';
	
	$plugin = 'app';
	$access_level = 3;
	//$cp_access_level = 1;
	$hidden = 0;
	$default_action = 'index';	
	$multilanguage = 1;
	
	$multiple_windows = true;
	
	$version = '1.0';
	$build = '28.09.20';
	$author = 'PHPOS / Marcin Szczyglinski';
	$website = 'http://phpos.rox.pl';
	$email = 'szczyglis83@gmail.com';
	
	$title = txt('logs_app_title');
	$desc = txt('logs_app_title_desc');
	$icon = 'logs_icon.png';

	$section['logs'] = array(		
		'access_level' => 3
	);	
	
	$section['sessions'] = array(		
		'access_level' => 3
	);
	
	$actions['index'] = array(		
		'name' => txt('logs_app_title'),
		'access_level' => 3
	);

?>