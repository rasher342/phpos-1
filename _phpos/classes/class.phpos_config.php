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


	class phpos_config {
	
		private
			$id_user,
			$config_mode,
			$config_name,
			$config_value,
			$config_param,
			$db_userconfig,
			$db_globalconfig,
			$global_config = array(),
			$user_config = array();
		
	 
/*
**************************
*/
 		
		public function __construct($no_get = null)
		{
			$this->db_userconfig = 'userconfig';
			$this->db_globalconfig = 'globalconfig';
			
			if($no_get != 'no_get')
			{			
				global $sql;				
				$records = $sql->records($this->db_globalconfig);			
				foreach($records as $row)
				{
					$this->global_config[$row['config_name']] = $row['config_value'];			
				}	
			}
		}
 
/*
**************************
*/
 			
		public function set_id_user($id_user = null)
		{
			if($id_user != null)
			{
				$this->id_user = $id_user;
				
			} else {
			
				$usr = new phpos_users;
				$usr->get_logged_user();
				$id_user = $usr->get_id_user();
				$this->id_user = $id_user;
			}		
			$this->get_all_user();
		}		
	 
/*
**************************
*/
 		
		public function get_all_user()
		{			
			global $sql;	
			$sql->cond('id_user', $this->id_user);
			$records = $sql->records($this->db_userconfig);	
			
			foreach($records as $row)
			{
				$this->user_config[$row['config_name']] = $row['config_value'];			
			}		
		}		
	 
/*
**************************
*/
 		
		public function get_all_global($name = null)
		{
			global $sql;		
			$records = $sql->records($this->db_globalconfig);	
			
			foreach($records as $row)
			{
				$this->global_config[$row['config_name']] = $row['config_value'];			
			}		
		}
 
/*
**************************
*/
 		
		public function get_user($config_name)
		{
			if($this->get_global('demo_mode') !=0 && !empty($_SESSION['demo_lang']))
			{
				$this->user_config['lang'] = $_SESSION['demo_lang'];
			}					
			
			return $this->user_config[$config_name];		
		}
	 
/*
**************************
*/
 	
		public function get_global($config_name)
		{
			return $this->global_config[$config_name];		
		}
	 
/*
**************************
*/
 	
		public function is_user($config_name)
		{
			global $sql;	
			$sql->cond('id_user', $this->id_user);
			$sql->cond('config_name', $config_name);
			if($sql->is_row($this->db_userconfig)) return true;
		}
	 
/*
**************************
*/
 		
		public function is_global($config_name)
		{
			global $sql;			
			$sql->cond('config_name', $config_name);
			if($sql->is_row($this->db_globalconfig)) return true;
		}
 
/*
**************************
*/
 			
		public function new_user($config_name)
		{
			if(!$this->is_user($config_name))
			{
				global $sql;					
				$data = array(
					'id_user' => $this->id_user,
					'config_name' => $config_name,
					'config_value' => '', 
					'config_param' => ''
				);
				
				if($sql->add($this->db_userconfig, $data)) return true;
			}
		}
 
/*
**************************
*/
 			
		public function new_global($config_name)
		{
			if(!$this->is_global($config_name))
			{
				global $sql;					
				$data = array(				
					'config_name' => $config_name,
					'config_value' => '', 
					'config_param' => ''
				);
				
				if($sql->add($this->db_globalconfig, $data)) return true;
			}
		}
		
	 
/*
**************************
*/
 	
		public function update_user($config_name, $config_value)
		{
			$this->new_user($config_name);
			
			global $sql;					
			$data = array(
				'id_user' => $this->id_user,
				'config_name' => $config_name,
				'config_value' => $config_value			
			);
			$sql->cond('config_name', $config_name);
			$sql->cond('id_user', $this->id_user);
			if($sql->update($this->db_userconfig, $data))	
			{
				$this->user_config[$config_name] = $config_value;
				return true;
			}
			
		}
 
/*
**************************
*/
 			
		public function update_global($config_name, $config_value)
		{
			$this->new_global($config_name);
			
			global $sql;					
			$data = array(			
				'config_name' => $config_name,
				'config_value' => $config_value				
			);
			
			$sql->cond('config_name', $config_name);
			if($sql->update($this->db_globalconfig, $data))	
			{
				$this->global_config[$config_name] = $config_value;
				return true;
			}
		}
		
}
?>