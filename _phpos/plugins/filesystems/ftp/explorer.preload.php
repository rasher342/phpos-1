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
		
		$title = '<img src="'.ICONS.'server/ftp.png" style="width:30px; display:inline-block; vertical-align:middle" /> 
		<a title="'.txt('ftp_folders').'" href="javascript:void(0);" onclick="'.link_action('ftp', 'ftp_id:0,tmp_shared_id:0,shared_id:0,cloud_id:0,in_shared:0,workgroup_id:0,fs:ftp').'">
		'.txt('ftp_folders').'
		</a>
		<img src="'.THEME_URL.'icons/arrow_small_right.png" style="width:15px; display:inline-block; vertical-align:middle; padding-left:10px;padding-right:10px"/> 
		'.$ftp_info->get_host();			
		
		
		
		
		
		//$title = '<span style="color:black">FTP:</span> '.$ftp_info->get_host();
		$html['icons'].=	 $layout->subtitle($title);
	}
?>