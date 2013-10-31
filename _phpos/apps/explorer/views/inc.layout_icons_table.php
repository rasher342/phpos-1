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

<?php 
if($_SESSION['phpos_explorer_hide_right'])
{
	$showhide_right_link = '<img src="'.THEME_URL.'icons/arrow_small_left.png" style="padding-right:10px;width:10px;display:inline-block;vertical-align:middle"/> <a href="javascript:void(0);" onclick="'.link_action(APP_ACTION, 'hide_right:0').'"><span style="color:#686868">Show Filesystem Column</span></a>';
} else {
	
	$showhide_right_link = '<a href="javascript:void(0);" onclick="'.link_action(APP_ACTION, 'hide_right:1').'"><span style="color:#686868">Hide Filesystem Column</span></a><img src="'.THEME_URL.'icons/arrow_small_right.png" style="padding-left:10px;width:10px;display:inline-block;vertical-align:middle"/>';
}

  
$showhide_right = '<div style="padding:5px;width:98%; text-align:right">'.$showhide_right_link.'</div>';
?>
 
 <?php	echo $showhide_right; ?>
<table width="100%" id="phpos_explorer_files_table_main">

		<tr>

				<td width="100%" valign="top" class="td_icons" id="phpos_explorer_td<?php div();?>">				
			
						<div id="<?php echo $explorer->config('div_contener');?>" class="icons_contener">
						
								<?php if(!$explorerAPI && $_SESSION['phpos_explorer_hide_right'] != 1) echo $layout->column('75%'); ?>				
						
								<?php	echo $html['icons']; ?>
								
								<?php if(!$explorerAPI && $_SESSION['phpos_explorer_hide_right'] != 1) echo $layout->end('column'); ?>						
								
								<?php if(!$explorerAPI && $_SESSION['phpos_explorer_hide_right'] != 1) echo $layout->column('25%'); ?>
								
								<?php 
								
								if(!$explorerAPI && $_SESSION['phpos_explorer_hide_right'] != 1)
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
								
								<?php if(!$explorerAPI && $_SESSION['phpos_explorer_hide_right'] != true) echo $layout->end('column'); ?>	
								
								<?php if(!$explorerAPI && $_SESSION['phpos_explorer_hide_right'] != true) echo $layout->clr(); ?>		
								
						</div>		
			
				</td>

		</tr>
				
</table>	