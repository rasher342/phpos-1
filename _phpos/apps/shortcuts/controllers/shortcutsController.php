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
 
/*
**************************
*/
 
	$my_app->set_param('delete_id', '');
	$my_app->set_param('toolbar_checked', 'new_user');
	$my_app->set_param('section', 'account');
	$my_app->set_param('desktop', null);
	$my_app->set_param('link_type', null);
	$my_app->set_param('back', 1);
	$my_app->set_param('link_param', null);
	$my_app->set_param('to_menustart', null);
	$my_app->set_param('link_id', null);
	$my_app->set_param('edit', null);
	$my_app->set_param('edit_id', null);
	$my_app->set_param('shared_id', null);
	$my_app->set_param('stop_share', null);
	$my_app->set_param('dir_id', null);
	$my_app->set_param('old_name', null);
	$my_app->set_param('file_name', null);
	$my_app->set_param('file_chmod', null);
	$my_app->set_param('file_created', null);
	$my_app->set_param('file_modified', null);
	$my_app->set_param('file_type', null);
	$my_app->set_param('dir_name', null);
	$my_app->set_param('location', null);
	$my_app->set_param('after_reload', null);
	$my_app->set_param('app_id', null);
	$my_app->set_param('fs', null);
	 
/*
**************************
*/
 
	$my_app->using('params');
	$my_app->using('menu');
	 
/*
**************************
*/
 
	cache_param('desktop');
	cache_param('dir_id');
	cache_param('back');
	cache_param('edit');
	cache_param('edit_id');
	cache_param('shared_id');
	cache_param('to_menustart');
	cache_param('location');
	cache_param('after_reload');
	cache_param('stop_share');
	cache_param('link_type');
	cache_param('link_id');
	cache_param('old_name');
	//cache_param('link_param');	
	
	$back = $my_app->get_param('back');
	
	 
/*
**************************
*/
 
	$my_app->jquery_onready(msg::showMessages());
	
	$stop_share = $my_app->get_param('stop_share');
	$shared_id = $my_app->get_param('shared_id');
	
	 
/*
**************************
*/
 
 include MY_APP_DIR.'controllers/action_app_link.php';	
 include MY_APP_DIR.'controllers/action_webframe.php';	
 include MY_APP_DIR.'controllers/action_mediaframe.php';	
 include MY_APP_DIR.'controllers/action_url.php';	
 include MY_APP_DIR.'controllers/action_menustart.php';	
 include MY_APP_DIR.'controllers/action_share.php';	
 include MY_APP_DIR.'controllers/action_stopshare.php';	

	
	
	switch(APP_ACTION)
	{
		case 'index':		
			
			
			$wincfg['title'] = txt('shortcuts_window_title_index');
			$wincfg['width'] = '250';
			$wincfg['height'] = '350';				
			
			$html.= $layout->rowbutton(txt('shortcut_phpos'), ICONS.'btnrow_app.png', link_action('app'), txt('st_shortcut_newapp'));		
			$html.= $layout->rowbutton(txt('shortcut_webframe'), ICONS.'btnrow_app2.png', link_action('iframe'), txt('st_shortcut_iframe'));	
			$html.= $layout->rowbutton(txt('shortcut_url'), ICONS.'btnrow_browser.png', link_action('link'), txt('st_shortcut_link'));	
			$html.= $layout->rowbutton(txt('shortcut_mediaurl'), ICONS.'btnrow_media.png', link_action('medialink'), txt('st_shortcut_medialink'));	
			$html.= $layout->rowbutton(txt('shortcut_folder'), ICONS.'btnrow_folder2.png', link_action('folder', 'back:1'), txt('st_shortcut_newdir'));	
			//$html.= $layout->rowbutton(txt('shortcut_upload'), ICONS.'btnrow_upload.png', link_action('upload'), txt('st_shortcut_upload'));
		
		break;	

 	
		case 'menustart':
			include MY_APP_DIR.'controllers/shortcuts_menustart.php';			
		break; 

 
		case 'app':			
			include MY_APP_DIR.'controllers/shortcuts_app.php';			
		break;
		

		case 'iframe':			
			include MY_APP_DIR.'controllers/shortcuts_iframe.php';		
		break;
	
 
		case 'medialink':			
			include MY_APP_DIR.'controllers/shortcuts_medialink.php';		
		break;
		
	
		case 'link':		
			include MY_APP_DIR.'controllers/shortcuts_link.php';		
	  break;
	
			
		case 'folder':	
			include MY_APP_DIR.'controllers/shortcuts_folder.php';	
		break;			
			
			
		case 'file_info':		
			include MY_APP_DIR.'controllers/shortcuts_file_info.php';		
		break;		
		
		
		case 'upload':			
			include MY_APP_DIR.'controllers/shortcuts_upload.php';			
		break;		
		
	
		case 'share':				
			include MY_APP_DIR.'controllers/shortcuts_shared.php';		
		break;
	
	}
	
	 
/*
**************************
*/
	
		if(!empty($wincfg['title'])) winset('title', $wincfg['title']);
		if(!empty($wincfg['width'])) winset('width', $wincfg['width']);		
		
		if(!empty($wincfg['back']) == 1)
		{			
			$back_button = $layout->back_button($wincfg['back'], link_action($wincfg['back_action']), $wincfg['back'], null);
			if(!empty($wincfg['height'])) $wincfg['height'] = $wincfg['height'] + 100;					
		} 
		
		if(!empty($wincfg['height'])) winset('height', $wincfg['height']);		
		wincenter();
		
	
		
	
	$my_app->jquery_onready(msg::showMessages());


?>