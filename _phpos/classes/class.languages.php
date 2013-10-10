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


class phpos_languages
{
	private 
		$lang_dir,
		$flag_dir,
		$lang_id,
		$lang_list,
		$lang_name,
		$lang_default,
		$lang_data;
		
	
		 
/*
**************************
*/
 	
	public function __construct()
	{
		$this->lang_dir = PHPOS_DIR.'lang/';	
		$this->flag_dir = PHPOS_WEBROOT_URL.'_phpos/icons_lang/';
		$this->lang_list = array();
		$this->lang_default = 'en';
	}
		 
/*
**************************
*/
 	
	public function is_lang_dir()
	{
		if(!empty($this->lang_dir) && is_dir($this->lang_dir))
		{
			return true;
		}
	}
		 
/*
**************************
*/
 	
	public function is_flag_dir()
	{
		if(!empty($this->flag_dir) && is_dir($this->flag_dir))
		{
			return true;
		}
	}	
		 
/*
**************************
*/
 	
	public function get_lang_list()
	{
		if($this->is_lang_dir())
		{
			$dir = glob($this->lang_dir.'*Lang.php');
			
			foreach($dir as $file)
			{
				$this->lang_list[] = str_replace(array('Lang','.php'), '', basename($file));
			}
			
			return $this->lang_list;		
		}	
	}
	 
/*
**************************
*/
 	
	
	public function get_lang_info($lang_id = null)
	{
		$id = $this->lang_id;
		
		if(!empty($lang_id))
		{
			$id = $lang_id;
		}
		
		
		if($this->is_lang_dir())
		{
			$cfg_file = $this->lang_dir.strtolower($id).'Config.php';
			
			if(file_exists($cfg_file))
			{
				include $cfg_file;
				$this->lang_data = $lang_data;		
				return $this->lang_data;
			}	
		}
	}
		 
/*
**************************
*/
 	
	public function get_lang_flag_image($size = 30, $lang_id = null)
	{
		$id = $this->lang_id;
			
			if(!empty($lang_id))
			{
				$id = $lang_id;
			}
			
			
			if($this->is_flag_dir())
			{
				$size_dir = $size.'x'.$size.'/';
				$png_file = $this->flag_dir.$size_dir.strtolower($id).'.png';
				
				if(file_exists($png_file))
				{						
					return $png_file;
				}	
			}	
	}	
		 
/*
**************************
*/
 	
	public function lang_exists($lang_id)
	{
		if($this->is_lang_dir() && !empty($lang_id))
		{
			$file = $this->lang_dir.$lang_id.'Lang.php';
			
			if(file_exists($file)) return true;
		}	
	}
		 
/*
**************************
*/
 	
	public function lang_load($lang_id)
	{		
		include $this->lang_dir.'enLang.php';
		
		if($this->lang_exists($lang_id))
		{		
			$file = $this->lang_dir.$lang_id.'Lang.php';
		} 
		if(!empty($file) && $lang_id != 'en') include $file;
		
		glb::set('txt', $txt);
	}
	
}
?>