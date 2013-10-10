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
	$my_app->set_param('section', 'config_site');	
	$my_app->set_param('wallpaper_id', null);
	$my_app->set_param('selected_wallpaper_id', null);
	$my_app->set_param('selected_theme_id', null);
	$my_app->set_param('theme_id', null);
	$my_app->set_param('set_wallpaper', null);
	$my_app->set_param('set_theme', null);
	$my_app->set_param('wallpaper_type', null);
	
	
	$my_app->using('params');
	//$my_app->using('menu');
	$my_app->using('toolbar');
	
	//winConfig('use_params'); 
	winConfig('use_sections');		
	//winConfig('use_menu');		
	
	// Wallpaper set
	$set_wallpaper = $my_app->get_param('set_wallpaper');
	if(!empty($set_wallpaper))
	{
		globalconfig('wallpaper', $my_app->get_param('wallpaper_id'));
		$my_app->set_param('set_wallpaper', null);
		cache_param('set_wallpaper');
		
		savelog('CP#CFG_GLOBALWALLPEPER: UPDATED');
		
		helper_result('config_update', 'ok', txt('updated'));		
		helper_result('config_update_result', 'result', 'success');
	}
	
	$wallpaper_id = $my_app->get_param('wallpaper_id');
	if(empty($wallpaper_id)) $my_app->set_param('wallpaper_id', globalconfig('wallpaper'));	
	cache_param('wallpaper_id');
	
	$my_app->set_param('selected_wallpaper_id', globalconfig('wallpaper'));
	cache_param('selected_wallpaper_id');
	
	
	// Theme set
	$set_theme = $my_app->get_param('set_theme');
	if(!empty($set_theme))
	{
		globalconfig('theme', $my_app->get_param('theme_id'));
		$my_app->set_param('set_theme', null);
		cache_param('set_theme');
		
		savelog('CP#CFG_GLOBALTHEME: UPDATED');
		
		helper_result('config_update', 'ok', txt('updated'));		
		helper_result('config_update_result', 'result', 'success');
	}
	
	$theme_id = $my_app->get_param('theme_id');
	if(empty($theme_id)) $my_app->set_param('theme_id', globalconfig('theme'));	
	cache_param('theme_id');
	
	$my_app->set_param('selected_theme_id', globalconfig('theme'));
	cache_param('selected_theme_id');

	
	$my_app->jquery_onready(msg::showMessages());		
	
	$action = $my_app->get_param('action');
	
	switch($action)
	{
		case 'delete':
			$delete_id = $my_app->get_param('delete_id');
			if($ftp->delete_ftp($delete_id))
			{
				helper_result('delete_ftp', 'ok', txt('deleted'));
				$my_app->set_param('action', null);
				cache_param('action');
			}
			
		break;
	
	}



if(form_submit('config_site'))
{
	if($_POST['action'] == 'config_site')
	{
		globalconfig('site_title', strip_tags($_POST['site_title']));
		globalconfig('site_desc', strip_tags($_POST['site_desc']));
		globalconfig('lang', strip_tags($_POST['site_lang']));
		globalconfig('root_email', strip_tags($_POST['root_email']));
		
		savelog('CP#CFG_SITE: UPDATED');
		
			helper_result('config_update', 'ok', txt('updated'));		
			helper_result('config_update_result', 'result', 'success');		
		
		$_POST['action'] = null;
	}
}

if(form_submit('config_security'))
{
	if($_POST['action'] == 'config_security')
	{
		globalconfig('disable_access_users', strip_tags($_POST['disable_access_users']));
		globalconfig('disable_access_admins', strip_tags($_POST['disable_access_admins']));
		globalconfig('disable_upload', strip_tags($_POST['disable_upload']));
		globalconfig('upload_whitelist', strip_tags($_POST['upload_whitelist']));
		globalconfig('upload_blacklist', strip_tags($_POST['upload_blacklist']));
		globalconfig('readonly', strip_tags($_POST['readonly']));
		globalconfig('demo_mode', strip_tags($_POST['demo_mode']));
		
		savelog('CP#CFG_SECURITY: UPDATED');
		
			helper_result('config_update', 'ok', txt('updated'));		
			helper_result('config_update_result', 'result', 'success');		
		
		$_POST['action'] = null;
	}
}



if(form_submit('config_updater'))
{
	if($_POST['action'] == 'config_updater')
	{
		
		globalconfig('app_updater_autoupdate', strip_tags($_POST['app_updater_autoupdate']));
		globalconfig('app_updater_autoupdate_timeout', strip_tags($_POST['app_updater_autoupdate_timeout']));
		
		savelog('CP#CFG_AUTOUPDATES: UPDATED');
		
			helper_result('config_update', 'ok', txt('updated'));		
			helper_result('config_update_result', 'result', 'success');		
		
		$_POST['action'] = null;
	}
}

?>