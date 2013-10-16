<?php
/*
**********************************

	PHPOS Web Operating system
	MIT License
	(c) 2013 Marcin Szczyglinski
	szczyglis83@gmail.com
	GitHUB: https://github.com/phpos/
	File version: 1.2.6, 2013.10.16
 
**********************************
*/
if(!defined('PHPOS'))	die();	

		// Actions results	
	$action_id = $my_app->get_param('action_id');
	$action_status = $my_app->get_param('action_status');
	$action_status_msg = $my_app->get_param('action_status_msg');
	
	if(!empty($action_status))
	{
		if($action_status == 'error')
		{
			msg::error($action_status_msg);
			
		} else {		
			
			msg::ok($action_status_msg);
		}
		
		$my_app->set_param('action_status', null);
		$my_app->set_param('action_status_msg', null);
		cache_param('action_status');	
		cache_param('action_status_msg');	
	}

?>