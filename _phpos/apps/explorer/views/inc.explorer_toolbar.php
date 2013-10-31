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

?><div id="phpos_explorer_toolbar">				
			
			<div id="explorer_click_area<?php div();?>">
				<div id="phpos_explorer_address_bar_container">
					<div class="address_area">
						
						<div class="nav_icons_container">
						<?php echo $html['navbar']; ?>
						</div>
						
						<div class="nav_address_container">
					<?php echo $html['addressbar']; ?>
					</div>
					</div>

					<?php 
					if(!$explorerAPI && APP_ACTION == 'index' && 
					($my_app->get_param('fs') == 'ftp' || $my_app->get_param('fs') == 'clouds_google_drive' || 
					($my_app->get_param('fs') == 'local_files' && (!$readonly && globalconfig('disable_upload') !=1  || 
					is_root())))) 
					{ ?>
					<div id="phpos_explorer_uploader_container" class="easyui-tooltip" title="<?php echo txt('tip_explorer_upload_file');?>">
						<form enctype="multipart/form-data" method="post" action="<?php echo helper_post('null', array('fs' => $app_param['fs'])); ?>" id="upload" class="upload_form" style="background: transparent"> 
						
							<input type="hidden" name="phpos_upload" value="1"> 
							<input type="hidden" name="posttest" value="postyes"> 
						
							<img style="height:29px" valign="middle" src="<?php echo THEME_URL;?>windows/explorer_upload_icon.png"><input type="file" name="file" style="background: transparent; color:white; font-size:10px">
							<input type="submit" value="<?php echo txt('upload');?>">
						
						</form>
					</div>
					<?php } ?>
					
					<div class="clear"></div>
				</div>
				
				</div>
				
			</div>