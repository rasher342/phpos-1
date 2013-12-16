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
	error_reporting(E_ERROR | E_PARSE);
	include 'version.php';
	session_start();
	define('PHPOS', true);	
	define('PHPOS_FS', true);
	define('PHPOS_IN_EXPLORER', true);
	define('PHPOS_APP_SYS', true);
	
	define('LOGIN_SCREEN', true);	

	define('PHPOS_URL', '../_phpos/'); 
	define('PHPOS_DIR', '../_phpos/'); 
	define('PHPOS_WEBROOT', '');	
	define('PHPOS_WEBROOT_URL', '');
	define('PHPOS_WEBROOT_DIR', '');
	
	require PHPOS_DIR.'config/core.php';
	require_once(PHPOS_DIR.'common/check_install.php');
	define('PHPOS_INSTALLED', true);	
	
	require PHPOS_DIR.'config/database.php';	
	require_once(PHPOS_DIR.'controllers/databaseController.php');	
	require_once(PHPOS_DIR.'classes/class.phpos_filters.php');

	require_once(PHPOS_DIR.'classes/class.users.php');	
	require_once(PHPOS_DIR.'classes/class.phpos_config.php');	
		
	$config = new phpos_config;
	$config->set_id_user();
	
	require_once(PHPOS_DIR.'classes/class.api_wintask.php');	
	require_once(PHPOS_DIR.'classes/class.helpers.php');
	require_once(PHPOS_DIR.'controllers/helpersController.php');	
	require_once(PHPOS_DIR.'classes/class.languages.php');
	require_once(PHPOS_DIR.'controllers/languageController.php');
	require_once(PHPOS_DIR.'classes/class.phpos_wallpapers.php');	
	 

	
	$usr = new phpos_users;
	
	
	if(isset($_POST['phpos_login_me']) && $_POST['phpos_login_me'] == '1')
	{
		session_regenerate_id();
		
		$usr->set_user_login(strip_tags($_POST['phpos_login']));
		$usr->set_raw_pass(strip_tags($_POST['phpos_password']));
		if($usr->login())
		{
		
		} else {
			$error_message = txt('wrong_login').'<br><b>'.txt('try_again').'</b>';	
		}
		
		/*
		if($_POST['phpos_login'] == 'demo' && $_POST['phpos_password'] == 'demo')
		{
			$_SESSION['logged'] = 1;
			header('Location: '.PHPOS_WEBROOT_URL.'phpos_desktop.php?logged=1&lang='.$_GET['lang']);
		} else {
			$error_message = txt('wrong_login').'<br><b>'.txt('try_again').'</b>';	
		}		
		*/
	}
	

		
	
?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo txt('login_title'); ?></title>
<link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
<script type="text/javascript" src="<?php echo PHPOS_WEBROOT_URL;?>_phpos/javascript/jquery/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo PHPOS_WEBROOT_URL;?>_phpos/javascript/phposAPI_login.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo PHPOS_WEBROOT_URL;?>_phpos/javascript/contextMenu/jquery.contextMenu_login.css" />
<script type="text/javascript" src="<?php echo PHPOS_WEBROOT_URL;?>_phpos/javascript/contextMenu/jquery.contextMenu.js"></script>
<script type="text/javascript" src="<?php echo PHPOS_WEBROOT_URL;?>_phpos/javascript/wallpaper/jquery.bp.wallpaper.min.js"></script>

<link rel="stylesheet" type="text/css" href="<?php echo PHPOS_WEBROOT_URL;?>_phpos/themes/default/phposAPI_login.css" />

</head>
<body>
<div id="main">

	<div id="login_form"<?php if(!empty($error_message)) 
				{
					echo ' class="msg_error"';
				} else {
					echo ' class="msg_no_error"';
				}
				?>>
	
		<div id="form_img"><img src="<?php echo PHPOS_WEBROOT_URL; ?>_phpos/icons/user.png" /></div>	
		<div id="form_form">	
			<div id="form_title"><b><?php echo txt('login_title_you_are_not_logged'); ?></b><br /><?php echo txt('login_title_please_login'); ?></div>
			
			<form id="phpos_login" method="POST" action="phpos_login.php?lang=<?php echo $_GET['lang']; ?>">
			<input type="hidden" name="phpos_login_me" value="1" />
				
				<div class="form_area_row input_row_mouseleave">
					<div class="form_area_title"><?php echo txt('login'); ?></div>
					<div class="form_area_input"><input title="<?php echo txt('enter_login_here'); ?>" id="input_login" class="input_mouseleave" type="text" name="phpos_login" <?php if(!empty($_SESSION['first_login'])) { echo ' value="'.$_SESSION['first_login'].'"'; unset($_SESSION['first_login']); }?>/></div>
					<div style="clear:both"></div>
					
				</div>
				<div class="form_area_row input_row_mouseleave">
					<div class="form_area_title"><?php echo txt('password'); ?></div>
					<div class="form_area_input"><input title="<?php echo txt('enter_pass_here'); ?>" id="input_password" class="input_mouseleave" type="password" name="phpos_password" <?php if(!empty($_SESSION['first_password'])) { echo ' value="'.$_SESSION['first_password'].'"'; unset($_SESSION['first_password']); }?>/></div>
					<div style="clear:both"></div>
				</div>
				

				<?php if(!empty($error_message)) 
				{
					echo '<div id="error_message"><p>'.$error_message.'</p></div>';
				} else {
					echo '<div id="error_message" style="display:none"></div>';
				}
				
				
				$in_login = 1;
				include PHPOS_DIR.'plugins/tray/tray.languages.php';							
				$wintask = new api_wintask;
				$wintask->setContextMenu($tray['context_menu']);
				$js_context_menu = $wintask->contextMenuRender('lang', 'div', 'hover');		
			
				echo '<div id="lang" title="'.$tray['title'].'" class="phpos_tray_item phpos_tray_item_mouseleave"><div><img src="'.$tray['icons'][0].'" /> <span><b style="color:white">'.strtoupper($login_language).'</b> | CHANGE LANGUAGE</span></div></div>';					
				
				
				
				?>
				<div class="form_login_btn btn_mouseleave" title="<?php echo txt('login_btn_tip'); ?>"><p><?php echo txt('login_btn_txt'); ?></p></div>
				<input type="submit" value="login" style="visibility:hidden" />
			</form>
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

<div id="phpos_desktop_www" style="display:none">
<b>Official site of PHPOS:</b> <a href="http://www.phpos.pl" target="_blank">www.phpos.pl</a>
</div>

<?php if($_GET['noinfo'] != 'yes') { ?>
<div id="phpos_desktop_info" style="display:none">
<div style="width:50%; float:left">
<img src="<?php echo PHPOS_WEBROOT_URL;?>_phpos/logo_gdrive.png"/>
</div>

<div style="text-align:left;width:50%; float:left">
<?php echo txt('googledrive_loginscreen_info'); ?>
</div>
<div style="clear:both"></div>
<?php //echo 'Language:'.strtoupper(cfg::get('lang'));?>
</div>

<?php } ?>
<script>


$(document).ready(function() { 

	$.wallpaper({
	file: "<?php
	$wallpaper = new phpos_wallpapers;
	echo $wallpaper->get_global_url(globalconfig('wallpaper'));	
	?>"
	});
	
	
	
	$('#login_form').center();    
	$(window).bind('resize', function() {
    $('#login_form').center({transition:300});
  });
		
	<?php 
	if(!empty($error_message) || !empty($_GET['lang']))
	{
		echo "$('#login_form').delay(200).show('fast');
	$('#login_form').fadeIn('fast').delay(3000);";
	
	
	} else {
		echo "$('#login_form').delay(500).show('slow');
	$('#login_form').fadeIn('slow').delay(5000);";
	
	}
	?>
	$('#phpos_desktop_www').delay(1000).show('fast');
 	$('#phpos_desktop_info').delay(1500).show('fast');
	//$('#phpos_desktop_info').fadeIn('slow').delay(30000).fadeOut('slow');	

	$('#phpos_desktop_logo').delay(2500).show('fast');
	//$('#phpos_desktop_logo').fadeIn('slow').delay(30000).fadeOut('slow');		
	
	$('.form_login_btn').mouseenter(function() {
		$(this).removeClass('btn_mouseleave').addClass('btn_mouseenter');	
	});	
	
	$('.form_login_btn').mouseleave(function() {
		$(this).removeClass('btn_mouseenter').addClass('btn_mouseleave');	
	});
		
	$('#input_login').mouseover(function() {
		if(!$(this).is(":focus"))
		{
			$(this).removeClass('input_mouseclick').removeClass('input_mouseleave').addClass('input_mouseenter');	
		}
	});	
	
	$('#input_login').mouseleave(function() {
		if(!$(this).is(":focus"))
		{
			$(this).removeClass('input_mouseclick').removeClass('input_mouseenter').addClass('input_mouseleave');	
		}
	});
	
	$('#input_login').click(function() {
		$('#input_password').removeClass('input_mouseclick').removeClass('input_mouseenter').addClass('input_mouseleave');	
		$(this).removeClass('input_mouseenter').addClass('input_mouseclick');	
	});
	
	$('#input_login').focusin(function() {
		$('#input_password').removeClass('input_mouseclick').removeClass('input_mouseenter').addClass('input_mouseleave');	
		$(this).removeClass('input_mouseenter').addClass('input_mouseclick');	
	});
	
	
	$('#input_password').mouseover(function() {
		if(!$(this).is(":focus"))
		{
			$(this).removeClass('input_mouseclick').removeClass('input_mouseleave').addClass('input_mouseenter');	
		}
	});	
	
	$('#input_password').mouseleave(function() {
		if(!$(this).is(":focus"))
		{
			$(this).removeClass('input_mouseclick').removeClass('input_mouseenter').addClass('input_mouseleave');	
		}
	});
	
	$('#input_password').click(function() {
		$('#input_login').removeClass('input_mouseclick').removeClass('input_mouseenter').addClass('input_mouseleave');	
		$(this).removeClass('input_mouseenter').addClass('input_mouseclick');	
	});
	
	$('#input_password').focusin(function() {
		$('#input_login').removeClass('input_mouseclick').removeClass('input_mouseenter').addClass('input_mouseleave');	
		$(this).removeClass('input_mouseenter').addClass('input_mouseclick');	
	});
	
	$('*').click(function() {
		if(!$('#input_password').is(":focus"))
		{
			$('#input_password').removeClass('input_mouseclick').removeClass('input_mouseenter').addClass('input_mouseleave');	
		}
		
		if(!$('#input_login').is(":focus"))
		{
			$('#input_login').removeClass('input_mouseclick').removeClass('input_mouseenter').addClass('input_mouseleave');	
		}
	});		
		
	
	
	 $('#phpos_login').submit(function(){
	 
		if($('#input_login').val() == '' || $('#input_password').val() == '')
		{			
			$('#error_message').html('<p><?php echo txt('login_empty_fields'); ?></p>');
			$('#error_message').css('display', 'block');			
		
			return false;
		}   
		
   });
	
	
	$('.form_login_btn').click(function() {
		$('#phpos_login').submit();
	});
	
	
	/* lang */
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