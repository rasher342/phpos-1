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


$tray['id'] = 'bugtracker';
$tray['access_level'] = 1;
$tray['version'] = 1.0;
$tray['load_only_with_app'] = false;
$tray['app_id'] = 'bugtracker';
$tray['use_custom_icons'] = true;
$tray['use_lang'] = true;

$tmp_context_menu = array();

$tray['icons'] = array(ICONS.'tray/bugtracker.png');
$tray['title'] = 	txt('bugtracker_app_tray');

$tmp_context_menu[] = 'app::<b>'.txt('bugtracker_app').'</b>::'.helper::win(txt('bugtracker_app'), 'app', 'app_id:bugtracker').'::letter';
$tray['context_menu'] = $tmp_context_menu;


?>