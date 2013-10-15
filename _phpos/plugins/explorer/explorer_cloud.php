<?php
/*
**********************************

	PHPOS Web Operating system
	MIT License
	(c) 2013 Marcin Szczyglinski
	szczyglis83@gmail.com
	GitHUB: https://github.com/phpos/
	File version: 1.2.5, 2013.10.15
 
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
			
			$items.= '<li data-options="iconCls:\'icon-google_drive\'"><span><a title="'.$row['title'].' '.$row['host'].'"href="javascript:void(0);" onclick="'.link_action('index', 'tmp_shared_id:0,ftp_id:0,workgroup_id:0,dir_id:.,cloud_id:'.$row['id'].',reset_google_token:1,root_id:.,fs:clouds_google_drive').'"><span style="color: black;">'.$tmp_title.'</span></a></span></li>';		
		} 

	} else {
		
		$items.= '<li data-options="iconCls:\'icon-blank\'"><span>'.txt('cloud_no_accounts').'</span></li>';
	}

	
$tmp_header = '<span class="explorer_tree_header">'.$txt['cloud_folders'].'</span>';
if($my_app->get_param('fs') == 'clouds_google_drive') $tmp_header = '<span class="explorer_tree_header_marked">'.$txt['cloud_folders'].'</span>';
$html['left_tree'].= '<br/><br/>
<ul id="tt2" class="easyui-tree">
	<li data-options="iconCls:\'icon-clouds\'">
         <span><a title="'.$txt['cloud_folders'].'" href="javascript:void(0);" onclick="'.link_action('clouds', 'tmp_shared_id:0,ftp_id:0,shared_id:0,cloud_id:0,workgroup_id:0,fs:clouds_google_drive').'">'.$tmp_header.'</a></span>
				<ul>
				'.$items.'
				</ul>
	</li>
</ul>';
$items = null;
?>