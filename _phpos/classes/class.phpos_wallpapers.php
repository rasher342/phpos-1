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


class phpos_wallpapers
{
	private 
		$global_wallpapers_dir,
		$global_wallpapers_url,
		$user_wallpapers_dir,
		$user_wallpapers_url,
		$flag_dir,
		$lang_id,
		$lang_list,
		$lang_name,
		$lang_default,
		$lang_data;
		
	
		 
/*
**************************
*/
 	public function get_global_wallpapers()
	{		
		$list_wallpapers = glob($this->global_wallpapers_dir);
		$wallpaper = array();
		foreach($list_wallpapers as $img)
		{
			$wallpaper[] = basename($img);
			//echo basename($img);
		}
		
		return $wallpaper;	
	}
	 
/*
**************************
*/
 	
	public function get_user_wallpapers()
	{		
		$list_wallpapers = glob($this->user_wallpapers_dir);
		$wallpaper = array();
		if(!empty($list_wallpapers))
		{
			foreach($list_wallpapers as $img)
			{
				$wallpaper[] = basename($img);
				//echo basename($img);
			}
		}
		
		return $wallpaper;	
	}
	 
/*
**************************
*/
 	
	public function get_global_url($wallpaper_name)
	{
		return $this->global_wallpapers_url.$wallpaper_name;
	}
	 
/*
**************************
*/
 	
	public function get_global_wallpapers_dir()
	{
		return $this->global_wallpapers_dir;
	}
	 
/*
**************************
*/
 	
	public function get_global_wallpapers_url()
	{
		return $this->global_wallpapers_url;
	}
	 
/*
**************************
*/
 	
	public function get_user_wallpapers_dir()
	{
		return $this->user_wallpapers_dir;
	}
	 
/*
**************************
*/
 	
	public function get_user_wallpapers_url()
	{
		return $this->user_wallpapers_url;
	}
	
	 
/*
**************************
*/
 	
	public function __construct()
	{
		$this->global_wallpapers_dir = PHPOS_WEBROOT_DIR.'_phpos/wallpapers/*.jpg';
		$this->global_wallpapers_url = PHPOS_WEBROOT_URL.'_phpos/wallpapers/';
		
		$usr = new phpos_users;
		$my_id = logged_id();
		$usr->get_user_by_id($my_id);
		$my_dir = $usr->get_home_dir_hash();
		if(is_dir(PHPOS_HOME_DIR.$my_dir.'/_Wallpapers')) 
		{
			$this->user_wallpapers_dir = PHPOS_HOME_DIR.$my_dir.'/_Wallpapers/*.jpg'; 
			$this->user_wallpapers_url = PHPOS_HOME_URL.$my_dir.'/_Wallpapers/';
		}		
		
		$this->lang_dir = PHPOS_DIR.'lang/';	
		$this->flag_dir = PHPOS_WEBROOT_URL.'_phpos/icons_lang/';
		$this->lang_list = array();
		$this->lang_default = 'en';
	}
	
}
?>