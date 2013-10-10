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
	$my_app->set_param('group_id', null);
	$my_app->set_param('remove_user_id', null);
	$my_app->set_param('add_user_id', null);
	$my_app->set_param('action', '');
	$my_app->set_param('toolbar_checked', 'new_user');
	$my_app->set_param('section', 'new_group');
	
	
	$my_app->using('params');
	$my_app->using('menu');
	$my_app->using('toolbar');
	
	//winConfig('use_params'); 
	winConfig('use_sections');		
	//winConfig('use_menu');		
	cache_param('group_id');
	
	
	
	$remove_user_id = $my_app->get_param('remove_user_id');
	$add_user_id = $my_app->get_param('add_user_id');
	$group_id = $my_app->get_param('group_id');
	
	if(!empty($group_id))
	{
		$group = new phpos_groups;
		
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
	
	$my_app->jquery_onready(msg::showMessages());

	
	$action = $my_app->get_param('action');
	
	switch($action)
	{
		case 'delete':
			$delete_id = $my_app->get_param('delete_id');
			if($group->delete_group($delete_id))
			{
				helper_result('delete_group', 'ok', txt('deleted'));
				$my_app->set_param('action', null);
				cache_param('action');
			}
			
		break;
	
	}
	
	
	
	

if(form_submit('new_group'))
{
	if($_POST['action'] == 'new_group')
	{
		$tmp_name = strip_tags($_POST['group_new_name']);
		$tmp_desc = strip_tags($_POST['group_new_desc']);
		$tmp_msg = strip_tags($_POST['group_new_msg']);
		
		$group = new phpos_groups;
		
		if($group->new_group($tmp_name, $tmp_desc, $tmp_msg))
		{
			helper_result('new_group', 'ok', txt('created'));		
			helper_result('new_group_result', 'result', 'success');
			helper_result('new_group_id', 'var', 1);		
		} else {
		
			helper_result('new_group_result', 'result', 'error');
			helper_result('new_group', 'error', txt('error'));	
		}
		
		$_POST['action'] = null;
	}
}

// update
if(form_submit('update_group'))
{
	if($_POST['action'] == 'update_group')
	{
		$tmp_name = strip_tags($_POST['group_new_name']);
		$tmp_desc = strip_tags($_POST['group_new_desc']);
		$tmp_msg = strip_tags($_POST['group_new_msg']);
		
		$group = new phpos_groups;
		$group->set_id($group_id);
		if($group->update_group($tmp_name, $tmp_desc, $tmp_msg))
		{
			helper_result('update_group', 'ok', txt('updated'));		
			helper_result('update_group_result', 'result', 'success');
			helper_result('update_group_id', 'var', 1);		
		} else {
		
			helper_result('update_group_result', 'result', 'error');
			helper_result('update_group', 'error', txt('error'));	
		}
		
		$_POST['action'] = null;
	}
}


?>