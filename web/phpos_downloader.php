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

	define('PHPOS', true);	
	
	define('PHPOS_NET_URL',  'http://'. $_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']);
	$_SESSION['PHPOS_NETURL'] = PHPOS_NET_URL;
	define('PHPOS_URL', '../_phpos/'); 
	define('PHPOS_DIR', '../_phpos/'); 
	define('PHPOS_WEBROOT', '');	
	define('PHPOS_WEBROOT_URL', '');
	define('PHPOS_WEBROOT_DIR', '');	
	define('PHPOS_HOME_DIR', PHPOS_WEBROOT_DIR.'home/');
	define('PHPOS_HOME_URL', PHPOS_WEBROOT_URL.'home/');
	require_once(PHPOS_DIR.'classes/class.phpos_filters.php');
	
	if(file_exists(PHPOS_DIR.'config/security_key.php'))
	{		
		include PHPOS_DIR.'config/security_key.php';
		define('PHPOS_KEY', $phpos_key);
		
	} else {
	
		die('PHPOS is not installed');
	}
	

	$filename = base64_decode($_GET['file']);	
	$download_type = base64_decode(strip_tags($_GET['download_type']));
	
	
	if(!empty($download_type))
	{
		if(strip_tags($_GET['hash']) != md5(PHPOS_KEY)) die('Please don\'t hack :).');	
		
		switch($download_type)
		{
			case 'log':
				
				$h = md5('LOGS_'.PHPOS_KEY);
				$folder_dir = PHPOS_DIR.'logs/'.$h.'/';
				$folder_url = PHPOS_URL.'logs/'.$h.'/';
				
				$l = '../logs/'.$h.'/';
				$file_unhashed = str_replace($l, '', $filename);
				$file_unhashed = str_replace(array('../', './', '.', ':', '//', '\\'), '', str_replace('log', '', $file_unhashed));
				
				$file_id = $folder_dir.$file_unhashed.'.log';
				//echo $file_id;
				if(file_exists($file_id)) define('CAN_DOWNLOAD', true);
			break;
			
			case 'local_file':
				$folder_dir = PHPOS_HOME_DIR;
				$folder_url = PHPOS_HOME_URL;
				$file_unhashed = str_replace(PHPOS_HOME_DIR, '', $filename);
				$file_unhashed = str_replace(array('../', './', ':'), '', $file_unhashed);
				
				$file_id = $folder_dir.$file_unhashed;
				//echo 'folder_id: '.$folder_dir.', file_unhashed: '.$file_unhashed;
				if(file_exists($file_id)) define('CAN_DOWNLOAD', true);
			break;
			
			case 'ftp_file':
				//$folder_dir = PHPOS_HOME_DIR;
				$folder_url = PHPOS_HOME_URL;
				$folder_dir = PHPOS_HOME_DIR;
				$file_unhashed = str_replace(PHPOS_HOME_DIR, '', $filename);
				//$file_unhashed = str_replace(array('../', './', ':'), '', $file_unhashed);
				
				$file_id = $folder_dir.$file_unhashed;
				//echo 'folder_id: '.$folder_dir.', file_unhashed: '.$file_unhashed;
				if(file_exists($file_id)) define('CAN_DOWNLOAD', true);
			break;
		
		
		
		
		}
	}

	//echo 'folder_dir: '.$folder_dir.'<br>folder_url: '.$folder_url.'<br>file: '.$file_unhashed.'<br>file_to_download:'.$file_id;
	
	
	
	if(defined('CAN_DOWNLOAD'))
	{
		$basename = basename($file_id);
		header('Content-disposition: attachment; filename='.$basename.'');
		@readfile($file_id);
		if($download_type == 'ftp_file') @unlink($file_id);		
	}
	
/*
$homedir = '../../web/home/szczyglis/';
$filename = base64_decode($_GET['file']);
$file_path = str_replace($homedir, '', $filename);

$basename = basename($filename);

header('Content-disposition: attachment; filename='.$basename.'');
readfile('home/szczyglis/'.$file_path);
*/

?>