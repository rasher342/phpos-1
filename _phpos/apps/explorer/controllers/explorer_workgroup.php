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


if(APP_ACTION == 'workgroup')
{
		
		// Address icon
		
		$address_icon = ICONS.'server/workgroup.png';	

		
		
		// Right items
				
		$html['right_items_title'] = txt('explorer_right_groups');
		$html['right_items_desc'] = txt('explorer_right_groups_desc');
		$html['right_items_img'] = 'workgroup.png';					
		
		$groups = new phpos_groups;
		$groups_records = $groups->get_my_groups();				
		$k = count($groups_records);
		
		if($k != 0)
		{
			foreach($groups_records as $group_row)
			{							
				$group = new phpos_groups;										
				$group->set_id($group_row['id']);
				$num_users = $group->count_users();
				
				$right_item['name'] = $group_row['title'].' <span class="desc">('.txt('workgroup_users').': '.$num_users.')</span>';
				$right_item['onclick'] = link_action('workgroup', 'workgroup_user_id:0,tmp_shared_id:0,shared_id:0,workgroup_id:'.$group_row['id'].',fs:local_files');
				$right_item['icon'] = 'group.png';
				$right_item['marked'] = false;
				
				if($my_app->get_param('workgroup_id') == $group_row['id']) $right_item['marked'] = true;
				
				$explorer_right_items[] = $right_item;					
			}				
		}				
				
		
// In Workgroup (users list)

		if($my_app->get_param('workgroup_id') != 0)		
		{
			$group = new phpos_groups;
			$group_id = $my_app->get_param('workgroup_id');
			$group->set_id($group_id);
			
			// If it is my group
			if($group->group_exists() && $group->im_in_group())
			{			
				$group->get_group();	
				$count_users = $group->count_users();			
				
				$records = $group->get_users_in_group();					
				
				// Header title
				$title = '
				<img src="'.ICONS.'server/workgroup.png'.'" style="width:30px; display:inline-block; vertical-align:middle" /> 
				<a href="javascript:void(0);" onclick="'.link_action('workgroup', 'workgroup_user_id:0,tmp_shared_id:0,shared_id:0,ftp_id:0,workgroup_id:0,fs:local_files').'">
				'.txt('workgroups').'
				</a>
				<img src="'.THEME_URL.'icons/arrow_small_right.png" style="width:15px; display:inline-block; vertical-align:middle; padding-left:10px;padding-right:10px"/> <img src="'.ICONS.'server/group.png'.'" style="width:30px; display:inline-block; vertical-align:middle" /> 
				<a href="javascript:void(0);" onclick="'.link_action('workgroup', 'workgroup_user_id:0,tmp_shared_id:0,shared_id:0,workgroup_id:'.$my_app->get_param('workgroup_id').',fs:local_files').'">
				'.$group->get_title().'
				</a>';				
				
				
				$html['icons'].= $layout->subtitle($title);
				$html['icons'].= $layout->txtdesc(txt('shared_folders_serv_desc'));
				$html['icons'].= $layout->area_start(txt('explorer_right_group_users')).$layout->txtdesc(txt('explorer_right_group_users_desc')).$layout->area_end();
				
				if($count_users != 0)
				{				
					foreach($records as $row)
					{							
						$action_open = link_action('shared', 'workgroup_id:'.$group_id.',workgroup_user_id:'.$row['id_user'].',fs:local_files');
						
						$contextMenu_shared = array(				
							'open::'.txt('open').'::'.$action_open.'::folder_open'					
						);				
							
						$apiWindow->setContextMenu($contextMenu_shared);
						$js = $apiWindow->contextMenuRender('groups_shared_list_'.$row['id_user'].WIN_ID, 'img');	
						jquery_function($js);
						unset($js);
						$apiWindow->resetContextMenu();								
						
						$tmp_usr = new phpos_users;
						$tmp_usr->set_id_user($row['id_user']);
						
						// Show group user
						if($tmp_usr->user_id_exists())
						{
							$user_info = $tmp_usr->get_user_by_id($row['id_user']);
							$owner = '';
							
							$owner = txt('guest');
							if($row['id_user'] == $group->get_id_owner()) $owner = txt('owner');
							$html['icons'].='
							<div id="groups_shared_list_'.$row['id_user'].WIN_ID.'" class="phpos_server_icon" title="'.$group->get_title().' / '.$user_info['user_login'].'">
							<a href="javascript:void(0);" ondblclick="'.$action_open.'">
							<img src="'.ICONS.'accounts/user-icon.png" /></a>
							<p><b>'.$user_info['user_login'].'</b>
							<br />'.txt('workgroups_last_user_activity').' <b>'.date('Y.m.d H:i:s', $user_info['last_activity']).'</b>
							<br /><span class="desc">'.$owner.'</span></p>
							</div>';	
						}
					}
					
				} else {
					
					$html['icons'].= txt('group_no_users');
				}
				
				
				
			} else {				
			
				$html['icons']= $layout->area_start(txt('group_error')).txt('group_not_exists').$layout->area_end();			
			}	
			
			// --- window context menu ---	
			if($groups->im_owner($my_app->get_param('workgroup_id')) || is_root())
			{		
				$contextWindow = array(		
					'edit::'.txt('group_section_edit_group').'::'.winopen(txt('group_section_edit_group'), 'cp', 'app_id:groups@groups_admin','section:edit_group,group_id:'.$my_app->get_param('workgroup_id')).'::edit'	
				);
				
				$apiWindow->setContextMenu($contextWindow);
				$js= $apiWindow->contextMenuRender('phpos_explorer_div'.div(1), 'td');	
				jquery_function($js);
				unset($js);
				$apiWindow->resetContextMenu();	
			}	
			// --- window context menu ---	
		
		} else {
		
/* ================================================== */			
			
// Workgroups List
				
		$group = new phpos_groups;			
		$groups = new phpos_groups;		
		$address_icon = ICONS.'server/workgroup.png';				
		$records = $groups->get_my_groups();		
		
		$title = '
		<img src="'.ICONS.'server/workgroup.png'.'" style="width:30px; display:inline-block; vertical-align:middle" /> 
		<a href="javascript:void(0);" onclick="'.link_action('workgroup', 'workgroup_user_id:0,tmp_shared_id:0,shared_id:0,ftp_id:0,workgroup_id:0,fs:local_files').'">
		'.txt('workgroups').'
		</a>';
		
		$html['icons'].= $layout->subtitle($title);		
		$html['icons'].= $layout->txtdesc(txt('groups_serv_desc'));
		
		$html['icons'].= $layout->area_start(txt('choose_group')).$layout->txtdesc(txt('explorer_right_groups_desc'));					
	
		// If workgroups
		if(count($records) != 0)
		{		
			foreach($records as $row)
			{						
				$group = new phpos_groups;										
				$group->set_id($row['id']);	
				$num_users = $group->count_users();
				
			// --- context menu ---	
				$action_open = link_action('workgroup', 'workgroup_id:'.$row['id'].',fs:local_files');		
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
				$js = $apiWindow->contextMenuRender('group_list_'.$row['id'].WIN_ID, 'img');	
				jquery_function($js);
				unset($js);
				$apiWindow->resetContextMenu();							
			// --- context menu ---	
						
				$html['icons'].=	'
				<div id="group_list_'.$row['id'].WIN_ID.'" ondblclick="'.$action_open.'" class="phpos_server_icon" title="'.$row['title'].' '.$row['description'].'">
				<img src="'.ICONS.'server/group.png" />
				<p><b>'.string_cut($row['title'],30).'</b>
				<br />'.string_cut($row['description'], 30).'
				<br /><span class="desc">'.txt('workgroup_users').': '.$num_users.'</span></p>
				</div>';			
			}
			
			$html['icons'].= $layout->area_end();	
			
		} else {	
				
			// No workgroups
			$html['icons'].= $layout->area_start(txt('ftp_folders')).txt('ftp_no_accounts').$layout->txtdesc(txt('st_ftp')).$layout->area_end();						
		}	
		
		if(is_root() || is_admin())
		{
			$contextWindow = array(		
					'newgroup::'.txt('group_section_new_group').'::'.winopen(txt('group_section_new_group'), 'cp', 'app_id:groups@groups_admin','section:new_group').'::edit_add'
			);
			
			$apiWindow->setContextMenu($contextWindow);
			$js= $apiWindow->contextMenuRender('phpos_explorer_div'.div(1), 'td');	
			jquery_function($js);
			unset($js);
			$apiWindow->resetContextMenu();	
		}		
	}
}
?>