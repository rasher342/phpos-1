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


$app_toolbar = array();
$app_toolbar[] = array('id' => 'config_site', 'title' => txt('cp_settings_section_site'), 'link' => helper_reload(array('section' => 'config_site')), 'icon' => 'mycomp.png', 'tip' => txt('cp_settings_section_site'));

$app_toolbar[] = array('id' => 'config_themes', 'title' => txt('cp_settings_section_themes'), 'link' => helper_reload(array('section' => 'config_themes')), 'icon' => 'settings/themes_icon.png', 'tip' => txt('cp_settings_section_themes'));

$app_toolbar[] = array('id' => 'config_wallpapers', 'title' => txt('cp_settings_section_wallpapers'), 'link' => helper_reload(array('section' => 'config_wallpapers')), 'icon' => 'settings/wallpaper_icon.png', 'tip' => txt('cp_settings_section_wallpapers'));

$app_toolbar[] = array('id' => 'config_updater', 'title' => txt('cp_settings_section_updater'), 'link' => helper_reload(array('section' => 'config_updater')), 'icon' => 'apps/updater.png', 'tip' => txt('cp_settings_section_updater'));

$app_toolbar[] = array('id' => 'config_security', 'title' => txt('cp_settings_section_security'), 'link' => helper_reload(array('section' => 'config_security')), 'icon' => 'access_denied3.png', 'tip' => txt('cp_settings_section_security'));
?>