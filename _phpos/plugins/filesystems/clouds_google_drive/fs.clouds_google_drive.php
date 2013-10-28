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

	// Include Google API classes

	require_once PHPOS_DIR.'plugins/filesystems/clouds_google_drive/google-api-php-client/src/Google_Client.php';
	require_once PHPOS_DIR.'plugins/filesystems/clouds_google_drive/google-api-php-client/src/contrib/Google_Oauth2Service.php';
	require_once PHPOS_DIR.'plugins/filesystems/clouds_google_drive/google-api-php-client/src/contrib/Google_DriveService.php';
		
		 
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
		$connected,
		$logged,			
		$connection_status;	
		 
/*
**************************
*/
 	
	protected		
		$root_directory_id,
		$directory_id,
		$parent_id,
		$parents,
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
		$this->fs_prefix = 'clouds_google_drive';	
		
		$this->set_root_directory_id('root');
		$this->client = $this->connect();		
		 		
	}	
		
/*
**************************
*/
 	
	function set_error_msg($msg)
	{
		$this->error_msg = $msg;
		$this->connection_status = $msg;	
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
			
			$this->service = new Google_DriveService($this->client);
			$userInfoService = new Google_Oauth2Service($this->client);
			$userInfo = null;
			
			$this->client->setClientId($this->cloud->get_login());
			$this->client->setClientSecret($this->cloud->get_password());
			$this->client->setRedirectUri($this->cloud->get_url());
		  $this->client->setAccessType("offline");
			$this->client->setScopes(array('https://www.googleapis.com/auth/drive'));		
							
/*.............................................. */		

			if(isset($_SESSION['google_token'])) 
			{
				try 
				{					
						$_GET['code'] = $_SESSION['google_token'];
						$_SESSION['token'] = $this->client->authenticate($_GET['code']);
						//$_SESSION['token'] = $this->client->getAccessToken();
						$redirect = $this->cloud->get_url();
						unset($_SESSION['google_token']);					
							
					
				}	catch (Exception $e) 
				{
					$this->connected = false;		
					//$this->set_error_msg('TOKEN#1: '.$e->getMessage());
					//$this->set_status('TOKEN#1: '.$e->getMessage());
					$this->set_authUrl($this->client->createAuthUrl());
				}			
			}	else {
				
					$this->set_authUrl($this->client->createAuthUrl());
			}
/*.............................................. */		
			
			if(isset($_SESSION['token'])) 
			{			
				try 
				{				
					$this->client->setAccessToken($_SESSION['token']);
					$this->client->setUseObjects(true);
					
	
					$this->set_authUrl($this->client->createAuthUrl());
					$this->connected = true;
					
				}	catch (Exception $e) 
				{				
					$this->connected = false;		
					//$this->set_error_msg('TOKEN#2: '.$e->getMessage());
					//$this->set_status('TOKEN#2: '.$e->getMessage());				
					$this->set_authUrl($this->client->createAuthUrl());
				}						
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
		if($this->directory_id == '.') $this->directory_id = 'root';		
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
 
	public function have_parent($file = null)
	{		
		try 
		{
			$parents = $this->service->parents->listParents($this->directory_id);

			foreach ($parents->getItems() as $parent) 
			{
				$this->parent_id = $parent->getId();
				return true;
			}
			
		} catch (Exception $e) 
		{
			//$this->set_error_msg('PARENT#1: '.$e->getMessage());
		}
	}	
		
/*
**************************
*/
 		
	public function get_parent_dir($file)
	{			
		return $this->parent_id;
	}		
		
/*
**************************
*/
 		 
	function get_parents($fileId) 
	{
		try 
		{
			if(!is_array($this->parents))
			{
				$parents = $this->service->parents->listParents($fileId);

				$parents_array = array();
				foreach ($parents->getItems() as $parent) 
				{
					$parents_array[] = $parent->getId();
				}
				$this->parents = $parents_array;
				return $parents_array;
				
			} else {
			
				return $this->parents;
			}
			
			
		} catch (Exception $e) 
		{
			$this->set_error_msg($e->getMessage());
		}
	}	 		 
/*
**************************
*/
 		 
	public function google_service()
	{		
		return $this->service;
	}			

	
	public function get_tree($dir = 'root')
	{
		$dir_parents = $dir;
		if(!empty($this->directory_id)) $dir_parents = $this->directory_id;
		$this->get_parents($dir_parents);
		
		$root_files = $this->get_files_list($dir);
		$c = count($root_files);
		
		$tree = '';
		if($c != 0)
		{
			$tree.= '<ul>';
			for($i=0; $i<$c; $i++)
			{
				if($this->is_directory($root_files[$i]))
				{
					$state = 'closed';
					if(in_array($root_files[$i]['id'], $this->parents) || $root_files[$i]['id'] == $this->directory_id)					
					{
						$span = '<span style="color:black"><b>'.$root_files[$i]['basename'].'</b></span>';
						//$items = $this->get_files_list($root_files[$i]['id']);
						//$state = 'opened';						
						
					} else {
					
						$span = '<span style="color:black">'.$root_files[$i]['basename'].'</span>';				
					}	
										
					
					$tree.= '<li data-options="state:\''.$state.'\'"><span><a href="">'.$span.'</a></span></li>'.$items;
				}		
			}
			
			$tree.= '</ul>';
		}
		
		
		//print_r($root_files);
		return $tree;	
	}
/*
**************************
*/
 
	public function get_file_info($file)
	{				
		if(is_array($file))
		{
			$file_id = $file['id'];			
		
		} else {
		
			$file_id = $file;			
		}	

		try 
		{			
			$parameters['fields'] = "items/pagemap/*/title";			
			$googlefile = $this->service->files->get($file_id);		
		
		} catch (Exception $e) 
		{ 
			$this->set_error_msg($e->getMessage());
		}	

		$file_info['id'] = $file_id;			
		$file_info['basename'] = $googlefile->getTitle();	
		$file_info['extension'] = str_replace(array('application/','vnd.google-apps.'),'',$googlefile->getMimeType());
		$file_info['filename'] = $googlefile->getTitle();					
		$file_info['modified_at'] = $googlefile->getModifiedDate();	
		$file_info['created_at'] = $googlefile->getCreatedDate();	
		$file_info['chmod'] = $googlefile->getTitle();		
		$file_info['webContentLink'] = $googlefile->getWebContentLink();	
		$file_info['webViewLink'] = $googlefile->getWebViewLink();
		$file_info['downloadUrl'] = $googlefile->getDownloadUrl();	
		$file_info['size'] = $googlefile->getQuotaBytesUsed();
		$file_info['defaultOpenWithLink'] = $googlefile->getDefaultOpenWithLink();		
		if($file_info['extension'] != 'folder') $file_info['icon'] = $googlefile->getIconLink();	
		if($file_info['extension'] == 'folder') $file_info['extension'] = '';
		
		return $file_info;	
	}	
		 
/*
**************************
*/

 
	public function get_files_list($directory_id = null)
	{		
		if($this->directory_id == '.') $this->directory_id = 'root';		 
		$pageToken = NULL;
		
		do 
		{
			try 
			{
				$parameters = array();
				if ($pageToken) {
					$parameters['pageToken'] = $pageToken;
				}
				
				if($directory_id === null) $directory_id = $this->directory_id;			
				
				$parameters['q'] = '\''.$directory_id.'\' in parents';				
				$parameters['fields'] = "items(id,title,mimeType,createdDate,modifiedDate,iconLink,webContentLink,webViewLink,quotaBytesUsed)";				
				
				$files = $this->service->files->listFiles($parameters);
				$items = $files->getItems();
				foreach($items as $googlefile) 
				{						
					$file_info = array();							
					$file_info['id'] = $googlefile->getId();	
					$file_info['basename'] = $googlefile->getTitle();	
					$file_info['extension'] = str_replace(array('application/','vnd.google-apps.'),'',$googlefile->getMimeType());
					$file_info['filename'] = $googlefile->getTitle();					
					$file_info['modified_at'] = $googlefile->getModifiedDate();	
					$file_info['created_at'] = $googlefile->getCreatedDate();	
					$file_info['chmod'] = $googlefile->getTitle();
					$file_info['webContentLink'] = $googlefile->getWebContentLink();
					$file_info['webViewLink'] = $googlefile->getWebViewLink();					
					$file_info['downloadUrl'] = $googlefile->getDownloadUrl();	
					$file_info['size'] = $googlefile->getQuotaBytesUsed();
					$file_info['defaultOpenWithLink'] = $googlefile->getDefaultOpenWithLink();
					if($file_info['extension'] != 'folder') $file_info['icon'] = $googlefile->getIconLink();
					if($file_info['extension'] == 'folder') $file_info['extension'] = '';					
					
					if($file_info['extension'] == 'folder' || empty($file_info['extension']))
					{
						$list_dirs[] = $file_info;
						
					} else {
					
						$list_files[] = $file_info;
					}						
				}
				
			$pageToken = $files->getNextPageToken();	
			
			} catch (Exception $e) 
			{
				$this->set_error_msg($e->getMessage());
				$pageToken = NULL;
			}
			
		} while ($pageToken);								
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
		try 
		{		  
		  $file = new Google_DriveFile();
			
			$file->setTitle($dirname);			
			$file->setMimeType('application/vnd.google-apps.folder');		
			
			$createdFile = $this->service->files->insert($file, array(							
				'mimeType' => 'application/vnd.google-apps.folder'								
			));			
			
			$inserted_id =  $createdFile->getId();			
			$newChild = new Google_ChildReference();
			$newChild->setId($inserted_id);
			$this->service->children->insert($this->directory_id, $newChild);

			return $createdFile;
			
		} catch (Exception $e) {
			$this->set_error_msg($e->getMessage());
		}					
	}	 
 		
/*
**************************
*/
  
	public function is_directory($file)
	{
		$f = $file;
		if(is_array($file)) $f = $file['id'];			
		if($file['extension'] == 'application/vnd.google-apps.folder' || empty($file['extension']))	 return true;
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
							
			return "window.open('".$file['webContentLink']."', '_blank');";	
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
				
/*.............................................. */	
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
 
	
	public function rename($fileId, $newTitle)
	{		
		try 
		{   
			$file = $this->service->files->get($fileId);    
			$file->setTitle($newTitle); 
			
			$updatedFile = $this->service->files->update($fileId, $file);
			return $updatedFile;
			
		} catch (Exception $e) {
			$this->set_error_msg($e->getMessage());
		}
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
	
	public function delete($fileId)
	{		
		try {
			$this->service->files->delete($fileId);
		} catch (Exception $e) {
			$this->set_error_msg($e->getMessage());
		}
	}
		
/*
**************************
*/
 	
	public function upload_file($file_upload)
	{					
		try 
		{		  
		  $file = new Google_DriveFile();
			
			$file->setTitle(basename($file_upload['name']));
			$file->setDescription('Uploaded from PHPOS');
			$file->setMimeType($file_upload['type']);				
	
			$data = file_get_contents($file_upload['tmp_name']);
			$createdFile = $this->service->files->insert($file, array(
				'data' => $data,					
				'mimeType' => $file_upload['type']								
			));			
			
			$inserted_id =  $createdFile->getId();			
			$newChild = new Google_ChildReference();
			$newChild->setId($inserted_id);
			$this->service->children->insert($this->directory_id, $newChild);

			return $createdFile;
			
		} catch (Exception $e) {
			$this->set_error_msg($e->getMessage());
		}					
	}
		
/*
**************************
*/
 	
	public function clipboard_copy()
	{
		$file = new Google_DriveFile();
		$file = $this->service->files->get(param('action_param')); 		
		$fileName = $file->getTitle();
		
		$clipboard = new phpos_clipboard;
		$clipboard->set_mode('copy');
		$clipboard->set_name($fileName);
		$clipboard->set_server(false);
		$clipboard->add_clipboard(param('action_param'), param('action_param2'), null);	
	}	
			
/*
**************************
*/

	public function clipboard_copy_server()
	{
		$file = new Google_DriveFile();
		$file = $this->service->files->get(param('action_param')); 		
		$fileName = $file->getTitle();
		
		$clipboard = new phpos_clipboard;
		$clipboard->set_mode('copy');
		$clipboard->set_name($fileName);
		$clipboard->set_server(true);
		$clipboard->add_clipboard(param('action_param'), param('action_param2'), $connect_id);			
		$this->file_download(param('action_param'), false, true);
	}	
			
/*
**************************
*/
 	
	public function clipboard_cut()
	{
		$file = new Google_DriveFile();
		$file = $this->service->files->get(param('action_param')); 		
		$fileName = $file->getTitle();
		
		$clipboard = new phpos_clipboard;
		$clipboard->set_mode('cut');
		$clipboard->set_source_win(WIN_ID);
		$clipboard->set_name($fileName);
		$clipboard->set_server(false);
		$clipboard->add_clipboard(param('action_param'), param('action_param2'), null);	
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
		$file_name = $clipboard->get_name();		
				
/*.............................................. */	
		switch($fs)
		{ 
			case $this->fs_prefix:			
		
					$file_data = $this->get_file_info($id_file);
					$copiedFile = new Google_DriveFile();
					$copiedFile->setTitle($file_data['basename']);
					
					
/*.............................................. */			
					switch($mode)
					{ 
						case 'copy':
						
								try 
								{		
									$new_file = $this->service->files->copy($id_file, $copiedFile);
									$newParent = new Google_ParentReference();
									$newParent->setId($to_dir_id);			
									$new_file_id = $new_file->getId();
									$this->service->parents->insert($new_file_id, $newParent);
									return true;
									
								} catch (Exception $e) {
									$this->set_error_msg($e->getMessage());
								}
								return NULL;
					
						break;
								
/*.............................................. */	
						case 'cut':
							
							  try 
								{										 
									$file = new Google_DriveFile();
									$file = $this->service->files->get($id_file);    
									$newParent = new Google_ParentReference();
									$newParent->setId($to_dir_id);								
									$file->setParents(array($newParent));
									
									$updatedFile = $this->service->files->update($id_file, $file);
									return true;
									
								} catch (Exception $e) {
									$this->set_error_msg($e->getMessage());
								}					
						
						
						break;
					}

			break;
					
/*.............................................. */	
			default:
			$basename = $file_name;	
				if(is_dir(MY_HOME_DIR.'_Clipboard/'.$id_file))
				{
					//$this->ftp_putAll(MY_HOME_DIR.'_Clipboard/'.$id_file, $to_dir_id.'/'.$basename);			 
			 
				} else {	
			 
				 $file = array();
				 $file['tmp_name'] = MY_HOME_DIR.'_Clipboard/'.$id_file;
				 $file['name'] = $basename;
				 
					if($this->upload_file($file))
					{ 											
						return true;					
					} 
			  }			
		}		 
	}	
	
				
/*
**************************
*/
 	
	public function file_download($file_id, $download_local = false, $clipboard = false)
	{
		$file = new Google_DriveFile();
		$file = $this->service->files->get($file_id);   
		$downloadUrl = $file->getDownloadUrl();
		$fileName = $file->getTitle();
		if ($downloadUrl) {
			$request = new Google_HttpRequest($downloadUrl, 'GET', null, null);
			$httpRequest = Google_Client::$io->authenticatedRequest($request);
			if ($httpRequest->getResponseHttpCode() == 200) {
				$content = $httpRequest->getResponseBody();
						
/*.............................................. */	
				if(!empty($content))
				{
					if(!$download_local)
					{					
						$dir = '_Download';
						$fname = $fileName;
						if($clipboard) 
						{
							$dir = '_Clipboard';
							$fname = $file_id;
						}
						
						if(file_put_contents(MY_HOME_DIR.$dir.'/'.$fname, $content)) 
						{						
							/*
							echo '<script>phpos.windowRefresh("'.WIN_ID.'", "reset_shared:1,dir_id:'.MY_HOME_DIR.'_Download,in_shared:0,tmp_shared_id:0,shared_id:0,app_id:index,fs:local_files"); </script>';
							*/
							return true;							
						}	
								
/*.............................................. */	
					} else {
					
						if(file_put_contents(PHPOS_TEMP.$fileName, $content)) 
						{								
							echo '<script>'.browser_url(PHPOS_WEBROOT_URL.'phpos_downloader.php?hash='.md5(PHPOS_KEY).'&download_type='.base64_encode('ftp_file').'&file='.base64_encode(str_replace(PHPOS_WEBROOT_DIR, '', PHPOS_TEMP.$fileName))).'</script>';
							return true;							
						}					
					}
				}
			} else {
				// An error occurred.
				return null;
			}
			
		} else {
			// The file doesn't have any content stored on Drive.
			return null;
		}	
	}	
			 
/*
**************************
*/
 	
	public function file_view()
	{
		// to do in next update			
	}
	
}
?>