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


$tray['id'] = 'updater';
$tray['access_level'] = 2;
$tray['version'] = 1.0;
$tray['load_only_with_app'] = false;
$tray['app_id'] = null;
$tray['use_custom_icons'] = true;
$tray['use_lang'] = true;
$tray['title'] = 	txt('updater_tray_title');

$tmp_context_menu = array();

$www_link = 'window.open(\''.PHPOS_ONLINE.'?from_updater=1&lang='.myconfig('lang').'\', \'_blank\'); return false;';
$github_link = 'window.open(\''.PHPOS_GITHUB.'\', \'_blank\'); return false;';

$tmp_context_menu[] = 'upd1::<b>'.txt('updater_tray_launch_updater').'</b>::'.helper::win(txt('updater_tray_title'), 'app', 'app_id:updater').'::time';
$tmp_context_menu[] = '---';
$tmp_context_menu[] = 'www::'.txt('updater_tray_visit_www').'::'.$www_link.'::arrow_back';
$tmp_context_menu[] = 'git::'.txt('updater_tray_visit_git').'::'.$github_link.'::arrow_back';


$context_menu_style=array();

global $updater_message;


$conn_msg['online'] = '<span style=\'font-weight:bold; color: #257128\'>'.txt('updater_tray_online').'</span>';
$conn_msg['offline'] = '<span style=\'font-weight:bold; color: #7f211d\'>'.txt('updater_tray_offline').'</span>';
$conn_msg['disabled'] = '<span style=\'font-weight:bold; color: #384e92\'>'.txt('updater_tray_disabled').'</span>';


$updater = new phpos_updater;
$tray['icons'] = array(ICONS.'tray/updater.png');

$timeout = 3;
$cfg_timeout = globalconfig('app_updater_autoupdate_timeout');

if(!empty($cfg_timeout) && $cfg_timeout != 0) $timeout = $cfg_timeout;

if(globalconfig('app_updater_autoupdate') == 1)
{
	if($updater->check_online(intval($timeout))) 
	{		
		$last_version_name = $updater->get_name();
		if(!$updater->is_actual())
		{
			$your_version = '<span style=\'color: #7f211d\'><b>'.txt('updater_tray_your_version').':</b> '.PHPOS_VERSION_NAME.'</span>'; 
			$newest_version = '<span style=\'color: #257128\'><b>'.txt('updater_tray_newest_version').':</b> '.$last_version_name.'</span>'; 
			
			$tmp_context_menu[] = '---';
			$tmp_context_menu[] = 'your_v::'.$your_version.'::return false;::cancel';
			$tmp_context_menu[] = 'serv_v::'.$newest_version.'::return false;::ok';
			
			$tray['icons'] = array(ICONS.'tray/updater_alert.png');
			
			
			$updater_message = str_replace(array('%version%', '%date%'), array('<b>'.$updater->get_name().'</b>', '<b>'.$updater->get_build().'</b>'), txt('updater_tray_msg_new')).'<br/><a href="javascript:updater()" ><span style="font-size:14px"><b>'.txt('updater_tray_msg_click').'</b></span></a> '.txt('updater_tray_msg_click_download');			
		
		
		} else {			
		
			$your_version = '<span style=\'color: #257128\'><b>'.txt('updater_tray_your_version').':</b> '.PHPOS_VERSION_NAME.'</span>'; 
			$newest_version = '<span style=\'color: #257128\'><b>'.txt('updater_tray_newest_version').':</b> '.$last_version_name.'</span>'; 
			
			
			$tmp_context_menu[] = '---';
			$tmp_context_menu[] = 'your_v::'.$your_version.'::return false;::ok';
			$tmp_context_menu[] = 'serv_v::'.$newest_version.'::return false;::ok';
			
			$tray['icons'] = array(ICONS.'tray/updater_ok.png');
		}	
		
		$tmp_context_menu[] = '---';
		$tmp_context_menu[] = 'status::'.$conn_msg['online'].'::return false;::reload';
		
		
	}	else {

		$tmp_context_menu[] = '---';
		$tmp_context_menu[] = 'status::'.$conn_msg['offline'].'::return false;::ico';
	}
	
} else {

	$tmp_context_menu[] = '---';
	$tmp_context_menu[] = 'status::'.$conn_msg['disabled'].'::return false;::ico';
}

$tray['context_menu'] = $tmp_context_menu;
echo '<style>'.$styles.'</style>';

?>