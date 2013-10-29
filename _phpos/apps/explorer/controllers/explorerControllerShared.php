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


// Shared - set ID
	
	$tmp_shared = $my_app->get_param('reset_shared');
	$shared_id = $my_app->get_param('shared_id');
	
	if(!empty($shared_id)) $tmp_shared_id = $shared_id;
					
/*.............................................. */		
	
	
	if(!empty($tmp_shared_id)) 
	{
		$my_app->set_param('tmp_shared_id', $tmp_shared_id);
		cache_param('tmp_shared_id');
		//$my_app->window->set_AppParam('tmp_shared_id', $tmp_shared_id);	
	}
		 
/*
**************************
*/
 	// Reset shared
	
	if($my_app->get_param('reset_shared') == 1)
	{			
	  $my_app->set_param('root_id', null);
	  $my_app->set_param('readonly', null);
		//if(empty($my_app->get_param('dir_id')) $my_app->set_param('dir_id', null);				
			
		$my_app->set_param('shared_id', null);
		$my_app->set_param('in_shared', null);
		$my_app->set_param('reset_shared', null);		
	}
		 
/*
**************************
*/
 	// Reset shared
	
	if(APP_ACTION != 'index' || $my_app->get_param('fs') != 'local_files')
	{
		$my_app->set_param('in_shared', NULL);
	}
		 
/*
**************************
*/	

	// Shared folders
	
	$shared_id = $my_app->get_param('shared_id');
	
	if(!empty($shared_id))
	{
		$shared = new phpos_shared;
		$shared->set_id($shared_id);
		$shared->get_shared();
						
/*.............................................. */		
	
		if($shared->is_shared_to_me())
		{		
			$shared_dir = $shared->get_folder_id();		
			
			if(!empty($shared_dir) && is_dir(base64_decode($shared_dir)))
			{		
				$my_app->set_param('root_id', base64_decode($shared_dir));
				$my_app->set_param('dir_id', base64_decode($shared_dir));
				define('SHARED', true);
				
			} else {
			
				$my_app->set_param('root_id', null);
				$my_app->set_param('dir_id', null);
				$my_app->set_param('shared_id', null);
				cache_param('shared_id');
				jquery_onready(link_action('my_server', ''));
				msg::error(txt('folder_not_found'));
			}
			
				
/*.............................................. */		
	
		
		} else {
			
				$my_app->set_param('root_id', null);
				$my_app->set_param('dir_id', null);
				$my_app->set_param('shared_id', null);
				cache_param('shared_id');
				jquery_onready(link_action('my_server', ''));
				msg::error(txt('access_denied'));
		}
		
		$my_app->set_param('shared_id', null);
		
				
/*.............................................. */		
			
	} else {
	
			//$my_app->set_param('root_id', null);
			//$my_app->set_param('dir_id', null);
	}
	
	// If shared and readonly
	
	$in_shared = $my_app->get_param('in_shared');		
	$readonly = $my_app->get_param('readonly');
				
/*.............................................. */		
		
	if($in_shared == 1)
	{					
		$shared = new phpos_shared;
		$share_dir_id = $my_app->get_param('dir_id');
		
		if(substr($share_dir_id, -1) == '/')		
		{
			$share_dir_id = substr($share_dir_id, 0, -1);
		}
		
		//echo $share_dir_id;
		$shared_id = $shared->find_shared($share_dir_id);
		
		$address_icon = ICONS.'server/shared1.png';
				
/*.............................................. */		
			
		if(!empty($shared_id) && !$shared->is_my($shared_id))
		{
			$shared->set_id($shared_id);
			$shared->get_shared();
			$readonly = $shared->get_readonly();
		}	
					
/*.............................................. */		
		
		if($readonly) $my_app->set_param('readonly', 1);
		
	} else {
		
		$my_app->set_param('readonly', null);
	}
					
/*.............................................. */		
	
	cache_param('readonly');

?>