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


	class phpos_icons {
	
		private
			$accepted_extensions,
			$my_icons_dir,
			$my_icons_url;
				 
/*
**************************
*/
 	
		public function __construct()
		{
			$usr = new phpos_users;
			$my_id = logged_id();
			$usr->get_user_by_id($my_id);			
			$my_dir = $usr->get_home_dir_hash();
			
			if(is_dir(PHPOS_HOME_DIR.$my_dir.'/_Icons'))
			{
				$this->my_icons_dir = PHPOS_HOME_DIR.$my_dir.'/_Icons/';
				$this->my_icons_url = PHPOS_HOME_URL.$my_dir.'/_Icons/';
			}		
			
			$this->accepted_extensions = array('png', 'gif', 'jpg', 'jpeg');
		}
				 
/*
**************************
*/
 	
		
		public function count_icons()
		{
			$icons = $this->get_icon_list();
			if(is_array($icons)) return count($icons);
		}
				 
/*
**************************
*/
 	
		public function get_icon_list()
		{
			if(!empty($this->my_icons_dir))
			{
				$dir = glob($this->my_icons_dir.'*.*');
				$icons = array();
				
				foreach($dir as $file)
				{					
					$ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));					
					if(in_array($ext, $this->accepted_extensions)) $icons[] = basename($file);
				}	
				
				return $icons;
			}		
		}
				 
/*
**************************
*/
 	
		public function get_icons_dir()
		{
			return $this->my_icons_dir;
		}
				 
/*
**************************
*/
 	
		public function get_icons_url()
		{
			return $this->my_icons_url;
		}	
	
	}
?>