<?php
/*
**********************************

	PHPOS Web Operating system
	MIT License
	(c) 2013 Marcin Szczyglinski
	szczyglis83@gmail.com
	GitHUB: https://github.com/phpos/
	File version: 1.2.8, 2013.10.26
 
**********************************
*/
if(!defined('PHPOS'))	die();	

if(!defined("PHPOS_IN_EXPLORER"))
{
	die();
}

	$login_area = '';

// Cloud connection status		
		if($my_app->get_param('fs') == 'clouds_google_drive')
		{			
			$address_icon ='aaa';
			
			if($phposFS->get_authUrl() != '')
			{
					//$auth_url = '<a href="'.$phposFS->get_authUrl().'"><b>'.txt('googledrive_right_clickhere').'</b></a> '.txt('googledrive_right_clickhere_desc');
					$up_auth_url = ' <a class="easyui-linkbutton" href="'.$phposFS->get_authUrl().'"><b>'.txt('googledrive_auth_url').'</b></a>';
			}
				
			if($phposFS->is_connected())
			{
				$cloud_connect_status =	'<div class="server_conn_ok">'.txt('cloud_google_connected').$phposFS->get_status().'</div>';	
				$cloud_connected = true;
				$cloud_header_msg = txt('googledrive_header_connected');
				
			} else {				
				
				$err = '';
				if($phposFS->get_status() != '') $err = '<br/>'.$phposFS->get_status();
				
				//$cloud_connect_status =	'<div class="server_conn_error">'.$auth_url.$err.'</div>';	
				$cloud_header_msg = txt('googledrive_header_must_login');
				$login_area = '<div style="width:90%; text-align:center;padding:30px; padding-top:50px">'.txt('googledrive_need_login_help').'<br/><br/>'.$up_auth_url.'</div>';
			}
		}
			
							
/*.............................................. */		
	

	
	if(APP_ACTION == 'index' && $context_fs == 'clouds_google_drive')
	{	
		$title = '
		<img src="'.ICONS.'server/cloud.png" style="width:30px; display:inline-block; vertical-align:middle" /> 
		<a title="'.$txt['cloud_folders'].'" href="javascript:void(0);" onclick="'.link_action('clouds', 'ftp_id:0,tmp_shared_id:0,shared_id:0,cloud_id:0,in_shared:0,workgroup_id:0,fs:local_files').'">
		'.txt('cloud_folders').'
		</a>
		<img src="'.THEME_URL.'icons/arrow_small_right.png" style="width:15px; display:inline-block; vertical-align:middle; padding-left:10px;padding-right:10px"/> 
		<img src="'.PHPOS_URL.'plugins/filesystems/clouds_google_drive/resources/fs.icon_big.png" style="width:30px; display:inline-block; vertical-align:middle" /> 	
		Google Drive'; 
		
		
		$html['icons'].= $layout->subtitle($title);	
		$html['icons'].= $login_area;
	}
	

	
?>