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


class phpos_explorerAPI {
	
		private 
			$file_extension,
			$action,
			$fs,
			$allowed_extensions,
			$db_files,
			$window_id;
			
	 
/*
**************************
*/ 			
			
	public function __construct()
	{
		$this->window_id = WIN_ID;
		$this->db_files = 'files';
		$this->fs = 'local_files';
		$this->allowed_extensions = null;
	}
	 
/*
**************************
*/
 	
	public function set_window_id($id)
	{
		$this->window_id = $id;
	}
	 
/*
**************************
*/
 	
	public function set_allowed_extensions($allowed_extensions)
	{
		$this->allowed_extensions = $allowed_extensions;
	}
	 
/*
**************************
*/
 	
	public function get_allowed_extensions()
	{
		return $this->allowed_extensions;
	}
	 
/*
**************************
*/
 	
	public function allowed_extensions_exists()
	{
		if($this->allowed_extensions !== null) return true;
	}
	 
/*
**************************
*/
 	
	public function set_fs($fs)
	{
		$this->fs = $fs;
	}
	 
/*
**************************
*/
 	
	private function cache_action()
	{
		if(!is_array($_SESSION['phpos_savefiles_handler_action'])) $_SESSION['phpos_savefiles_handler_action'] = array();
		$_SESSION['phpos_savefiles_handler_action'][$this->window_id] = $this->action;	
	}	
	 
/*
**************************
*/
 	
	public function get_db_content($id)
	{
		global $sql;
		$sql->cond('id_file', $id);
		$row = $sql->get_row($this->db_files);
		return $row['content'];
	}
	 
/*
**************************
*/
 	
	public function have_db_content($id)
	{
		global $sql;
		$sql->cond('id_file', $id);
		$row = $sql->get_row($this->db_files);
		if(!empty($row['content'])) return true;
	}
	 
/*
**************************
*/
 	
	public function get_db_info($id)
	{
		global $sql;
		$sql->cond('id_file', $id);
		$row = $sql->get_row($this->db_files);
		
		$file_info['id'] = $row['id_file'];
		$file_info['filename'] = $row['file_title'];
		$file_info['basename'] = $row['file_title'];
		$file_info['modified_at'] = $row['modified_at'];
		if(empty($file_info['modified_at'])) $file_info['modified_at'] = $row['created_at'];
		
		return $file_info;
	}
	 
/*
**************************
*/
 	
	public function set_action($action)
	{
		$this->action = $action;
		$this->cache_action();
	}
	 
/*
**************************
*/
 	
	public function get_action()
	{
		return $_SESSION['phpos_savefiles_handler_action'][$this->window_id];
	}
	 
/*
**************************
*/
 	
	public function set_file_extension($ext)
	{
		$this->file_extension = strtolower($ext);
	}
	 
/*
**************************
*/
 	
	public function parse_allowed_extensions()
	{
		if(is_array($this->allowed_extensions))
		{
			$parsed = implode(';', $this->allowed_extensions);
			return ',allowed_ext:'.str_replace(array(',', ':'), '', $parsed);		
		}
	}
	
	 
/*
**************************
*/
 	
	public function openfile_dialog()
	{
		$allowed = null;
		if($this->allowed_extensions_exists())
		{
			$allowed = $this->parse_allowed_extensions();
		}
		
		$str.= winmodal(txt('explorer_api_window_open_title'), 'app', 'app_id:explorer@index,width:900,height:500','api_dialog:1,api_dialog_type:open_file,fs:'.$this->fs.',win_id:'.$this->window_id.$allowed);
		return $str;	
	}
	 
/*
**************************
*/

	public function openfile($noecho = null)
	{			
		global $my_app;
		if($my_app->get_param('loadFS') !== null && $my_app->get_param('loadID') !== null)
		{	
			$this->fs = $my_app->get_param('loadFS');
		
			$str.= winmodal(txt('explorer_api_window_open_title'), 'app', 'app_id:explorer@index,width:900,height:500','api_dialog:1,api_dialog_type:open_file,api_open_id:'.$my_app->get_param('loadID').',fs:'.$this->fs.',win_id:'.$this->window_id);
			$my_app->set_param('loadAPI', null);
			cache_param('loadAPI');
			if($noecho === null)
			{
				echo '<script>'.$str.'</script>';
				return $str;
			
			} else {
			
				return $str;					
			}
		}
	}
	 
/*
**************************
*/
 	
	public function savefile_dialog()
	{
		$allowed = null;
		if($this->allowed_extensions_exists())
		{
			$allowed = $this->parse_allowed_extensions();
		}
		
		//$this->cache_data_to_save($data);
		$str.= winmodal(txt('explorer_api_window_save_title'), 'app', 'app_id:explorer@index,width:900,height:500','api_dialog:1,api_dialog_type:save_as_file,api_file_ext:'.$this->file_extension.',fs:'.$this->fs.',win_id:'.$this->window_id.$allowed);
		return $str;	
	}
	 
/*
**************************
*/
 	
	public function cache_data_to_save($data)
	{
		if(!is_array($_SESSION['phpos_savefiles_handler'])) $_SESSION['phpos_savefiles_handler'] = array();
		$_SESSION['phpos_savefiles_handler'][$this->window_id] = array();
		
		$app_data['app_id'] = APP_ID;
		$app_data['app_action'] = APP_ACTION;
		$_SESSION['phpos_savefiles_handler'][$this->window_id]['file_data'] = $data;
		$_SESSION['phpos_savefiles_handler'][$this->window_id]['app_data'] = $app_data;
	}
	 
/*
**************************
*/
 	
	public function get_cached_data_to_save()
	{		
		$data = $_SESSION['phpos_savefiles_handler'][$this->window_id]['file_data'];
		//$this->clear_save_cache();
		return $data;
	}
	 
/*
**************************
*/
 	
	public function get_cached_app_data()
	{		
		$app_data = $_SESSION['phpos_savefiles_handler'][$this->window_id]['app_data'];
		//$this->clear_save_cache();
		return $app_data;
	}
	 
/*
**************************
*/
 	
	public function set_saved_file_info($file_info)
	{		
		$_SESSION['phpos_savefiles_handler'][$this->window_id]['file_info'] = $file_info;		
	}
	 
/*
**************************
*/
 	
	public function is_saved_file_info()
	{		
		if(is_array($_SESSION['phpos_savefiles_handler'][$this->window_id]['file_info']))
		{
			return true;
		}		
	}
 
/*
**************************
*/
 		
	public function get_saved_file_info()
	{		
		$data = $_SESSION['phpos_savefiles_handler'][$this->window_id]['file_info'];
		unset($_SESSION['phpos_savefiles_handler'][$this->window_id]);
		return $data;
	}	
	 
/*
**************************
*/

	
	public function data_loaded()
	{
		if(is_array($_SESSION['phpos_files_handler'][$this->window_id])) return true;
	}	
	 
/*
**************************
*/
 	
	public function clear_save_cache()
	{
		unset($_SESSION['phpos_savefiles_handler'][$this->window_id]);
	}
	 
/*
**************************
*/
 	
	public function clear_data()
	{
		unset($_SESSION['phpos_files_handler'][$this->window_id]);
	}
	 
/*
**************************
*/
 	
	public function clear_savedata()
	{
		unset($_SESSION['phpos_savefiles_handler'][$this->window_id]);
	}
	 
/*
**************************
*/
 	
	public function clear_all_data()
	{
		unset($_SESSION['phpos_files_handler']);
		unset($_SESSION['phpos_savefiles_handler']);
		unset($_SESSION['phpos_savefiles_handler_action']);
	}
	 
/*
**************************
*/
 	
	public function get_file_data()
	{
		return $_SESSION['phpos_files_handler'][$this->window_id]['file_data'];
	}
	 
/*
**************************
*/
 	
	public function set_file_info($file_info)
	{
		if(!empty($file_info['fs'])) $this->fs = $file_info['fs'];
		$_SESSION['phpos_files_handler'][$this->window_id] = array();
		$_SESSION['phpos_files_handler'][$this->window_id]['file_info'] = $file_info;
	}
	 
/*
**************************
*/
 	
	public function get_file_info()
	{
		$data = $_SESSION['phpos_files_handler'][$this->window_id]['file_info'];
		unset($_SESSION['phpos_files_handler'][$this->window_id]);
		return $data;
	}	
	
}
?>