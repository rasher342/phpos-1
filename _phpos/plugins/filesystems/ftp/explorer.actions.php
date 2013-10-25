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

if($action_id == 'ftp_download')
{
		$connect_id = null;
		$ftp_id = param('ftp_id');
		if(!empty($ftp_id)) $connect_id = $ftp_id;
		$clipboard = new phpos_clipboard;
		$clipboard->add_clipboard(param('action_param'), param('action_param2'), $connect_id);
		//msg::ok('Copied to clipboard');
		
		
		if(!$phposFS->ftp_download(param('action_param'))) 
		{						
			param('action_status','error');
			param('action_status_msg',txt('folder_create_error'));
			cache_param('action_status');	
			cache_param('action_status_msg');	
			msg::error(txt('error'));
		}	
}

if($action_id == 'ftp_view')
{
		$connect_id = null;
		$ftp_id = param('ftp_id');
		if(!empty($ftp_id)) $connect_id = $ftp_id;
		$clipboard = new phpos_clipboard;
		$clipboard->add_clipboard(param('action_param'), param('action_param2'), $connect_id);					
		
		$pathinfo =  pathinfo(param('action_param2'));
		$ext = $pathinfo['extension'];					
		
		$stop_upload = false;
		
		if(globalconfig('upload_blacklist') != '')
		{
			$blacklist = explode(',', globalconfig('upload_blacklist'));
			if(in_array(strtolower($ext), $blacklist))
			{
				$stop_upload = true;
				$upload_error = 'This filetype is on blacklist';
			}		
				
			} else {
				
				if(globalconfig('upload_whitelist') != '')
				{
					$whitelist = explode(',', globalconfig('upload_whitelist'));
			
						if(!in_array(strtolower($ext), $whitelist))
						{
							$stop_upload = true;
							$upload_error = 'This filetype is not in whitelist';
						}
				}						
			}
		
		if(!$stop_upload)
		{
				$phposFS->ftp_view(param('action_param'));
				param('action_param', null);
				cache_param('action_param');				
		}
}
?>