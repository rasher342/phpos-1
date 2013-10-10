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

$app_toolbar[] = array('id' => 'new_user', 'title' => 'Add new user', 'link' => helper_reload(array('section' => 'new_user')), 'icon' => 'accounts/toolbar_new_user2.png', 'tip' => 'Add new user');

$app_toolbar[] = array('id' => 'users_list', 'title' => 'Browse users', 'link' => helper_reload(array('section' => 'users_list')), 'icon' => 'accounts/toolbar_accounts.png', 'tip' => 'Browse users list');

$app_toolbar[] = array('id' => 'account', 'title' => 'Your account', 'link' => helper_reload(array('section' => 'account')), 'icon' => 'accounts/toolbar_edit.png', 'tip' => 'Your account');


$app_toolbar[] = array('id' => 'account_groups', 'title' => 'Workgroups', 'link' => helper_reload(array('section' => 'account_groups')), 'icon' => 'accounts/toolbar_edit.png', 'tip' => 'Manage your workgroups');


$app_toolbar[] = array('id' => 'list', 'title' => 'User groups', 'link' => helper_reload(array('section' => 'list')), 'icon' => 'user.png', 'tip' => 'Groups admin');


$app_toolbar[] = array('id' => 'groups', 'title' => 'Settings', 'link' => 'alert()', 'icon' => 'user.png', 'tip' => 'Groups admin');
?>