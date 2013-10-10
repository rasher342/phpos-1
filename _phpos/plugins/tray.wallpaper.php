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

$tray['id'] = 'wallpaper';
$tray['version'] = '1.0';
$tray['load_only_with_app'] = false;
$tray['app_id'] = null;
$tray['use_custom_icons'] = true;
$tray['use_lang'] = false;
$tray['title'] = txt('wallpaper_tray_title');

$tmp_context_menu = array();

$wallpaper = new phpos_wallpapers;
$wallpapers_url = $wallpaper->get_global_wallpapers_url();
	
$i=1;
$list_wallpapers = $wallpaper->get_global_wallpapers();

	foreach($list_wallpapers as $img)
	{	
		$tmp_context_menu[] = 'wallpaper'.$i.'::'.$img.'::phpos.wallpaperUpdate("'.$wallpapers_url.'", "'.$img.'", "global");::ico';
		$i++;	
	}

$tmp_context_menu[] = '---';

$wallpapers_url = $wallpaper->get_user_wallpapers_url();
$list_wallpapers = $wallpaper->get_user_wallpapers();

	foreach($list_wallpapers as $img)
	{	
		$tmp_context_menu[] = 'wallpaper'.$i.'::'.$img.'::phpos.wallpaperUpdate("'.$wallpapers_url.'", "'.$img.'", "user");::ico';
		$i++;	
	}							

$context_menu_style=array();

$tray['context_menu'] = $tmp_context_menu;

$tray['icons'] = array(ICONS.'tray/wallpaper.png');

?>