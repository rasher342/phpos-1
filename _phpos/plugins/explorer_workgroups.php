<?php
/*
**********************************

	PHPOS Web Operating system
	MIT License
	(c) 2013 Marcin Szczyglinski
	szczyglis83@gmail.com
	GitHUB: https://github.com/phpos/
	File version: 1.0.0, 2013.10.09
 
**********************************
*/
if(!defined('PHPOS'))	die();	

if(!defined('PHPOS_EXPLORER_PLUGIN')) die();
$items = null;

$groups = new phpos_groups;
$records = $groups->get_my_groups();

if(count($records) != 0)
{
	foreach($records as $row)
	{
		$items.= '<li data-options="iconCls:\'icon-folder\'"><span><a title="'.$row['title'].' '.$row['desc'].'" href="javascript:void(0);" onclick="'.link_action('workgroup', 'shared_id:0,workgroup_id:'.$row['id'].',fs:local_files').'"><span style="color: black">'.$row['title'].'</span></a></span>	</li>';
	}	
} else {
	
	$items.= '<li data-options="iconCls:\'icon-blank\'"><span>'.txt('workgroups_empty').'</span></li>';
}
$html['left_tree'].= '<br/><br/>
<ul id="tt4" class="easyui-tree">
	<li data-options="iconCls:\'icon-group\'">
        <span><a title="'.txt('workgroups').'" href="javascript:void(0);" onclick="'.link_action('workgroup', 'shared_id:0,workgroup_id:0,fs:local_files').'"><span style="color: black;"><b>'.txt('workgroups').'</b></span></a></span>
				<ul>
				'.$items.'
				</ul>
	</li>
</ul>';

$items = null;
?>