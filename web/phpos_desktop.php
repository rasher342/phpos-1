<?php 
error_reporting(E_ERROR);
/*
**********************************

	PHPOS Web Operating system
	MIT License
	(c) 2013 Marcin Szczyglinski
	szczyglis83@gmail.com
	GitHUB: https://github.com/phpos/
	File version: 1.2.5, 2013.10.15
 
**********************************
*/
	error_reporting(E_ERROR | E_PARSE);
	include 'version.php';
	session_start();
	//session_destroy();
	
	@ini_set('upload_max_filesize', '10G');
	@ini_set('post_max_size', '10G');
	
	if($_GET['logout'] == 1)
	{
		session_destroy();
		header('Location: phpos_login.php');
		exit;
	}	
	
	define('PHPOS', true);	
	define('PHPOS_FS', true);
	define('PHPOS_IN_EXPLORER', true);
	define('PHPOS_APP_SYS', true);
	
	define('PHPOS_NET_URL',  'http://'. $_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']);
	$_SESSION['PHPOS_NETURL'] = PHPOS_NET_URL;

	define('PHPOS_URL', '../_phpos/'); 
	define('PHPOS_DIR', '../_phpos/'); 
	define('PHPOS_WEBROOT', '');	
	define('PHPOS_WEBROOT_URL', '');
	define('ICONS', PHPOS_WEBROOT_URL.'_phpos/icons/');
	define('PHPOS_WEBROOT_DIR', '');
	define('PHPOS_APPS_DIR',PHPOS_DIR.'apps/');	
	define('PHPOS_APPS_URL',PHPOS_URL.'apps/');	
	
	define('PHPOS_HOME_DIR', PHPOS_WEBROOT_DIR.'home/');
	define('PHPOS_HOME_URL', PHPOS_WEBROOT_URL.'home/');

	require PHPOS_DIR.'config/core.php';
	
	require_once(PHPOS_DIR.'common/check_install.php');
	define('PHPOS_INSTALLED', true);
	
	require PHPOS_DIR.'config/database.php';	
	require_once(PHPOS_DIR.'controllers/databaseController.php');	
	require_once(PHPOS_DIR.'classes/class.phpos_filters.php');
	
	$updater_message = null;
	
	require_once(PHPOS_DIR.'classes/class.users.php');		
	require_once(PHPOS_DIR.'controllers/usersController.php');
	require_once(PHPOS_DIR.'classes/class.phpos_config.php');		
	
	require_once(PHPOS_DIR.'classes/class.languages.php');
	require PHPOS_DIR.'classes/class.phpos_updater.php';

	
	$config = new phpos_config;
	$config->set_id_user();
	
	// next only if logged:
	
	require_once(PHPOS_DIR.'common/functions.php');
	require_once(PHPOS_DIR.'classes/class.helpers.php');
	
	require_once(PHPOS_DIR.'classes/class.api_wintask.php');	
	require_once(PHPOS_DIR.'classes/class.api_processes.php');	
	require_once(PHPOS_DIR.'classes/class.phpos_clipboard.php');	
	require_once(PHPOS_DIR.'classes/class.phpos_app.php');
		
	require_once(PHPOS_DIR.'controllers/helpersController.php');	
	
	define('THEME_DIR', PHPOS_WEBROOT_DIR.'_phpos/themes/'.globalconfig('theme').'/');
	define('THEME_URL', PHPOS_WEBROOT_URL.'_phpos/themes/'.globalconfig('theme').'/');
	
	require_once(PHPOS_DIR.'controllers/languageController.php');
	require_once(PHPOS_DIR.'classes/class.phpos_shortcuts.php');
	require_once(PHPOS_DIR.'classes/class.phpos_wallpapers.php');	
	require_once(PHPOS_DIR.'classes/class.phpos_messages.php');
	
	require_once(PHPOS_DIR.'classes/class.phpos_logs.php');		
	$phpos_log = new phpos_logs;	
	//$phpos_log->create_log('xxxx');

	
	$_SESSION['DEBUG'] = false;
	/*
	if($_GET['root']) 
	{
		$_SESSION['DEBUG'] = true;
		if($_SESSION['DEBUG']) define('DEBUG', true);	
	}	
	*/
	
	if($_SESSION['logged_message'] == 1)
	{
		 savelog('LOGIN#SUCCESS');
		 msg::ok(txt('msg_logged'));
		 unset($_SESSION['logged_message']);
	}
	
	$user = new phpos_users;
	$user->get_logged_user();
	
	if(!empty($_GET['code']))
	{
		$_SESSION['google_token'] = $_GET['code'];
		$_SESSION['google_refresh'] = true;
		savelog('GOOGLE_TOKEN#RECEIVED');
	} 
	
	//savelog('ACCESS#SUCCESS');
	
?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo globalconfig('site_title');?></title>
<META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
<META HTTP-EQUIV="PRAGMA" CONTENT="NO-CACHE">
<META NAME="ROBOTS" CONTENT="NONE">
<META NAME="GOOGLEBOT" CONTENT="NOARCHIVE">
<!--[if !IE]> -->

<!-- <![endif]-->
<script type="text/javascript">window.PHPOS_DIR = '<?php echo PHPOS_DIR;?>';</script>
<link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
<link rel="stylesheet" type="text/css" href="<?php echo THEME_URL;?>phposAPI.css" />
<link rel="stylesheet" type="text/css" href="<?php echo PHPOS_WEBROOT_URL;?>_phpos/javascript/jnotify/jNotify.jquery.css" media="screen" />
<link rel="stylesheet" type="text/css" href="<?php echo THEME_URL;?>easyui/default/easyui.css" />
<link rel="stylesheet" type="text/css" href="<?php echo THEME_URL;?>easyuiOverride.css" />
<link rel="stylesheet" type="text/css" href="<?php echo PHPOS_WEBROOT_URL;?>_phpos/javascript/contextMenu/jquery.contextMenu.css" />
<link rel="stylesheet" type="text/css" href="<?php echo PHPOS_WEBROOT_URL;?>_phpos/javascript/lightbox/css/lightbox.css" />
<link rel="stylesheet" type="text/css" href="<?php echo PHPOS_WEBROOT_URL;?>_phpos/javascript/dropzone/css/dropzone.css" />
<script type="text/javascript" src="<?php echo PHPOS_WEBROOT_URL;?>_phpos/javascript/jquery/jquery-2.0.3.min.js"></script>
<script type="text/javascript" src="<?php echo PHPOS_WEBROOT_URL;?>_phpos/javascript/vendor/php2js_functions.js"></script>
<script type="text/javascript" src="<?php echo PHPOS_WEBROOT_URL;?>_phpos/javascript/jquery-easyui-1.3.3/jquery.easyui.min.js"></script>
<script type="text/javascript" src="<?php echo PHPOS_WEBROOT_URL;?>_phpos/javascript/jnotify/jNotify.jquery.js"></script>
<script type="text/javascript" src="<?php echo PHPOS_WEBROOT_URL;?>_phpos/javascript/contextMenu/jquery.contextMenu.js"></script>

<script type="text/javascript" src="<?php echo PHPOS_WEBROOT_URL;?>_phpos/javascript/jquery.resize.min.js"></script>
<script type="text/javascript" src="<?php echo PHPOS_WEBROOT_URL;?>_phpos/javascript/config.js"></script>
<script type="text/javascript" src="<?php echo PHPOS_WEBROOT_URL;?>_phpos/javascript/phposAPI.js"></script>
<script type="text/javascript" src="<?php echo PHPOS_WEBROOT_URL;?>_phpos/javascript/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="<?php echo PHPOS_WEBROOT_URL;?>_phpos/javascript/ckeditor/adapters/jquery.js"></script>
<script type="text/javascript" src="<?php echo PHPOS_WEBROOT_URL;?>_phpos/javascript/lightbox/js/lightbox-2.6.min.js"></script>
<script type="text/javascript" src="<?php echo PHPOS_WEBROOT_URL;?>_phpos/javascript/wallpaper/jquery.bp.wallpaper.min.js"></script>
<script type="text/javascript" src="<?php echo PHPOS_WEBROOT_URL;?>_phpos/javascript/dropzone/dropzone.js"></script>


<?php require_once(PHPOS_DIR.'common/inc.style_generator.php'); ?>

</head>
<body class="easyui-layout" data-options="cache:false,split:false">  
<?php require_once(PHPOS_DIR.'controllers/windowsManagerController.php'); ?>
<?php require_once(PHPOS_DIR.'controllers/wallpaperManager.php'); ?>
<?php require_once(PHPOS_DIR.'controllers/menu_startController.php'); ?>	
<?php //require_once(PHPOS_DIR.'common/inc.debugger_loader.php'); ?>
<?php require_once(PHPOS_DIR.'common/inc.desktop_loader.php'); ?>
<script>
<?php echo msg::showMessages();  ?>
</script>
</body>
</html>