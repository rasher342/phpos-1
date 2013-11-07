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


?>
<div id="phpos_desktop_logo" style="display:none">
<img src="<?php echo PHPOS_WEBROOT_URL;?>_phpos/logo.png" />
<br/>v.<?php echo PHPOS_VERSION_NAME;?><br/>
<?php echo PHPOS_BUILD;?><br />
<?php echo txt('language').':'.strtoupper($config->get_user('lang'));?>
</div>

<?php 

$msg = new phpos_messages;
if($msg->have_unreaded())
{
	$msg_message = txt('messager_tray_got_now_messages').'<br/><a href="javascript:open_msg()" ><span style="font-size:14px"><b>'.txt('messager_tray_click_to_read').'</b></span></a>';
	
	
	$link = helper::win(txt('updater_tray_title'), 'app', 'app_id:messenger'); 
	 echo '
	 <script>
	 function open_msg() {
		'.$link.'
	 }
	</script>'; 
	msg::messenger($msg_message);
}



if($updater_message !== null)
{
	$link = helper::win(txt('updater_tray_title'), 'app', 'app_id:updater'); 
	 echo '
	 <script>
	 function updater() {
		'.$link.'
	 }
	</script>'; 
	msg::updater($updater_message);
}
?>

<script>
$(document).ready(function() { 

$('#phpos_desktop_logo').delay(1500).show('fast');
$('#phpos_desktop_logo').fadeIn('slow').delay(5000).fadeOut('slow');

$.wallpaper({
	file: "<?php 
	
	$my_wallpaper_type = myconfig('wallpaper_type');
	
	$wallpaper = new phpos_wallpapers;
	
	if($my_wallpaper_type == 'user')
	{
		echo $wallpaper->get_user_url(myconfig('wallpaper'));	
		
	} else {
	
		echo $wallpaper->get_global_url(myconfig('wallpaper'));	
	}
	
	//echo PHPOS_WEBROOT_URL.myconfig('wallpaper');?>"
});
	phpos.windowDesktopCreate('PHPOS DESKTOP', 'app', 'app_id:explorer@desktop, parent_id:0', 'fs:db_mysql');
	
	phpos.tray_clock();
});
</script>
