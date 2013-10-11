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


class phpos_shortcuts {

	private
		$db_shortcuts = 'files',
		$db_startmenu = 'startmenu';
		
		 
/*
**************************
*/ 	
		
	public function add($title, $plugin = 'app', $app_id = null, $app_action = 'index', $icon = null, $post_app_params = null, $location = null, $id_parent, $content = null)
	{	
		if(is_array($post_app_params))
		{			
			$c = count($post_app_params);
			if($c != 0)
			{
				$app_params = array();
				foreach($post_app_params as $key => $value)
				{
					$app_params[] = $key.':'.$value;				
				}	
				
				$db_app_params = implode(',', $app_params);
			}
		}
		
	global $my_user;	
	if($icon == 'null') $icon = '';
	$items = array(
			'file_title' => filter::fname($title),
			'id_user' => $my_user->get_id_user(),
			'id_parent' => filter::num($id_parent),
			'plugin_id' => filter::alfas($plugin),
			'app_id' => filter::alfas($app_id),
			'app_action' => filter::alfas($app_action),
			'created_at' => time(),
			'modified_at' => time(),
			'app_params' => $db_app_params,
			'location' => filter::alfa($location),
			'icon' => filter::fname($icon),
			'content' => $content
		);
		
		global $sql;
		if(false !== ($record_id = $sql->add($this->db_shortcuts, $items))) 
		{
			return $record_id;
			
		} else {
		
			return false;
		}
	}
	 
/*
**************************
*/
 	
	public function update($title, $plugin = 'app', $app_id = null, $app_action = 'index', $icon = null,$post_app_params = null, $location = null, $id)
	{	
		if(is_array($post_app_params))
		{			
			$c = count($post_app_params);
			if($c != 0)
			{
				$app_params = array();
				foreach($post_app_params as $key => $value)
				{
					$app_params[] = $key.':'.$value;				
				}	
				
				$db_app_params = implode(',', $app_params);
			}
		}
		
	global $my_user;	
	if($icon == 'null') $icon = '';
	$items = array(
			'file_title' => filter::fname($title),
			'id_user' => $my_user->get_id_user(),			
			'plugin_id' => filter::alfas($plugin),
			'app_id' => filter::alfas($app_id),
			'app_action' => filter::alfas($app_action),
			'modified_at' => time(),
			'app_params' => $db_app_params,	
			'icon' => filter::fname($icon)
		);
		
		global $sql;
		$sql->cond('id_file', $id);
		if($sql->update($this->db_shortcuts, $items)) return true;
	}
	
	 
/*
**************************
*/
 	
	public function update_content($id, $content)
	{	
		$items = array(			
			'content' => $content,
			'modified_at' => time()
		);
		
		global $sql;
		$sql->cond('id_file', $id);
		if($sql->update($this->db_shortcuts, $items)) return true;
	}	
	 
/*
**************************
*/
 	
	public function get_params_from_db($id)
	{
		if(!empty($id))
		{
			global $sql;
			$sql->cond('id_file', $id);
			$row = $sql->get_row($this->db_shortcuts);
			
			$db_param = array();
			$db_param['id_file'] = $id;
			if(!empty($row['app_params']))
			{
				$params = explode(',', $row['app_params']); 
				foreach($params as $p)
				{
					$item = explode(':', $p);
					$param_name = $item[0];
					$param_value = $item[1];
					$db_param[$param_name] = $param_value;				
				}				
			}	
			
			return $db_param;
		}
	}
	 
/*
**************************
*/
 	
	public function get_shortcut($id)
	{
		if(!empty($id))
		{
			global $sql;
			$sql->cond('id_file', $id);
			return $sql->get_row($this->db_shortcuts);
		}
	}
	
	
	public function is_shortcut($id)
	{
		if(!empty($id))
		{
			global $sql;
			$sql->cond('id_file', $id);
			if($sql->is_row($this->db_shortcuts)) return true;
		}
	}
	 
/*
**************************
*/
 	
	public function new_menustart($link_id)
	{
		global $my_user;
		global $sql;
		
		$items = array(			
			'id_user' => $my_user->get_id_user(),
			'id_file' => $link_id
		);
		
		if($sql->add($this->db_startmenu, $items))
		{
			return true;		
		}		
		
		$row = $this->get_shortcut($link_id);
		
		$items = array(
			'file_title' => $title,
			'id_user' => $my_user->get_id_user(),
			'id_parent' => $row['id_parent'],
			'plugin_id' => $row['plugin_id'],
			'app_id' => $row['app_id'],
			'app_action' => $row['app_action'],
			'created_at' => time(),
			'app_params' => $row['app_params'],
			'win_params' => $row['win_params'],
			'location' => 'menustart',
			'icon' => $row['icon']
		);	
		
		
		if($sql->add($this->db_shortcuts, $items))
		{
			
		} 
		return true;						
	}	
	 
/*
**************************
*/
 	
	public function link_icon($plugin = 'app', $app_id = null, $icon = null, $app_action = null)
	{
		$app = new phpos_app;
		$app->set_app_id($app_id);
		$app->load_config();
		
		if(!empty($icon))
		{
			$user_icons = new phpos_icons;
			$user_icons_dir = $user_icons->get_icons_dir();
			$user_icons_url = $user_icons->get_icons_url();
				
			if(file_exists($user_icons_dir.$icon)) 
			{
				return $user_icons_url.$icon;
			}
		} else {
			
			if($app_id == 'mediaframes')
			{
				return ICONS.'mediaframes/'.$app_action.'.png';
			}
		
			return $app->get_icon();
			
		}	
	}
}
?>