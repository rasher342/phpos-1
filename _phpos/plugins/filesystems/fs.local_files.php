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


if(!defined('PHPOS_IN_EXPLORER'))
{
	die();
}

class phpos_fs_plugin_local_files extends phpos_filesystems
{
                                                                               
	public
		$protocol_name;
				 
/*
**************************
*/
 	
	private 
		$errorHandler = null, // error messages handler			
		$contextMenu; // array with context menu
				 
/*
**************************
*/
 	
	protected		
		$root_directory_id,
		$directory_id,
		$api_file_id,
		$address,
		$fs_prefix,		
		$dir_id;	
			 
/*
**************************
*/
 	
	function __construct()
	{		
		$this->protocol_name = txt('home_local_folder');		 	 
		$this->errorHandler = array();		
		$this->prefix = 'home';	
		
		global $my_user;			
		$dir_hash = $my_user->get_home_dir_hash();
		$home_dir = PHPOS_HOME_DIR.$dir_hash;		
		if(is_dir($home_dir)) 
		{
			$this->root_directory_id = $home_dir;		
		}		
		/*
		if($my_user->get_user_type() == 3)
		{
			$this->root_directory_id = PHPOS_WEBROOT_DIR.'home';
		}		
		*/
		
		if(empty($this->directory_id))
		{
			if(is_dir($this->root_directory_id))	$this->directory_id = $this->root_directory_id;
		}		
		
		if(empty($this->directory_id) || empty($this->root_directory_id))	$this->errorHandler = 1;
		
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
		if(dirname($file) != dirname($this->root_directory_id))
		{
			return true;
		}
	}	
			 
/*
**************************
*/
 	
	public function new_dir($dirname)
	{
		if(mkdir($this->directory_id.'/'.$dirname, 0777)) 
		{
			$file = '<?php die(); ?>';
			if(!@file_put_contents($this->directory_id.'/'.$dirname.'/index.php', $file)) return false;		
			return true;	
		}		
	}	
			 
/*
**************************
*/
 	
	public function upload_file($file)
	{		
		$target_path = $this->directory_id.'/'.basename($file['name']); 
		if(move_uploaded_file($file['tmp_name'], $target_path)) return true;	
	}
	
			 
/*
**************************
*/
 	
	public function get_parent_dir($file)
	{
		if(!$this->errorHandler)
		{
			$pathinfo =  pathinfo($file);		
			return $pathinfo['dirname'];	
		}
	}
			 
/*
**************************
*/
 	
	public function get_parents($file)
	{
		if(!$this->errorHandler)
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
	}	
			 
/*
**************************
*/
 	
	public function get_file_info($file)
	{
		$pathinfo =  pathinfo($file);
		$file_info['id'] = $file;
		$file_info['dirname'] = $pathinfo['dirname'];	
		$file_info['basename'] = $pathinfo['basename'];	
		$file_info['extension'] = $pathinfo['extension'];	
		$file_info['filename'] = $pathinfo['filename'];		
		$file_info['modified_at'] = @filemtime($file);
		$file_info['created_at'] = @filectime($file);
		$file_info['chmod'] = @fileperms($file);
		$file_info['fs'] = 'local_files';
		$file_info['icon'] = '';			
		return $file_info;	
	}	
			 
/*
**************************
*/
 	
	public function get_files_list()
	{		
		if(!$this->errorHandler)
		{
			$path = $this->directory_id.'/*';		
			$directory = glob($path);
			
			$list_dirs = array();
			$list_files = array();
			
			$files_array = array();
			foreach($directory as $file)
			{			
				$file_info = array();
				$pathinfo =  pathinfo($file);
				
				$file_info['id'] = $file;
				$file_info['dirname'] = $pathinfo['dirname'];	
				$file_info['basename'] = $pathinfo['basename'];	
				$file_info['extension'] = $pathinfo['extension'];	
				$file_info['filename'] = $pathinfo['filename'];		
				$file_info['modified_at'] = @filemtime($file);
				$file_info['created_at'] = @filectime($file);
				$file_info['chmod'] = @fileperms($file);
				$file_info['fs'] = 'local_files';
				$file_info['icon'] = '';
				
				$files_array[] = $file_info;
				
					if($this->is_directory($file_info))
					{
						$list_dirs[] = $file_info;
					} else {
					
						$list_files[] = $file_info;
					}
					
				
				}		
				array_sort($list_dirs, 'basename');
				array_sort($list_files, 'basename');
				
				$all_files = array_merge($list_dirs, $list_files);
				
				return $all_files;
			
		}
	}
		 
/*
**************************
*/
 		
	public function is_directory($file)
	{
		if(is_dir($file['id']))
		{			
			return true;
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
				return helper_reload(array('shared_id' => 0,'reset_shared' => 0, 'dir_id' => $file['id']));	
			} else {
				return winopen($file['basename'], 'app', 'app_id:explorer@index', 'shared_id:0,reset_shared:0,fs:local_files,dir_id:'.$file['id']);
			}			
			
		} else {
			
			return 'explorer_open_in_browser("'.$file['id'].'");';	
		}
	}
			 
/*
**************************
*/
 	
	public function rename($id_file, $new_name)
	{
		$dir = dirname($id_file);		
		if(rename($id_file, $dir.'/'.$new_name)) return true;
	}
			 
/*
**************************
*/
 	
	public static function deleteDir($path) {
    if (!is_dir($path)) {
        return false;
    }
    if (substr($path, strlen($path) - 1, 1) != '/') {
        $path .= '/';
    }
		
    $dotfiles = glob($path . '.*', GLOB_MARK);
    $files = glob($path . '*', GLOB_MARK);
    $files = array_merge($files, $dotfiles);
    foreach ($files as $file) {
        if (basename($file) == '.' || basename($file) == '..') {
            continue;
        } else if (is_dir($file)) {
            self::deleteDir($file);
        } else {
            @unlink($file);
        }
    }
    rmdir($path);
	}
	
	
			 
/*
**************************
*/
 	
	
	public function delete($id_file)
	{		
		if(is_dir($id_file))
		{			
			self::deleteDir($id_file);
			return true;
			
		} else {		
		
			if(@unlink($id_file)) return true;
		}
	}
	
			 
/*
**************************
*/
 	
	
	public function get_icon($file)
	{	
		global $explorer;
		
		if(empty($file['icon']))
		{
			if($this->is_directory($file)) 
			{
				$icon_image = $explorer->config('filetypes_icons_folder_url').'folder.png'; 
				
			} else {					
			
				if(file_exists($explorer->config('filetypes_icons_folder_dir').$file['extension'].'.png'))
				{
					$icon_image = $explorer->config('filetypes_icons_folder_url').$file['extension'].'.png';
				} else {
					$icon_image = $explorer->config('filetypes_icons_folder_url').'default.png';
				}
			}				
		
		} else {
			$icon_image = PHPOS_WEBROOT_URL.'_phpos/icons/'.$file['icon'];		
		}		
			
		return $icon_image; // @returns full url
	}	
			 
/*
**************************
*/
 	
	public function set_api_file_id($file_id)
	{
		$this->api_file_id = $file_id;	
	}
	
			 
/*
**************************
*/
 	
	
	public function get_file_content()
	{
		if(file_exists($this->api_file_id))
		{
			$f = file_get_contents($this->api_file_id);
			return $f;		
		}	
	}
			 
/*
**************************
*/
 	
	
	public function save_file_content($file_name, $content)
	{
		if(file_put_contents($this->directory_id.'/'.$file_name, $content)) 
		{
			return $this->get_file_info($this->directory_id.'/'.$file_name);
			
		} else {
		
			return false;
		}
	}
	
	
			 
/*
**************************
*/
 	
	
	
	
	
	public function update_file_content($file_info, $content)
	{
		if(!empty($file_info['id']))
		{
			if(file_put_contents($file_info['id'], $content)) 
			{
				return true;
				
			} else {
			
				return false;
			}
		}
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
 	
	public function recurse_copy($src, $dst) 
	{     
		 
		 $dir = opendir($src); 
		 
    @mkdir($dst, 0777); 
    while(false !== ( $file = readdir($dir)) ) { 
        if (( $file != '.' ) && ( $file != '..' )) { 
            if ( is_dir($src . '/' . $file) ) { 
                $this->recurse_copy($src . '/' . $file,$dst . '/' . $file); 
            } 
            else { 
                copy($src . '/' . $file,$dst . '/' . $file); 
            } 
        } 
    } 
    closedir($dir); 
		
		return true;
} 
	
			 
/*
**************************
*/
 	
	
	
	public function copy($to_dir_id = null)
	{
		 $clipboard = new phpos_clipboard;		
		 $clipboard->get_clipboard();			
		 $id_file = $clipboard->get_file_id();			
		 $fs = $clipboard->get_file_fs();				
				
		switch($fs)
		{ 
			case 'ftp':			
			
			$clipboard->get_clipboard();				
			$ftp_connect = new phpos_fs_plugin_ftp($clipboard->get_file_connect_id());		
			 
			 if(ftp_get($ftp_connect->get_conn_id(), $to_dir_id.'/'.$id_file, $id_file, FTP_BINARY))
			 { 
					$clipboard->reset_clipboard();						
					return true;
			 }
		 	
			break;
			
			case 'local_files':					 
			  				
				$basename = basename($id_file);			
				
				if(!is_dir($id_file))
				{						
					if(copy($id_file, $to_dir_id.'/'.$basename))
					{ 				
						$clipboard->reset_clipboard();							
						return true;
						
					} else {  
					
						$clipboard->reset_clipboard();	
						return false; 
					} 	
				
				} else {
					
					$to_dir = $to_dir_id.'/'.$basename;
					mkdir($to_dir, 0777);
					$clipboard->reset_clipboard();					
					if($this->recurse_copy($id_file, $to_dir)) return true;
				}
				
			break;			
		}		
	}
	
	public function cut($to_dir_id = null)
	{
		 $clipboard = new phpos_clipboard;		
		 $clipboard->get_clipboard();			
		 $id_file = $clipboard->get_file_id();			
		 $fs = $clipboard->get_file_fs();				
				
		switch($fs)
		{ 
			case 'ftp':			
			
			$clipboard->get_clipboard();				
			$ftp_connect = new phpos_fs_plugin_ftp($clipboard->get_file_connect_id());		
			 
			// unlink ftp add
			if(ftp_get($ftp_connect->get_conn_id(), $to_dir_id.'/'.$id_file, $id_file, FTP_BINARY))
			{ 
					if(ftp_delete($ftp_connect->get_conn_id(), $id_file))
					{
						$clipboard->reset_clipboard();						
						return true;
					}
			 }
		 	
			break;
			
			case 'local_files':					 
			  				
				$basename = basename($id_file);			
				
										
					if(rename($id_file, $to_dir_id.'/'.$basename))
					{ 				
						$clipboard->reset_clipboard();							
						return true;
						
					} else {  
					
						$clipboard->reset_clipboard();	
						return false; 
					} 				
				
			break;			
		}		
	}
	
	
}
?>