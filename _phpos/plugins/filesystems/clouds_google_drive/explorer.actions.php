<?php
/*
**********************************

	PHPOS Web Operating system
	MIT License
	(c) 2013 Marcin Szczyglinski
	szczyglis83@gmail.com
	GitHUB: https://github.com/phpos/
	File version: 1.2.8, 2013.10.25
 
**********************************
*/
if(!defined('PHPOS'))	die();	

if($action_id == 'googledrive_download_server')
{				
	if(!$phposFS->file_download(param('action_param'))) 
	{						
		param('action_status','error');
		param('action_status_msg',txt('error'));
		cache_param('action_status');	
		cache_param('action_status_msg');	
		msg::error(txt('error'));
	}	
}

if($action_id == 'googledrive_download_local')
{				
	if(!$phposFS->file_download(param('action_param'), true)) 
	{						
		param('action_status','error');
		param('action_status_msg',txt('error'));
		cache_param('action_status');	
		cache_param('action_status_msg');	
		msg::error(txt('error'));
	}	
}

?>