<?php
/*
**********************************

	PHPOS Web Operating system
	MIT License
	(c) 2013 Marcin Szczyglinski
	szczyglis83@gmail.com
	GitHUB: https://github.com/phpos/
	File version: 1.0.0, 2013.10.09
 
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
			
			if(!$stop_upload)
			{
				$_FILES['file']['name'] = filter::fname($_FILES['file']['name']);
				if($phposFS->upload_file($_FILES['file'])) 
				{			
					
					$my_app->set_param('action_status','ok');
					$my_app->set_param('action_status_msg', txt('uploaded'));
					cache_param('action_status');	
					cache_param('action_status_msg');					
					//msg::error(txt('access_denied'));											
				}
				
			} else {				
				
				$my_app->set_param('action_status','error');
				$my_app->set_param('action_status_msg', $upload_error);
				cache_param('action_status');	
				cache_param('action_status_msg');					
				msg::error(txt('access_denied'));		
			
			}
			
			
		} else {
		
			$my_app->set_param('action_status','error');
			$my_app->set_param('action_status_msg',txt('access_denied'));
			cache_param('action_status');	
			cache_param('action_status_msg');					
			msg::error(txt('access_denied'));				
		
		}
		
		unset($_FILES);
	}
	
		 
/*
**************************
*/	
	//echo $_SESSION['ftp'].'<br>';
if(globalconfig('demo_mode') != 1 || is_root())
{

	if(form_submit('new_rename')) 
	{
				if($readonly != 1) // 0
				{
					if($phposFS->rename(strip_tags($_POST['edit_id']), filter::fname($_POST['new_folder_name']))) 
					{
						$my_app->set_param('action_status','ok');					
						$my_app->set_param('action_status_msg', txt('renamed'));
						cache_param('action_status');	
						cache_param('action_status_msg');	
						msg::ok($txt('updated'));						
					} 					
					
				} else {
				
					$my_app->set_param('action_status','error');
					$my_app->set_param('action_status_msg',txt('access_denied'));
					cache_param('action_status');	
					cache_param('action_status_msg');					
					msg::error($txt('access_denied'));				
				}
			}
			
	 
	/*
	**************************
	*/
			
			if(form_submit('new_folder')) 
			{
				if($readonly != 1) // 0
				{
					if($phposFS->new_dir(strip_tags(filter::fname($_POST['new_folder_name'])))) 
					{
						$my_app->set_param('action_status','ok');						
						$my_app->set_param('action_status_msg', txt('folder_created'));
						cache_param('action_status');	
						cache_param('action_status_msg');	
						msg::ok($txt('created'));
						
					} else {
						
						$my_app->set_param('action_status','error');
						$my_app->set_param('action_status_msg',txt('folder_create_error'));
						cache_param('action_status');	
						cache_param('action_status_msg');	
						msg::ok($txt('created'));
					}
					
					
				} else {
				
					$my_app->set_param('action_status','error');
					$my_app->set_param('action_status_msg',txt('access_denied'));
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
			switch($action_id)
			{			
				case 'delete':			
					if($phposFS->delete($my_app->get_param('action_param'))) msg::ok(txt('file_deleted'));				
				break;	
				
				case 'copy':
					
					$connect_id = null;
					$ftp_id = $my_app->get_param('ftp_id');
					if(!empty($ftp_id)) $connect_id = $ftp_id;
					$clipboard = new phpos_clipboard;
					$clipboard->add_clipboard($my_app->get_param('action_param'), $my_app->get_param('action_param2'), $connect_id);
					msg::ok(txt('copied_to_clip'));			
					
				break;
				
				case 'cut':
					
					$connect_id = null;
					$ftp_id = $my_app->get_param('ftp_id');
					if(!empty($ftp_id)) $connect_id = $ftp_id;
					$clipboard = new phpos_clipboard;
					$clipboard->set_mode('cut');
					$clipboard->set_source_win(WIN_ID);
					$clipboard->add_clipboard($my_app->get_param('action_param'), $my_app->get_param('action_param2'), $connect_id);
					msg::ok(txt('cutted_to_clip'));			
					
				break;
				
				case 'ftp_download':
					
					$connect_id = null;
					$ftp_id = $my_app->get_param('ftp_id');
					if(!empty($ftp_id)) $connect_id = $ftp_id;
					$clipboard = new phpos_clipboard;
					$clipboard->add_clipboard($my_app->get_param('action_param'), $my_app->get_param('action_param2'), $connect_id);
					//msg::ok('Copied to clipboard');
					
					
					if($phposFS->ftp_download($my_app->get_param('action_param'))) 
					{
						/*
						$my_app->set_param('action_status','ok');					
						$my_app->set_param('action_status_msg', null);
						cache_param('action_status');	
						cache_param('action_status_msg');	
						//msg::ok(txt('download_link'));
						*/
						
					} else {
						
						$my_app->set_param('action_status','error');
						$my_app->set_param('action_status_msg',txt('folder_create_error'));
						cache_param('action_status');	
						cache_param('action_status_msg');	
						msg::error(txt('error'));
					}			
					
				break;
				
				
				case 'ftp_view':
					
					$connect_id = null;
					$ftp_id = $my_app->get_param('ftp_id');
					if(!empty($ftp_id)) $connect_id = $ftp_id;
					$clipboard = new phpos_clipboard;
					$clipboard->add_clipboard($my_app->get_param('action_param'), $my_app->get_param('action_param2'), $connect_id);					
					
					$pathinfo =  pathinfo($my_app->get_param('action_param2'));
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
							$phposFS->ftp_view($my_app->get_param('action_param'));
							$my_app->set_param('action_param', null);
							cache_param('action_param');
							
					}
				break;			
				
				
				
				case 'paste':			
				
					$clipboard = new phpos_clipboard;
					$mode = $clipboard->get_mode();						
					
					if($mode == 'copy')
					{
						if($phposFS->copy($my_app->get_param('action_param'))) 	msg::ok(txt('file_pasted'));	
						
					} elseif($mode == 'cut') {
						
						$source_win = $clipboard->get_source_win();
						if($phposFS->cut($my_app->get_param('action_param'))) 	
						{
							echo '<script>phpos.windowRefresh("'.$source_win.'", "");</script>';
							msg::ok(txt('file_pasted'));							
						}
					}					
					
				break;			
			}	
			
			$my_app->set_param('action_id', null);
			cache_param('action_id');
		}

}
	$my_app->set_param('action_id', null);
			cache_param('action_id');
?>