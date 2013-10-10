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


	class phpos_filesystems 
	{
	
		protected 
			$app_param,			
			$pluginFile,
			$pluginData,
			$pluginAction,
			$tmp_context_menu,						
			$Config;
					
			 
/*
**************************
*/
 		
		function __construct() {		
			//parent::__construct(); // call plugin constructor								
		}				
			 
/*
**************************
*/
 	
		public function api_ROOT()
		{
			return $this->FileROOT_ID;	
		}		
		
/*
**************************
*/
 	
		public function addLastSlash($id)
		{
			$last_char = substr($id, -1);
			$str = $id;
			if($last_char != '/')
			{
				$str = $id.'/';
			}				
			return $str;
		}
		
/*
**************************
*/
 	
	
	public function eregCheckPrefix($address)
	{
		$pattern = "^[a-zA-Z0-9]+([\:]){1}([\/]){2}(.)*$";
		if(eregi($pattern, $address)) 
		{
			return true;	
		}
	}
		 
/*
**************************
*/
 	
	public function eregSingleFile($address)
	{
			$pattern = "^([\/]?)[^\/]*(\/)?$";
			if(eregi($pattern, $address)) 
		{
			return true;	
		}
	}
		 
/*
**************************
*/
 	
	public function eregLastSlash($address)
	{
		$pattern = "^.*([\/]){1}$";
		if(eregi($pattern, $address)) 
		{
			return true;	
		}
	}
		 
/*
**************************
*/
 	
	
	public function addressCutChars($address)
	{
		$address = strip_tags($address);
		$address = str_replace('\\', '/', $address);
		$chars_to_remove = array('@', '../', '..', '. .', './', ' /', ' / ', '///', '  ', '\\');
		$address = str_replace($chars_to_remove, '', $address);
		return $address;	
	}
		 
/*
**************************
*/
 	
	public function addressCutCharsURL($address)
	{
		$address = strip_tags($address);
		$chars_to_remove = array(':','//');
		$address = str_replace($chars_to_remove, '', $address);
		return $address;	
	}
		 
/*
**************************
*/
 	
	public function addressGetLevels($url)
	{
		if(!empty($url))
		{
			$subdirs = explode('/', $url);
			return $subdirs;		
		}	
	}
		 
/*
**************************
*/
 	
	
	public function addressExplode($address)
	{		
		if(!$this->eregCheckPrefix($address))
		{
			$address = $this->virtualPrefix.$address;			
		}	
		
		$protocol = ereg_replace("([a-zA-Z]+)://([.]?[a-zA-Z0-9_/-])*", "\\1", $address); //ret protocol
		$url = ereg_replace("([a-zA-Z]+)://([.]?[a-zA-Z0-9_/-])", "\\2", $address); //ret url		
		$url = $this->addressCutCharsURL($url); // cut more chars		
		
		$subdirs = $this->addressGetLevels($url);
		
		$ret['subdirs'] = $subdirs;
		$ret['protocol'] = $protocol;
		$ret['url'] = $url;				
	
		return $ret;
	}
			
}
?>