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
		$tmp_title = '<span class="explorer_tree_item">'.string_cut($row['title'], 20).'</span>';			
		if($my_app->get_param('workgroup_id') == $row['id']) $tmp_title = '<span class="explorer_tree_item_marked">'.string_cut($row['title'], 20).'</span>';		
		
		$state = 'state:\'closed\', ';
		if(param('workgroup_id') == $row['id']) $state = '';					
		
		$items.= '<li data-options="'.$state.'iconCls:\'icon-groupusers\'"><span><a title="'.$row['title'].' '.$row['desc'].'" href="javascript:void(0);" onclick="'.link_action('workgroup', 'cloud_id:0,tmp_shared_id:0,ftp_id:0,shared_id:0,workgroup_id:'.$row['id'].',fs:local_files').'">'.$tmp_title.'</a></span><ul>';
		
		$groups->set_id($row['id']);
		$count_users = $groups->count_users();
		$users = $groups->get_users_in_group();
		foreach($users as $group_user)
		{
			$u = new phpos_users;
			$u->set_id_user($group_user['id_user']);
			$u->get_user_by_id();
			
			$user_name = $u->get_user_login();
			if(param('workgroup_user_id') == $group_user['id_user']) $user_name = '<b>'.$u->get_user_login().'</b>';
			
			$items.= '<li data-options="iconCls:\'icon-user\'"><span><a title="'.$row['title'].' '.$row['desc'].'" href="javascript:void(0);" onclick="'.link_action('shared', 'cloud_id:0,tmp_shared_id:0,ftp_id:0,shared_id:0,workgroup_id:'.$row['id'].',workgroup_user_id:'.$group_user['id_user'].',fs:local_files').'">'.$user_name.'</a></span></li>';
		}		
		
		$items.= '</ul></li>';
	}	
} else {
	
	$items.= '<li data-options="iconCls:\'icon-blank\'"><span>'.txt('workgroups_empty').'</span></li>';
}

$tmp_header = '<span class="explorer_tree_header">'.txt('workgroups').'</span>';
if(APP_ACTION == 'workgroup' || $my_app->get_param('workgroup_id') != null) $tmp_header = '<span class="explorer_tree_header_marked">'.txt('workgroups').'</span>';

$html['left_tree'].= '<br/><br/>
<ul id="tt4" class="easyui-tree">
	<li data-options="iconCls:\'icon-workgroup\'">
        <span><a title="'.txt('workgroups').'" href="javascript:void(0);" onclick="'.link_action('workgroup', 'tmp_shared_id:0,shared_id:0,ftp_id:0,workgroup_id:0,fs:local_files').'">'.$tmp_header.'</a></span>
				<ul>
				'.$items.'
				</ul>
	</li>
</ul>';

unset($items, $tmp_header, $tmp_title, $shared, $records, $row, $u, $users, $groups, $group_user, $state, $count_users, $user_name);
?>