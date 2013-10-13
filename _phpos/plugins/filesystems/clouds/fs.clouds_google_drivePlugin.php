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
	 
/*
**************************
*/
 
class phpos_fs_plugin_clouds_google_drive extends phpos_filesystems
{

                                                                             
	public
		$protocol_name;
		 
/*
**************************
*/
 	
	private 
		$errorHandler, // error messages handler			
		$contextMenu, // array with context menu
		$ftp_host,
		$ftp_login,
		$ftp_pass,
		$ftp_mode,
		$connected,
		$logged,
		$ftp,
		$conn_id,
		$connection_status,
		$ftp_remote_dir;
		 
/*
**************************
*/
 	
	protected		
		$root_directory_id,
		$directory_id,
		$address,
		$fs_prefix,	
		$client,
		$cloud,
		$service,
		$google_drive_files,
		$dir_id;	
	 
/*
**************************
*/
 	
	function __construct($cloud_id = null)
	{		
		global $my_app;
		
		if($my_app->get_param('cloud_id') != null)
		{					
			$this->cloud = new phpos_clouds;
			$this->cloud->set_id($my_app->get_param('cloud_id'));
			$this->cloud->get_cloud();				
			
			$this->protocol_name = txt('fs_cloud_gdrive');		 	 
			$this->errorHandler = array();		
			$this->prefix = 'google_drive';	
			
			require_once PHPOS_DIR.'classes/google-api-php-client/src/Google_Client.php';
			require_once PHPOS_DIR.'classes/google-api-php-client/src/contrib/Google_DriveService.php';
			$this->client = new Google_Client();
			// Get your credentials from the APIs Console
			$this->client->setClientId($this->cloud->get_login());
			$this->client->setClientSecret($this->cloud->get_password());
			$this->client->setRedirectUri($this->cloud->get_url());
			$this->client->setScopes(array('https://www.googleapis.com/auth/drive'));			

			// Exchange authorization code for access token
			//$plus = new Google_PlusService($client);

			if(isset($_SESSION['google_token'])) {
				$_GET['code'] = $_SESSION['google_token'];
				$this->client->authenticate();
				$_SESSION['token'] = $this->client->getAccessToken();
				$redirect = $_SESSION['PHPOS_NETURL'];
				//unset($_SESSION['google_token']);
				header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
			}

			if (isset($_SESSION['token'])) {
				$this->client->setAccessToken($_SESSION['token']);
			}

			if ($this->client->getAccessToken()) {
				
				echo 'Connected to your google account.<br />';
				//$activities = $plus->activities->listActivities('me', 'public');
				//print 'Your Activities: <pre>' . print_r($activities, true) . '</pre>';

				// We're not done yet. Remember to update the cached access token.
				// Remember to replace $_SESSION with a real database or memcached.
				$_SESSION['token'] = $this->client->getAccessToken();
			} else {
				$authUrl = $this->client->createAuthUrl();
				echo "<a href='$authUrl'>Connect Me!</a>";
			}
			
			
			}		
		
	}
		
/*
**************************
*/
 
	public function set_status($str)
	{
		$this->connection_status = $str;	
	}
	
	
	
	public function get_status()
	{
		//print_r($this);
		return $this->conn_id;	
	}
	
	public function get_conn_id()
	{
		//print_r($this);
		return $this->conn_id;	
	}
	
	public function connect()
	{
		
			$this->conn_id = @ftp_connect($this->ftp->get_host()); 			
		
			 //msg::error('FTP: Error connection to server');
		
		
			if($this->conn !== FALSE)
			{		
				
				$this->connected = 1;
				//msg::ok('FTP: Connected to: '.$this->ftp->get_host());
				
				$login_result = @ftp_login($this->conn_id, $this->ftp->get_login(), $this->ftp->get_password()); 
				if($login_result !== FALSE)
				{	
					//msg::ok('FTP: Logged as: '.$this->ftp->get_login());
					$this->logged = 1;	
					$this->connection_status = 'connected';
					return true;
					
				} else {
					
					$this->connection_status = $login_result;
					msg::error('FTP: Login incorrect');
					$this->logged = 0;				
				}
				
			} else {
			
				$this->connected = 0;
				$this->connection_status = 'cccccccccccccconnected';
				msg::error('FTP: Error connection to server');
				return false;
			}	
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
		if(!empty($file['dirname']) && $this->directory_id != '.')
		{
			return true;
		}
	}	
		 
/*
**************************
*/
 
	public function get_parent_dir($file)
	{
		//$pathinfo =  pathinfo($file);		
		return $file['dirname'];	
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
		$file_info['id'] = $file['id'];					
		$f = $this->google_drive_files[$file['id']];					
		
		$file_info['file_id'] = $f['id'];
		
		if($f['parents'][0]['isRoot'] != 1)	$file_info['dirname'] = $f['parents'][0]['id'];						
		
		$file_info['basename'] = $f['title'];	
		$file_info['extension'] = $f['mimeType'];	
		$file_info['filename'] = $f['title'];				
		$file_info['modified_at'] = 0;
		$file_info['created_at'] = 0;
		$file_info['chmod'] = 0;
		if($f['mimeType'] != 'application/vnd.google-apps.folder')	$file_info['icon'] = $f['iconLink'];	

		return $file_info;	
	}	
		 
/*
**************************
*/
 
	public function get_files_list()
	{	
		
		$files_array = array();		
		
		$service = new Google_DriveService($this->client);
		$lista = @$service->files->list();
	//echo '<pre>';
	//print_r($lista);
	//echo '</pre>';

		$c = count($lista['items']);
		if($c != 0)
		{
			$this->google_drive_files = $lista['items'];
			$i = 0;
			foreach($lista['items'] as $f)
			{
								
					$file_info = array();				
					
					$file_info['id'] = $i;
					$file_info['file_id'] = $f['id'];
					
					if($f['parents'][0]['isRoot'] != 1)	$file_info['dirname'] = $f['parents'][0]['id'];						
					
					$file_info['basename'] = $f['title'];	
					$file_info['extension'] = $f['mimeType'];	
					$file_info['filename'] = $f['title'];				
					$file_info['modified_at'] = 0;
					$file_info['created_at'] = 0;
					$file_info['chmod'] = 0;
					if($f['mimeType'] != 'application/vnd.google-apps.folder')	$file_info['icon'] = $f['iconLink'];		
				
					
					if($this->directory_id == '.')
					{					
						if($f['parents'][0]['isRoot'] == 1)
						{				
							if($f['mimeType'] == 'application/vnd.google-apps.folder')
							{
								$list_dirs[] = $file_info;
							} else {
							
								$list_files[] = $file_info;
							}		

						}
						
					} else {
						
						$parent = $this->google_drive_files[$this->directory_id];
						$parent_id = $parent['id'];
						
						if($f['parents'][0]['id'] == $parent_id)
						{
							if($f['mimeType'] == 'application/vnd.google-apps.folder')
							{
								$list_dirs[] = $file_info;
							} else {
							
								$list_files[] = $file_info;
							}		
						}					
					}
					
					if($f['mimeType'] == 'application/vnd.google-apps.folder')
					{
						//echo '<img src="'.$f['iconLink'].'">FOLDER: <a href="'.$f['webContentLink'].'" target="_blank">'.$f['title'].'</a><br>';
					} else {
						//echo '<img src="'.$f['iconLink'].'"><a href="'.$f['webContentLink'].'" target="_blank">'.$f['title'].'</a><br>';
					}
					
				
			$i++;
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
 
 public function connect_status()
 {
	
	return $this->connection_status;
 
 }
 
	public function new_dir($dirname)
	{
			global $my_app;
			$dir = $my_app->get_param('dir_id');		
			
			if(ftp_mkdir($this->conn_id, $dir.'/'.$dirname)) return true;	
	}	
 
 
 
 
 
	public function is_directory($file)
	{
		$f = $file;
		if(is_array($file)) $f = $file['id'];			
		if($this->google_drive_files[$f]['mimeType'] == 'application/vnd.google-apps.folder')	 return true;
	}
		 
/*
**************************
*/
 
	public function get_action_dblclick($file)
	{
		if($this->is_directory($file))
		{
			return helper_reload(array('shared_id' => 0, 'reset_shared' => 0, 'dir_id' => $file['id']));	
		} else {
			
			$f = $this->google_drive_files[$file['id']];			
			
			return "window.open('".$f['webContentLink']."', '_blank');";	
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
		
			$icon_image = $file['icon'];		
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

	
		public function rename($id_file, $new_name)
	{
		//$dir = dirname($id_file);		
		global $my_app;
		$dir = $my_app->get_param('dir_id');
		$_SESSION['ftp'] = 'conn:'.$this->conn_id.'  dir:'.$dir.'/'.$id_file.' to:'.$dir.'/'.$new_name;
		if(ftp_rename($this->conn_id, $id_file, $dir.'/'.$new_name)) return true;
	}
	
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
            unlink($file);
        }
    }
    rmdir($path);
	}
	
	
	
	public function delete($id_file)
	{		
		if(ftp_delete($this->conn_id, $id_file)) return true;		
	}
	
	public function upload_file($file)
	{					
		global $my_app;
		$dir = $my_app->get_param('dir_id');		
		if(ftp_put($this->conn_id, $dir.'/'.$file['name'], $file['tmp_name'], FTP_BINARY)) return true;			
	}
	
	public function copy($to_dir_id = null)
	{
		 $clipboard = new phpos_clipboard;		
		 $clipboard->get_clipboard();			
		 $id_file = $clipboard->get_file_id();			
		 $fs = $clipboard->get_file_fs();
				
				
		switch($fs)
		 { 
			case 'ftp':
			
			 $tmp_name = base64_encode($id_file);			 
			 if(ftp_get($this->conn_id, PHPOS_TEMP.$tmp_name, $id_file, FTP_BINARY))
			 { 				
				$basename = basename($id_file);
				
				if(ftp_put($this->conn_id, $to_dir_id.'/'.$basename , PHPOS_TEMP.$tmp_name , FTP_BINARY))
				{ 
					if(file_exists(PHPOS_TEMP.$tmp_name)) unlink(PHPOS_TEMP.$tmp_name); 
					$clipboard->reset_clipboard();						
					return true;
					
					
				} else {   
				
					return false; 
				} 			
			}		
			break;
			
			case 'local_files':
			
			 $tmp_name = base64_encode($id_file);			 
			  				
				$basename = basename($id_file);
				
				if(ftp_put($this->conn_id, $to_dir_id.'/'.$basename , $id_file , FTP_BINARY))
				{ 
					if(file_exists(PHPOS_TEMP.$tmp_name)) unlink(PHPOS_TEMP.$tmp_name);  
					$clipboard->reset_clipboard();							
					return true;
					
				} else {   
				
					return false; 
				} 		
				
			break;
			
			
		}
		
	}
	
	
}
?>