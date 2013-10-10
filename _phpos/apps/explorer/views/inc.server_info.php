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
					<div class="phpos_server_info">
					<div class="phpos_server_cp_link"><img src="<?php echo ICONS;?>server/cp.png" class="server_cp_link" /><span><a href="javascript:void(0);" onclick="phpos.windowActionChange('<?php echo WIN_ID;?>', 'cp')"><span style="font-weight:bold;padding-left:15px;font-size:14px"><?php echo txt('control_panel'); ?></span></a><br />
					</div>
					</div>
					
					
					
					<?php echo $layout->column('40%'); ?>
					<div style="padding-left:30px; font-weight:bold">IP:<br />OS:<br />PHP:<br />DB:<br /></div>	
					<?php echo $layout->end('column'); ?>	
					
					
					<?php echo $layout->column('50%'); ?>
			<b><?php echo $_SERVER['SERVER_ADDR']; ?></b><br /><?php 
			if(globalconfig('demo_mode') != 1 || is_root())
			{
				echo PHP_OS;
			} else {
				echo 'XXXXX';
			}
			?><br /><?php 
			if(globalconfig('demo_mode') != 1 || is_root())
			{			
				echo phpversion();
			} else {
				echo 'XXXXX';
			}
				?><br />MySQL<br />
					<?php echo $layout->end('column'); ?>	
					<?php echo $layout->clr(); ?>				