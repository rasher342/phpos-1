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

$shared = new phpos_shared;
$records = $shared->get_my_shared();

if(count($records) != 0)
{
	foreach($records as $row)
	{
		$items.= '<li data-options="iconCls:\'icon-sharedfolder\'"><span><a title="'.$row['title'].' '.$row['desc'].'"  href="javascript:void(0);" onclick="'.link_action('index', 'workgroup_id:0,reset_shared:0,in_shared:1,shared_id:'.$row['id'].',user_id:'.$root_id.',fs:local_files').'"><span style="color: black">'.$row['title'].'</span></a></span>	</li>';
	}	
} else {
	
	$items.= '<li data-options="iconCls:\'icon-blank\'"><span>'.txt('shared_no_folders').'</span></li>';
}







$html['left_tree'].= '<br/><br/>
<ul id="tt3" class="easyui-tree">
	<li data-options="iconCls:\'icon-sharedfolder\'">
        <span><a title="'.txt('shared_folders').'" href="javascript:void(0);" onclick="'.link_action('shared', 'shared_id:0,tmp_shared_id:0,in_shared:1,reset_shared:0,workgroup_id:0,fs:local_files').'"><span style="color: black;"><b>'.txt('shared_folders').'</b></span></a></span>
				<ul>
				'.$items.'
				</ul>
	</li>
</ul>';

$items = null;

?>