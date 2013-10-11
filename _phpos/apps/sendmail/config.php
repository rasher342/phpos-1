<?php
/*
**********************************

	PHPOS Web Operating system
	MIT License
	(c) 2013 Marcin Szczyglinski
	szczyglis83@gmail.com
	GitHUB: https://github.com/phpos/
	File version: 1.0.0, 2013.10.11
 
**********************************
*/
if(!defined('PHPOS'))	die();	


	$app_id = 'sendmail';
	
	$plugin = 'app';
	$access_level = 1;	
	$hidden = 0;	
	$default_action = 'index';		
	$multiple_windows = true;	
	
	
	$version = '0.1 alpha';
	$build = '2013.10.12';
	$author = 'Marcin Szczyglinski';
	$website = 'http://www.phpos.pl';
	$github = 'https://github.com/phpos/phpos/';
	$email = 'szczyglis83@gmail.com';
	
	$title = 'SendMail';
	$icon = 'icon.png';
	
	$actions['index'] = array(		
		'access_level' => 1,
		'name' => 'Send email',
	);
	

?>