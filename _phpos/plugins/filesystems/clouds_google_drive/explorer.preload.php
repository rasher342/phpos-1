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
	

	
	if(APP_ACTION == 'index' && $context_fs == 'clouds_google_drive')
	{	
		$html['icons'].=	$layout->subtitle($cloud_header_msg, ICONS.'server/google_drive.png');	
	}
?>