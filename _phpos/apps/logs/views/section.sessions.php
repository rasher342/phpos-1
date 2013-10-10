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


echo $layout->title(txt('logs_section_sessions_title'), 'icon.png'); 
echo $layout->txtdesc(txt('logs_section_sessions_subdesc'));

$id_session = $my_app->get_param('id_session');

$limit = 30;

if($id_session === null)
{

	$sessions = new phpos_users;
	
	$sessions->set_id_user(logged_id());
	$sessions_list = $sessions->get_last_sessions_ids($limit);
	
	$c = count($sessions_list);
	
		$today = '';		
						
		$log_title = txt('logs_log_from_title').$my_app->get_param('year_id').' - '.$my_app->get_param('month_id').' - '.$my_app->get_param('day_id').$today;
		
		echo $layout->subtitle(str_replace('%limit%', $limit, $txt['logs_section_sessions_last_title']), ICONS.'logs/section_sessions.png');
		echo $layout->txtdesc(str_replace('%limit%', $limit, $txt['logs_section_sessions_last_desc']));


		if($c != 0)
		{		
		
			echo $layout->tbl_start();
			$layout->td_classes(array(''));
			echo $layout->head(array(txt('logs_section_sessions_tbl_id') => '5%', txt('logs_section_sessions_tbl_starttime') => '10%', txt('logs_section_sessions_tbl_endtime') => '10%', txt('logs_section_sessions_tbl_user') => '25%', txt('logs_section_sessions_tbl_ip') => '15%', txt('logs_section_sessions_tbl_browser') => '20%', txt('logs_section_sessions_tbl_sid') => '5%', txt('logs_section_sessions_tbl_action') => '10%'));	
			
			foreach($sessions_list as $id_session)
			{			
				$session_info = $sessions->get_session_id_data($id_session);
				
				
			
				$u_info = new phpos_users;
				$u_info->set_id_user($session_info['id_user']);
				$u_info->get_user_by_id();			
				
				
				$tip = '<b>UID:</b> '.$session_info['id_user'].'<br /><b>'.txt('logs_sessions_fulltime').'</b> '.date('d.m.Y H:i:s', intval($session_info['start_time'])).' - '.date('d.m.Y H:i:s', intval($session_info['end_time']));
				
				
				$usr_link = '<b>'.$u_info->get_user_login().'</b> (UID: '.$session_info['id_user'].')';
			
				$action = helper_reload(array('section' => 'sessions', 'action' => 'delete_session', 'id_session' => $session_info['id_session']));
					
			
			
			
				echo $layout->row(array(
					$session_info['id_session'],
					
					date('d.m.Y H:i:s', intval($session_info['start_time'])),
					date('d.m.Y H:i:s', intval($session_info['end_time'])),
					$usr_link,
					$session_info['user_ip'],
					$session_info['user_browser'],
					$session_info['php_sessid'],
					$layout->button(txt('btn_delete'), $action, 'cancel')
				
				), $tip);			
			}
			
			
			echo $layout->tbl_end();	
	
	}

} else {

	// log session
	$sessions = new phpos_users;

	if($sessions->is_session_id($id_session))
	{
	
		echo $layout->subtitle($txt['logs_section_sessions_view_title'], ICONS.'logs/section_sessions.png');
		echo $layout->txtdesc($txt['logs_section_sessions_view_desc']);


			echo $layout->tbl_start();
			$layout->td_classes(array(''));
			echo $layout->head(array(txt('logs_section_sessions_tbl_id') => '5%', txt('logs_section_sessions_tbl_starttime') => '10%', txt('logs_section_sessions_tbl_endtime') => '10%', txt('logs_section_sessions_tbl_user') => '25%', txt('logs_section_sessions_tbl_ip') => '15%', txt('logs_section_sessions_tbl_browser') => '20%', txt('logs_section_sessions_tbl_sid') => '5%', txt('logs_section_sessions_tbl_action') => '10%'));	
			
					
				$session_info = $sessions->get_session_id_data($id_session);
				
				$tip = '<b>UID:</b> '.$session_info['id_user'].'<br /><b>'.txt('logs_sessions_fulltime').'</b> '.date('d.m.Y H:i:s', intval($session_info['start_time'])).' - '.date('d.m.Y H:i:s', intval($session_info['end_time']));
			
				$u_info = new phpos_users;
				$u_info->set_id_user($session_info['id_user']);
				$u_info->get_user_by_id();			
				
				$usr_link = '<b>'.$u_info->get_user_login().'</b> (UID: '.$session_info['id_user'].')';
			
				$action = helper_reload(array('section' => 'sessions', 'action' => 'delete_session', 'id_session' => $session_info['id_session']));
					
			
			
			
				echo $layout->row(array(
					$session_info['id_session'],
					
					date('d.m.Y H:i:s', intval($session_info['start_time'])),
					date('d.m.Y H:i:s', intval($session_info['end_time'])),
					$usr_link,
					$session_info['user_ip'],
					$session_info['user_browser'],
					$session_info['php_sessid'],
					$layout->button(txt('btn_delete'), $action, 'cancel')
				
				), $tip);			
		
			
			
			echo $layout->tbl_end();	
		
		} else {
		
			echo 'Session not exists in DB.';
		}

}	
	?>