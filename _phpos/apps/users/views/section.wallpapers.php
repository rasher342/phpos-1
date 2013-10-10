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

	
	$usr = new phpos_users;
	$usr->set_id_user($usr->get_logged_user());
	
	if($usr->user_id_exists())
	{
		$usr->get_user_by_id();	
	}
	
	$selected_wallpaper = $my_app->get_param('selected_wallpaper_id');
	$selected_wallpaper_type = $my_app->get_param('selected_wallpaper_type');
	
	$this_wallpaper = $my_app->get_param('wallpaper_id');

	$this_wallpaper_type = $my_app->get_param('wallpaper_type');
	
	echo helper_result('my_update_user');
	echo $layout->txtdesc(txt('dsc_users_account_wallpapers'));
	
	
	$wallpaper = new phpos_wallpapers;
	
	if($this_wallpaper_type == 'user')
	{
		$wallpapers_url = $wallpaper->get_user_wallpapers_url();	
	} else {
		$wallpapers_url = $wallpaper->get_global_wallpapers_url();	
	}
	
	
	
	echo $layout->column('33%');		
	echo $layout->subtitle(txt('g_wallpapers'),ICONS.'settings/wallpaper_icon.png');
	echo $layout->txtdesc(txt('st_usr_wall_g'));
	
	$list_wallpapers = $wallpaper->get_global_wallpapers();			
		
	echo $layout->tbl_start();
	$layout->td_classes(array(''));
	echo $layout->head(array(txt('wallpaper_image') => '100%'));	
	
	foreach($list_wallpapers as $img_name)
	{	
		$name = $img_name;
		if($this_wallpaper == $img_name && $this_wallpaper_type == 'global') $name = '<b>'.$img_name.'</b>';
		
		if($img_name == $selected_wallpaper && $selected_wallpaper_type == 'global') $name = '<img src="'.ICONS.'status/status_ok.png" style="width:15px"/> '.$name;
			
			
		echo $layout->row(array('<a href="javascript:void(0);" onclick="'.helper_reload(array('section' => 'wallpapers', 'wallpaper_type' => 'global', 'wallpaper_id' => $img_name)).'">'.$name.'</a>'), txt('st_usr_wall_c'));			
	}
	
	
	echo $layout->tbl_end();		
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
		
		
	
	
	echo $layout->end('column');	

	
	echo $layout->column('33%');
	echo $layout->subtitle(txt('u_wallpapers'),ICONS.'settings/wallpaper_icon.png');
	echo $layout->txtdesc(txt('st_usr_wall_u'));
	$list_wallpapers = $wallpaper->get_user_wallpapers();
	
	echo $layout->tbl_start();
	$layout->td_classes(array(''));
	echo $layout->head(array(txt('wallpaper_image') => '100%'));	
	
	foreach($list_wallpapers as $img_name)
	{	
		$name = $img_name;
		if($this_wallpaper == $img_name && $this_wallpaper_type == 'user') $name = '<b>'.$img_name.'</b>';
		
		if($img_name == $selected_wallpaper && $selected_wallpaper_type == 'user') $name = '<img src="'.ICONS.'status/status_ok.png" style="width:15px"/> '.$name;
		
		
		echo $layout->row(array('<a href="javascript:void(0);" onclick="'.helper_reload(array('section' => 'wallpapers', 'wallpaper_type' => 'user', 'wallpaper_id' => $img_name)).'">'.$name.'</a>'), txt('st_usr_wall_c'));			
	}
		echo $layout->tbl_end();		
	
	
	echo $layout->end('column');
	
	echo $layout->column('33%');
	echo $layout->subtitle(txt('preview'), ICONS.'preview.png');
	echo $layout->txtdesc(txt('st_usr_wall_p'));
	echo '<img style="width:350px;border:4px solid black" src="'.$wallpapers_url.$this_wallpaper.'" /><br />'.$this_wallpaper.'<br />';
	$action = "phpos.wallpaperUpdate('".$wallpapers_url."', '".$this_wallpaper."', '".$this_wallpaper_type."'); phpos.windowRefresh('".WIN_ID."','');";
	echo $layout->button(txt('set_wallpaper'), $action, 'ok');
	echo $layout->txtdesc(txt('st_usr_wall_s'));
	echo $layout->end('column');
	
	
	echo $layout->clr();
	
	



?>