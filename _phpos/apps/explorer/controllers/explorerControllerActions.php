<?php
/*
**********************************

	PHPOS Web Operating system
	MIT License
	(c) 2013 Marcin Szczyglinski
	szczyglis83@gmail.com
	GitHUB: https://github.com/phpos/
	File version: 1.3.3, 2013.11.06
 
**********************************
*/
if(!defined('PHPOS'))	die();	

//console::log('session: '.session_id().', ajax: '.$_SESSION['aaa']);	

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
				helper_waiting();
				$_FILES['file']['name'] = filter::fname($_FILES['file']['name']);
				console::log('EXPLORER.action: Upload ("'.$_FILES['file']['name'].'")');	 
				if($phposFS->upload_file($_FILES['file'])) 
				{					
					console::log('EXPLORER.action: Uploaded', 'ok');	
					if($my_app->get_param('hide_upload_status') == null)
					{
						
						param('action_status','ok');
						param('action_status_msg', txt('uploaded'));
						cache_param('action_status');	
						cache_param('action_status_msg');					
						//msg::error(txt('access_denied'));						
					} 
					
				} else {
					
					console::log('EXPLORER.action: Upload error', 'error');
				}
				
			} else {				
				
				console::log('EXPLORER.action: Upload error [STOP UPLOAD]', 'error');
				param('action_status','error');
				param('action_status_msg', $upload_error);
				cache_param('action_status');	
				cache_param('action_status_msg');					
				msg::error(txt('access_denied'));				
			}
			
			
		} else {
		
			console::log('EXPLORER.action: Upload error [READONLY/DEMO]', 'error');
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
					
					console::log('EXPLORER.action:Rename ("ID:'.$_POST['edit_id'].'", NEW_NAME:"'.filter::fname($_POST['new_folder_name']).'")');
					if($phposFS->rename(strip_tags($_POST['edit_id']), filter::fname($_POST['new_folder_name']))) 
					{
						console::log('EXPLORER.action: Renamed', 'ok');
						param('action_status','ok');					
						param('action_status_msg', txt('renamed'));
						cache_param('action_status');	
						cache_param('action_status_msg');	
						msg::ok($txt('updated'));	
						
					} else {
						
						console::log('EXPLORER.action: Error renaming', 'error');
					}
					
				} else {
				
					console::log('EXPLORER.action: Error renaming [READONLY]', 'error');
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
					helper_waiting();
					$_SESSION['aaa'] = session_id();
					$new_dir_name = strip_tags(filter::fname($_POST['new_folder_name']));
					
					console::log(array(
					'@FORM' => 'new_folder', 
					'[POST] new_folder_name' => $new_dir_name
					));							
					
					if($phposFS->new_dir($new_dir_name)) 
					{
						console::log('@action.new_dir: filesystem.new_dir()', 'ok');						
						
						param('action_status','ok');						
						param('action_status_msg', txt('folder_created'));
						cache_param('action_status');	
						cache_param('action_status_msg');	
						msg::ok(txt('created'));
						
					} else {
						
						console::log('@action.new_dir: filesystem.new_dir()', 'error');
						
						param('action_status','error');
						param('action_status_msg',txt('folder_create_error'));
						cache_param('action_status');	
						cache_param('action_status_msg');	
						msg::ok(txt('created'));
					}
					
					
				} else {
				
					console::log('@action.new_dir: filesystem.new_dir() [READONLY]', 'error');
					
					param('action_status','error');
					param('action_status_msg',txt('access_denied'));
					cache_param('action_status');	
					cache_param('action_status_msg');					
					msg::error(txt('access_denied'));				
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
					helper_waiting();
					console::log(array(
					'@action_id' => 'delete', 
					'action_param' => param('action_param')
					));					
				
					if($phposFS->delete(param('action_param'))) 
					{
						console::log('@action.delete: filesystem.delete()', 'ok');
						msg::ok(txt('file_deleted'));
						
					} else {
					
						console::log('@action.delete: filesystem.delete()', 'error');
					}
					
				break;	
				
				
				case 'explorer_link_to_folder':		
					
					helper_waiting();
					console::log('EXPLORER.action:NewLinkOnDesktop ("ID:"'.base64_decode(param('action_param')).'")');
					$shortcut = new phpos_shortcuts;					
					$shortcut->add(base64_decode(param('action_param2')), 'app', 'explorer', 'index', 'folder_shortcut.png', array('root_id' => param('root_id'), 'workgroup_id' => param('workgroup_id'), 'workgroup_user_id' => param('workgroup_user_id'), 'in_shared' => param('in_shared'),'shared_id' => param('shared_id'),'tmp_shared_id' => param('tmp_shared_id'), 'fs' => 'local_files','dir_id' => base64_decode(param('action_param'))), 'desktop', 0, null);
					echo '<script>phpos.windowRefresh("1", "");</script>';
					msg::ok(txt('updated'));							
					
				break;	
				
/*.............................................. */		
	
				case 'delete_list':		
					
					$file_hashes = param('action_param');
					if(!empty($file_hashes))
					{
						$e = explode(";;", $file_hashes);
						$c = count($e);
						console::log(array('@action_id' => 'delete_list ['.$c.']'));
						
						for($i=0;$i<$c;$i++)
						{
							if($phposFS->delete(base64_decode($e[$i])))
							{
								console::log('@action.delete_list: filesystem.delete()', 'ok');
								
							} else {
								
								console::log('@action.delete_list: filesystem.delete()', 'error');
							}
						}						
					}						
					msg::ok(txt('file_deleted'));				
				break;	
				
				
/*.............................................. */		
	
				case 'pack_multiple':		
					
					$file_hashes = param('action_param');
					if(!empty($file_hashes))
					{						
						$filesArray = explode(";;", $file_hashes);
						$c = count($filesArray);						
						console::log(array('@action_id' => 'pack_multiple ['.$c.']'));	
						console::log($filesArray);							
						
						if(method_exists($phposFS, 'pack_files'))
						{						
							if($phposFS->pack_files($filesArray, null, false)) 
							{
								console::log('@action.pack_multiple: filesystem.pack_files()', 'ok');
								msg::ok(txt('files_packed'));		
								
							} else {
								
								console::log('@action.pack_multiple: filesystem.pack_files()', 'error');
							}							
								
						} else {	
						
							console::log('@action.pack_multiple: filesystem.pack_files() [method not exists]', 'error');	
						}
						
						console::log('-');
					}	
				
						
				break;	
			
/*.............................................. */		
	
				case 'download_multiple':		
					
				
					$file_hashes = param('action_param');
					if(!empty($file_hashes))
					{						
						$filesArray = explode(";;", $file_hashes);
						$c = count($filesArray);						
						console::log(array('@action_id' => 'download_multiple ['.$c.']'));	
						console::log($filesArray);							
						
						if(method_exists($phposFS, 'pack_files'))
						{						
							if($phposFS->pack_files($filesArray, null, true)) 
							{
								console::log('@action.download_multiple: filesystem.pack_files()', 'ok');
								
							} else {
							
								console::log('@action.download_multiple: filesystem.pack_files()', 'error');
							}
							
							msg::ok(txt('files_packed'));		
								
						} else {		
						
							console::log('@action.download_multiple: filesystem.pack_files() [method not exists]', 'error');							
						}
						
						console::log('-');
						
					}						
				break;	
/*.............................................. */			
	
				case 'copy':
					
					helper_waiting();
					$connect_id = null;
					$ftp_id = param('ftp_id');
					if(!empty($ftp_id)) $connect_id = $ftp_id;	
					
					console::log(array(
					'@action_id' => 'copy', 
					'action_param' => param('action_param'), 
					'action_param2' => param('action_param2')
					));		
							
					if($phposFS->clipboard_copy())
					{
						console::log('@action.copy: filesystem.clipboard_copy()', 'ok');
						
					} else {
					
						console::log('@action.copy: filesystem.clipboard_copy()', 'error');
					}
					
					console::log('-');
					//msg::ok(txt('copied_to_clip'));		
					
				break;
			
/*.............................................. */			
	
				case 'copy_multiple':
					
				
					$connect_id = null;
					$ftp_id = param('ftp_id');
					if(!empty($ftp_id)) $connect_id = $ftp_id;	
					
					$file_hashes = param('action_param');
					param('action_param2', param('fs'));
					
					if(!empty($file_hashes))
					{
						$clipboard = new phpos_clipboard;
						$clipboard->reset_clipboard();
						$clipboard->set_multiple(true);
							
						$e = explode(";;", $file_hashes);
						$c = count($e);						
						
						console::log(array('@action_id' => 'copy_multiple ['.$c.']'));	
						console::log($e);					
					
						for($i=0;$i<$c;$i++)
						{							
							param('action_param', base64_decode($e[$i]));	
							console::log(array('action_param' => base64_decode($e[$i])));	
							if($phposFS->clipboard_copy())
							{
								console::log('@action.copy_multiple: filesystem.clipboard_copy()', 'ok');
								
							} else {
								
								console::log('@action.copy_multiple: filesystem.clipboard_copy()', 'error');
							}
							
							console::log('-');
						}	
								
						//echo $clipboard->debug_clipboard();
					}				
					
					
				break;
			
/*.............................................. */	

					case 'copy_server':
					
					helper_waiting();
					$connect_id = null;
					$ftp_id = param('ftp_id');
					if(!empty($ftp_id)) $connect_id = $ftp_id;	
					
					console::log(array(
					'@action_id' => 'copy_server', 
					'action_param' => param('action_param'), 
					'action_param2' => param('action_param2')
					));							
											
					if($phposFS->clipboard_copy_server())
					{
						console::log('@action.copy_server: filesystem.clipboard_copy_server()', 'ok');
						//msg::ok(txt('copied_to_clip'));	
						
					} else {
					
						console::log('@action.copy_server: filesystem.clipboard_copy_server()', 'error');
					}
					
					console::log('-');
					
				break;
					
/*.............................................. */		

				case 'cut':
					
					helper_waiting();
					$connect_id = null;
					$ftp_id = param('ftp_id');
					if(!empty($ftp_id)) $connect_id = $ftp_id;
					
					console::log(array(
					'@action_id' => 'cut', 
					'action_param' => param('action_param'), 
					'action_param2' => param('action_param2')
					));	
					
					if($phposFS->clipboard_cut())
					{
						console::log('@action.cut: filesystem.clipboard_cut()', 'ok');
						
					} else {
					
						console::log('@action.cut: filesystem.clipboard_cut()', 'error');
					}
					console::log('-');
					
					//msg::ok(txt('cutted_to_clip'));			
					
				break;		
					
/*.............................................. */		

				case 'cut_multiple':
					
					helper_waiting();
					$connect_id = null;
					$ftp_id = param('ftp_id');
					if(!empty($ftp_id)) $connect_id = $ftp_id;	
					
					$file_hashes = param('action_param');
					param('action_param2', param('fs'));
					
					if(!empty($file_hashes))
					{
						$clipboard = new phpos_clipboard;
						$clipboard->reset_clipboard();
						$clipboard->set_multiple(true);
							
						$e = explode(";;", $file_hashes);
						$c = count($e);
						
						console::log(array('@action_id' => 'cut_multiple ['.$c.']'));	
						console::log($e);							
						
						for($i=0;$i<$c;$i++)
						{							
							param('action_param', base64_decode($e[$i]));		
							console::log(array('action_param' => base64_decode($e[$i])));		
							
							if($phposFS->clipboard_cut())
							{
								console::log('@action.cut: filesystem.clipboard_cut()', 'ok');
								
							} else {
							
								console::log('@action.cut: filesystem.clipboard_cut()', 'error');
							}
							
							console::log('-');
						}	
								
						//echo $clipboard->debug_clipboard();
					}					
									
					//msg::ok(txt('cutted_to_clip'));	
					
				break;		

			
/*.............................................. */				

				case 'paste':						
				
					helper_waiting();
					$clipboard = new phpos_clipboard;					
					$clipboard->get_clipboard();
					$mode = $clipboard->get_mode();						
					
					if(!$clipboard->is_multiple())
					{
						console::log(array(
						'@action_id' => 'paste', 
						'action_param' => param('action_param'), 
						'action_param2' => param('action_param2')
						));							
						
						if($mode == 'copy')
						{						
							if($phposFS->clipboard_paste(param('action_param'), 'copy'))	
							{
								console::log('@action.paste: filesystem.clipboard_paste() [copy]', 'ok');								
								msg::ok(txt('file_pasted'));
								
							}	 else {	
							
								console::log('@action.paste: filesystem.clipboard_paste() [copy]', 'error');		
							}
						
							console::log(array('@windowRefresh' => WIN_ID));
							console::log('-');
							echo '<script>phpos.windowRefresh("'.WIN_ID.'", "");</script>';
							
						} elseif($mode == 'cut') {
							
							$source_win = $clipboard->get_source_win();
							if($phposFS->clipboard_paste(param('action_param'), 'cut')) 	
							{
								console::log('@action.paste: filesystem.clipboard_paste() [cut]', 'ok');
								console::log(array('@windowRefresh' => $source_win.', '.WIN_ID));								
								echo '<script>phpos.windowRefresh("'.$source_win.'", ""); phpos.windowRefresh("'.WIN_ID.'", "");</script>';
								msg::ok(txt('file_pasted'));	
								
							} else {	
							
								console::log('@action.paste: filesystem.clipboard_paste() [cut]', 'error');				
							}
							
							console::log('-');
						}
						
					} else {
					
						$clipboard_ids_array = $clipboard->get_file_id();	 
				  	$clipboard_names_array = $clipboard->get_name();	
						$clipboard_fs = $clipboard->get_file_fs();
						$clipboard_source_win = $clipboard->get_source_win();
						$clipboard_connect_id = $clipboard->get_file_connect_id();
					  $clipboard_is_server = $clipboard->is_server();
						
						$c = count($clipboard_ids_array);
						console::log(array('@action_id' => 'paste_multiple ['.$c.']'));	
						console::log($e);							
						
						for($i=0; $i<$c; $i++)
						{
							$clipboard->reset_clipboard();
							
							$clipboard->set_mode($mode);
							$clipboard->set_name($clipboard_names_array[$i]);
							$clipboard->set_server($clipboard_is_server);
							$clipboard->set_source_win($clipboard_source_win);
							$clipboard->add_clipboard($clipboard_ids_array[$i], $clipboard_fs, $clipboard_connect_id);	
							
							if($mode == 'copy')
							{						
								if($phposFS->clipboard_paste(param('action_param'), 'copy')) 
								{
									console::log('@action.paste_multiple: filesystem.clipboard_paste() [copy]', 'ok');										
								 
								} else {
								
									console::log('@action.paste_multiple: filesystem.clipboard_paste() [copy]', 'error');		
								}
								
								console::log('-');
								
							} elseif($mode == 'cut') {
								
								$source_win = $clipboard->get_source_win();
								if($phposFS->clipboard_paste(param('action_param'), 'cut'))
								{
									console::log('@action.paste_multiple: filesystem.clipboard_paste() [cut]', 'ok');			
									
								} else {		
								
								  console::log('@action.paste_multiple: filesystem.clipboard_paste() [cut]', 'error');			
								}	
								
								console::log('-');
							}					
						}
						
						if($mode == 'copy')
						{							
							// Restore clipboard
							$clipboard->reset_clipboard();
							
							$clipboard->set_mode($mode);	
							$clipboard->set_server($clipboard_is_server);
							$clipboard->set_source_win($clipboard_source_win);
							$clipboard->set_multiple(true);
							
							for($i=0; $i<$c; $i++)
							{							
								$clipboard->set_name($clipboard_names_array[$i]);							
								$clipboard->add_clipboard($clipboard_ids_array[$i], $clipboard_fs, $clipboard_connect_id);										
							}
							
							console::log(array('@windowRefresh' => WIN_ID));
							console::log('-');
							echo '<script>phpos.windowRefresh("'.WIN_ID.'", "");</script>';
							msg::ok(txt('file_pasted'));	
							
						} elseif($mode == 'cut') {					
							
								console::log(array('@windowRefresh' => $clipboard->get_source_win().', '.WIN_ID));
								console::log('-');
								echo '<script>phpos.windowRefresh("'.$clipboard->get_source_win().'", ""); phpos.windowRefresh("'.WIN_ID.'", "");</script>';
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
		helper_stopwaiting();
		
/*.............................................. */	

	param('action_id', null);
	cache_param('action_id');			
			
	param('action_id', null);
	param('action_param', null);
	cache_param('action_id');
	cache_param('action_param');			
			
?>