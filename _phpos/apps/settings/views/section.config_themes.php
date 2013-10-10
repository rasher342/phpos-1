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


	
	$this_theme = $my_app->get_param('theme_id');
	$selected_theme = $my_app->get_param('selected_theme_id');
	
	echo helper_result('config_update');
	echo $layout->title(txt('cp_settings_section_themes'), 'icon.png'); 
	echo $layout->txtdesc(txt('cp_settings_section_themes_desc'));
	
	


	$themes = new phpos_themes;
	
	
	echo $layout->column('50%');		
	echo $layout->subtitle(txt('cp_themes_global_themes'), ICONS.'settings/wallpaper_icon.png');
	echo $layout->txtdesc(txt('cp_themes_global_themes_desc'));
	
	$list_themes = $themes->get_themes_list();			
		
	echo $layout->tbl_start();
	$layout->td_classes(array(''));
	echo $layout->head(array(txt('cp_themes_theme_name') => '100%'));	
	
	foreach($list_themes as $theme_name)
	{	
		$themes->load_theme_info($theme_name);
		$name = $themes->get_name();
		if($this_theme == $theme_name) $name = '<b>'.$themes->get_name().'</b>';
		if($theme_name == $selected_theme) $name = '<img src="'.ICONS.'status/status_ok.png" style="width:15px"/> '.$name;
		
		echo $layout->row(array('<a href="javascript:void(0);" onclick="'.helper_reload(array('section' => 'config_themes', 'theme_type' => 'global', 'theme_id' => $theme_name)).'">'.$name.'</a>'), txt('st_usr_wall_c'));			
	}
	
	
	echo $layout->tbl_end();		
		
	
	
	echo $layout->end('column');	
	
	
	echo $layout->column('50%');
	echo $layout->subtitle(txt('cp_themes_preview'), ICONS.'preview.png');
	echo $layout->txtdesc(txt('cp_themes_preview_desc'));
	
	$themes->load_theme_info($this_theme);
	$name = $themes->get_name();
	$version = $themes->get_version();
		
		
	echo '<img style="width:350px;border:4px solid black" src="'.$themes->theme_img_preview($this_theme).'" /><br />'.$name.'<br />Version: '.$version.'<br />';
	$action = helper_reload(array('section' => 'config_themes', 'set_theme' => 1, 'theme_id' => $this_theme));
	echo $layout->button(txt('cp_themes_set_global'), $action, 'ok');
	echo $layout->txtdesc(txt('cp_themes_set_global_desc'));
	echo $layout->end('column');
	
	
	echo $layout->clr();
	
	



?>