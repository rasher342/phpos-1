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
	if($my_app->get_param('fs') == 'db_mysql' && !$phposFS->is_directory($icons[$i]))
	{
		$plugged_context_menu[] = '---';
		$plugged_context_menu[] = $explorer->generate_to_start_context($my_app->get_param('fs'), $icons[$i]['plugin_id'], $icons[$i]['app_id'], $icons[$i]['id']);
		
		$plugged_context_menu[] = $explorer->generate_to_edit_context($my_app->get_param('fs'), $icons[$i]['plugin_id'], $icons[$i]['app_id'], $icons[$i]['id']);		
	}
?>