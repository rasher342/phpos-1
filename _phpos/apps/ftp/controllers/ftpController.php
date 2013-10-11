<?php
/*
**********************************

	PHPOS Web Operating system
	MIT License
	(c) 2013 Marcin Szczyglinski
	szczyglis83@gmail.com
	GitHUB: https://github.com/phpos/
	File version: 1.0.0, 2013.10.08
 
**********************************
*/
if(!defined('PHPOS'))	die();	


if(PHPOS_HAVE_ACCESS != $my_app->get_app_id() or !defined('PHPOS'))
{
	die();
}

	$my_app->set_param('delete_id', '');
	$my_app->set_param('ftp_id', null);
	$my_app->set_param('remove_user_id', null);
	$my_app->set_param('add_user_id', null);
	$my_app->set_param('action', null);
	$my_app->set_param('toolbar_checked', 'new_ftp');
	$my_app->set_param('section', 'new_account');	
	
	
	$my_app->using('params');
	//$my_app->using('menu');
	$my_app->using('toolbar');
	
	//winConfig('use_params'); 
	winConfig('use_sections');		
	//winConfig('use_menu');		
	cache_param('ftp_id');	
	
	$ftp_id = $my_app->get_param('ftp_id');
	
	if(!empty($ftp_id))
	{
		$ftp = new phpos_ftp;
		
		if(globalconfig('demo_mode') != 1 || is_root())
		{
			if(!empty($add_user_id))
			{
				$group->add_user($add_user_id, $group_id);
				$my_app->set_param('add_user_id', null);
				cache_param('add_user_id');
			}
			
			if(!empty($remove_user_id))
			{
				$group->remove_user($remove_user_id, $group_id);
				$my_app->set_param('remove_user_id', null);
				cache_param('remove_user_id');
			}
		
		}
	}
	
	$my_app->jquery_onready(msg::showMessages());	
	
	
	$action = $my_app->get_param('action');

if(globalconfig('demo_mode') != 1 || is_root())
{	
		switch($action)
		{
			case 'delete':
				$delete_id = $my_app->get_param('delete_id');
				if($ftp->delete_ftp($delete_id))
				{
					helper_result('delete_ftp', 'ok', txt('deleted'));			
					$my_app->set_param('action', null);
					cache_param('action');
					
					savelog('FTP_ACCOUNT_DELETE_id_'.$delete_id.'#SUCCESS');
				}
				
			break;
		
		}



	if(form_submit('new_ftp'))
	{
		if($_POST['action'] == 'new_ftp')
		{
			$tmp_title = strip_tags($_POST['ftp_new_title']);
			$tmp_desc = strip_tags($_POST['ftp_new_desc']);
			$tmp_host = strip_tags($_POST['ftp_new_host']);
			$tmp_login = strip_tags($_POST['ftp_new_login']);
			$tmp_pass = strip_tags($_POST['ftp_new_pass']);
			$tmp_port = strip_tags($_POST['ftp_new_port']);
			$tmp_public = strip_tags($_POST['ftp_new_public']);
			
			$ftp = new phpos_ftp;
			
			if($ftp->new_ftp($tmp_title, $tmp_desc, $tmp_host, $tmp_login, $tmp_pass, $tmp_port, $tmp_public, null))
			{
				helper_result('new_ftp', 'ok', txt('created'));		
				helper_result('new_ftp_result', 'result', 'success');
				helper_result('new_ftp_id', 'var', 1);	
				savelog('FTP_ACCOUNT_CREATE#SUCCESS');			
				
			} else {
			
				savelog('FTP_ACCOUNT_CREATE#FAILED');
				
				helper_result('new_ftp_result', 'result', 'error');
				helper_result('new_ftp', 'error', txt('error'));	
			}
			
			$_POST['action'] = null;
		}
	}

	// update
	if(form_submit('update_ftp'))
	{
		if($_POST['action'] == 'update_ftp')
		{		
			$ftp = new phpos_ftp;
			
			if($ftp->is_my_ftp($ftp_id) || is_root() || is_admin())
			{
				$tmp_title = strip_tags($_POST['ftp_new_title']);
				$tmp_desc = strip_tags($_POST['ftp_new_desc']);
				$tmp_host = strip_tags($_POST['ftp_new_host']);
				$tmp_login = strip_tags($_POST['ftp_new_login']);
				$tmp_pass = strip_tags($_POST['ftp_new_pass']);
				$tmp_port = strip_tags($_POST['ftp_new_port']);		
				$tmp_public = strip_tags($_POST['ftp_new_public']);
				
				$ftp->set_id($ftp_id);
				if($ftp->update_ftp($ftp_id, $tmp_title, $tmp_desc, $tmp_host, $tmp_login, $tmp_pass, $tmp_port, $tmp_public, null))
				{
					helper_result('update_ftp', 'ok', txt('updated'));		
					helper_result('update_ftp_result', 'result', 'success');
					helper_result('update_ftp_id', 'var', 1);		
					
					savelog('FTP_ACCOUNT_UPDATE_ID_'.$ftp_id.'#SUCCESS');
					
				} else {
				
					helper_result('update_ftp_result', 'result', 'error');
					helper_result('update_ftp', 'error', txt('error'));	
					
					savelog('FTP_ACCOUNT_UPDATE_ID_'.$ftp_id.'#FAILED');
				}
				
				$_POST['action'] = null;	
			}
		}
	}

}

?>