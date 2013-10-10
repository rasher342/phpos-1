<?php	
/*
**********************************

	PHPOS Web Operating system
	MIT License
	(c) 2013 Marcin Szczyglinski
	szczyglis83@gmail.com
	GitHUB: https://github.com/phpos/
	File version: 1.0.0, 2013.10.09
 
**********************************
*/
if(!defined('PHPOS'))	die();	
?><div data-options="fit:true" class="easyui-layout" id="phpos_startmenu_layout" style="background:transparent">
				
			 
				<div data-options="region:'west',title:'',split:true" id="phpos_startmenu_layout_left">
				<?php echo $items; ?>
				</div>	
				
				
				
		<div id="phpos_startmenu_layout_right" data-options="region:'center',title:''">
		
			
				<div class="user_area"><img src="<?php echo PHPOS_WEBROOT_URL;?>_phpos/themes/default/icons/user_medium.png"><br /><span class="user_name"><?php 
				$user = new phpos_users;
				$user->get_logged_user();
				echo $user->get_user_login();
				?>
				</span><br /><span class="user_type"><?php
				$user_type = $user->get_user_type();
				switch($user_type)
				{
					case '1':
						$usr_str = txt('user_user');
					break;
					
					case '2':
						$usr_str = txt('user_admin');
					break;
					
					case '3':
						$usr_str = '<span style="color:#FFF;background-color:#c91b1f;font-weight:bold;padding:2px;margin:2px">'.txt('user_root').'</span>';
					break;		
					
				}
				
				echo $usr_str;
				
				
				?></span><br /><span class="user_ip">IP <?php echo getIP(); ?></span></div>	
		
		
		
		
				<div class="startmenu_right_item" onclick="<?php echo winopen(txt('my_server'), 'app', 'app_id:explorer@my_server','fs:local_files'); ?>"><span><b><?php echo txt('my_server');?></b></span></div>	
				<div class="startmenu_right_item" onclick="<?php echo winopen(txt('home_local_folder'), 'app', 'app_id:explorer@index','fs:local_files'); ?>"><span><?php echo txt('home_local_folder');?></span></div>	
				<div class="startmenu_right_item" onclick="<?php echo winopen(txt('home_db_folder'), 'app', 'app_id:explorer@index','fs:db_mysql'); ?>"><span><?php echo txt('home_db_folder');?></span></div>	
				<div class="startmenu_right_item" onclick="<?php echo winopen(txt('ftp_folders'), 'app', 'app_id:explorer@ftp','fs:local_files'); ?>"><span><?php echo txt('ftp_folders');?></span></div>
				<div class="separator"></div>				
					<div class="startmenu_right_item" onclick="phpos.menustartAppsSwitch();"><span><b><?php echo txt('mstart_apps');?></b></span></div>
					<div class="startmenu_right_item" onclick="<?php echo winopen(txt('control_panel'), 'app', 'app_id:explorer@cp','fs:local_files'); ?>"><span><?php echo txt('control_panel');?></span></div>
				<div class="startmenu_right_item" onclick="<?php echo winopen(txt('account_settings'), 'cp', 'app_id:users@index',''); ?>"><span><?php echo txt('account_settings');?></span></div>	
				<?php if(is_root() || is_admin()) { ?>
				<div class="startmenu_right_item" onclick="<?php echo winopen(txt('sys_info'), 'cp', 'app_id:system_info@index',''); ?>"><span><?php echo txt('sys_info');?></span></div>	
				<?php } ?>							
		
				
				<div class="startmenu_right_item">	<a href="<?php echo PHPOS_ONLINE; ?>?from=phpos_client&lang=<?php echo myconfig('lang'); ?>" target="_blank"><span><?php echo txt('start_phpos_online');?></span></a> / 	<a href="<?php echo PHPOS_GITHUB; ?>" target="_blank"><span>GitHUB</span></a></div>
				
				
				<?php if(is_root() || is_admin()) { ?>
				<div class="startmenu_right_item" onclick="<?php echo winopen(txt('updates'), 'app', 'app_id:updater@index',''); ?>"><span><?php echo txt('updates');?></span></div>				
				<?php } ?>
		
			
				
		</div>
		
		<div data-options="region:'south',title:'',split:true" id="phpos_startmenu_layout_footer">
		
		<div class="column_info_server"><span style="color:#653299"><b>PHPOS</b> <?php echo PHPOS_VERSION_NAME;?></span><br /><b><?php echo txt('start_ip'); ?>:</b> <?php echo $_SERVER['SERVER_ADDR'];?></div>
		<div class="column_info_php"><?php if(is_root() | is_admin()) { ?><b>PHP</b> <?php echo phpversion();?><br /><b><?php echo txt('start_db'); ?></b> <?php echo $db_adapter; } ?></div>
		<div class="column_logout" title="<?php echo txt('click_to_logout');?>"><?php echo txt('logout');?></div>
		
		
		
		</div>
		
</div>


<script>
$(document).ready(function() { 

	$('.startmenu_left_item').mouseenter(function()
	{
		$(this).removeClass('mouseleave').addClass('mouseenter');	
	});
	
	$('.startmenu_left_item').mouseleave(function()
	{
		$(this).removeClass('mouseenter').addClass('mouseleave');	
	});
	
	$('.startmenu_right_item').mouseenter(function()
	{
		$(this).removeClass('mouseleave').addClass('mouseenter');	
	});
	
	$('.startmenu_right_item').mouseleave(function()
	{
		$(this).removeClass('mouseenter').addClass('mouseleave');	
	});
	
	$('.column_logout').mouseenter(function()
	{
		$(this).addClass('mouseenter');	
	});
	
	$('.column_logout').mouseleave(function()
	{
		$(this).removeClass('mouseenter');	
	});
	
	$('.column_logout').click(function()
	{
		window.location='?logout=1';
	});
	

});

</script>