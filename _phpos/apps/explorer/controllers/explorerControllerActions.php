<?php
/*
**********************************

	PHPOS Web Operating system
	MIT License
	(c) 2013 Marcin Szczyglinski
	szczyglis83@gmail.com
	GitHUB: https://github.com/phpos/
	File version: 1.3.5, 2013.11.07
 
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

			console::log(array(
			'@FORM' => 'upload', 
			'[FILES] file_name' => $_FILES['file']['name'],
			'[FILES] tmp_name' => $_FILES['file']['tmp_name'],
			'[FILES] extension' => $ext,
			'[FILES] mimetype' => $_FILES['file']['type']			
			));					
			
			
			$stop_upload = false;
			if(globalconfig('upload_blacklist') != '')
			{
				$blacklist = explode(',', globalconfig('upload_blacklist'));
				if(in_array(strtolower($ext), $blacklist))
				{
					$stop_upload = true;
					console::log('@action.upload: filetype in blacklist', 'error');
					$upload_error = 'This filetype is on blacklist';
				}		
					
				} else {
					
					if(globalconfig('upload_whitelist') != '')
					{
						$whitelist = explode(',', globalconfig('upload_whitelist'));
				
						if(!in_array(strtolower($ext), $whitelist))
						{
							$stop_upload = true;
							console::log('@action.upload: filetype not in whitelist', 'error');
							$upload_error = 'This filetype is not in whitelist';
						}
					}
				
				}
				
/*.............................................. */		
			if(!$stop_upload)
			{
				helper_waiting();
				$_FILES['file']['name'] = filter::fname($_FILES['file']['name']);
			
				if($phposFS->upload_file($_FILES['file'])) 
				{					
					console::log('@action.upload: filesystem.upload_file()', 'ok');
				
					if($my_app->get_param('hide_upload_status') == null)
					{
						
						param('action_status','ok');
						param('action_status_msg', txt('uploaded'));
						cache_param('action_status');	
						cache_param('action_status_msg');					
						//msg::error(txt('access_denied'));						
					} 
					
				} else {
					
					console::log('@action.upload: filesystem.upload_file()', 'error');					
				}
				
			} else {				
				
				console::log('@action.upload: filesystem.upload_file() [stop upload]', 'error');
				param('action_status','error');
				param('action_status_msg', $upload_error);
				cache_param('action_status');	
				cache_param('action_status_msg');					
				msg::error(txt('access_denied'));				
			}
			
			
		} else {
		
			console::log('@action.upload: filesystem.upload_file() [read only]', 'error');
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
					$new_name = filter::fname($_POST['new_folder_name']);
					console::log(array(
					'@FORM' => 'rename', 
					'[POST] new_name' => $new_name,
					'[POST] edit_id' => $_POST['edit_id']
					));					
				
					if($phposFS->rename(strip_tags($_POST['edit_id']), $new_name)) 
					{
						console::log('@action.new_rename: filesystem.rename()', 'ok');		
						
						param('action_status','ok');					
						param('action_status_msg', txt('renamed'));
						cache_param('action_status');	
						cache_param('action_status_msg');	
						msg::ok($txt('updated'));	
						
					} else {
						
						console::log('@action.new_rename: filesystem.rename()', 'error');	
					}
					
				} else {
				
					console::log('@action.new_rename: filesystem.rename() [READONLY]', 'error');
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
					//$_SESSION['aaa'] = session_id();
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
				
				//echo '<script>phpos.windowRefresh("'.WIN_ID.'", "action_id:0");</script>';
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
				
					console::log(array(
					'@action_id' => 'delete', 
					'action_param' => param('action_param')
					));					
				
					if($phposFS->delete(param('action_param'))) 
					{
						console::log('@action.delete: filesystem.delete()', 'ok');
						apply_status('ok', txt('file_deleted'));					
						
					} else {
					
						console::log('@action.delete: filesystem.delete()', 'error');
					}
					
					echo '<script>phpos.windowRefresh("'.WIN_ID.'", "action_id:0");</script>';
						
				break;	
				
				
				case 'explorer_link_to_folder':		
					
					
					console::log('EXPLORER.action:NewLinkOnDesktop ("ID:"'.base64_decode(param('action_param')).'")');
					$shortcut = new phpos_shortcuts;					
					$shortcut->add(base64_decode(param('action_param2')), 'app', 'explorer', 'index', 'folder_shortcut.png', array('root_id' => param('root_id'), 'workgroup_id' => param('workgroup_id'), 'workgroup_user_id' => param('workgroup_user_id'), 'in_shared' => param('in_shared'),'shared_id' => param('shared_id'),'tmp_shared_id' => param('tmp_shared_id'), 'fs' => 'local_files','dir_id' => base64_decode(param('action_param'))), 'desktop', 0, null);
					
					apply_status('ok', txt('updated'));
					echo '<script>phpos.windowRefresh("1", "");</script>';
											
					
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
								apply_status('ok', txt('file_deleted'));
								
							} else {
								
								console::log('@action.delete_list: filesystem.delete()', 'error');
							}
						}						
					}		
						echo '<script>phpos.windowRefresh("'.WIN_ID.'", "action_id:0");</script>';
							
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
								apply_status('ok', txt('files_packed'));
								
								
							} else {
								
								console::log('@action.pack_multiple: filesystem.pack_files()', 'error');
							}							
								
						} else {	
						
							console::log('@action.pack_multiple: filesystem.pack_files() [method not exists]', 'error');	
						}
						
						console::log('-');
					}	
					
					echo '<script>phpos.windowRefresh("'.WIN_ID.'", "action_id:0");</script>';
						
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
								apply_status('ok', txt('files_packed'));
								
							} else {
							
								console::log('@action.download_multiple: filesystem.pack_files()', 'error');
							}								
								
						} else {		
						
							console::log('@action.download_multiple: filesystem.pack_files() [method not exists]', 'error');							
						}
						
						console::log('-');
						
					}		
					echo '<script>phpos.windowRefresh("'.WIN_ID.'", "action_id:0");</script>';
					
				break;	
/*.............................................. */			
	
				case 'copy':					
					
					$connect_id = null;
					$ftp_id = param('ftp_id');
					if(!empty($ftp_id)) $connect_id = $ftp_id;	
					
					$clipboard = new phpos_clipboard();
					$clipboard->reset_clipboard();
					
					console::log(array(
					'@action_id' => 'copy', 
					'action_param' => param('action_param'), 
					'action_param2' => param('action_param2')
					));		
							
					if($phposFS->clipboard_copy())
					{
						console::log('@action.copy: filesystem.clipboard_copy()', 'ok');
						apply_status('ok', txt('copied_to_clip'));
						
					} else {
					
						console::log('@action.copy: filesystem.clipboard_copy()', 'error');
					}
					
					console::log('-');
					
					echo '<script>phpos.windowRefresh("'.WIN_ID.'", "action_id:0");</script>';
					
				break;
			
/*.............................................. */			
	
				case 'copy_multiple':
					
				
					$connect_id = null;
					$ftp_id = param('ftp_id');
					if(!empty($ftp_id)) $connect_id = $ftp_id;	
					
					$clipboard = new phpos_clipboard();
					$clipboard->reset_clipboard();
					
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
						$error = null;
						for($i=0;$i<$c;$i++)
						{							
							param('action_param', base64_decode($e[$i]));	
							console::log(array('action_param' => base64_decode($e[$i])));	
							if($phposFS->clipboard_copy())
							{
								console::log('@action.copy_multiple: filesystem.clipboard_copy()', 'ok');
								
							} else {
								
								$error = 1;
								console::log('@action.copy_multiple: filesystem.clipboard_copy()', 'error');
							}
							
							console::log('-');
						}	
						
						if(!$error) apply_status('ok', txt('copied_to_clip'));								
						
					}				
					echo '<script>phpos.windowRefresh("'.WIN_ID.'", "action_id:0");</script>';
					
				break;
			
/*.............................................. */	

					case 'copy_server':					
					
					$connect_id = null;
					$ftp_id = param('ftp_id');
					if(!empty($ftp_id)) $connect_id = $ftp_id;	
					
					$clipboard = new phpos_clipboard();
					$clipboard->reset_clipboard();
					
					console::log(array(
					'@action_id' => 'copy_server', 
					'action_param' => param('action_param'), 
					'action_param2' => param('action_param2')
					));							
											
					if($phposFS->clipboard_copy_server())
					{
						console::log('@action.copy_server: filesystem.clipboard_copy_server()', 'ok');
						apply_status('ok', txt('copied_to_clip'));						
						
					} else {
					
						console::log('@action.copy_server: filesystem.clipboard_copy_server()', 'error');
					}
					
					console::log('-');
					echo '<script>phpos.windowRefresh("'.WIN_ID.'", "action_id:0");</script>';
					
				break;
					
/*.............................................. */		

				case 'cut':					
				
					$connect_id = null;
					$ftp_id = param('ftp_id');
					if(!empty($ftp_id)) $connect_id = $ftp_id;
					
					$clipboard = new phpos_clipboard();
					$clipboard->reset_clipboard();
					
					console::log(array(
					'@action_id' => 'cut', 
					'action_param' => param('action_param'), 
					'action_param2' => param('action_param2')
					));	
					
					if($phposFS->clipboard_cut())
					{
						console::log('@action.cut: filesystem.clipboard_cut()', 'ok');
						apply_status('ok', txt('cutted_to_clip'));
						
					} else {
					
						console::log('@action.cut: filesystem.clipboard_cut()', 'error');
					}
					
					console::log('-');					
						
					echo '<script>phpos.windowRefresh("'.WIN_ID.'", "action_id:0");</script>';
					
				break;		
					
/*.............................................. */		

				case 'cut_multiple':					
					
					$connect_id = null;
					$ftp_id = param('ftp_id');
					if(!empty($ftp_id)) $connect_id = $ftp_id;	
					
					$clipboard = new phpos_clipboard();
					$clipboard->reset_clipboard();
					
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
						
						$error = null;
						for($i=0;$i<$c;$i++)
						{							
							param('action_param', base64_decode($e[$i]));		
							console::log(array('action_param' => base64_decode($e[$i])));		
							
							if($phposFS->clipboard_cut())
							{
								console::log('@action.cut: filesystem.clipboard_cut()', 'ok');
								
							} else {
							
								$error = 1;
								console::log('@action.cut: filesystem.clipboard_cut()', 'error');
							}
							
							console::log('-');
						}	
						
						if(!$error) apply_status('ok', txt('cutted_to_clip'));
						//echo $clipboard->debug_clipboard();
					}					
									
					//msg::ok(txt('cutted_to_clip'));	
					echo '<script>phpos.windowRefresh("'.WIN_ID.'", "action_id:0");</script>';
				break;		

			
/*.............................................. */				

				case 'paste':
				
					
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
								apply_status('ok', txt('file_pasted'));								
								
							}	 else {	
							
								console::log('@action.paste: filesystem.clipboard_paste() [copy]', 'error');		
							}
						
							console::log(array('@windowRefresh' => WIN_ID));
							console::log('-');
							
							echo '<script>phpos.windowRefresh("'.WIN_ID.'", "action_id:0");</script>';
							
						} elseif($mode == 'cut') {
							
							$source_win = $clipboard->get_source_win();
							if($phposFS->clipboard_paste(param('action_param'), 'cut')) 	
							{
								console::log('@action.paste: filesystem.clipboard_paste() [cut]', 'ok');
								console::log(array('@windowRefresh' => $source_win.', '.WIN_ID));								
								echo '<script>phpos.windowRefresh("'.$source_win.'", ""); phpos.windowRefresh("'.WIN_ID.'", "action_id:0");</script>';
								
								apply_status('ok', txt('file_pasted'));	
								
								$clipboard = new phpos_clipboard();
								$clipboard->reset_clipboard();
								exit;
								
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
						
						$error = null;
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
								
									$error = 1;
									console::log('@action.paste_multiple: filesystem.clipboard_paste() [copy]', 'error');		
								}
								
								console::log('-');
								
							} elseif($mode == 'cut') {
								
								$source_win = $clipboard->get_source_win();
								if($phposFS->clipboard_paste(param('action_param'), 'cut'))
								{
									console::log('@action.paste_multiple: filesystem.clipboard_paste() [cut]', 'ok');			
									
								} else {		
								
								  $error = 1;
									console::log('@action.paste_multiple: filesystem.clipboard_paste() [cut]', 'error');			
								}	
								
								console::log('-');
							}					
						}
						
						if(!$error) apply_status('ok', txt('file_pasted'));	
						
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
							echo '<script>phpos.windowRefresh("'.WIN_ID.'", "action_id:0");</script>';
							
							
						} elseif($mode == 'cut') {					
							
								console::log(array('@windowRefresh' => $clipboard->get_source_win().', '.WIN_ID));
								console::log('-');
								echo '<script>phpos.windowRefresh("'.$clipboard->get_source_win().'", ""); phpos.windowRefresh("'.WIN_ID.'", "action_id:0");</script>';
												
						}					
					}
					
				break;			
			}	
				
/*.............................................. */	

		}

} elseif(!empty($action_id)) {
	
	echo '<script>phpos.windowRefresh("'.WIN_ID.'", "action_id:0");</script>';
	
}

	helper_stopwaiting();
		
/*.............................................. */	
	
			
	param('action_id', null);
	param('action_param', null);
	cache_param('action_id');
	cache_param('action_param');			
			
?>