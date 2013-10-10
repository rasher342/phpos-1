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

$app_toolbar[] = array('id' => 'new_user', 'title' => txt('usr_new'), 'link' => helper_reload(array('section' => 'new_user')), 'icon' => 'accounts/toolbar_new_user2.png', 'tip' => txt('usr_new'));

$app_toolbar[] = array('id' => 'edit_account', 'title' => txt('edit_user'), 'link' => helper_reload(array('section' => 'edit_account')), 'icon' => 'accounts/toolbar_edit.png', 'tip' => txt('edit_user'));

$app_toolbar[] = array('id' => 'list', 'title' => txt('users'), 'link' => helper_reload(array('section' => 'list')), 'icon' => 'user.png', 'tip' => txt('users'));

?>