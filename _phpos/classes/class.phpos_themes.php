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


class phpos_themes
{
	private 
		$themes_dir,
		$themes_url,
		$theme_info = array(),
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
 	public function get_themes_list()
	{		
		$list_themes = glob($this->themes_dir.'*');
		$theme = array();
		foreach($list_themes as $name)
		{
			if(is_dir($name)) $theme[] = basename($name);
			//echo basename($img);
		}
		
		return $theme;	
	}
	 
/*
**************************
*/
 	
	public function theme_img_preview($theme_id)
	{
		if(is_dir($this->themes_dir.$theme_id)) 
		{
			if(file_exists($this->themes_dir.$theme_id.'/theme_preview.jpg')) return $this->themes_url.$theme_id.'/theme_preview.jpg';			
		}	
	}
	 
/*
**************************
*/
 	
	public function load_theme_info($theme_id)
	{
		if(is_dir($this->themes_dir.$theme_id)) 
		{
			if(file_exists($this->themes_dir.$theme_id.'/config.php')) 
			{
				include $this->themes_dir.$theme_id.'/config.php';
				$this->theme_info = $theme;
			}			
		}	
	}
	 
/*
**************************
*/
 	
	public function get_name()
	{
		return $this->theme_info['name'];	
	}
	 
/*
**************************
*/
 	
	public function get_version()
	{
		return $this->theme_info['version'];	
	}
	 
/*
**************************
*/
 	
	public function get_user_wallpapers()
	{		
		$list_wallpapers = glob($this->user_wallpapers_dir);
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
		$this->themes_dir = PHPOS_WEBROOT_DIR.'_phpos/themes/';
		$this->themes_url = PHPOS_WEBROOT_URL.'_phpos/themes/';
		
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