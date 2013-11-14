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


?><div id="phpos-menustart_task_windows" style="z-index:99999" class="phpos-menustart_task_windows_hide"></div>

<div data-options="border:false,region:'south',split:true, minHeight:70, maxHeight:250, cache:false, style:{zIndex:99999}" id="phpos-menustart_container">

	<div id="phpos-menustart_Button_container" title="Start" class="easyui-tooltip">
		<img src="<?php echo THEME_URL;?>startmenu/api_startmenu-button.png" />
	</div>

	<div id="phpos-menustart_Tasks_container">

		<div id="phpos-menustart_Tasks" class="easyui-panel" title="WindowTasks" 
			data-options="
			iconCls:'',
			closable:false,
			collapsible:false,
			noheader:true,
			width:500,
			border:false,
			minimizable:false,
			loadingMessage:'',
			maximizable:false,
			fit:true,
			cls:'easyui-linkbutton'
			">  
		</div>
		
	</div>

	<div id="phpos-menustart_Tray_container">
	<div style="height:100% auto;display:inline-block; vertical-align:middle">
		<?php require_once(PHPOS_DIR.'controllers/menu_startTrayController.php'); ?>
	</div>	
	<div style="margin-top:10px;padding-left:20px;text-align:center;color:#fff;line-height:160%;height:100% auto;display:inline-block; vertical-align:middle">
	<span id="tray_clock" style="font-weight:bold">17:43</span><br /><?php echo txt('week_'.date('w'));?><br/><?php echo date('Y-m-d'); ?></span>
	</div>
	</div>
	
	
	
	<div id="phpos-menustart_Switch_container">
	<img src="<?php echo ICONS;?>startmenu/switch_arrow_left_inactive.png" id="desktop_switch_left" title="<?php echo txt('desktop_switch_tray_to_db'); ?>"/>
		<img src="<?php echo ICONS;?>startmenu/switch_arrow_right.png"  id="desktop_switch_right"  title="<?php echo txt('desktop_switch_tray_to_local'); ?>"/>
	</div>

</div>

<div id="phpos-menustart_Window_container"></div>
<div id="phpos-menustart_WindowApps_container">	<?php require_once(PHPOS_DIR.'controllers/menu_startAppsController.php'); ?>	</div>
<?php
if(globalconfig('demo_mode') == 1 && !is_root())
{
	echo '<div id="phpos-menustart_Desktop_demo"><span style="font-size:24px">'.txt('demo_mode').'</span><br />'.txt('demo_mode_desc').'</div>';
}
?>
<div id="phpos-menustart_Desktop_info"><img src="<?php echo ICONS;?>desktop_switcher/db.png" style="display:inline-block; vertical-align:middle; padding-right:5px" /><b><?php echo txt('desktop_switch_up_desktop');?></b> <?php echo txt('desktop_switch_up_db');?></div>

<script>
$(document).ready(function() { 
	
	var phpos_desktop = 'database';
	
	$('#desktop_switch_left').mouseenter(function() {
		
		if(phpos_desktop != 'database')
		{
			$(this).attr('src', '<?php echo ICONS;?>startmenu/switch_arrow_left_hover.png');
			$(this).css('cursor', 'pointer');
		}
	});
	
	$('#desktop_switch_left').mouseleave(function() {
		if(phpos_desktop != 'database')
		{
			$(this).attr('src', '<?php echo ICONS;?>startmenu/switch_arrow_left.png');	
		}
	});
	
	$('#desktop_switch_right').mouseenter(function() {
		if(phpos_desktop != 'files')
		{
			$(this).attr('src', '<?php echo ICONS;?>startmenu/switch_arrow_right_hover.png');
			$(this).css('cursor', 'pointer');
		}
	});
	$('#desktop_switch_right').mouseleave(function() {
		if(phpos_desktop != 'files')
		{
			$(this).attr('src', '<?php echo ICONS;?>startmenu/switch_arrow_right.png');
		}
	});
	
	$('#desktop_switch_right').click(function() {
		if(phpos_desktop != 'files')
		{			
			phpos_desktop = 'files';
			$(this).attr('src', '<?php echo ICONS;?>startmenu/switch_arrow_right_inactive.png');
			$('#desktop_switch_left').attr('src', '<?php echo ICONS;?>startmenu/switch_arrow_left.png');
			$('#phpos-menustart_Desktop_info').html('<img src="<?php echo ICONS;?>desktop_switcher/local_files.png" style="display:inline-block; vertical-align:middle; padding-right:5px" /><b><?php echo txt('desktop_switch_up_desktop');?></b> <?php echo txt('desktop_switch_up_local');?>');
			phpos.desktopSwitch('local_files');
		}		
	});
	
	$('#desktop_switch_left').click(function() {
		if(phpos_desktop != 'database')
		{			
			phpos_desktop = 'database';
			$(this).attr('src', '<?php echo ICONS;?>startmenu/switch_arrow_left_inactive.png');
			$('#desktop_switch_right').attr('src', '<?php echo ICONS;?>startmenu/switch_arrow_right.png');
			$('#phpos-menustart_Desktop_info').html('<img src="<?php echo ICONS;?>desktop_switcher/db.png" style="display:inline-block; vertical-align:middle; padding-right:5px" /><b><?php echo txt('desktop_switch_up_desktop');?></b> <?php echo txt('desktop_switch_up_db');?>');
			phpos.desktopSwitch('database');
		}		
	});
	
	// Menu start - mouseover
	$('#phpos-menustart_Button_container').mouseenter(function() {
		$('#phpos-menustart_Button_container').removeClass('start_mouseleave').addClass('start_mouseover');		
		$('#phpos-menustart_Button_container img').attr('src', '<?php echo THEME_URL;?>startmenu/api_startmenu-button_over.png');		
	});
	
// Menu start - mouseout	
	$('#phpos-menustart_Button_container').mouseleave(function() {
		$('#phpos-menustart_Button_container img').attr('src', '<?php echo THEME_URL;?>startmenu/api_startmenu-button.png');
		$('#phpos-menustart_Button_container').removeClass('start_mouseover').addClass('start_mouseleave');		
	});
	
});
</script>