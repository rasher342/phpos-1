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

					
	if((APP_ACTION == 'index' || APP_ACTION == 'desktop') && $context_fs == 'ftp' || $context_fs == 'local_files')
	{
		$plugged_context_menu[] = '---';
		$plugged_context_menu[] = 'properties::'.txt('fileinfo_context').'::'.winmodal(txt('file_info'), 'app', 'app_id:shortcuts@file_info','location:'.$context_location.',fs:'.$context_fs.',edit_id:'.base64_encode($icons[$i]['id']).',dir_name:'.base64_encode(dirname($icons[$i]['id'])).',file_name:'.base64_encode($icons[$i]['basename']).',file_modified:'.base64_encode($icons[$i]['modified_at']).',file_type:'.base64_encode($icons[$i]['extension']).',file_chmod:'.base64_encode($icons[$i]['chmod']).',file_created:'.base64_encode($icons[$i]['created_at']).',after_reload:'.WIN_ID).'::edit';		
	}
?>