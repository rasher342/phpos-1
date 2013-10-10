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

$app_toolbar[] = array('id' => 'system_info_phpos', 'title' => txt('cp_system_info_phpos_title'), 'link' => helper_reload(array('section' => 'system_info_phpos')), 'icon' => 'system_info/phpos_icon.png', 'tip' => txt('cp_system_info_phpos_desc'));

$app_toolbar[] = array('id' => 'system_info_php', 'title' => txt('cp_system_info_php_title'), 'link' => helper_reload(array('section' => 'system_info_php')), 'icon' => 'system_info/php_icon.png', 'tip' => txt('cp_system_info_php_desc'));

$app_toolbar[] = array('id' => 'system_info_db', 'title' => txt('cp_system_info_db_title'), 'link' => helper_reload(array('section' => 'system_info_db')), 'icon' => 'system_info/db_icon.png', 'tip' => txt('cp_system_info_db_desc'));

$app_toolbar[] = array('id' => 'system_info_server', 'title' => txt('cp_system_info_server_title'), 'link' => helper_reload(array('section' => 'system_info_server')), 'icon' => 'system_info/server_icon.png', 'tip' => txt('cp_system_info_server_desc'));

$app_toolbar[] = array('id' => 'system_info_key', 'title' => txt('cp_system_info_key_title'), 'link' => helper_reload(array('section' => 'system_info_key')), 'icon' => 'system_info/key_icon.png', 'tip' => txt('cp_system_info_key_desc'));

?>