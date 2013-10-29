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

$server_item_title = txt('workgroups');
$groups = new phpos_groups;
$records = $groups->get_my_groups();

if(count($records) != 0)
{
	foreach($records as $row)
	{		
	
	// --- context menu ---	
		$action_open = link_action('workgroup', 'shared_id:0,workgroup_id:'.$row['id'].',fs:ftp');
		$action_edit = winopen(txt('group_section_edit_group'), 'cp', 'app_id:groups@groups_admin','section:edit_group,group_id:'.$row['id']);		
		$action_users = winopen(txt('group_section_group_users'), 'cp', 'app_id:groups@groups_admin','section:group_users,group_id:'.$row['id']);	
		
		$action_delete = "
			$.messager.confirm('".txt('delete')."', '".txt('delete_confirm')."?', function(r){
			if (r){
			
				".winopen(txt('dsc_ftp_a_edit'), 'cp', 'app_id:groups@groups_admin','section:list,after_refresh:'.WIN_ID.',action:delete,group_id:'.$row['id'].',delete_id:'.$row['id'])."				
			}
			});";		
		
		$contextMenu_group = array(				
			'open::'.txt('open').'::'.$action_open.'::folder_open'							
		);	
					
		if($groups->im_owner($row['id']) || is_root())
		{
			$contextMenu_group[] =	'edit::'.txt('group_section_edit_group').'::'.$action_edit.'::edit';	
			$contextMenu_group[] = 'users::'.txt('group_section_group_users').'::'.$action_users.'::user';		
			$contextMenu_group[] = 'delete::'.txt('delete').'::'.$action_delete.'::cancel';					
		}
		
		$apiWindow->setContextMenu($contextMenu_group);
		$js = $apiWindow->contextMenuRender('groups_list_'.$row['id'].WIN_ID, 'img');	
		jquery_function($js);
		unset($js);
		$apiWindow->resetContextMenu();				
	// --- context menu ---		
	
		$groups->set_id($row['id']);
		$c = $groups->count_users();
		$tmp_html.='<div id="groups_list_'.$row['id'].WIN_ID.'" class="phpos_server_icon"  title="'.$row['title'].' '.$row['description'].'" ondblclick="'.$action_open.'"><img src="'.ICONS.'server/workgroup.png" /><p><b>'.$row['title'].'</b><br />'.txt('workgroup_users').': '.$c.'<br /><span class="desc">'.string_cut($row['description'], 20).'</span></p></div>';
	}
} else {

	$tmp_html = txt('workgroups_empty');
}
?>			