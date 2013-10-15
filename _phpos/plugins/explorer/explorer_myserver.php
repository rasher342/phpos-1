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

	// local_files
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
 	
	if($dir_id == $root_id || $global_fs != $my_fs)
	{
		$closed = ',state:\'closed\'';
	}
			 
/*
**************************
*/
 	
	$tree_local_files = '
	<li data-options="iconCls:\'icon-disk\''.$closed.'">
	<span><a title="'.txt('home_local_folder').'" href="javascript:void(0);" onclick="'.link_action('index', 'reset_shared:1,in_shared:0,shared_id:0,root_id:'.$root_id.',dir_id:'.$root_id.',fs:'.$my_fs).'"><span style="color: black; ">'.txt('home_local_folder').'</span></a></span>			
	<ul>'.$tree_explorer->get_tree($treeFS->get_root_directory_id()).'</ul>
	</li>
	';
	
	
	
			 
/*
**************************
*/
 	
	// mysql
	
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
 	
	
	$tree_db_mysql = '
	<li data-options="iconCls:\'icon-disk\''.$closed.'">
	<span><a title="'.txt('home_db_folder').'" href="javascript:void(0);" onclick="'.link_action('index', 'reset_shared:1,in_shared:0,shared_id:0,tmp_shared_id:0,root_id:'.$root_id.',dir_id:'.$root_id.',fs:'.$my_fs).'"><span style="color: black;">'.txt('home_db_folder').'</span></a></span>				
	<ul>'.$tree_explorer->get_tree($treeFS->get_root_directory_id()).'</ul>
	</li>
	';
			 
/*
**************************
*/
 	
	
	
	$html['left_tree'].= '<br/><br/>
	<ul id="tt" class="easyui-tree">	
	
		<li data-options="iconCls:\'icon-myserver\'" id="xx">
									
					<span><a href="javascript:void(0);" onclick="phpos.windowActionChange(\''.$apiWindow->getID().'\', \'my_server\')"><span style="color:black"><b>'.txt('my_server').'</b></span></a></span>
					
					<ul>
					
							'.$tree_local_files.'			
							'.$tree_db_mysql.'	
					</ul>
		</li>	
	
	</ul>';


?>