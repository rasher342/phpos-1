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


if(!defined('PHPOS_EXPLORER_PLUGIN')) die();

$items = null;


$u = new phpos_users;
$u->set_id_user(logged_id());
$u->get_user_by_id();
$hash = $u->get_home_dir_hash();
$dir = PHPOS_HOME_DIR.$hash.'/';


$default_span = 'explorer_tree_item';
$marked_span = 'explorer_tree_item_marked';

$span['download'] = $default_span;
$span['clipboard'] = $default_span;
$span['desktop'] = $default_span;
$span['docs'] = $default_span;
$span['pics'] = $default_span;
$span['wallpapers'] = $default_span;
$span['icons'] = $default_span;
$span['video'] = $default_span;
$span['temp'] = $default_span;

$dir_id = $my_app->get_param('dir_id');

$mark_lib = 0;

if($my_app->get_param('fs') == 'local_files' && APP_ACTION == 'index')
{
	switch($dir_id)
	{
		case $dir.'_Desktop':
			$span['desktop'] = $marked_span;
			$mark_lib = 1;
		break;
		
		case $dir.'_Download':
			$span['download'] = $marked_span;
			$mark_lib = 1;
		break;
		
		case $dir.'_Documents':
			$span['docs'] = $marked_span;
			$mark_lib = 1;
		break;
		
		case $dir.'_Pictures':
			$span['pics'] = $marked_span;
			$mark_lib = 1;
		break;
		
		case $dir.'_Wallpapers':
			$span['wallpapers'] = $marked_span;
			$mark_lib = 1;
		break;
		
		case $dir.'_Icons':
			$span['icons'] = $marked_span;
			$mark_lib = 1;
		break;
		
		case $dir.'_Video':
			$span['video'] = $marked_span;
			$mark_lib = 1;
		break;
		
		case $dir.'_Clipboard':
			$span['clipboard'] = $marked_span;
			$mark_lib = 1;
		break;
		
		case $dir.'_Temp':
			$span['temp'] = $marked_span;
			$mark_lib = 1;
		break;

	}
}


$tmp_header = '<span class="explorer_tree_header">'.txt('libs').'</span>';
if($mark_lib == 1) $tmp_header = '<span class="explorer_tree_header_marked">'.txt('libs').'</span>';


$html['left_tree'].= '
<ul id="explorer_tree'.WIN_ID.'" class="easyui-tree">
	<li data-options="iconCls:\'icon-favs\'">
        <span><a title="'.txt('lib_desktop').'" href="javascript:void(0);" onclick="phpos.windowActionChange(\''.WIN_ID.'\', \'index\' , \'reset_shared:1,dir_id:'.$dir.'_Desktop,in_shared:0,tmp_shared_id:0,shared_id:0,app_id:index,fs:local_files\')">'.$tmp_header.'</a></span>
				<ul>
				
				
					<li data-options="iconCls:\'icon-folder\'"><span><a title="'.txt('lib_desktop').'" href="javascript:void(0);" onclick="phpos.windowActionChange(\''.WIN_ID.'\', \'index\' , \'reset_shared:1,dir_id:'.$dir.'_Desktop,in_shared:0,tmp_shared_id:0,shared_id:0,app_id:index,fs:local_files\')"><span class="'.$span['desktop'].'">'.txt('lib_desktop').'</span></a></span></li>
				
				<li data-options="iconCls:\'icon-folder\'"><span><a title="'.txt('lib_download').'" href="javascript:void(0);" onclick="phpos.windowActionChange(\''.WIN_ID.'\', \'index\' , \'reset_shared:1,dir_id:'.$dir.'_Download,in_shared:0,tmp_shared_id:0,shared_id:0,app_id:index,fs:local_files\')"><span class="'.$span['download'].'">'.txt('lib_download').'</span></a></span></li>
				
					<li data-options="iconCls:\'icon-folder\'"><span><a title="'.txt('lib_docs').'" href="javascript:void(0);" onclick="phpos.windowActionChange(\''.WIN_ID.'\', \'index\' , \'reset_shared:1,dir_id:'.$dir.'_Documents,in_shared:0,tmp_shared_id:0,shared_id:0,app_id:index,fs:local_files\')"><span class="'.$span['docs'].'">'.txt('lib_docs').'</span></a></span></li>
					
						<li data-options="iconCls:\'icon-folder\'"><span><a title="'.txt('lib_pics').'" href="javascript:void(0);" onclick="phpos.windowActionChange(\''.WIN_ID.'\', \'index\' , \'reset_shared:1,dir_id:'.$dir.'_Pictures,in_shared:0,tmp_shared_id:0,shared_id:0,app_id:index,fs:local_files\')"><span class="'.$span['pics'].'">'.txt('lib_pics').'</span></a></span></li>
				
					<li data-options="iconCls:\'icon-folder\'"><span><a title="'.txt('lib_wallpapers').'" href="javascript:void(0);" onclick="phpos.windowActionChange(\''.WIN_ID.'\', \'index\' , \'reset_shared:1,dir_id:'.$dir.'_Wallpapers,in_shared:0,tmp_shared_id:0,shared_id:0,app_id:index,fs:local_files\')"><span class="'.$span['wallpapers'].'">'.txt('lib_wallpapers').'</span></a></span></li>
					
							<li data-options="iconCls:\'icon-folder\'"><span><a title="'.txt('lib_music').'" href="javascript:void(0);" onclick="phpos.windowActionChange(\''.WIN_ID.'\', \'index\' , \'reset_shared:1,dir_id:'.$dir.'_Icons,in_shared:0,tmp_shared_id:0,shared_id:0,app_id:index,fs:local_files\')"><span class="'.$span['icons'].'">'.txt('lib_icons').'</span></a></span></li>
					
				
					<li data-options="iconCls:\'icon-folder\'"><span><a title="'.txt('lib_media').'" href="javascript:void(0);" onclick="phpos.windowActionChange(\''.WIN_ID.'\', \'index\' , \'reset_shared:1,dir_id:'.$dir.'_Video,in_shared:0,tmp_shared_id:0,shared_id:0,app_id:index,fs:local_files\')"><span class="'.$span['video'].'">'.txt('lib_media').'</span></a></span></li>
					
					<li data-options="iconCls:\'icon-folder\'"><span><a title="'.txt('lib_clipboard').'" href="javascript:void(0);" onclick="phpos.windowActionChange(\''.WIN_ID.'\', \'index\' , \'reset_shared:1,dir_id:'.$dir.'_Clipboard,in_shared:0,tmp_shared_id:0,shared_id:0,app_id:index,fs:local_files\')"><span class="'.$span['clipboard'].'">'.txt('lib_clipboard').'</span></a></span></li>
					
					
					<li data-options="iconCls:\'icon-folder\'"><span><a title="'.txt('lib_temp').'" href="javascript:void(0);" onclick="phpos.windowActionChange(\''.WIN_ID.'\', \'index\' , \'reset_shared:1,dir_id:'.$dir.'_Temp,in_shared:0,tmp_shared_id:0,shared_id:0,app_id:index,fs:local_files\')"><span class="'.$span['temp'].'">'.txt('lib_temp').'</span></a></span></li>
				
			
				
				</ul>
	</li>
</ul>';

$items = null;
?>