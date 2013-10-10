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

if(PHPOS_HAVE_ACCESS != $my_app->get_app_id() or !defined('PHPOS'))
{
	die();
}

	$my_app->set_param('year_id', null);
	$my_app->set_param('month_id', null);
	$my_app->set_param('day_id', null);
	$my_app->set_param('log_id', null);

	$my_app->set_param('id_session', null);
	$my_app->set_param('action', null);
	$my_app->set_param('section', 'logs');		
	
	$my_app->using('params');
	$my_app->using('sections');
	$my_app->using('toolbar');
	
	$year_id = $my_app->get_param('year_id');
	$month_id = $my_app->get_param('month_id');
	$day_id = $my_app->get_param('day_id');
	$log_id = $my_app->get_param('log_id');
	
	
	
	if(empty($log_id))
	{
		$my_app->set_param('year_id', date('Y'));
		$my_app->set_param('month_id', date('m'));
		$my_app->set_param('day_id', date('d'));	
		
		$logs = new phpos_logs;	
		$today_log_id = $logs->get_today_log_file();
		$my_app->set_param('log_id', $today_log_id);
	}
	

	
	$my_app->jquery_onready(msg::showMessages());		
	
	$action = $my_app->get_param('action');	
	switch($action)
	{
		case 'delete_session':
			$delete_id = $my_app->get_param('id_session');
			$u_d = new phpos_users;
			
			if($u_d->delete_session($delete_id))
			{
				helper_result('delete_session', 'ok', txt('deleted'));
				$my_app->set_param('action', null);
				cache_param('action');
				$my_app->set_param('id_session', null);
				cache_param('id_session');
			}
			
		break;
	
	}



?>