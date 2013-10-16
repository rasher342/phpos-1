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
	
		// FS headers
	
	
	if(APP_ACTION == 'index' && $context_fs == 'ftp' && $ftp_connected)
	{	
		$ftp_info = new phpos_ftp;
		$ftp_info->set_id($my_app->get_param('ftp_id'));
		$ftp_info->get_ftp();
		
		$title = '<span style="color:black">FTP:</span> '.$ftp_info->get_host();
		$html['icons'].=	 $layout->subtitle($title, ICONS.'server/ftp.png');
	}
?>