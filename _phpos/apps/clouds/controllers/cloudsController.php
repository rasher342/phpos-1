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
	$my_app->set_param('cloud_id', null);
	$my_app->set_param('remove_user_id', null);
	$my_app->set_param('add_user_id', null);
	$my_app->set_param('action', null);
	$my_app->set_param('cloud_type', null);
	$my_app->set_param('toolbar_checked', 'new_ftp');
	$my_app->set_param('section', 'new_account');	
	
	
	$my_app->using('params');
	//$my_app->using('menu');
	$my_app->using('toolbar');
	
	//winConfig('use_params'); 
	winConfig('use_sections');		
	//winConfig('use_menu');		
	cache_param('cloud_id');	
	cache_param('cloud_type');
	
	$cloud_id = $my_app->get_param('cloud_id');
	
	if(!empty($cloud_id))
	{
		$cloud = new phpos_clouds;		
		
	}
	
	$my_app->jquery_onready(msg::showMessages());	
	
	
	$action = $my_app->get_param('action');
	
if(globalconfig('demo_mode') != 1 || is_root())
{	
	
	switch($action)
	{
		case 'delete':
			$delete_id = $my_app->get_param('delete_id');
			if($cloud->delete_cloud($delete_id))
			{
				helper_result('delete_cloud', 'ok', txt('deleted'));
				$my_app->set_param('action', null);
				cache_param('action');
				$my_app->set_param('cloud_id', null);
				cache_param('cloud_id');	
				
			}
			
		break;
	
	}



if(form_submit('new_cloud'))
{
	if($_POST['action'] == 'new_cloud')
	{
		$tmp_title = strip_tags($_POST['cloud_new_title']);
		$tmp_desc = strip_tags($_POST['cloud_new_desc']);
		
		$tmp_login = strip_tags($_POST['cloud_new_login']);
		$tmp_pass = strip_tags($_POST['cloud_new_pass']);
		$tmp_url = strip_tags($_POST['cloud_new_url']);
		$tmp_cloud = strip_tags($_POST['cloud_new_type']);
		$tmp_public = strip_tags($_POST['cloud_new_public']);
		
		$tmp_param1 = strip_tags($_POST['cloud_new_param1']);
		$tmp_param2 = strip_tags($_POST['cloud_new_param2']);
		$tmp_param3 = strip_tags($_POST['cloud_new_param3']);
		$tmp_param4 = strip_tags($_POST['cloud_new_param4']);
		
		$cloud = new phpos_clouds;
		
		if($cloud->new_cloud($tmp_title, $tmp_desc, $tmp_cloud, $tmp_login, $tmp_pass,	$tmp_public, $tmp_url, $tmp_param1, $tmp_param2, $tmp_param3, $tmp_param4))
		{
			helper_result('new_cloud', 'ok', txt('created'));		
			helper_result('new_cloud_result', 'result', 'success');
			helper_result('new_cloud_id', 'var', 1);		
		} else {
		
			helper_result('new_cloud_result', 'result', 'error');
			helper_result('new_cloud', 'error', txt('error'));	
		}
		
		$_POST['action'] = null;
	}
}

// update
if(form_submit('update_cloud'))
{
	if($_POST['action'] == 'update_cloud')
	{		
		$cloud = new phpos_clouds;
		
		if($cloud->is_my_cloud($cloud_id) || is_root() || is_admin())
		{
			$tmp_title = strip_tags($_POST['cloud_new_title']);
		$tmp_desc = strip_tags($_POST['cloud_new_desc']);
		
		$tmp_login = strip_tags($_POST['cloud_new_login']);
		$tmp_pass = strip_tags($_POST['cloud_new_pass']);
		$tmp_url = strip_tags($_POST['cloud_new_url']);
		//$tmp_cloud = strip_tags($_POST['cloud_new_type']);
		$tmp_public = strip_tags($_POST['cloud_new_public']);
		
		$tmp_param1 = strip_tags($_POST['cloud_new_param1']);
		$tmp_param2 = strip_tags($_POST['cloud_new_param2']);
		$tmp_param3 = strip_tags($_POST['cloud_new_param3']);
		$tmp_param4 = strip_tags($_POST['cloud_new_param4']);		
			
			$cloud->set_id($cloud_id);
			if($cloud->update_cloud($cloud_id, $tmp_title, $tmp_desc, $tmp_login, $tmp_pass, $tmp_public, $tmp_url, $tmp_param1, $tmp_param2, $tmp_param3, $tmp_param4))
			{
				helper_result('update_cloud', 'ok', txt('updated'));		
				helper_result('update_cloud_result', 'result', 'success');
				helper_result('update_cloud_id', 'var', 1);		
				
			} else {
			
				helper_result('update_cloud_result', 'result', 'error');
				helper_result('update_cloud', 'error', txt('error'));	
			}
			
			$_POST['action'] = null;	
		}
	}
}

}
?>