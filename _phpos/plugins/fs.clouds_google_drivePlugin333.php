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
		$authUrl,
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
		
		
			$this->connect();		
			$this->set_root_directory_id('.');
		
	}
		
/*
**************************
*/
 
	public function set_status($str)
	{
		$this->connection_status = $str;	
	}
	
	public function set_authUrl($authUrl)
	{
		$this->authUrl = $authUrl;	
	}
	
	public function get_authUrl()
	{
		return $this->authUrl;	
	}
			
/*
**************************
*/
 
	public function is_connected()
	{		
		return $this->connected;	
	}	
			
/*
**************************
*/
 
	public function get_status()
	{		
		return $this->connection_status;	
	}	
			
/*
**************************
*/
 
	public function connect()
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

			
			try 
			{
				if(isset($_SESSION['google_token'])) 
				{
						$_GET['code'] = $_SESSION['google_token'];
						$this->client->authenticate();
						$_SESSION['token'] = $this->client->getAccessToken();
						$redirect = $this->cloud->get_url();
						unset($_SESSION['google_token']);
						//header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
				}
			}	catch (Exception $e) 
			{
					$this->connected = false;		
					$this->set_status($e->getMessage());
					$this->set_authUrl($this->client->createAuthUrl());
			}
			
			
			if(isset($_SESSION['token'])) 
			{			
				try 
				{				
					$this->client->setAccessToken($_SESSION['token']);
					
				}	catch (Exception $e) 
				{				
					$this->connected = false;		
					$this->set_status($e->getMessage());				
					$this->set_authUrl($this->client->createAuthUrl());
				}			
			}			
			
			if($this->client->getAccessToken()) 
			{				
				try 
				{					
					$this->connected = true;
					//$this->set_status('Token get ok');							
					$this->set_authUrl($this->client->createAuthUrl());
					$_SESSION['token'] = $this->client->getAccessToken();	
												
					//$this->get_filelist();	
					
				}	catch (Exception $e) 
				{
					$this->connected = false;		
					$this->set_status($e->getMessage());
			  	$this->set_authUrl($this->client->createAuthUrl());
				}
				
				
			} else {
				
				$this->connected = false;				
				$this->set_authUrl($this->client->createAuthUrl());				
			}	
			
				
			
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
		//echo 'dir_id:'.$this->directory_id.'<br>';
		return $this->directory_id;	
	}
		 
/*
**************************
*/
 
	public function have_parent($file)
	{		
		if($this->directory_id == '.') return false;		
		
		if(!empty($file['dirname']))
		{
			return true;
		}
		
	
		//echo 'ma';
		$fileinfo = $this->get_file_info($file);
		if(!empty($fileinfo['dirname'])) return true;
	}	
		 
/*
**************************
*/
 
	public function get_filelist()
	{
		if(!is_array($this->google_drive_files) || empty($this->google_drive_files[0])) 
		{
			try {			
			$this->service = new Google_DriveService($this->client);	
			
			$parameters = array();     
      $parameters['maxResults'] = 100;
			//$parameters['projection'] = 'BASIC';
			
			$q = 'root';
			if($this->directory_id != '.') 
			{
				$dirinfo = $this->get_file_info($this->directory_id);
				$q = $dirinfo['file_id'];			
			}
			
			
			//$parameters['q'] = '\''.$q.'\' in parents';		
			
			$filelist = @$this->service->files->list();
			$this->connected = true;
			}	catch (Exception $e) 
			{
					$this->connected = false;		
					$this->set_status($e->getMessage());
					$this->set_authUrl($this->client->createAuthUrl());
			}
			
			
			// debug
			//echo '<pre>';
			//print_r($filelist);
			//echo '</pre>';

			$c = count($filelist['items']);
			if($c != 0)
			{
				$this->google_drive_files = $filelist['items'];		
			}
			
		}		
	
		
		
		
	} 
 
 
	public function get_parent_dir($file)
	{		
		$this->get_filelist();
		$i = 0;
		
		$a['id'] = $file;			
		
		$fileinfo = $this->get_file_info($a);
		$parent_id = $fileinfo['dirname'];
		
		// debug
			//echo '<pre>';
			//print_r($fileinfo);
			//echo '</pre>';
		if(is_array($this->google_drive_files))
		{		
			foreach($this->google_drive_files as $f)
			{	
				if($f['id'] == $parent_id) return $i;
				$i++;
			}	
		}
		
		return '.';
	}
		 
	function printParents($fileId) {
  try {
    $parents = $this->service->parents->listParents($fileId);

    foreach ($parents->getItems() as $parent) {
      print 'File Id: ' . $parent->getId();
    }
  } catch (Exception $e) {
    print "An error occurred: " . $e->getMessage();
  }
}	 
		 
		 
/*
**************************
*/
 
	public function get_parents($file)
	{
		$this->get_filelist();
		$parents = array();
		//echo '<br>file:'.$file.'<br><br>';
		if($this->have_parent($file))
		{			
			//echo '<br>maparenta:'.$file.'<br><br>';
			
			$i=0;
			while($this->have_parent($file) && $i < 50)
			{
				$file = $this->get_parent_dir($file);
			
				if($file != ".") 
				{
						//echo '<br>pobieram parenta, pobrano: '.$file.'<br>';
						$parents[] = $file;
					
				}
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
	  $this->get_filelist();
		if(is_array($file))
		{
			$f_id = $file['id'];			
		
		} else {
		
			$f_id = $file;			
		}
		
		$file_info['id'] = $f_id;	
		//echo $file['id'].',';
		$f = $this->google_drive_files[$f_id];					
		
		$file_info['file_id'] = $f['id'];
		
		if($f['parents'][0]['isRoot'] != 1)	$file_info['dirname'] = $f['parents'][0]['id'];						
		
		$file_info['basename'] = $f['title'];	
		$file_info['extension'] = $f['mimeType'];	
		$file_info['filename'] = $f['title'];				
		$file_info['modified_at'] = $f['modifiedDate'];
		$file_info['created_at'] = $f['createdDate'];
		$file_info['chmod'] = $f['owners'][0]['permissionId'];
		if($f['mimeType'] != 'application/vnd.google-apps.folder')	$file_info['icon'] = $f['iconLink'];	

		return $file_info;	
	}	
		 
/*
**************************
*/
 
	public function get_files_list()
	{		
		$files_array = array();		
		$this->get_filelist();
		
		$c = count($this->google_drive_files);
		if($c != 0)
		{		
			$i = 0;
			foreach($this->google_drive_files as $f)
			{								
				$file_info = array();				
				
				$file_info['id'] = $i;
				$file_info['file_id'] = $f['id'];
				
				if($f['parents'][0]['isRoot'] != 1)	$file_info['dirname'] = $f['parents'][0]['id'];						
				
				$file_info['basename'] = $f['title'];	
				$file_info['extension'] = $f['mimeType'];	
				$file_info['filename'] = $f['title'];				
				$file_info['modified_at'] = $f['modifiedDate'];
				$file_info['created_at'] = $f['createdDate'];
				$file_info['chmod'] = $f['owners'][0]['permissionId'];
				if($f['mimeType'] != 'application/vnd.google-apps.folder')	$file_info['icon'] = $f['iconLink'];			
				$a = 1;
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
			
				$i++;
			}
			
				if(is_array($list_dirs)) 
				{
					array_sort($list_dirs, 'basename');
					
				} else {
				
					$list_dirs = array();
				}
				
				if(is_array($list_files)) 
				{
					array_sort($list_files, 'basename');	
					
				} else {
				
					$list_files = array();
				}				
				
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
	
	public function upload_file($file_upload)
	{					
		global $my_app;
		$dir = $my_app->get_param('dir_id');			
		$target_path = PHPOS_TEMP.basename($file_upload['name']); 
		if(move_uploaded_file($file_upload['tmp_name'], $target_path)) {
			echo '<script>alert("'.PHPOS_TEMP.basename($file_upload['name']).'  mime:'.$file_upload["type"].'");</script>';
			
			
		// upload to google
				$dir_google_id = null;
				if($this->directory_id != '.')
				{
					$this->get_filelist();
					$dir_info = $this->get_file_info($this->directory_id);
					$dir_google_id = $dir_info['file_id'];			
					//$ref = $service->files->get($dir_google_id);
				}
				
				
			$service = new Google_DriveService($this->client);		
		  $file = new Google_DriveFile();
			
			$file->setTitle(basename($file_upload['name']));
			$file->setDescription('Uploaded from PHPOS');
			$file->setMimeType($file_upload["type"]);

			
			
			
			echo '<script>alert("upload dirid:'.$this->directory_id.', googleid:'.$dir_google_id.'");</script>';
			
			// Set the parent folder.
			
			if($dir_google_id !== null) {
				$parent = new ParentReference();
				$parent->setId($dir_google_id);
				$file->setParents(array($parent));
			}

			try {
			
				$data = file_get_contents($target_path);
				$createdFile = $service->files->insert($file, array(
					'data' => $data,
					'mimeType' => $mimeType,
				));
				//@unlink($target_path);
				// Uncomment the following line to print the File ID
				$inserted_id =  $createdFile->getId();
				
			
			
				if($dir_google_id !== null) 
				{						
					  $newChild = new Google_ChildReference();
						$newChild->setId($inserted_id);	
					
					try {
					$service->children->insert($dir_google_id, $newChild);
				
					} catch (Exception $e) {
					print "An error occurred: " . $e->getMessage();
					}
				}			
				
				

				return $createdFile;
			} catch (Exception $e) {
				print "An error occurred: " . $e->getMessage();
			}




		
			
			
			
			
			
		}			
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