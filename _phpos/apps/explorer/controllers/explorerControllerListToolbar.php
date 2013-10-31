<?php
/*
**********************************

	PHPOS Web Operating system
	MIT License
	(c) 2013 Marcin Szczyglinski
	szczyglis83@gmail.com
	GitHUB: https://github.com/phpos/
	File version: 1.2.8, 2013.10.26
 
**********************************
*/
if(!defined('PHPOS'))	die();

$html['icons'].= '
<div class="phpos_explorer_list_toolbar">';
			
	if($my_app->get_param('fs') == 'local_files')
	{
		$html['icons'].= '<div class="phpos_explorer_list_toolbar_item">
		<a href="javascript:void(0);" title="'.txt('list_download_desc').'" onclick="phpos.list_download(\''.WIN_ID.'\');">
		<img src="'.ICONS.'/explorer_toolbar/download.png" /><br />'.txt('download').'</a>
		</div>
		
		<div class="phpos_explorer_list_toolbar_item">
		<a href="javascript:void(0);" title="'.txt('list_zip_desc').'" onclick="phpos.list_zip(\''.WIN_ID.'\');">
		<img src="'.ICONS.'/explorer_toolbar/zip2.png" /><br />'.txt('list_pack_zip').'</a>
		</div>';
	}
	
	$html['icons'].= '<div class="phpos_explorer_list_toolbar_item">
	<a href="javascript:void(0);" title="'.txt('list_cut_desc').'" onclick="phpos.list_cut(\''.WIN_ID.'\');">
	<img src="'.ICONS.'/explorer_toolbar/cut.png" /><br />'.txt('cut').'</a>
	</div>
	
	<div class="phpos_explorer_list_toolbar_item">
	<a href="javascript:void(0);" title="'.txt('list_copy_desc').'" onclick="phpos.list_copy(\''.WIN_ID.'\');">
	<img src="'.ICONS.'/explorer_toolbar/copy.png" /><br />'.txt('copy').'</a>
	</div>
	
	<div class="phpos_explorer_list_toolbar_item">
	<a href="javascript:void(0);" title="'.txt('list_delete_desc').'" onclick="phpos.list_delete(\''.WIN_ID.'\');">
	<img src="'.ICONS.'/explorer_toolbar/delete.png" /><br />'.txt('delete').'</a>
	</div>

</div>

<div class="phpos_explorer_list_toolbar_select">
<span><a href="javascript:void(0);" title="'.txt('list_select_all_desc').'" onclick="phpos.list_select_all(\''.WIN_ID.'\');"><img src="'.THEME_URL.'icons/arrow_down_small2.png" /> '.txt('list_select_all').'</a>

<a href="javascript:void(0);" title="'.txt('list_select_none_desc').'" onclick="phpos.list_unselect_all(\''.WIN_ID.'\');"><img src="'.THEME_URL.'icons/arrow_down_small2.png" /> '.txt('list_select_none').'</a>

<a href="javascript:void(0);" title="'.txt('list_select_reverse_desc').'" onclick="phpos.list_reverse_select(\''.WIN_ID.'\');"><img src="'.THEME_URL.'icons/arrow_down_small2.png" /> '.txt('list_select_reverse').'</a></span>
</div>';

?>