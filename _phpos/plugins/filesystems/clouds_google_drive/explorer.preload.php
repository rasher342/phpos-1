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
		$html['icons'].=	$layout->subtitle($cloud_header_msg, ICONS.'server/google_drive.png');	
		$html['icons'].= $login_area;
	}
	

	
?>