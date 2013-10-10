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


class phpos_clipboard
{
	private 
		$file_id,	
		$file_connect_id,	
		$mode,
		$file_fs;		
		 
/*
**************************
*/
 	
	public function __construct() {
		
		if(!is_array($_SESSION['phpos_clipboard']))
		{
			$_SESSION['phpos_clipboard'] = array();
			$_SESSION['phpos_clipboard']['id'] = null;			
			$_SESSION['phpos_clipboard']['fs'] = null;
			$_SESSION['phpos_clipboard']['mode'] = 'copy';
			$_SESSION['phpos_clipboard']['connect_id'] = null;
		}		
	}
	
	 
/*
**************************
*/
 	public function set_mode($mode)
	{
		$_SESSION['phpos_clipboard']['mode'] = $mode;
	}
	
	public function set_source_win($id)
	{
		$_SESSION['phpos_clipboard']['source_win'] = $id;
	}
	
	public function get_source_win()
	{
		return $_SESSION['phpos_clipboard']['source_win'];
	}
	
	public function add_clipboard($id, $fs, $connect_id = null)
	{
		$_SESSION['phpos_clipboard']['id'] = $id;		
		$_SESSION['phpos_clipboard']['fs'] = $fs;
		$_SESSION['phpos_clipboard']['connect_id'] = $connect_id;
	}
	 
/*
**************************
*/
 	
	public function get_clipboard()
	{
		$this->file_id = $_SESSION['phpos_clipboard']['id'];
		$this->file_fs = $_SESSION['phpos_clipboard']['fs'];
		$this->file_connect_id = $_SESSION['phpos_clipboard']['connect_id'];		
	}
	
	public function get_mode()
	{
		return $_SESSION['phpos_clipboard']['mode'];
	}
/*
**************************
*/
 	
	public function get_file_id()
	{
		return $this->file_id;
	}
	 
/*
**************************
*/
 	
	public function get_file_connect_id()
	{
		return $this->file_connect_id;
	}
	
 
/*
**************************
*/
 	
	
	public function get_file_fs()
	{
		return $this->file_fs;
	}
	
	 
/*
**************************
*/
 	
	public function reset_clipboard()
	{
		$_SESSION['phpos_clipboard'] = array();
		$_SESSION['phpos_clipboard']['id'] = null;			
		$_SESSION['phpos_clipboard']['fs'] = null;
		$_SESSION['phpos_clipboard']['connect_id'] = null;
	}
	 
/*
**************************
*/
 	
	public function is_clipboard($fs = null)  
	{
		if(!empty($_SESSION['phpos_clipboard']['id']))
		{
			//if($_SESSION['phpos_clipboard']['fs'] == $fs) return true;	
			return true;	
		}
	}
	 
/*
**************************
*/
 	
	public function is_my_clipboard($fs)
	{
		switch($fs)
		{
			case 'db_mysql':
				$allowed = array('db_mysql');
			break;
			
			case 'local_files':
			case 'ftp':
				$allowed = array('local_files', 'ftp');
			break;		
		}	
		
		
		if($this->is_clipboard() && in_array($_SESSION['phpos_clipboard']['fs'], $allowed)) return true;				
	}
	 
/*
**************************
*/
 	
	public function debug_clipboard()
	{
		//print_r($_SESSION['phpos_clipboard']);
	}
	
}
?>