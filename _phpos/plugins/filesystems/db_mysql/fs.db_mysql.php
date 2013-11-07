<?php 
/*
**********************************

	PHPOS Web Operating system
	MIT License
	(c) 2013 Marcin Szczyglinski
	szczyglis83@gmail.com
	GitHUB: https://github.com/phpos/
	File version: 1.2.8, 2013.10.26
 
**********************************
*/
if(!defined('PHPOS'))	die();	

if(!defined('PHPOS_IN_EXPLORER'))
{
	die();
}
			 
/*
**************************
*/
 	
class phpos_fs_plugin_db_mysql extends phpos_filesystems
{
                                                                               
	public
		$protocol_name;
			 
/*
**************************
*/
 		
	private 
		$errorHandler, // error messages handler			
		$contextMenu; // array with context menu
			 
/*
**************************
*/
 		
	protected		
		$root_directory_id,
		$db_files = 'files',
		$directory_id,
		$address,
		$db_name,
		$api_file_id,
		$fs_prefix,		
		$dir_id;	
			 
/*
**************************
*/
 	
	function __construct()
	{		
		$this->protocol_name = txt('home_mysql_folder');		
		$this->errorHandler = array();		
		$this->prefix = 'db';			
		$this->root_directory_id = 0;
		$this->db_name = 'files';
		
		if($this->directory_id === null)	$this->directory_id = $this->root_directory_id;
	}
			 
/*
**************************
*/
 	
	public function get_filetype($file)
	{
		return 'bmp';	
	}	
			 
/*
**************************
*/
 	
	public function set_root_directory_id($dir_id)
	{
		$this->root_directory_id = $dir_id;	
	}
			 
/*
**************************
*/
 	
	public function set_directory_id($dir_id)
	{
		$this->directory_id = $dir_id;	
	}
			 
/*
**************************
*/
 	
	public function get_root_directory_id()
	{
		return $this->root_directory_id;	
	}
			 
/*
**************************
*/
 	
	public function get_directory_id()
	{
		return $this->directory_id;	
	}
			 
/*
**************************
*/
 	
	public function have_parent($file)
	{		
		global $sql;
		$my_id = logged_id();
		$sql->cond('id_user', $my_id);
		$sql->cond('id_file', $file['dirname']);
		if(defined('DESKTOP'))	$sql->cond('location', 'desktop');
		if($sql->is_row($this->db_name)) return true;
	}	
			 
/*
**************************
*/
 	
	public function new_dir($dirname)
	{
		$my_id = logged_id();
		global $sql;
		
		if(defined('DESKTOP')) 
		{
			$location = 'desktop';
			
		} else {
		
			$location = 'db';
		}
		
		$data = array(
			'id_user' => $my_id,
			'id_parent' => $this->directory_id,
			'is_dir' => 1,
			'created_at' => time(),
			'plugin_id' => 'folder',
			'file_title' => $dirname,
			'location' => $location
		);
		if($sql->add($this->db_name, $data)) 
		{
			console::log(array(
				'@filesystem' => 'new_dir()',	
				'id_user' => $my_id,
				'id_parent' => $this->directory_id,
				'is_dir' => 1,
				'created_at' => time(),
				'plugin_id' => 'folder',
				'file_title' => $dirname,
				'location' => $location
			), 'ok');
			
			return true;	
			
		} else {
			
				console::log(array(
				'@filesystem' => 'new_dir()',	
				'id_user' => $my_id,
				'id_parent' => $this->directory_id,
				'is_dir' => 1,
				'created_at' => time(),
				'plugin_id' => 'folder',
				'file_title' => $dirname,
				'location' => $location
			), 'error');
		}
	}	
			 
/*
**************************
*/
 	
	public function upload_file($file)
	{		
		return true;	
	}
	
			 
/*
**************************
*/
 		
	
	public function get_parent_dir($file)
	{		
		global $sql;
		$my_id = logged_id();
		$sql->cond('id_user', $my_id);
		$sql->cond('id_file', $file);
		
		if(defined('DESKTOP')) {
			$sql->cond('location', 'desktop');
		} else {
			$sql->cond('location', 'db');
		}
		
		$row=$sql->get_row($this->db_name);
		return $row['id_parent'];
	}
			 
/*
**************************
*/
 	
	public function get_parents($file)
	{
		$parents = array();
		
		if($this->have_parent($file))
		{			
			$i=0;
			
			while($this->have_parent($file) && $i < 50)
			{
				$file = $this->get_parent_dir($file);
				$parents[] = $file;
				$i++;
			}	
		}			
		return $parents;		
	}	
			 
/*
**************************
*/
 	
	public function get_file_info($file)
	{
		global $sql;
		$my_id = logged_id();
		$sql->cond('id_user', $my_id);
		$sql->cond('id_file', $file['id']);	
		
		if(defined('DESKTOP')) {
			$sql->cond('location', 'desktop');
		} else {
			$sql->cond('location', 'db');
		}
		
		if(defined('DESKTOP'))	$sql->cond('location', 'desktop');
		$row = $sql->get_row($this->db_name);
		
		$file_info = $row;			
		$file_info['id'] = $row['id_file'];
		$file_info['dirname'] = $row['id_parent'];	
		$file_info['basename'] = $row['file_title'];	
		$file_info['extension'] = $row['plugin_id'];
		$file_info['filename'] = $row['file_title'];				
		$file_info['icon'] = $row['icon'];
		$file_info['app_id'] = $row['app_id'];	
		$file_info['app_action'] = $row['app_action'];	
		$file_info['app_params'] = $row['app_params'];	
		$file_info['plugin_id'] = $row['plugin_id'];	
		$file_info['no_delete'] = $row['no_delete'];
		$file_info['fs'] = 'db_mysql';
		
		if(empty($file_info['modified_at'])) $file_info['modified_at'] = $file_info['created_at'];
		$file_info['created_at'] = date("Y.m.d H:i:s", $file_info['created_at']);
		$file_info['modified_at'] = date("Y.m.d H:i:s", $file_info['modified_at']);
		
		if(!empty($row['content'])) $file_info['content'] = true;	
			
			$params[0] = 'id_file:'.$file_info['id'];
			$params[1] = $file_info['app_params'];
			
			if(!empty($params[1])) 
			{	
				$file_info['app_params'] = implode(',', $params);
				
			} else {
				$file_info['app_params'] = $params[0];
			}
			
		
		
		return $file_info;	
	}	
			 
/*
**************************
*/
 	
	public function get_files_list()
	{				
		$files_array = array();		
		
		global $sql;
		$my_id = logged_id();
		$sql->cond('id_user', $my_id);
		$sql->cond('id_parent', $this->directory_id);
		
		if(defined('DESKTOP')) {
			$sql->cond('location', 'desktop');
		} else {
			$sql->cond('location', 'db');
		}
		
		$records = $sql->records($this->db_name);
		
		$c = count($records);
		if($c != 0)
		{	
			foreach($records as $row)
			{			
				$file_info = $row;			
				$file_info['id'] = $row['id_file'];
				$file_info['dirname'] = $row['id_parent'];				
				$file_info['basename'] = $row['file_title'];			
				$file_info['extension'] = $row['plugin_id'];	
				$file_info['filename'] = $row['file_title'];	
				$file_info['app_id'] = $row['app_id'];	
				$file_info['app_action'] = $row['app_action'];	
				$file_info['app_params'] = $row['app_params'];	
				$file_info['plugin_id'] = $row['plugin_id'];	
				$file_info['no_delete'] = $row['no_delete'];	
				$file_info['fs'] = 'db_mysql';
				
				if(empty($file_info['modified_at'])) $file_info['modified_at'] = $file_info['created_at'];
				$file_info['created_at'] = date("Y.m.d H:i:s", $file_info['created_at']);
				$file_info['modified_at'] = date("Y.m.d H:i:s", $file_info['modified_at']);
				
				if(!empty($row['content'])) $file_info['content'] = true;			
				
				
				$params[0] = 'id_file:'.$file_info['id'];
				$params[1] = $file_info['app_params'];
				
				if(!empty($params[1])) 
				{	
					$file_info['app_params'] = implode(',', $params);
					
				} else {
					$file_info['app_params'] = $params[0];
				}
				
				
				if($row['multilang']) $file_info['filename'] = txt($row['file_title']);
				
				
				if(!empty($row['icon']))
				{			
					$file_info['icon'] = $row['icon'];
				}
				
				$files_array[] = $file_info;	
			}	
		}
		return $files_array;
	}
			 
/*
**************************
*/
 	
	public function is_directory($file)
	{
		if($file['extension'] == 'folder')
		{
			return true;
		}	
	}
			 
/*
**************************
*/
 	
	
	public function set_api_file_id($file_id)
	{
		console::log(array(
				'@filesystem' => 'set_api_file_id()',	
				'file_id' => $file_id
		), 'ok');
		
		$this->api_file_id = $file_id;	
	}	
			 
/*
**************************
*/
 	
	public function get_file_content()
	{
		if(!empty($this->api_file_id))
		{
			$explorerAPI = new phpos_explorerAPI;
			console::log(array(
				'@filesystem' => 'get_file_content()',	
				'file_id' => $this->api_file_id
			), 'ok');
			
			return $explorerAPI->get_db_content($this->api_file_id);
		}	
	}
	
			 
/*
**************************
*/
 	
	public function save_file_content($file_name, $content)
	{
		global $my_app;
		
		$explorerAPI = new phpos_explorerAPI;
		$explorerAPI->set_window_id($my_app->get_param('win_id'));
		$app_data = $explorerAPI->get_cached_app_data();
		
		
		$shortcut = new phpos_shortcuts;		
		$app_params['content'] = 1;
		if(false !== ($record_id = $shortcut->add($file_name, 'app', $app_data['app_id'], $app_data['app_action'], null, $app_params, 'db', $my_app->get_param('dir_id'), $content))) 
		{
			$file['id'] = $record_id;
			console::log(array(
				'@filesystem' => 'save_file_content()',																
				'file_name' => $file_name,
				'file_id' => $record_id,
				'app_id' => $app_data['app_id'],
				'app_action' => $app_data['app_action'],				
				'location' => 'db',
				'parent_id' => $my_app->get_param('dir_id')
			), 'ok');
				
			return $this->get_file_info($file);		
			
		} else {
			
			console::log(array(
				'@filesystem' => 'save_file_content()',																
				'file_name' => $file_name,
				'file_id' => $record_id,
				'app_id' => $app_data['app_id'],
				'app_action' => $app_data['app_action'],				
				'location' => 'db',
				'parent_id' => $my_app->get_param('dir_id')
			), 'error');
		}
	}
			 
/*
**************************
*/
 	
	public function update_file_content($file_info, $content)
	{
		if(!empty($file_info['id']))
		{
			$shortcut = new phpos_shortcuts;		
			
			if($shortcut->update_content($file_info['id'], $content)) 
			{
				console::log(array(
				'@filesystem' => 'update_file_content()',																
				'file_id' => $file_info['id']
				), 'ok');
				
				return true;
				
			} else {
			
				console::log(array(
				'@filesystem' => 'update_file_content()',																
				'file_id' => $file_info['id']
				), 'error');
				
				return false;
			}
		}
	}
	
			 
/*
**************************
*/
 	
		
	public function get_action_dblclick($file)
	{
		if($this->is_directory($file))
		{
			if(!defined('DESKTOP')) {
				return helper_reload(array('reset_shared' => 0, 'dir_id' => $file['id']));	
			} else {
				return winopen($file['basename'], 'app', 'app_id:explorer@index', 'fs:db_mysql,dir_id:'.$file['id']);
			}
			
		} else {
			
			$filedata = $this->get_file_info($file);
		
			
			$action = "phpos.windowCreate('".$filedata['basename']."','".$filedata['app_id']."', '".$filedata['win_params']."', '".$filedata['app_params']."');";
			
			$app_action = 'app_id:'.$filedata['app_id'].'@'.$filedata['app_action'];
			$action = winopen(txt($filedata['basename']), $filedata['plugin_id'], $app_action, $filedata['app_params']);
					
			return $action;			
		}
	}
			 
/*
**************************
*/
 	
	public function delete($id_file)
	{
		global $sql;
		$my_id = logged_id();
		$sql->cond('id_user', $my_id);
		$sql->cond('id_file', $id_file);
		
		if($sql->delete($this->db_name)) 
		{
			console::log(array(
				'@filesystem' => 'delete()',	
				'file_id' => $id_file
				), 'ok');
				
			return true;	
			
		} else {
			
			console::log(array(
				'@filesystem' => 'delete()',	
				'file_id' => $id_file
			), 'error');
		}
	}
			 
/*
**************************
*/
 	
	public function rename($id_file, $new_name)
	{
		global $sql;
		$my_id = logged_id();
		$sql->cond('id_user', $my_id);
		$sql->cond('id_file', $id_file);
		$items = array(
			'file_title' => $new_name
		);
		if($sql->update($this->db_name, $items)) 
		{
			console::log(array(
				'@filesystem' => 'rename()',	
				'file_id' => $id_file,
				'new_name' => $new_name
			), 'ok');
			
			return true;
			
		} else {
			
			console::log(array(
				'@filesystem' => 'rename()',	
				'file_id' => $id_file,
				'new_name' => $new_name
			), 'error');
		}
	}
	
			 
/*
**************************
*/
 	
	
	public function get_icon($file)
	{	
		global $explorer;
		$shortcut = new phpos_shortcuts;
		
		
		if(empty($file['icon']))
		{
			if($this->is_directory($file)) 
			{
				$icon_image = $explorer->config('filetypes_icons_folder_url').'folder.png'; 
				
			} else {					
			
					$shortcut = new phpos_shortcuts;
					return $shortcut->link_icon($file['extension'], $file['app_id'], null, $file['app_action']);
				
				if(file_exists($explorer->config('filetypes_icons_folder_dir').$file['extension'].'.png'))
				{
					$icon_image = $explorer->config('filetypes_icons_folder_url').$file['extension'].'.png';
				} else {
					$icon_image = $explorer->config('filetypes_icons_folder_url').'default.png';
				}
			}				
		
		} else {			
				
			$user_icons = new phpos_icons;
			$user_icons_dir = $user_icons->get_icons_dir();
			$user_icons_url = $user_icons->get_icons_url();
				
			if(file_exists($user_icons_dir.$file['icon'])) 
			{
				$icon_image = $user_icons_url.$file['icon'];
				
			} else {
			
				if(file_exists(PHPOS_WEBROOT_DIR.'_phpos/icons/'.$file['icon'])) 
				{
					$icon_image = PHPOS_WEBROOT_URL.'_phpos/icons/'.$file['icon'];
				} else {
					$icon_image = PHPOS_WEBROOT_URL.'_phpos/icons/default.png';
				}
			}
			
			
		}		
			
		return $icon_image; // @returns full url
	}	
			 
/*
**************************
*/
 	
	
	public function get_address()
	{
		if($this->have_parent($this->directory_id))
		{
			$parents = $this->get_parents($this->directory_id);
			asort($parents);		
			
			$c = count($parents);
			
			$items= array();
			for($i=0; $i<$c; $i++)
			{	
				if($parents[$i] != $this->root_directory_id)
				{
					$items[] = basename($parents[$i]);					
				}
			}							
		}		
		
		$address = str_replace($this->root_directory_id.'/', '', $this->directory_id);
		$address = $this->prefix.'://'.str_replace($this->root_directory_id, '', $address);			
		return $address;	
	}
			 
/*
**************************
*/
 	
	public function set_address()
	{
	
	
	}
		 
/*
**************************
*/
 	
	public function clipboard_paste($to_dir_id = null, $mode = 'copy')
	{
	 $clipboard = new phpos_clipboard;		
	 $clipboard->get_clipboard();			
	 $id_file = $clipboard->get_file_id();			
	 $fs = $clipboard->get_file_fs();			
		
	 global $sql, $my_app;
	 
	 $location = 'db';
	 if($my_app->get_param('desktop_location') !== null) $location = 'desktop';
		
		switch($mode)
		{
			case 'copy':		
		
				$sql->cond('id_file', $id_file);
				$row = $sql->get_row($this->db_files);					
				
				$items = array(
				'file_title' => $row['file_title'],
				'plugin_id' => $row['plugin_id'],
				'location' => $location,
				'app_id' => $row['app_id'],
				'app_action' => $row['app_action'],
				'win_params' => $row['win_params'],
				'app_params' => $row['app_params'],
				'id_parent' => $to_dir_id,
				'id_user' => $row['id_user'],
				'created_at' => time(),
				'modified_at' => time(),
				'is_dir' => $row['is_dir'],
				'content' => $row['content'],
				'multilang' =>  $row['multilang']		
				);			
				
				if(false !== $sql->add($this->db_files, $items))	
				{
					$log = array(
					'@filesystem' => 'clipboard_paste()',	
					'file_id' => $id_file,
					'mode' => 'copy',
					'to_dir_id' => $to_dir_id
					);
					
					//$full_log = array_merge($log, $items);					
					console::log($log, 'ok');
			
					return true;	
				
				} else {
					
					$log = array(
					'@filesystem' => 'clipboard_paste()',	
					'file_id' => $id_file,
					'mode' => 'copy',
					'to_dir_id' => $to_dir_id
					);
					
					//$full_log = array_merge($log, $items);					
					console::log($log, 'error');
				}

			break;
			
			case 'cut':
			
				$sql->cond('id_file', $id_file);
				$items = array(
					'id_parent' => $to_dir_id,
					'location' => $location
				);
				
				if($sql->update($this->db_files, $items))	
				{
					$log = array(
					'@filesystem' => 'clipboard_paste()',	
					'file_id' => $id_file,
					'to_location' => $location,
					'mode' => 'cut',					
					'to_dir_id' => $to_dir_id
					);								
					console::log($log, 'ok');
					
					$clipboard->reset_clipboard();		
					return true;
					
				} else {
					
					$log = array(
					'@filesystem' => 'clipboard_paste()',	
					'file_id' => $id_file,	
					'to_location' => $location,
					'mode' => 'cut',					
					'to_dir_id' => $to_dir_id
					);								
					console::log($log, 'error');
				}
			
			break;
		}		
	}
			 
/*
**************************
*/
 	
	
	public function clipboard_copy()
	{
		$clipboard = new phpos_clipboard;
		$clipboard->set_mode('copy');
		$clipboard->set_name(basename(param('action_param')));
		$clipboard->set_server(false);
		if($clipboard->add_clipboard(param('action_param'), param('action_param2'), null)) return true;	
	}	
			 
/*
**************************
*/
 	
	public function clipboard_cut()
	{
		$clipboard = new phpos_clipboard;
		$clipboard->set_mode('cut');
		$clipboard->set_source_win(WIN_ID);
		$clipboard->set_name(basename(param('action_param')));
		$clipboard->set_server(false);
		if($clipboard->add_clipboard(param('action_param'), param('action_param2'), null)) return true;	
	}
	
}
?>