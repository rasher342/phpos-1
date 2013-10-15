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


$tray['id'] = 'messenger';
$tray['access_level'] = 1;
$tray['version'] = 1.0;
$tray['load_only_with_app'] = false;
$tray['app_id'] = 'messenger';
$tray['use_custom_icons'] = true;
$tray['use_lang'] = true;

$tmp_context_menu = array();

$tray['icons'] = array(ICONS.'tray/messager.png');
$tray['title'] = 	txt('messager_tray_tip_no_messages');

$tmp_context_menu[] = 'app::<b>'.txt('tray_messager_open').'</b>::'.helper::win(txt('app_messager'), 'app', 'app_id:messenger').'::letter';
$tray['context_menu'] = $tmp_context_menu;

$msg = new phpos_messages;
if($msg->have_unreaded())
{
	$how_many_new  = $msg->count_unreaded();
	$tray['icons'] = array(ICONS.'tray/messager_alert.png');
	$tray['title'] = 	txt('messager_tray_tip_new_messages').': '.$how_many_new;
}

?>