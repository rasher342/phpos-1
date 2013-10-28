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


if(APP_ACTION == 'workgroup')
	{
		$address_icon = ICONS.'server/workgroup.png';
		
		if($my_app->get_param('workgroup_id') != 0)		
		{
			$group = new phpos_groups;
			$group_id = $my_app->get_param('workgroup_id');
			$group->set_id($group_id);
			
			if($group->group_exists() && $group->im_in_group())
			{			
				$group->get_group();	
				$count_users = $group->count_users();			
				
				$records = $group->get_users_in_group();				
				
				
				$title = '<img src="'.ICONS.'server/workgroup.png'.'" style="width:30px; display:inline-block; vertical-align:middle" /> <span style="color:black">'.txt('workgroup').':</span> '.$group->get_title();
				
				$html['icons'].= $layout->area_start($title);
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
						$js.= $apiWindow->contextMenuRender('groups_shared_list_'.$row['id_user'].WIN_ID, 'img');	
						$apiWindow->resetContextMenu();				
						
						
						$tmp_usr = new phpos_users;
						$tmp_usr->set_id_user($row['id_user']);
						
						if($tmp_usr->user_id_exists())
						{
							$user_info = $tmp_usr->get_user_by_id($row['id_user']);
							$owner = '';
							
							$owner = txt('guest');
							if($row['id_user'] == $group->get_id_owner()) $owner = txt('owner');
							$html['icons'].='<div id="groups_shared_list_'.$row['id_user'].WIN_ID.'" class="phpos_server_icon" title="'.$group->get_title().' / '.$user_info['user_login'].'"><a href="javascript:void(0);" ondblclick="'.$action_open.'"><img src="'.ICONS.'accounts/user-icon.png" /></a><p><b>'.$user_info['user_login'].'</b><br />'.txt('workgroups_last_user_activity').' <b>'.date('Y.m.d H:i:s', $user_info['last_activity']).'</b><br /><span class="desc">'.$owner.'</span></p></div>';	
						}
					}
					
				} else {
					
					$html['icons'].= txt('group_no_users');
				}
				
				$html['icons'].= $layout->area_end();
				
				
				
				
					// right items
				
					$html['right_items_title'] = txt('explorer_right_groups');
					$html['right_items_desc'] = txt('explorer_right_groups_desc');
					$html['right_items_img'] = 'workgroup.png';
					
					//$group->get_group();
					$users_in_group = $group->get_users_in_group();
					
					$groups = new phpos_groups;
					$groups_records = $groups->get_my_groups();
					
					$k = count($users_in_group);
					
					if($k != 0)
					{
						foreach($groups_records as $group_row)
						{							
							
							$right_item['name'] = $group_row['title'];
							$right_item['onclick'] = link_action('workgroup', 'shared_id:0,workgroup_id:'.$group_row['id'].',fs:db_mysql');
							$right_item['icon'] = 'group.png';
							$right_item['marked'] = false;
							if($shared_id_user == $grp_user['id_user']) $right_item['marked'] = true;
							
							$explorer_right_items[] = $right_item;
						
						}				
					}
				
				
				
				
				
				
				
				
				
				
				
				
				
			/* ================================================== */	
				
			} else {				
			
				$html['icons']= $layout->area_start(txt('group_error')).txt('group_not_exists').$layout->area_end();
			
			}
			
		/* ================================================== */		
		} else {
			
				$tmp_html = '';	
				
				include(PHPOS_DIR.'plugins/server.explorer_workgroups.php');
				$html['icons'].= $layout->area_start($server_item_title).$layout->txtdesc(txt('groups_serv_desc')).$tmp_html.$layout->area_end();				
			
				
				
				
		$group = new phpos_groups;		
		$groups = new phpos_groups;		
		$address_icon = ICONS.'server/workgroup.png';
		$ftp = new phpos_ftp;
		$records = $groups->get_my_groups();
		
		$html['right_items_title'] = txt('explorer_right_groups');
		//$html['right_items_desc'] = txt('explorer_right_groups_desc');
		$html['right_items_img'] = 'workgroup.png';
		
		//$group->get_group();	
		
		
		if(count($records) != 0)
		{		
			foreach($records as $row)
			{						
				$action_open = link_action('workgroup', 'workgroup_id:'.$row['id'].',fs:local_files');
			
				
				$contextMenu_group = array(				
					'open::'.txt('open').'::'.$action_open.'::folder_open'							
					);				
								
				$apiWindow->setContextMenu($contextMenu_group);
				$js.= $apiWindow->contextMenuRender('group_list_'.$row['id'].WIN_ID, 'img');	
				$apiWindow->resetContextMenu();							
				
				$html['icons'].=	'<div id="group_list_'.$row['id'].WIN_ID.'" ondblclick="'.$action_open.'" class="phpos_server_icon" title="'.$row['title'].' '.$row['host'].'"><img src="'.ICONS.'server/group.png" /><p><b>'.string_cut($row['title'],30).'</b><br />'.string_cut($row['description'], 30).'<br /><span class="desc">'.string_cut($row['host'], 30).'</span></p></div>';
			
			}
			
			$html['icons'].= $layout->area_end();
			
		} else {	
				
			$html['icons'].= $layout->area_start(txt('ftp_folders')).txt('ftp_no_accounts').$layout->txtdesc(txt('st_ftp')).$layout->area_end();						
		}
				
				
	
		
		}
	}

?>