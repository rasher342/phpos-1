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


/*
 echo 'OPENED_ID:'.$my_app->get_param('opened_file_id').'  name:'.$my_app->get_param('opened_file_name').'  ext:'.$my_app->get_param('opened_file_extension').'  app_id:'.$my_app->get_param('opened_file_app_id').'<br>SAVE_AS: '.$my_app->get_param('explorer_save_as_filename').'<br>content<br>'.$api_file_content; */?>


<table width="100%" id="phpos_explorer_files_table_main">

		<tr>

				<td width="100%" valign="top" class="td_icons" id="phpos_explorer_td<?php div();?>">				
			
						<div id="<?php echo $explorer->config('div_contener');?>" class="icons_contener">
						
								<?php if(!$explorerAPI) echo $layout->column('75%'); ?>				
						
								<?php	echo $html['icons']; ?>
								
								<?php if(!$explorerAPI) echo $layout->end('column'); ?>						
								
								<?php if(!$explorerAPI) echo $layout->column('25%'); ?>
								
								<?php 
								
								if(!$explorerAPI)
								{		
								
									
									if(APP_ACTION != 'my_server')
									{
										echo $html['right_items']; 
										
									} else {
								
								?>
								
									<img src="<?php echo ICONS;?>server/bg.png"  style="width:192px;height:192px"/><br />
									<?php include MY_APP_DIR.'views/inc.server_info.php';?>
								<?php
								
									}			
								
								
								}
								?>	
								
								<?php if(!$explorerAPI) echo $layout->end('column'); ?>	
								
								<?php if(!$explorerAPI) echo $layout->clr(); ?>		
								
						</div>		
			
				</td>

		</tr>
				
</table>	