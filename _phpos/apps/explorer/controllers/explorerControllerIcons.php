<?php
/*
**********************************

	PHPOS Web Operating system
	MIT License
	(c) 2013 Marcin Szczyglinski
	szczyglis83@gmail.com
	GitHUB: https://github.com/phpos/
	File version: 1.2.5, 2013.10.15
 
**********************************
*/
if(!defined('PHPOS'))	die();	




		$context_location = 'db';
		if(defined('DESKTOP')) $context_location = 'desktop';
		$context_fs = $my_app->get_param('fs');
		$context_dir_id = $my_app->get_param('dir_id');
						
/*.............................................. */		
	
		
		// FTP connection status
		if($my_app->get_param('fs') == 'ftp')
		{
			$ftp_res = $phposFS->get_status().'<br />';
			
			if(strstr($ftp_res, 'Resource'))
			{
				$ftp_connect_status =	'<div class="server_conn_ok">'.txt('ftp_connected').'</div>';	
				$ftp_connected = true;
				
			} else {
			
				$ftp_connect_status =	'<div class="server_conn_error">'.txt('ftp_not_connected').'</div>';	
			}
		}
		
		
		// Cloud connection status		
		if($my_app->get_param('fs') == 'clouds_google_drive')
		{			
			if($phposFS->get_authUrl() != '')
			{
					$auth_url = '<a href="'.$phposFS->get_authUrl().'"><b>Click here</b></a> to login to Google Account';
					$up_auth_url = ' <a href="'.$phposFS->get_authUrl().'"><b>[ Token auth URL ]</b></a>';
			}
				
				if($phposFS->is_connected())
			{
				$cloud_connect_status =	'<div class="server_conn_ok">'.txt('cloud_google_connected').$phposFS->get_status().'</div>';	
				$cloud_connected = true;
				$cloud_header_msg = 'You are connected to Google Drive API'.$up_auth_url;
				
			} else {				
				
				$err = '';
				if($phposFS->get_status() != '') $err = '<br/>Error message: '.$phposFS->get_status();
				
				$cloud_connect_status =	'<div class="server_conn_error">'.$auth_url.$err.'</div>';	
				$cloud_header_msg = 'At first you must login to your Google Drive API here: '.$up_auth_url;
			}
		}
			
							
/*.............................................. */		
	
	// FS headers
	
	
	if(APP_ACTION == 'index' && $context_fs == 'ftp' && $ftp_connected)
	{	
		$ftp_info = new phpos_ftp;
		$ftp_info->set_id($my_app->get_param('ftp_id'));
		$ftp_info->get_ftp();
		
		$title = '<span style="color:black">FTP:</span> '.$ftp_info->get_host();
		$html['icons'].=	 $layout->subtitle($title, ICONS.'server/ftp.png');
	}
	
	if(APP_ACTION == 'index' && $context_fs == 'clouds_google_drive')
	{	
		$html['icons'].=	$layout->subtitle($cloud_header_msg, ICONS.'server/google_drive.png');
		//$html['icons'].=	$layout->txtdesc('ggggggodle');
	}
	
					
/*.............................................. */		
	
	
			
	$icons = $phposFS->get_files_list();		

	$hidden_icons = array(
	'_Desktop',
	'_Documents',
	'_Log',
	'_Icons',
	'_Pictures',
	'_Shared',
	'_Temp',
	'_Userdata',
	'_Video',	
	'_Wallpapers',	
	'index.php',
	'index.htm',
	'index.html',
	'index.php5'
	);
	
		 
/*
**************************
*/
	

			$c = count($icons);
			
			$plugin = new phpos_plugins;
			$plugin->load_plugins();
			
				
/*.............................................. */		
			
		
			for($i=0; $i<$c; $i++)
			{
				$j = $i + 1;		
				
				$render_icon = true;
				if(in_array($icons[$i]['basename'], $hidden_icons)) $render_icon = false;				
				if(is_array($allowed_extensions) && !$phposFS->is_directory($icons[$i]) && $my_app->get_param('view_files_types') != 'all')
				{
					if(!in_array($icons[$i]['extension'], $allowed_extensions)) $render_icon = false;				
				}
				
/*.............................................. */		
					
				if($render_icon)
				{
					$is_icons = true;					
					if(is_root()) $icons[$i] = $explorer->root_homedir_parse($icons[$i]);		
				
					$iconDIV = $explorer->config('div_prefix').$j; // Generate unique ID for icon div			
					$icons[$i]['div'] = $explorer->config('div_prefix').$j;
					
				
/*.............................................. */		
						
					if(APP_ACTION == 'index' || APP_ACTION == 'desktop')
					{
						//$phposFS->api_getFile($icons[$i]);
						
						include MY_APP_DIR.'contextMenus.php';	
						if($phposFS->is_directory($icons[$i]))
						{
							$my_context_menu = $contextMenus['DIR'];
						} else {
							$my_context_menu = $contextMenus['FILE'];
						}
					}			
							
					$plugged_context_menu = $my_context_menu;				
					
					if($my_app->get_param('fs') == 'local_files' || $my_app->get_param('fs') == 'db_mysql' || $my_app->get_param('fs') == 'clouds_google_drive') 
					{
						$open_action = $phposFS->get_action_dblclick($icons[$i]);		
						$plugged_context_menu[0] = 'open::'.txt('open').'::'.str_replace('"', '\'', $open_action).'::folder_open';
						$my_plugin = $plugin->get_my_plugin($icons[$i]);
					}
					
				
/*.............................................. */		
						
					
					if(!empty($my_plugin) && !$phposFS->is_directory($icons[$i]))
					{
						$plugin->load_plugin_data($my_plugin, $icons[$i]);
						$plugindata = $plugin->get_plugin($my_plugin);
						
						// Plugin contextmenu
						if(is_array($plugindata['context_menu']) && is_array($my_context_menu)) $plugged_context_menu = array_merge($my_context_menu, $plugindata['context_menu']);
						
						// Plugin onopen
						if(!empty($plugindata['open'])) 
						{
							$plugged_context_menu[0] = 'open_plugged::'.txt('open').'::'.$plugindata['open'].'::open';
							$icons[$i]['action'] = str_replace('"', '\'', $plugindata['open']);
						}
						
						// Plugin on_open
						$context_on_open = $plugged_context_menu[3];
						$plugged_on_open = $context_on_open;
						
						if(is_array($plugindata['open_with']) && is_array($context_on_open))
						{
							$plugged_on_open = array_merge($context_on_open, $plugindata['open_with']);
							$plugged_context_menu[3] = $plugged_on_open;				
						}
						
					}
				
/*.............................................. */		
						
					// clipboard
					$clipboard= new phpos_clipboard;
					
					// ftp copy/paste in next updates
					if($my_app->get_param('fs') != 'ftp')
					{
						$plugged_context_menu[] = '---';
						$plugged_context_menu[] = 'copy::'.txt('copy').'::explorer_copy("'.WIN_ID.'", "'.$icons[$i]['id'].'", "'.$icons[$i]['basename'].'", "'.$my_app->get_param('fs').'");::copy';
						$plugged_context_menu[] = 'cut::'.txt('cut').'::explorer_cut("'.WIN_ID.'", "'.$icons[$i]['id'].'", "'.$icons[$i]['basename'].'", "'.$my_app->get_param('fs').'");::cut';
					
					
						if($clipboard->is_clipboard($my_app->get_param('fs')) && $phposFS->is_directory($icons[$i]))				
						{
							if($clipboard->is_my_clipboard($my_app->get_param('fs'))) 
							{							
								$mode = $clipboard->get_mode();
								if($mode == 'copy')
								{
									$plugged_context_menu[] = 'paste::'.txt('paste').'::explorer_paste("'.WIN_ID.'", "'.$icons[$i]['id'].'", null);::paste';
									
								} elseif($mode == 'cut') {
									
									$plugged_context_menu[] = 'paste::'.txt('paste').'::explorer_paste_cut("'.WIN_ID.'", "'.$clipboard->get_source_win().'", "'.$icons[$i]['id'].'", null);::paste';
								}
													
							}
						}	

					}
				
/*.............................................. */		
						
					
					// add to startmenu
					if($context_fs == 'db_mysql' && !$phposFS->is_directory($icons[$i]))
					{
						$plugged_context_menu[] = '---';
						$plugged_context_menu[] = $explorer->generate_to_start_context($my_app->get_param('fs'), $icons[$i]['plugin_id'], $icons[$i]['app_id'], $icons[$i]['id']);
						
						$plugged_context_menu[] = $explorer->generate_to_edit_context($my_app->get_param('fs'), $icons[$i]['plugin_id'], $icons[$i]['app_id'], $icons[$i]['id']);		
					}
				
/*.............................................. */		
						
					// delete
					if($icons[$i]['no_delete'] != 1 && (!$readonly || is_root())) 
					{
						$plugged_context_menu[] = '---';
						$plugged_context_menu[] = 'del::'.txt('delete').'::explorer_delete_file("'.WIN_ID.'", "'.$icons[$i]['id'].'", "'.$icons[$i]['basename'].'");::delete';
					}
				
/*.............................................. */		
						
					$icons[$i]['is_shared'] = false;
					// share
					if($context_fs == 'local_files' && $phposFS->is_directory($icons[$i]))
					{						
						$shared = new phpos_shared;					
						
						if(!defined('SHARED'))
						{
							$plugged_context_menu[] = '---';							
							if(!$shared->is_folder_shared($icons[$i]['id']))
							{				
								$plugged_context_menu[] = 'share::'.txt('share_folder').'::'.winmodal(txt('share_folder'), 'app', 'app_id:shortcuts@share,width:300,height:350','desktop:1,location:'.$context_location.',dir_id:'.$context_dir_id.',shared_id:'.base64_encode($icons[$i]['id']).',after_reload:'.WIN_ID).'::ftpfolder';
								
							} else {
							
								$icons[$i]['is_shared'] = true;
								$plugged_context_menu[] = 'share::'.txt('stop_share_folder').'::'.winmodal(txt('share_folder'), 'app', 'app_id:shortcuts@share,width:300,height:350','stop_share:1,desktop:1,location:'.$context_location.',dir_id:'.$context_dir_id.',shared_id:'.base64_encode($icons[$i]['id']).',after_reload:'.WIN_ID).'::ftpfolder';					
							}
						}						
					}
					
				
/*.............................................. */		
						
					// file properties
					if((APP_ACTION == 'index' || APP_ACTION == 'desktop') && $context_fs == 'ftp' || $context_fs == 'local_files')
					{
						$plugged_context_menu[] = '---';
						$plugged_context_menu[] = 'properties::'.txt('fileinfo_context').'::'.winmodal(txt('file_info'), 'app', 'app_id:shortcuts@file_info','location:'.$context_location.',fs:'.$context_fs.',edit_id:'.base64_encode($icons[$i]['id']).',dir_name:'.base64_encode(dirname($icons[$i]['id'])).',file_name:'.base64_encode($icons[$i]['basename']).',file_modified:'.base64_encode($icons[$i]['modified_at']).',file_type:'.base64_encode($icons[$i]['extension']).',file_chmod:'.base64_encode($icons[$i]['chmod']).',file_created:'.base64_encode($icons[$i]['created_at']).',after_reload:'.WIN_ID).'::edit';		
					}
				
/*.............................................. */		
						
					// action from context
					if(!empty($plugged_context_menu[0]) && ( $context_fs == 'ftp' || $context_fs == 'local_files' ))
					{
						$e = explode('::', $plugged_context_menu[0]);
						if($e[0] == 'open' && !empty($e[1]) && !$phposFS->is_directory($icons[$i])) $icons[$i]['action'] = str_replace('"', '\'', $e[2]);
					}				
					
				
/*.............................................. */		
						
					// Rewrite render code from plugin
					if(!empty($my_plugin) && !empty($plugindata['render_rewrite']))
					{
						$html['icons'].= $explorer->get_explorer_icon_html($icons[$i], $plugindata['render_rewrite']); 
						
					} else {
					
						$html['icons'].= $explorer->get_explorer_icon_html($icons[$i]);
					}				
				
					
/*.............................................. */		
					
					
					//$free_area_menu = $contextMenus['WINDOW'];
					
					//$contextMenu = get_explorer_contextmenu($icons[$i]);			
					$apiWindow->setContextMenu($plugged_context_menu);	// apply to window			
							
		
					$js.=$apiWindow->contextMenuRender('m'.$iconDIV, 'img');				
					$apiWindow->resetContextMenu();	
			}		
			}	
			
			//jquery_function($js);	

				
/*.............................................. */		
	
		// Context menu for RMB click on folder area
				
				if(APP_ACTION == 'index' || APP_ACTION == 'desktop')
				{
					include MY_APP_DIR.'contextMenus.php';	


			// clipboard
					$clipboard= new phpos_clipboard;
				
					if($my_app->get_param('fs') != 'ftp')
					{					
						if($clipboard->is_clipboard($my_app->get_param('fs')))
						{
							if($clipboard->is_my_clipboard($my_app->get_param('fs')))
							{
								if(!$readonly || is_root())
								{
									$contextMenus['WINDOW'][] = '---';
									if(APP_ACTION != 'desktop')
									{
										$contextMenus['WINDOW'][] = 'paste::'.txt('paste').'::explorer_paste("'.WIN_ID.'", "'.$my_app->get_param('dir_id').'", null);::paste';
										
									} else {
									
										$contextMenus['WINDOW'][] = 'paste::'.txt('paste').'::explorer_paste("'.WIN_ID.'", "'.$my_app->get_param('dir_id').'", "desktop");::paste';
									}
								}
							}
						}					
					}

					//echo $my_app->get_param('dir_id');

				
/*.............................................. */		

						
					$free_area_menu = $contextMenus['WINDOW'];
					//$free_area_menu = $clipboard->assignClipboardPaste($free_area_menu, null);	
					
					$apiWindow->setContextMenu($free_area_menu);
					$js.= $apiWindow->contextMenuRender('phpos_explorer_div'.div(1), 'td');	
					$apiWindow->resetContextMenu();	
				}
						
				
				jquery_function($js);
				
		
						
/*.............................................. */		
	
		if(!$is_icons) $html['icons'].= txt('folder_is_empty');

?>