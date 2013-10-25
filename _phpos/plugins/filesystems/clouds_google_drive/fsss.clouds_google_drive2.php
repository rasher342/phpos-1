<?php 
/*
**********************************

	PHPOS Web Operating system
	MIT License
	(c) 2013 Marcin Szczyglinski
	szczyglis83@gmail.com
	GitHUB: https://github.com/phpos/
	File version: 1.2.6, 2013.10.16
 
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
// Include google API classes
require_once PHPOS_DIR.'plugins/filesystems/clouds_google_drive/google-api-php-client/src/Google_Client.php';
require_once PHPOS_DIR.'plugins/filesystems/clouds_google_drive/google-api-php-client/src/contrib/Google_DriveService.php';
		

// Class
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
		$connected,
		$logged,			
		$connection_status;	
		 
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
		$error_msg,
		$dir_id;	
	 
/*
**************************
*/
 	
	function __construct($cloud_id = null)
	{				
		$this->set_root_directory_id('root');
		$this->client = $this->connect();			
	}	
		
/*
**************************
*/
 	
	function set_error_msg($msg)
	{
		$this->error_msg = $msg;
	}
		
/*
**************************
*/
 
	public function set_status($str)
	{
		$this->connection_status = $str;	
	}
		
/*
**************************
*/
 	
	public function set_authUrl($authUrl)
	{
		$this->authUrl = $authUrl;	
	}
		
/*
**************************
*/
 	
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
 public function get_wait_notify($noscript = null)
 {
 	 if($noscript === null) 	$monit.= "<script>";
	
	 $monit.= "
				jNotify(
					'Retrieving data from Google servers...Please wait...',
					{
						autoHide : true, 
						clickOverlay : false,
						MinWidth : 200,
						TimeShown : 6000,
						ShowTimeEffect : 1000,
						HideTimeEffect : 600,
						LongTrip :20,
						HorizontalPosition : 'right',
						VerticalPosition : 'bottom',
						ShowOverlay : false
					}
				);
				";		
		if($noscript === null) $monit.= "</script>";
		return $monit;
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
			
			$this->client = new Google_Client();
		
			$this->client->setClientId($this->cloud->get_login());
			$this->client->setClientSecret($this->cloud->get_password());
			$this->client->setRedirectUri($this->cloud->get_url());
			$this->client->setScopes(array('https://www.googleapis.com/auth/drive'));		
							
/*.............................................. */		
			
			try 
			{
				if(isset($_SESSION['google_token'])) 
				{
					$_GET['code'] = $_SESSION['google_token'];
					$this->client->authenticate();
					$_SESSION['token'] = $this->client->getAccessToken();
					$redirect = $this->cloud->get_url();
					unset($_SESSION['google_token']);					
				}			
				
			}	catch (Exception $e) 
			{
				$this->connected = false;		
				$this->set_status($e->getMessage());
				$this->set_authUrl($this->client->createAuthUrl());
			}			
							
/*.............................................. */		
			
			if(isset($_SESSION['token'])) 
			{			
				try 
				{				
					$this->client->setAccessToken($_SESSION['token']);		
					
				}	catch (Exception $e) 
				{				
					$this->connected = false;		
					$this->set_error_msg($e->getMessage());
					$this->set_status($e->getMessage());				
					$this->set_authUrl($this->client->createAuthUrl());
				}			
			}			
							
/*.............................................. */		
			
			if($this->client->getAccessToken()) 
			{				
				try 
				{					
					$this->connected = true;					
								
					$this->set_authUrl($this->client->createAuthUrl());
					$_SESSION['token'] = $this->client->getAccessToken();					
					
				}	catch (Exception $e) 
				{
					$this->connected = false;		
					$this->set_error_msg($e->getMessage());
					$this->set_status($e->getMessage());
			  	$this->set_authUrl($this->client->createAuthUrl());
				}				
				
			} else {
				
				$this->connected = false;				
				$this->set_authUrl($this->client->createAuthUrl());				
			}				
		}	
		
		return $this->client;
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
		if($this->directory_id == '.' || $this->directory_id == 'root') return false;		
		
	 	global $my_app;
		
		if($my_app->get_param('parent_id') !== null)
		{
			return true;
		}
	}	
		
/*
**************************
*/
 		 
	public function google_service()
	{
		$this->service = new Google_DriveService($this->client);
		
		return $this->service;
	}	
			 
		 
/*
**************************
*/
 
	public function get_filelist($where = null)
	{
		if($this->directory_id == '.') $this->directory_id = 'root';			
		
		if(!isset($this->google_drive_files[$this->directory_id])) 
		{			
			try 
			{				
				$this->google_service();			
				if($this->directory_id == '.') $this->directory_id = 'root';
			
				$parameters['q'] = '\''.$this->directory_id.'\' in parents';				
				$parameters['projection'] = 'BASIC';
				$filelist = @$this->service->files->listFiles($parameters);			
				
				$c = count($filelist['items']);			
			
				if($c != 0)
				{
					foreach($filelist['items'] as $item)
					{
						$this->google_drive_files[$item['id']] = $item;				
					}	
				}
								
				$this->connected = true;
				
			}	catch (Exception $e) 
			{
					$this->connected = false;		
					$this->set_error_msg($e->getMessage());
					$this->set_status($e->getMessage());
					$this->set_authUrl($this->client->createAuthUrl());
			}
		}
	} 
		
/*
**************************
*/
  
 
	public function get_parent_dir($file)
	{			
		global $my_app;
		
		if($my_app->get_param('parent_id') !== null) return $my_app->get_param('parent_id');
		
		return 'root';
	}
		
/*
**************************
*/
 		 
	function printParents($fileId) 
	{
		try 
		{
			$parents = $this->service->parents->listParents($fileId);

			foreach ($parents->getItems() as $parent) 
			{
				print 'File Id: ' . $parent->getId();
			}
			
		} catch (Exception $e) 
		{
			$this->set_error_msg($e->getMessage());
		}
	}	 		 
		 
/*
**************************
*/
 
	public function get_parents($file)
	{
		/*$this->get_filelist();
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
		}			*/
		return $parents;		
	}	
		 
/*
**************************
*/
 
	public function get_file_info($file)
	{			
	  //$this->get_filelist();
		if(is_array($file))
		{
			$f_id = $file['id'];			
		
		} else {
		
			$f_id = $file;			
		}		
								
/*.............................................. */		
	
		try 
		{				
			$service = new Google_DriveService($this->connect());		
			$googlefile = $service->files->get($f_id);
			
			if(is_object($googlefile))
			{
				print "Title: " . $googlefile->getTitle();
				print "Description: " . $googlefile->getDescription();
				print "MIME type: " . $googlefile->getMimeType();
			}
		
		} catch (Exception $e) 
		{ 
			$this->set_error_msg($e->getMessage());
		}		
								
/*.............................................. */		
	
		$file_info['id'] = $f_id;			
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
								
/*.............................................. */		
	
		$c = count($this->google_drive_files);
		if($c != 0)
		{		
			$i = 0;
							
/*.............................................. */		
			
			foreach($this->google_drive_files as $f)
			{								
				$file_info = array();				
				
				$file_info['id'] = $f['id'];
				$file_info['file_id'] = $f['id'];
				
				if($f['parents'][0]['isRoot'] != 1)	$file_info['dirname'] = $f['parents'][0]['id'];						
				
				$file_info['basename'] = $f['title'];	
				$file_info['extension'] = $f['mimeType'];	
				$file_info['filename'] = $f['title'];				
				$file_info['modified_at'] = $f['modifiedDate'];
				$file_info['created_at'] = $f['createdDate'];
				$file_info['chmod'] = $f['owners'][0]['permissionId'];
				if($f['mimeType'] != 'application/vnd.google-apps.folder')	$file_info['icon'] = $f['iconLink'];			
				
				if($this->directory_id == 'root' || $this->directory_id == '.')
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
					
					if($f['mimeType'] == 'application/vnd.google-apps.folder')
					{
						$list_dirs[] = $file_info;
						
					} else {
					
						$list_files[] = $file_info;
					}												
				}				
		
				$i++;
			}
									
/*.............................................. */		
	
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
 		
/*
**************************
*/
 
	public function new_dir($dirname)
	{
		// to do in next update
	}	 
 		
/*
**************************
*/
  
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
			return $this->get_wait_notify('noscript').helper_reload(array('parent_id' => $this->directory_id,'shared_id' => 0, 'reset_shared' => 0, 'dir_id' => $file['id']));
			
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
		
			$pathinfo =  pathinfo($file['basename']);
			$ext = strtolower($pathinfo['extension']);
			if(!empty($ext))
			{
				if(file_exists($explorer->config('filetypes_icons_folder_dir').$ext.'.png'))
				{
					$icon_image = $explorer->config('filetypes_icons_folder_url').$ext.'.png';
				} else {
					$icon_image = $explorer->config('filetypes_icons_folder_url').'default.png';
				}		
			
			} else {
			
				$icon_image = $file['icon'];	
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
 
	
	public function rename($id_file, $new_name)
	{
		// to do in next update
	}
		
/*
**************************
*/
 	
	public static function deleteDir($path) {
   // to do in next update
	}	
			
/*
**************************
*/ 
	
	public function delete($id_file)
	{		
		// to do in next update	
	}
		
/*
**************************
*/
 	
	public function upload_file($file_upload)
	{					
		global $my_app;
		$dir = $my_app->get_param('dir_id');			
		$target_path = PHPOS_TEMP.basename($file_upload['name']); 
		if(move_uploaded_file($file_upload['tmp_name'], $target_path)) 
		{
			// echo '<script>alert("'.PHPOS_TEMP.basename($file_upload['name']).'  mime:'.$file_upload["type"].'");</script>';			
			
			// upload to google		
			$dir_google_id = null;
			if($dir != '.' && $dir != 'root')
			{							
				$dir_google_id = $dir;			
				//$ref = $service->files->get($dir_google_id);
			}			
				
			$service = new Google_DriveService($this->client);		
		  $file = new Google_DriveFile();
			
			$file->setTitle(basename($file_upload['name']));
			$file->setDescription('Uploaded from PHPOS');
			$file->setMimeType($file_upload["type"]);
			//$file->setParents($this->directory_id);		
			
			// Set the parent folder.
			/*
			if($dir_google_id != null) {
				$parent = new ParentReference();
				$parent->setId($dir_google_id);
				$file->setParents(array($parent));
			}
				*/
				
				//echo '<script>alert("insertid:'.$createdFile['id'].', upload dirid:'.$this->directory_id.', googleid:'.$dir_google_id.'");</script>';				
									
/*.............................................. */		
	
				$data = file_get_contents($target_path);
				$createdFile = $service->files->insert($file, array(
					'data' => $data,
					'uploadType' => 'multipart',
					'mimeType' => $mimeType,
					'parents' => array($dir_google_id)				
				));				
			
				@unlink($target_path);				
				$inserted_id =  $createdFile['id'];				
			
			/*
				if($dir_google_id !== null) 
				{						
					  $newChild = new Google_ChildReference();
						$newChild->setId($inserted_id);	
					
					try {
					$service->children->insert($dir_google_id, $newChild);
				
					} catch (Exception $e) {
						echo '<script>alert("err-insertid:'.$inserted_id.', upload dirid:'.$this->directory_id.', googleid:'.$dir_google_id.'");</script>';
					print "An error occurred: " . $e->getMessage();
					}
				}			
				*/			

				return $createdFile;
		}			
	}
		
/*
**************************
*/
 	
	public function copy($to_dir_id = null)
	{
		// to do in next update			
	}	
}
?>