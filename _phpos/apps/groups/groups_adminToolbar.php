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

$app_toolbar[] = array('id' => 'new_group', 'title' => txt('group_section_new_group'), 'link' => helper_reload(array('section' => 'new_group')), 'icon' => 'create_new.png', 'tip' => txt('group_section_new_group'));

$app_toolbar[] = array('id' => 'edit_group', 'title' => txt('group_section_edit_group'), 'link' => helper_reload(array('section' => 'edit_group')), 'icon' => 'accounts/toolbar_edit.png', 'tip' => txt('group_section_edit_group'));

$app_toolbar[] = array('id' => 'group_users', 'title' => txt('group_section_group_users'), 'link' => helper_reload(array('section' => 'group_users')), 'icon' => 'accounts/toolbar_accounts.png', 'tip' => txt('group_section_group_users'));

$app_toolbar[] = array('id' => 'list', 'title' => txt('group_section_list'), 'link' => helper_reload(array('section' => 'list')), 'icon' => 'workgroups.png', 'tip' => txt('group_section_list'));

?>