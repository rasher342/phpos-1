<?php
/*
**********************************

	PHPOS Web Operating system
	MIT License
	(c) 2013 Marcin Szczyglinski
	szczyglis83@gmail.com
	GitHUB: https://github.com/phpos/
	File version: 1.2.8, 2013.10.28
 
**********************************
*/
if(!defined('PHPOS'))	die();	


if(!empty($_FILES)) 
{
		if(is_root() || ($readonly != 1 && globalconfig('disable_upload') !=1 && globalconfig('demo_mode') != 1)) // 0
		{			
			$pathinfo =  pathinfo($_FILES['file']['name']);
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
				
/*.............................................. */		
			if(!$stop_upload)
			{
				$_FILES['file']['name'] = filter::fname($_FILES['file']['name']);
				if($phposFS->upload_file($_FILES['file'])) 
				{					
					param('action_status','ok');
					param('action_status_msg', txt('uploaded'));
					cache_param('action_status');	
					cache_param('action_status_msg');					
					//msg::error(txt('access_denied'));											
				}
				
			} else {				
				
				param('action_status','error');
				param('action_status_msg', $upload_error);
				cache_param('action_status');	
				cache_param('action_status_msg');					
				msg::error(txt('access_denied'));				
			}
			
			
		} else {
		
			param('action_status','error');
			param('action_status_msg',txt('access_denied'));
			cache_param('action_status');	
			cache_param('action_status_msg');					
			msg::error(txt('access_denied'));			
		}
		
		unset($_FILES);
	}
	
		
/*.............................................. */	


if(globalconfig('demo_mode') != 1 || is_root())
{

	if(form_submit('new_rename')) 
	{
				if($readonly != 1) // 0
				{
					if($phposFS->rename(strip_tags($_POST['edit_id']), filter::fname($_POST['new_folder_name']))) 
					{
						param('action_status','ok');					
						param('action_status_msg', txt('renamed'));
						cache_param('action_status');	
						cache_param('action_status_msg');	
						msg::ok($txt('updated'));						
					} 					
					
				} else {
				
					param('action_status','error');
					param('action_status_msg',txt('access_denied'));
					cache_param('action_status');	
					cache_param('action_status_msg');					
					msg::error($txt('access_denied'));				
				}
			}
		
/*.............................................. */	
		
			if(form_submit('new_folder')) 
			{
				if($readonly != 1) // 0
				{
					if($phposFS->new_dir(strip_tags(filter::fname($_POST['new_folder_name'])))) 
					{
						param('action_status','ok');						
						param('action_status_msg', txt('folder_created'));
						cache_param('action_status');	
						cache_param('action_status_msg');	
						msg::ok($txt('created'));
						
					} else {
						
						param('action_status','error');
						param('action_status_msg',txt('folder_create_error'));
						cache_param('action_status');	
						cache_param('action_status_msg');	
						msg::ok($txt('created'));
					}
					
					
				} else {
				
					param('action_status','error');
					param('action_status_msg',txt('access_denied'));
					cache_param('action_status');	
					cache_param('action_status_msg');					
					msg::error($txt('access_denied'));				
				}
			}
			
			
		 
/*
**************************
*/	 
		
		if(!empty($action_id))
		{			
			if(file_exists(PHPOS_DIR.'plugins/filesystems/'.param('fs').'/explorer.actions.php'))
			{
				include PHPOS_DIR.'plugins/filesystems/'.param('fs').'/explorer.actions.php';
			}	
			
		
/*.............................................. */		
		
			switch($action_id)
			{			
				case 'delete':			
					if($phposFS->delete(param('action_param'))) msg::ok(txt('file_deleted'));				
				break;	
				
/*.............................................. */		
	
				case 'delete_list':		
					$file_hashes = param('action_param');
					if(!empty($file_hashes))
					{
						$e = explode(";;", $file_hashes);
						$c = count($e);
						for($i=0;$i<$c;$i++)
						{
							$phposFS->delete(base64_decode($e[$i]));
						}						
					}						
					msg::ok(txt('file_deleted'));				
				break;	
			
/*.............................................. */			
	
				case 'copy':
					
					$connect_id = null;
					$ftp_id = param('ftp_id');
					if(!empty($ftp_id)) $connect_id = $ftp_id;					
					$phposFS->clipboard_copy();							
					msg::ok(txt('copied_to_clip'));		
					
				break;
			
/*.............................................. */			
	
				case 'copy_server':
					
					$connect_id = null;
					$ftp_id = param('ftp_id');
					if(!empty($ftp_id)) $connect_id = $ftp_id;									
					$phposFS->clipboard_copy_server();							
					msg::ok(txt('copied_to_clip'));		
					
				break;
					
/*.............................................. */		

				case 'cut':
					
					$connect_id = null;
					$ftp_id = param('ftp_id');
					if(!empty($ftp_id)) $connect_id = $ftp_id;					
					$phposFS->clipboard_cut();					
					msg::ok(txt('cutted_to_clip'));			
					
				break;				
			
/*.............................................. */				

				case 'paste':						
				
					$clipboard = new phpos_clipboard;					
					$clipboard->get_clipboard();
					$mode = $clipboard->get_mode();						
					
					if($mode == 'copy')
					{						
						if($phposFS->clipboard_paste(param('action_param'), 'copy'))	msg::ok(txt('file_pasted'));	
						echo '<script>phpos.windowRefresh("'.WIN_ID.'", "");</script>';
						
					} elseif($mode == 'cut') {
						
						$source_win = $clipboard->get_source_win();
						if($phposFS->clipboard_paste(param('action_param'), 'cut')) 	
						{
							echo '<script>phpos.windowRefresh("'.$source_win.'", ""); phpos.windowRefresh("'.WIN_ID.'", "");</script>';
							msg::ok(txt('file_pasted'));							
						}
					}					
					
				break;			
			}	
				
/*.............................................. */	

	
			param('action_id', null);
			cache_param('action_id');
		}

}
		
/*.............................................. */	

	param('action_id', null);
	cache_param('action_id');			
			
	param('action_id', null);
	param('action_param', null);
	cache_param('action_id');
	cache_param('action_param');			
			
?>