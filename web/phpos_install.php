<?php 
	error_reporting(E_ERROR | E_PARSE);
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

	include 'version.php';
	session_start();

	if($_GET['d']==1)
	{
		session_destroy();
		session_start();
	}	
		
	define('PHPOS', true);	
	define('INSTALLER', true);	
	define('PHPOS_FS', true);
	define('PHPOS_IN_EXPLORER', true);
	define('PHPOS_APP_SYS', true);
	define('PHPOS_URL', '../_phpos/'); 
	define('PHPOS_DIR', '../_phpos/'); 
	define('PHPOS_WEBROOT', '');	
	define('PHPOS_WEBROOT_URL', '');
	define('PHPOS_WEBROOT_DIR', '');
	define('INSTALLER_DIR', PHPOS_DIR.'install/');
	define('PHPOS_HOME_DIR', PHPOS_WEBROOT_DIR.'home/');
	define('PHPOS_HOME_URL', PHPOS_WEBROOT_URL.'home/');
	define('PHPOS_HOME_CHMOD', PHPOS_WEBROOT_DIR.'home');
	
	
	// Check to system is not installed yet
	if(file_exists(PHPOS_DIR.'config/installed.php'))	include PHPOS_DIR.'config/installed.php';		
	
	// ***** INSTALLED *****
	if($phpos_installed_time > 0)
	{
		header("Location: phpos_desktop.php");
		exit;
	}	
	
	// Config
	$footer = '(c) 2013 Copyrights PHPOS Group<br />Marcin Szczyglinski';
	
	
	// ***** NOT INSTALLED *****	
	
	require PHPOS_DIR.'config/core.php';
	require_once(PHPOS_DIR.'classes/class.phpos_filters.php');
	require_once(PHPOS_DIR.'classes/class.api_wintask.php');	
	require_once(PHPOS_DIR.'classes/class.helpers.php');
	require_once(PHPOS_DIR.'classes/class.users.php');
	require_once(PHPOS_DIR.'controllers/helpersController.php');
	require_once(PHPOS_DIR.'classes/class.languages.php');	
	require_once(PHPOS_DIR.'controllers/languageController.php');
	require_once(PHPOS_DIR.'classes/class.phpos_databases.php');	
		
	require_once(PHPOS_DIR.'classes/class.phpos_wallpapers.php');
	require_once(PHPOS_DIR.'classes/class.phpos_installer.php');	
	$installer = new phpos_installer;
	

	
	
	/* STEPS */
	$installer->get_steps();	
	$step = $installer->get_this_step();	
	$next_step = $installer->get_next_step();
	$prev_step = $installer->get_prev_step();
	
	$jquery_next = $installer->jquery_next_button($step);	
	$jquery_start = $installer->jquery_at_start($step);		
	
	
	switch($step)
	{
		case 2:
			$_SESSION['need_reinstall'] = false;
			$installer->action_set_accept_license_session();			
		break;
		
		case 4:
			$installer->action_set_root_pwd_session();			
			$installer->action_set_chmods();				
		break;
		
		
		case 5:		
			$installer->action_set_db_session();
		break;
	
	
		case 6:	
			$installer->action_set_cfg_session();		
		break;
		
		
		case 7:		
		
			require PHPOS_DIR.'classes/class.database.'.$_SESSION['phpos_install_data']['db_adapter'].'.php';
			
			$sql = new phpos_database;
			$sql->set_type('mysql');
			$sql->set_host($_SESSION['phpos_install_data']['db_host']);
			$sql->set_user($_SESSION['phpos_install_data']['db_user']);
			$sql->set_password($_SESSION['phpos_install_data']['db_password']);
			$sql->set_dbname($_SESSION['phpos_install_data']['db_name']);
			$sql->set_prefix($_SESSION['phpos_install_data']['db_prefix']);		
			include(PHPOS_DIR.'classes/class.phpos_config.php');
			
			$installer->installer_gen_key();
			
			if($installer->installer_check_connection()) 
			{
				if($_GET['reinstall']) $installer->installer_uninstall();
				
				
				if($installer->installer_install_db())
				{					
					$installer->installer_gen_install_file();		
					$installer->installer_save_config();	
					$installer->installer_save_db_config();	

					$install_status = $installer->get_key_info();
					
				}			
			}	
			
			
				
			
				
			$install_status.= $installer->get_install_status();		
		break;	
	}		
?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo txt('installer_title');?></title>
<script type="text/javascript" src="<?php echo PHPOS_WEBROOT_URL;?>_phpos/javascript/jquery/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo PHPOS_WEBROOT_URL;?>_phpos/javascript/phposAPI_login.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo PHPOS_WEBROOT_URL;?>_phpos/javascript/contextMenu/jquery.contextMenu_login.css" />
<script type="text/javascript" src="<?php echo PHPOS_WEBROOT_URL;?>_phpos/javascript/contextMenu/jquery.contextMenu.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo PHPOS_WEBROOT_URL;?>_phpos/themes/default/phposAPI_installer.css" />
<link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
<meta http-equiv="Expires" content="0" />
<meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate" />
<meta http-equiv="Cache-Control" content="post-check=0, pre-check=0" />
<meta http-equiv="Pragma" content="no-cache" />

</head>
<body>
<?php 				
		// Language switch
		$in_login = 1;
		include PHPOS_DIR.'plugins/tray/tray.languages.php';							
		$wintask = new api_wintask;
		$wintask->setContextMenu($tray['context_menu']);
		$js_context_menu = $wintask->contextMenuRender('lang', 'div', 'hover');	
		?>		
		
		<div id="lang" title="<?php echo $tray['title']; ?>" class="phpos_tray_item phpos_tray_item_mouseleave">
			<div>
				<img src="<?php echo $tray['icons'][0]; ?>" /> 
				<span><b style="color:white"><?php echo strtoupper($_SESSION['installer_lang']); ?></b> | CHANGE LANGUAGE</span>
			</div>
		</div>				
<div id="installer_title">
		<p class="title"><?php echo txt('installer_title2');?></p>
		<p class="version">(<?php echo txt('installer_your_v');?>: <?php echo PHPOS_VERSION;?>)</p>
		
		
		
	</div>	
	
	
<div id="install_step">
		<div class="step_title"><?php echo txt('installer_step');?> <?php echo $step; ?> / 8</div>
		<div class="step_desc"><?php echo $installer->get_step_title(); ?></div>	
		
		<div class="step_list">		
			<?php echo $installer->render_step_titles(); ?>	<Br /><br />		
			<img src="<?php echo PHPOS_WEBROOT_URL; ?>_phpos/installer/install_icon.png" />		
		</div>			
</div>			
		
<div id="installer_footer"><?php echo $footer;?></div>
		
<div id="main">


	<div id="step_body">	
		<div id="step_form">	
		
		<div id="title"><img src="<?php echo PHPOS_WEBROOT_URL;?>_phpos/installer/status_arrow.png" style="" /><?php echo $installer->get_title();?></div>
			<?php 
			if($step == 7)
			{
				if($installer->is_errors())
				{
					echo $installer->info('error', $installer->get_error_msg('install_errors')); 
				} else {
				
					echo $installer->info('info', $installer->get_ok_msg('install_ok')); 
				}
			
				// if installed
				if($_SESSION['need_reinstall'])
				{
						echo '<div style="text-align:right">	<div class="reinstall_btn btn_mouseleave_reinstall"><p>'.txt('installer_reinstall').'</p></div></div>';
				}
			
			} else {			
			
				echo $installer->info('info'); 
				
			}
			?>
			
			<?php if(!empty($install_status)) echo $install_status;	?>
			
			<form id="phpos_installer" method="POST" action="phpos_install.php">
			<input type="hidden" name="step" value="<?php echo $next_step; ?>" />		
			<input type="hidden" name="lang" value="<?php echo $_SESSION['installer_lang']; ?>" />		
			<div id="error_message"></div>	
			
<?php 		
// Render form steps		
switch($step)
{
	// License
	case '1':				
		echo $installer->step_license();
	break;
	
	// System check
	case '2':			
		echo $installer->step_system_check();			
	break;

	// Root password
	case '3':
		echo $installer->step_root_password();			
	break;
	
	// Database config
	case '4':
		echo $installer->step_db_config();				
	break;

	// Site config
	case '5':
		echo $installer->step_site_config();	
	break;

	// Chmod
	case '6':		
		echo $installer->step_chmod_check();		
	break;	
	
}
// end switch
?>			
			<input type="submit" value="step" style="visibility:hidden" />
			</form>					
			
		<div style="text-align:right">	
		<?php 
		
		// If step != first and last, show prev button:
		if($step!=1 && $step!=8)
		{
			if($step == 7)
			{
				if($installer->is_errors()) 	echo '<div class="prev_step_btn btn_mouseleave_prev"><p>'.txt('installer_prev_step').'</p></div>';			
			
			} else {
			
				echo '<div class="prev_step_btn btn_mouseleave_prev"><p>'.txt('installer_prev_step').'</p></div>';
			}			
		}
			
		
		// If step != last, show "next", else "finish"
		if($step != 8)
		{
			// If installation finished
			if($step != 7)			
			{
				echo '<div class="next_step_btn btn_mouseleave_next"><p>'.txt('installer_next_step').'</p></div>';
				
			} else {
				
				// if without errors
				if(!$installer->is_errors())	echo '<div class="next_step_btn btn_mouseleave_next"><p>'.txt('installer_finish_step').'</p></div>';
			}
			
		} else {
			
			// Last step info, please login:
			echo '<div class="next_step_btn btn_mouseleave_next"><p>'.txt('installer_finishlogin_step').'</p></div>';		
		}
		?>
 		
		
		</div>			
		</div>		
	</div>
	<div style="clear:both"></div>	
	
	</div>	
	
<div id="phpos_desktop_logo" style="display:none">
	<img src="<?php echo PHPOS_WEBROOT_URL;?>_phpos/logo.png" />
	<br/>v.<?php echo PHPOS_VERSION;?><br/>
	<?php echo PHPOS_BUILD;?><br />
	<?php //echo 'Language:'.strtoupper(cfg::get('lang'));?>
</div>


<script>
$(document).ready(function() { 

	$('#step_body').delay(200).show('fast');
	$('#step_body').fadeIn('fast').delay(3000);
 	
	// logo
	
	$('#phpos_desktop_logo').delay(2500).show('fast');
	$('#phpos_desktop_logo').fadeIn('slow');		
	

	/* input */
	$('.input').mouseleave(function() {
		if(!$(this).is(":focus"))
		{
			$(this).removeClass('input_mouseclick').removeClass('input_mouseenter').addClass('input_mouseleave');	
		}
	});
	
	$('.input').click(function() {
		$('.input').not(this).removeClass('input_mouseclick').removeClass('input_mouseenter').addClass('input_mouseleave');	
		$(this).removeClass('input_error').removeClass('input_mouseenter').addClass('input_mouseclick');	
	});
	
	$('.input').focusin(function() {
		$('.input').not(this).removeClass('input_mouseclick').removeClass('input_mouseenter').addClass('input_mouseleave');	
		$(this).removeClass('input_error').removeClass('input_mouseenter').addClass('input_mouseclick');	
	});	
	
	
	// click on window	
	$('*').click(function() {
		if(!$('.input').is(":focus"))
		{
			$('.input').removeClass('input_mouseclick').removeClass('input_mouseenter').addClass('input_mouseleave');	
		}		
	});		
		
	
	// form submit	
	 $('#phpos_installer').submit(function(){	 
	 <?php echo $jquery_next; ?>		
   });
	
	
	// next step button	
	$('.next_step_btn').mouseenter(function() {
		$(this).removeClass('btn_mouseleave_next').addClass('btn_mouseenter_next');	
	});	
	
	$('.next_step_btn').mouseleave(function() {
		$(this).removeClass('btn_mouseenter_next').addClass('btn_mouseleave_next');	
	});
	
	
	// reinstall button	
	$('.reinstall_btn').mouseenter(function() {
		$(this).removeClass('btn_mouseleave_reinstall').addClass('btn_mouseenter_reinstall');	
	});	
	
	$('.reinstall_btn').mouseleave(function() {
		$(this).removeClass('btn_mouseenter_reinstall').addClass('btn_mouseleave_reinstall');	
	});
	
	
	<?php if($step != 10) { ?>
	$('.next_step_btn').click(function() {
		$('#phpos_installer').submit();
	});
	<?php } else { ?>
	$('.next_step_btn').click(function() {
		window.location = "index.php";
	});
	<?php }  ?>
	
	// prev step btn
	$('.prev_step_btn').mouseenter(function() {
		$(this).removeClass('btn_mouseleave_prev').addClass('btn_mouseenter_prev');	
	});	
	
	$('.prev_step_btn').mouseleave(function() {
		$(this).removeClass('btn_mouseenter_prev').addClass('btn_mouseleave_prev');	
	});
	
	$('.prev_step_btn').click(function() {
		window.location = '?step=<?php echo $prev_step;?>&lang=<?php echo $_SESSION['installer_lang'];?>';
	});	
	
	$('.reinstall_btn').click(function() {
		if(confirm('<?php echo txt('installer_reinstall_msg');?>')) {
			window.location = '?step=<?php echo $step;?>&lang=<?php echo $_SESSION['installer_lang'];?>&reinstall=1';
		}
	});	
	
	
	/* lang */
	$('.phpos_tray_item').mouseenter(function()
	{
		$(this).removeClass('phpos_tray_item_mouseleave').addClass('phpos_tray_item_mouseenter');	
	});
	
	
	// form row
	$('.form_area_row').mouseover(function() {		
			$(this).removeClass('input_row_mouseleave').addClass('input_row_mouseenter');	
	});	
	
	$('.form_area_row').mouseleave(function() {		
			$(this).removeClass('input_row_mouseenter').addClass('input_row_mouseleave');			
	});
	
	<?php echo $jquery_start; ?>
	
	$('.phpos_tray_item').mouseenter(function()
	{
		$(this).removeClass('phpos_tray_item_mouseleave').addClass('phpos_tray_item_mouseenter');	
	});
	
});

$(function(){
		
		<?php  echo $js_context_menu; ?>		
});
</script>
</body>
</html>