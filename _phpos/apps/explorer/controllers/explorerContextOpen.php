<?php
/*
**********************************

	PHPOS Web Operating system
	MIT License
	(c) 2013 Marcin Szczyglinski
	szczyglis83@gmail.com
	GitHUB: https://github.com/phpos/
	File version: 1.2.6, 2013.10.16
 
**********************************
*/
if(!defined('PHPOS'))	die();	

if(!defined("PHPOS_IN_EXPLORER"))
{
	die();
}

	if($my_app->get_param('fs') == 'local_files' || $my_app->get_param('fs') == 'db_mysql' || $my_app->get_param('fs') == 'clouds_google_drive') 
	{
		$open_action = $phposFS->get_action_dblclick($icons[$i]);		
		$plugged_context_menu[0] = 'open::'.txt('open').'::'.str_replace('"', '\'', $open_action).'::folder_open';
		$my_plugin = $plugin->get_my_plugin($icons[$i]);
	}

	if(!empty($plugged_context_menu[0]) && ( $context_fs == 'ftp' || $context_fs == 'local_files' ))
	{
		$e = explode('::', $plugged_context_menu[0]);
		if($e[0] == 'open' && !empty($e[1]) && !$phposFS->is_directory($icons[$i])) 
		{
			$icons[$i]['action'] = str_replace('"', '\'', $e[2]);
		}
	}
?>