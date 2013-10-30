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

	$items = null;
		
	$ftp = new phpos_ftp;
	$records = $ftp->get_my_ftp();
		 
/*
**************************
*/ 	

	if(count($records) != 0)
	{
		foreach($records as $row)
		{
			$tmp_title = '<span class="explorer_tree_item">'.string_cut($row['title'], 20).'</span>';			
			if($my_app->get_param('fs') == 'ftp' && $my_app->get_param('ftp_id') == $row['id']) $tmp_title = '<span  class="explorer_tree_item_marked">'.string_cut($row['title'], 20).'</span>';
			
			$items.= '<li data-options="iconCls:\'icon-ftp\'"><span><a title="'.$row['title'].' '.$row['host'].'"href="javascript:void(0);" onclick="'.infomonit(txt('connecting_ftp_wait'),'noscript').link_action('index', 'tmp_shared_id:0,cloud_id:0,in_shared:0,workgroup_id:0,cloud_id:0,root_id:.,dir_id:.,ftp_id:'.$row['id'].',fs:ftp').'"><span style="color: black">'.$tmp_title.'</span></a></span>';
			
			if($my_app->get_param('fs') == 'ftp' && $my_app->get_param('ftp_id') == $row['id']) 
			{				
				$filesystem_class = 'phpos_fs_plugin_ftp';	
			
				$treeFS = new $filesystem_class; // start filesytem		
				$tree_explorer = new app_explorer;
				$tree_explorer->set_fs('ftp');				
				$tree_explorer->assign_filesystem($treeFS);
				$tree_explorer->assign_window($apiWindow);
				$tree_explorer->assign_my_app($my_app);				
				$root_id = $treeFS->get_root_directory_id();				
									
				if($dir_id == $root_id || $global_fs != $my_fs)
				{
					$closed = ',state:\'closed\'';
				}
				
				$items.= '	
				<ul>'.$tree_explorer->get_tree($treeFS->get_root_directory_id()).'</ul>';						
			}
			
			$items.='</li>';			
		} 

	} else {
		
		$items.= '<li data-options="iconCls:\'icon-blank\'"><span>'.$txt['ftp_no_accounts'].'</span></li>';
	}
		 
/*
**************************
*/

	$tmp_header = '<span class="explorer_tree_header">'.txt('ftp_folders').'</span>';
	if(APP_ACTION == 'ftp' || (APP_ACTION == 'index' && $my_app->get_param('fs') == 'ftp')) $tmp_header = '<span class="explorer_tree_header_marked">'.txt('ftp_folders').'</span>';
 	
	$html['left_tree'].= '<br/><br/>
	<ul id="tt2" class="easyui-tree">
		<li data-options="iconCls:\'icon-ftp\'">
					 <span><a title="'.$txt['ftp_folders'].'" href="javascript:void(0);" onclick="'.link_action('ftp', 'ftp_id:0,tmp_shared_id:0,shared_id:0,cloud_id:0,in_shared:0,workgroup_id:0,fs:ftp').'">'.$tmp_header .'</a></span>
					<ul>
					'.$items.'
					</ul>
		</li>
	</ul>';
	
unset($items, $tmp_header, $tmp_items, $root_id, $global_fs, $tree_explorer, $filesystem_class, $my_fs, $tmp_title, $ftp, $row, $treeFS, $dir_id, $closed);	
?>