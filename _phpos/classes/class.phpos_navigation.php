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


class phpos_navigation {

	public function __construct()
	{
		if(!is_array($_SESSION['phpos_navigation'])) 
		{
			$_SESSION['phpos_navigation'] = array(); 
			$_SESSION['phpos_navigation_actions'] = array(); 
			if(WIN_ID != 1) $_SESSION['phpos_navigation'][WIN_ID] = array();	
			if(WIN_ID != 1) $_SESSION['phpos_navigation_action'][WIN_ID] = null;	
		}
		
		if(WIN_ID != 1) 
		{
			if(!isset($_SESSION['phpos_navigation_index'][WIN_ID])) $_SESSION['phpos_navigation_index'][WIN_ID] = 0;			
		}
	}	
	
		 
/*
**************************
*/
 		
	public function get_a()
	{
		return 'navvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvi';
	}
			 
/*
**************************
*/
 	
	public function debug()
	{
		global $my_app;
		
	//	echo 'SESSION INDEX NOW: '.$_SESSION['phpos_navigation_index'][WIN_ID].'<br>';
		echo '<div style="background-color:white"><textarea>set_index: '.$my_app->get_param('set_index').',,,,,minus_index: '.$my_app->get_param('minus_index').',,,,,SESSION INDEX NOW: '.$_SESSION['phpos_navigation_index'][WIN_ID].'\nobenca:  akcja: '.$_SESSION['phpos_navigation_action'][WIN_ID].' <br> NAV ID:'.$my_app->get_param('this_index').'<br>params:'.$this->parse_params(0).'<br><pre>
		
		';
		print_r($_SESSION['phpos_navigation'][WIN_ID]);
		echo '</pre></textarea></div><br><br>';		
	}	
			 
/*
**************************
*/
 	
	public function next_index()
	{
		$index = $_SESSION['phpos_navigation_index'][WIN_ID];
		$index++;
		$_SESSION['phpos_navigation_index'][WIN_ID] = $index;
	}
			 
/*
**************************
*/
 	
	public function set_index($set_index)
	{	
		if(WIN_ID != 1) 	
		{	
			$_SESSION['phpos_navigation_index'][WIN_ID] = $set_index;		
		}
	}
	
			 
/*
**************************
*/
 	
	public function get_index()
	{		
		return $_SESSION['phpos_navigation_index'][WIN_ID];
	}
			 
/*
**************************
*/
 	
	public function is_next_index()
	{
		$index = $this->get_index(); 
		$next_index = $index + 1;
		//echo '<br>nnnnnnn:this:'.$index.' next:'.$next_index.'<br>';
		if(WIN_ID != 1 && is_array($_SESSION['phpos_navigation'][WIN_ID][$next_index])) return true;
	}
			 
/*
**************************
*/
 	
	public function get_next_index()
	{
		$index = $this->get_index(); 
		$next_index = $index + 1;
		return $next_index;
	}
			 
/*
**************************
*/
 	
	public function reset()
	{
		if(WIN_ID != 1) $_SESSION['phpos_navigation'][WIN_ID] = array();	
	}
	
			 
/*
**************************
*/
 	public function get_prev_index()
	{
		$index = $this->get_index(); 
		$prev_index = $index -1;
		return $prev_index;
	}
			 
/*
**************************
*/
 	
	public function is_prev_index()
	{
		$index = $this->get_index(); 
		$prev_index = $index - 1;
		
		if($prev_index < 1) return false;
		
		if(WIN_ID != 1  && is_array($_SESSION['phpos_navigation'][WIN_ID][$prev_index]) && $_SESSION['phpos_navigation'][WIN_ID][$prev_index] != null) return true;
		//return true;
	}
			 
/*
**************************
*/
 	
	public function get_action($index)
	{
		$params = $_SESSION['phpos_navigation'][WIN_ID][$index];
		return $params['APP_ACTION'];
	}
	
			 
/*
**************************
*/
 	
	public function parse_params($index)
	{		
		$params = $_SESSION['phpos_navigation'][WIN_ID][$index];
		
		//print_r($params);
		
		$c = count($params);
		if($c !=0)
		{
			$a = array();
			foreach($params as $k => $v)
			{
				if(!is_array($v)) 
				{
					if(empty($v)) $v = '0';
					$a[] = $k.':'.$v;		
				}	
			}	
	
		$params_parsed = implode(',', $a);				
		}
		
		return $params_parsed;
	}
			 
/*
**************************
*/
 	
	public function add_item()
	{
		global $my_app;
		$noindex = $my_app->get_param('noindex');
		
		if(WIN_ID != 1) 
		{
			//$_SESSION['phpos_navigation'][WIN_ID][] = 'dupaaa';
			
			global $my_app;			
			$item_data = array();			
			
			$item_data['noindex'] = 1;
			$item_data['APP_ACTION'] = APP_ACTION;
			$item_data['folder_root'] = $my_app->get_param('folder_root');
			$item_data['ftp_id'] = $my_app->get_param('ftp_id');
			$item_data['dir_id'] = $my_app->get_param('dir_id');
			$item_data['root_id'] = $my_app->get_param('root_id');
			$item_data['workgroup_id'] = $my_app->get_param('workgroup_id');
			$item_data['workgroup_user_id'] = $my_app->get_param('workgroup_user_id');
			$item_data['shared_id'] = $my_app->get_param('shared_id');
			$item_data['action_id'] = $my_app->get_param('action_id');
			$item_data['readonly'] = $my_app->get_param('readonly');
			$item_data['action_param'] = $my_app->get_param('action_param');
			$item_data['action_param2'] = $my_app->get_param('action_param2');
			$item_data['tmp_shared_id'] = $my_app->get_param('tmp_shared_id');
			$item_data['reset_shared'] = $my_app->get_param('reset_shared');
			$item_data['error_no_dir'] = $my_app->get_param('error_no_dir');
			$item_data['in_shared'] = $my_app->get_param('in_shared');
			$item_data['dir_navigation_history'] = $my_app->get_param('dir_navigation_history');
			$item_data['dir_navigation_index'] = $my_app->get_param('dir_navigation_index');
			$item_data['no_increment'] = $my_app->get_param('no_increment');
			$item_data['action_status'] = $my_app->get_param('action_status');
			$item_data['action_status_msg'] = $my_app->get_param('action_status_msg');
			$item_data['fs'] = $my_app->get_param('fs');	
			$item_data['delete_id'] = $my_app->get_param('delete_id');
			$item_data['noindex'] = 1;
			
			$i = $_SESSION['phpos_navigation_index'][WIN_ID];
			
			
			$_SESSION['phpos_navigation'][WIN_ID][$i] = $item_data;
			$_SESSION['phpos_navigation_action'][WIN_ID] = APP_ACTION;					
		}		
	}
	
}
?>