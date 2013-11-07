<?php
/*
**********************************

	PHPOS Web Operating system
	MIT License
	(c) 2013 Marcin Szczyglinski
	szczyglis83@gmail.com
	GitHUB: https://github.com/phpos/
	File version: 1.3.0, 2013.10.29
 
**********************************
*/
if(!defined('PHPOS'))	die();	

if(!defined('PHPOS_EXPLORER_PLUGIN')) die();



// Local_files

	$global_fs = $my_app->get_param('fs');
	$dir_id = $my_app->get_param('dir_id');	
			 
/*
**************************
*/
 	
	$closed = '';
	
	$my_fs = 'local_files';
	$filesystem_class = 'phpos_fs_plugin_'.$my_fs;	
			 
/*
**************************
*/
 	
	$treeFS = new $filesystem_class; // start filesytem		
	$tree_explorer = new app_explorer;
	$tree_explorer->set_fs($my_fs);
	
	$tree_explorer->assign_filesystem($treeFS);
	$tree_explorer->assign_window($apiWindow);
	$tree_explorer->assign_my_app($my_app);		
	
	$root_id = $treeFS->get_root_directory_id();
			 
/*
**************************
*/
 	
	if($dir_id == $root_id || $global_fs != $my_fs || $mark_lib == 1 || $my_app->get_param('shared_id') != null || $my_app->get_param('tmp_shared_id') != null)
	{
		$closed = ',state:\'closed\'';
	}
			 
/*
**************************
*/

	$tmp_item = '<span class="explorer_tree_item">'.txt('home_local_folder').'</span>';
	if($mark_lib != 1 && APP_ACTION == 'index' && $my_app->get_param('fs') == 'local_files') $tmp_item = '<span class="explorer_tree_item_marked">'.txt('home_local_folder').'</span>'; 	
		
		$tree_local_files = '
		<li data-options="iconCls:\'icon-hdd\''.$closed.'">
		<span><a title="'.txt('home_local_folder').'" href="javascript:void(0);" onclick="'.link_action('index', 'tmp_shared_id:0,workgroup_id:0,reset_shared:1,ftp_id:0,cloud_id:0,in_shared:0,shared_id:0,root_id:'.$root_id.',dir_id:'.$root_id.',fs:'.$my_fs).'">'.$tmp_item.'</a></span>			
		<ul>'.$tree_explorer->get_tree($treeFS->get_root_directory_id()).'</ul>
		</li>
		';	
			 
/*
**************************
*/
 	
// Database
	
	$closed = '';
	$my_fs = 'db_mysql';
	$filesystem_class = 'phpos_fs_plugin_'.$my_fs;	
	$treeFS = new $filesystem_class; // start filesytem		
	$tree_explorer = new app_explorer;
	$tree_explorer->set_fs($my_fs);
	
	$tree_explorer->assign_filesystem($treeFS);
	$tree_explorer->assign_window($apiWindow);
	$tree_explorer->assign_my_app($my_app);		

	$root_id = $treeFS->get_root_directory_id();	
	
	if($dir_id == $root_id || $global_fs != $my_fs)
	{
		$closed = ',state:\'closed\'';
	}
	
			 
/*
**************************
*/

$tmp_item = '<span class="explorer_tree_item">'.txt('home_db_folder').'</span>';
if(APP_ACTION == 'index' && $my_app->get_param('fs') == 'db_mysql') $tmp_item = '<span class="explorer_tree_item_marked">'.txt('home_db_folder').'</span>'; 	
	
	
	$tree_db_mysql = '
	<li data-options="iconCls:\'icon-db\''.$closed.'">
	<span><a title="'.txt('home_db_folder').'" href="javascript:void(0);" onclick="'.link_action('index', 'workgroup_id:0,reset_shared:1,in_shared:0,ftp_id:0,cloud_id:0,shared_id:0,tmp_shared_id:0,root_id:'.$root_id.',dir_id:'.$root_id.',fs:'.$my_fs).'">'.$tmp_item.'</a></span>				
	<ul>'.$tree_explorer->get_tree($treeFS->get_root_directory_id()).'</ul>
	</li>
	';
			 
/*
**************************
*/ 	
	
	$tmp_header = '<span class="explorer_tree_header">'.txt('my_server').'</span>';
	if($mark_lib != 1 && (APP_ACTION == 'my_server' || (APP_ACTION == 'index' && ($my_app->get_param('fs') == 'local_files' || $my_app->get_param('fs') == 'db_mysql')))) $tmp_header = '<span class="explorer_tree_header_marked">'.txt('my_server').'</span>';	
	
	$html['left_tree'].= '<br/><br/>
	<ul id="tt" class="easyui-tree">	
	
		<li data-options="iconCls:\'icon-myserver\'" id="xx">
									
					<span><a href="javascript:void(0);" onclick="phpos.windowActionChange(\''.WIN_ID.'\', \'my_server\', \'fs:local_files,tmp_shared_id:0,workgroup_id:0,ftp_id:0,cloud_id:0,ftp_id:0,in_shared:0,shared_id:0\')">'.$tmp_header.'</a></span>
					
					<ul>					
							'.$tree_local_files.'			
							'.$tree_db_mysql.'	
					</ul>
		</li>	
	
	</ul>';

unset($items, $tmp_header, $tmp_items, $tmp_item, $root_id, $global_fs, $tree_explorer, $filesystem_class, $my_fs, $tmp_title, $tree_local_files, $tree_db_mysql, $row, $treeFS, $dir_id, $closed);	

?>