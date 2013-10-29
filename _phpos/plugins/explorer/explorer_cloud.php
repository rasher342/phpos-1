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
$clouds = new phpos_clouds;
$records = $clouds->get_my_clouds();

	if(count($records) != 0)
	{
		foreach($records as $row)
		{			
			$tmp_title = '<span class="explorer_tree_item">'.string_cut($row['title'], 20).'</span>';			
			if($my_app->get_param('fs') == 'clouds_google_drive' && $my_app->get_param('cloud_id') == $row['id']) $tmp_title = '<span  class="explorer_tree_item_marked">'.string_cut($row['title'], 20).'</span>';
			
			$items.= '<li data-options="iconCls:\'icon-'.$row['cloud'].'\'"><span><a title="'.$row['title'].'" href="javascript:void(0);" onclick="'.link_action('index', 'shared_id:0,tmp_shared_id:0,ftp_id:0,workgroup_id:0,dir_id:.,cloud_id:'.$row['id'].',reset_google_token:1,root_id:root,fs:clouds_'.$row['cloud']).'"><span style="color: black;">'.$tmp_title.'</span></a></span>';		
			
			$my_fs = 'clouds_'.$row['cloud'];
			if($my_app->get_param('fs') == $my_fs && $my_app->get_param('cloud_id') != null && $my_app->get_param('cloud_id') == $row['id']) 
			{			
				if(method_exists($phposFS, 'get_tree'))
				{
					$items.= $phposFS->get_tree();
				}			
			}
			
			$items.= '</li>';
		} 

	} else {
		
		$items.= '<li data-options="iconCls:\'icon-blank\'"><span>'.txt('cloud_no_accounts').'</span></li>';
	}
	
	$tmp_header = '<span class="explorer_tree_header">'.$txt['cloud_folders'].'</span>';
	if($my_app->get_param('fs') == $my_fs) $tmp_header = '<span class="explorer_tree_header_marked">'.$txt['cloud_folders'].'</span>';

	$html['left_tree'].= '<br/><br/>
	<ul id="tt2" class="easyui-tree">
		<li data-options="iconCls:\'icon-cloud\'">
					 <span><a title="'.$txt['cloud_folders'].'" href="javascript:void(0);" onclick="'.link_action('clouds', 'ftp_id:0,tmp_shared_id:0,shared_id:0,cloud_id:0,in_shared:0,workgroup_id:0,fs:local_files').'">'.$tmp_header.'</a></span>
					<ul>
					'.$items.'
					</ul>
		</li>
	</ul>';
	
unset($items, $tmp_header, $tmp_items, $clouds, $my_fs, $tmp_title, $row);	
?>