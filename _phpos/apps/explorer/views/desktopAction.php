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


if(!defined("PHPOS_IN_EXPLORER"))
{
	die();
}
?>	
	
		<div id="phpos_explorer_div<?php div();?>" class="phpos_explorer_files_body desktop_body" style="height:100% auto">
				
			<table width="100%" id="phpos_explorer_files_table_main">
				<tr>

				<td width="100%" valign="top" class="td_icons" id="phpos_explorer_td<?php div();?>">	
					<div id="<?php echo $explorer->config('div_contener');?>" class="icons_contener">
					<?php	echo $html['icons']; ?>
					</div>
				</td>

				</tr>
			</table>	
				
		</div>
	<?php include MY_APP_DIR.'views/inc.explorer_dropzone_js.php'; ?>

<?php include MY_APP_DIR.'views/jquery.php'; ?>