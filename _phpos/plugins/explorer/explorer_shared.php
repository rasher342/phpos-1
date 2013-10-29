<?php
/*
**********************************

	PHPOS Web Operating system
	MIT License
	(c) 2013 Marcin Szczyglinski
	szczyglis83@gmail.com
	GitHUB: https://github.com/phpos/
	File version: 1.2.9, 2013.10.29
 
**********************************
*/
if(!defined('PHPOS'))	die();	

if(!defined('PHPOS_EXPLORER_PLUGIN')) die();

$items = null;

$shared = new phpos_shared;
$records = $shared->get_my_shared();

if(count($records) != 0)
{
	foreach($records as $row)
	{
		$tmp_title = '<span class="explorer_tree_item">'.string_cut($row['title'], 20).'</span>';			
		if($my_app->get_param('tmp_shared_id') == $row['id']) $tmp_title = '<span  class="explorer_tree_item_marked">'.string_cut($row['title'], 20).'</span>';
		
		
		$items.= '<li data-options="iconCls:\'icon-sharedfolder\'"><span><a title="'.$row['title'].' '.$row['desc'].'"  href="javascript:void(0);" onclick="'.link_action('index', 'workgroup_id:0,workgroup_user_id:0,reset_shared:0,in_shared:1,tmp_shared_id:'.$row['id'].',shared_id:'.$row['id'].',fs:local_files').'">'.$tmp_title.'</a></span>	</li>';
	}	
} else {
	
	$items.= '<li data-options="iconCls:\'icon-blank\'"><span>'.txt('shared_no_folders').'</span></li>';
}


$tmp_header = '<span class="explorer_tree_header">'.txt('shared_folders').'</span>';
if(APP_ACTION == 'shared' || $my_app->get_param('shared_id') != null || $my_app->get_param('shared') == 1 || $my_app->get_param('in_shared') == 1) $tmp_header = '<span class="explorer_tree_header_marked">'.txt('shared_folders').'</span>';


$html['left_tree'].= '<br/><br/>
<ul id="tt3" class="easyui-tree">
	<li data-options="iconCls:\'icon-shared1\'">
        <span><a title="'.txt('shared_folders').'" href="javascript:void(0);" onclick="'.link_action('shared', 'tmp_shared_id:0,shared_id:0,tmp_shared_id:0,in_shared:1,reset_shared:0,workgroup_id:0,workgroup_user_id:0,fs:local_files').'">'.$tmp_header.'</a></span>
				<ul>
				'.$items.'
				</ul>
	</li>
</ul>';

unset($items, $tmp_header, $tmp_title, $shared, $records, $row);
?>