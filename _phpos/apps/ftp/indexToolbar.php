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
$app_toolbar[] = array('id' => 'new_account', 'title' => txt('dsc_ftp_a_new'), 'link' => helper_reload(array('section' => 'new_account')), 'icon' => 'create_new.png', 'tip' => txt('dsc_ftp_a_new'));

$app_toolbar[] = array('id' => 'list', 'title' => txt('dsc_ftp_a_list'), 'link' => helper_reload(array('section' => 'list')), 'icon' => 'server/ftp.png', 'tip' => txt('dsc_ftp_a_list'));

$app_toolbar[] = array('id' => 'edit_account', 'title' => txt('dsc_ftp_a_edit'), 'link' => helper_reload(array('section' => 'edit_account')), 'icon' => 'edit.png', 'tip' => txt('dsc_ftp_a_edit'));
?>