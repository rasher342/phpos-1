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

$app_toolbar[] = array('id' => 'account', 'title' => 'Your account', 'link' => helper_reload(array('section' => 'account')), 'icon' => 'accounts/toolbar_edit.png', 'tip' => 'Your account');

$app_toolbar[] = array('id' => 'wallpapers', 'title' => 'Wallpapers', 'link' => helper_reload(array('section' => 'wallpapers')), 'icon' => 'settings/wallpaper_icon.png', 'tip' => 'Change wallpaper');

$app_toolbar[] = array('id' => 'groups', 'title' => 'Workgroups', 'link' => helper_reload(array('section' => 'groups')), 'icon' => 'workgroups.png', 'tip' => 'Manage your workgroups');


?>