<?php
/*
**********************************

	PHPOS Web Operating system
	MIT License
	(c) 2013 Marcin Szczyglinski
	szczyglis83@gmail.com
	GitHUB: https://github.com/phpos/
	File version: 1.0.0, 2013.10.09
 
**********************************
*/
if(!defined('PHPOS'))	die();	


$app_toolbar = array();

$app_toolbar[] = array('id' => 'new', 'title' => txt('messager_section_new'), 'link' => helper_reload(array('reply_id' => null, 'section' => 'new', 'msg_id' => null)), 'icon' => 'msg_new.png', 'tip' => txt('messager_section_new_desc'));

$app_toolbar[] = array('id' => 'received', 'title' => txt('messager_section_received'), 'link' => helper_reload(array('section' => 'received', 'msg_id' => null)), 'icon' =>  'msg_received.png', 'tip' => txt('messager_section_received_desc'));

$app_toolbar[] = array('id' => 'sended', 'title' => txt('messager_section_sended'), 'link' => helper_reload(array('section' => 'sended', 'msg_id' => null)), 'icon' => 'msg_sended.png', 'tip' => txt('messager_section_sended_desc'));

?>