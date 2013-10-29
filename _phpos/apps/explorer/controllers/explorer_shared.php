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

if(APP_ACTION == 'shared')
{
		$html['right_items_img'] = 'shared1.png';					
		$shared_id = $my_app->get_param('shared_id');
		$workgroup_id = $my_app->get_param('workgroup_id');
		$address_icon = ICONS.'server/shared1.png';
		
		
// Shared folders in workgroup		
	
		if($my_app->get_param('workgroup_id') != null)
		{		
			$group = new phpos_groups;
			$group->set_id($my_app->get_param('workgroup_id'));
			$group->get_group();
			
			if($group->im_in_group())
			{			
				$group_name = $group->get_title();		
				
				$shared = new phpos_shared;				
				$shared->set_id_user($my_app->get_param('workgroup_user_id'));
				$records = $shared->get_user_shared();
				
				$group_user = new phpos_users;
				$group_user->set_id_user($my_app->get_param('workgroup_user_id'));
				$group_user->get_user_by_id();
			
				// Header title
				$title = '
				<img src="'.ICONS.'server/workgroup.png'.'" style="width:30px; display:inline-block; vertical-align:middle" /> 
				<a href="javascript:void(0);" onclick="'.link_action('workgroup', 'workgroup_user_id:0,tmp_shared_id:0,shared_id:0,ftp_id:0,workgroup_id:0,fs:local_files').'">
				'.txt('workgroups').'
				</a> 
				<img src="'.THEME_URL.'icons/arrow_small_right.png" style="width:15px; display:inline-block; vertical-align:middle; padding-left:10px;padding-right:10px"/> <img src="'.ICONS.'server/group.png'.'" style="width:30px; display:inline-block; vertical-align:middle" /> 
				<a href="javascript:void(0);" onclick="'.link_action('workgroup', 'workgroup_user_id:0,tmp_shared_id:0,shared_id:0,workgroup_id:'.$my_app->get_param('workgroup_id').',fs:local_files').'">
				'.$group_name.'
				</a>
				<img src="'.THEME_URL.'icons/arrow_small_right.png"  style="width:15px; display:inline-block; vertical-align:middle; padding-left:10px;padding-right:10px"/> 
				<img src="'.ICONS.'user.png'.'" style="width:30px; display:inline-block; vertical-align:middle" />
				<a href="javascript:void(0);" onclick="'.link_action('shared', 'workgroup_id:'.$my_app->get_param('workgroup_id').',workgroup_user_id:'.$my_app->get_param('workgroup_user_id').',fs:local_files').'">
				'.$group_user->get_user_login().'
				</a>';				
				
				
				$html['icons'].= $layout->subtitle($title);				
				$html['icons'].= $layout->txtdesc(txt('st_shared'));
				$html['icons'].= $layout->subtitle($group_user->get_user_login(), ICONS.'user.png');
				$html['icons'].= txt('workgroups_last_user_activity').' <b>'.date('Y.m.d H:i', $group_user->get_last_activity()).'</b><br/>';
				
				$c = count($records);
				
				if($c!=0)
				{
					$html['icons'].= $layout->area_start(txt('shared_folders'));
					foreach($records as $row)
					{
						$tmp_usr = new phpos_users;
						$user_info = $tmp_usr->get_user_by_id($row['id_user']);	

						// Context menu
						$action_open = link_action('index', 'reset_shared:0,shared_id:'.$row['id'].',in_shared:1,fs:local_files');						
						$contextMenu_shared_folders = array(				
							'open::'.txt('open').'::'.$action_open.'::folder_open'					
						);				
						
						$contextMenu_shared_folders[]	=	
						'shortcuts::'.txt('link_on_desktop').'::explorer_link_to_folder("'.$row['folder_id'].'", "'.base64_encode($row['title']).'");::edit_add';						
						
						if($shared->is_my($row['id']))
						{
							$contextMenu_shared_folders[] = 'share::'.txt('stop_share_folder').'::'.winmodal(txt('share_folder'), 'app', 'app_id:shortcuts@share,width:300,height:350','stop_share:1,desktop:1,location:db,dir_id:'.$my_app->get_param('dir_id').',shared_id:'.$row['folder_id'].',after_reload:'.WIN_ID).'::cancel';	
						}	
						
						$apiWindow->setContextMenu($contextMenu_shared_folders);
						$js = $apiWindow->contextMenuRender('groups_shared_folders_'.$row['id'].WIN_ID, 'img');	
						jquery_function($js);
						unset($js);
						$apiWindow->resetContextMenu();				
						
						$desc = '';
						$access = txt('workgroup_shared_fullaccess');
						if($row['readonly'] == '1') $access = txt('workgroup_shared_readonly');						
						if(!empty($row['description'])) $desc = ' - '.$row['description'];
					
						$html['icons'].='
						<div id="groups_shared_folders_'.$row['id'].WIN_ID.'" title="'.$row['title'].' '.$desc.'" class="phpos_server_icon">
						<a href="javascript:void(0);" ondblclick="'.$action_open.'">
						<img src="'.ICONS.'server/shared1.png" /></a>
						<p><b>'.$row['title'].'</b>
						<br /><img src="'.ICONS.'group_access.png" style="display:inline-block; verical-align:middle; width:15px" />
						<span class="desc"><b>'.$access.'</b>
						<br />'.txt('owner').': <b>'.$user_info['user_login'].'</b></span>
						</p>
						</div>';				
					}				
					
				} else {
				
					// Nothing shared
					$html['icons'].= $layout->area_start(txt('workgroups_nosharing_title')).$layout->txtdesc(txt('workgroups_nosharing_desc')).$layout->area_end();
				}
				
				$html['icons'].= $layout->area_end();
				
				
			// Right items				
				$html['right_items_title'] = txt('explorer_right_group_users');
				$html['right_items_desc'] = txt('explorer_right_group_users_desc');
				$html['right_items_img'] = 'shared1.png';				
			
				$users_in_group = $group->get_users_in_group();				
				$k = count($users_in_group);
				
				if($k != 0)
				{
					foreach($users_in_group as $grp_user)
					{
						$usr_data = new phpos_users;
						$usr_data->set_id_user($grp_user['id_user']);
						$usr_data->get_user_by_id();
						
						$shared = new phpos_shared;							
						$shared->set_id_user($grp_user['id_user']);
						$num_shared = $shared->count_user_shared();							
						
						$right_item['name'] = $usr_data->get_user_login().' <span style="color:#606060">('.txt('workgroup_num_folders').': '.$num_shared.')</span>';
						$right_item['onclick'] = link_action('shared', 'workgroup_id:'.$workgroup_id.',workgroup_user_id:'.$grp_user['id_user'].',fs:local_files');
						$right_item['icon'] = 'user.png';
						$right_item['marked'] = false;
						if($my_app->get_param('workgroup_user_id') == $grp_user['id_user']) $right_item['marked'] = true;
						
						$explorer_right_items[] = $right_item;					
					}				
				}			
				
				
			/* ================================================== */			
			} else {
				
				$html['icons']= $layout->area_start(txt('shared_error')).$layout->txtdesc(txt('st_shared')).txt('shared_not_exists').$layout->area_end();			
			}
			
			
		
			
			
			
		/* ================================================== */	
		
		
// My shared folders (without group)		
		
		} else {					
				
				$shared = new phpos_shared;
				$shared_id_user = logged_id();
				$shared->set_id_user($shared_id_user);
				$records = $shared->get_user_shared();				
				
				$group_user = new phpos_users;
				$group_user->set_id_user($shared_id_user);
				$group_user->get_user_by_id();
			
				$title = '<img src="'.ICONS.'server/shared1.png'.'" style="width:30px; display:inline-block; vertical-align:middle" /> 
				<span style="color:#000">'.txt('shared').'</span>';
				
				$html['icons'].= $layout->subtitle($title);
				$html['icons'].= $layout->txtdesc(txt('st_shared'));
				$html['icons'].= $layout->subtitle($group_user->get_user_login(), ICONS.'user.png');
				$html['icons'].= txt('workgroups_last_user_activity').' <b>'.date('Y.m.d H:i', $group_user->get_last_activity()).'</b><br/>';
				
				$c = count($records);
				
				if($c!=0)
				{
					foreach($records as $row)
					{
						$tmp_usr = new phpos_users;
						$user_info = $tmp_usr->get_user_by_id($row['id_user']);	

						$action_open = link_action('index', 'reset_shared:0,shared_id:'.$row['id'].',in_shared:1,fs:local_files');						
						$contextMenu_shared_folders = array(				
							'open::'.txt('open').'::'.$action_open.'::folder_open'					
						);				
						
						$contextMenu_shared_folders[]	=	
						'shortcuts::'.txt('link_on_desktop').'::explorer_link_to_folder("'.$row['folder_id'].'", "'.base64_encode($row['title']).'");::edit_add';							
						
						if($shared->is_my($row['id']))
						{
							$contextMenu_shared_folders[] = 'share::'.txt('stop_share_folder').'::'.winmodal(txt('share_folder'), 'app', 'app_id:shortcuts@share,width:300,height:350','stop_share:1,desktop:1,location:db,dir_id:'.$my_app->get_param('dir_id').',shared_id:'.$row['folder_id'].',after_reload:'.WIN_ID).'::cancel';	
						}						
						
						$apiWindow->setContextMenu($contextMenu_shared_folders);
						$js.= $apiWindow->contextMenuRender('groups_shared_folders_'.$row['id'].WIN_ID, 'img');	
						jquery_function($js);
						unset($js);	
						$apiWindow->resetContextMenu();							
						
						$desc = '';
						$access = txt('workgroup_shared_fullaccess');
						if($row['readonly'] == '1') $access = txt('workgroup_shared_readonly');						
						if(!empty($row['description'])) $desc = ' - '.$row['description'];
					
						$html['icons'].='<div id="groups_shared_folders_'.$row['id'].WIN_ID.'" title="'.$row['title'].' '.$desc.'" class="phpos_server_icon"><a href="javascript:void(0);" ondblclick="'.$action_open.'"><img src="'.ICONS.'server/shared1.png" /></a><p><b>'.$row['title'].'</b><br /><img src="'.ICONS.'group_access.png" style="display:inline-block; verical-align:middle; width:15px" /><span class="desc"><b>'.$access.'</b><br />'.txt('owner').': <b>'.$user_info['user_login'].'</b></span></p></div>';				
					}
					
				} else {
				
					$html['icons'].= $layout->area_start(txt('workgroups_nosharing_title')).$layout->txtdesc(txt('workgroups_nosharing_desc')).$layout->area_end();
				}
					
		}
	}
	
	if(defined('SHARED') || $my_app->get_param('in_shared') || $my_app->get_param('shared_id') != null || $my_app->get_param('tmp_shared_id') != null) $address_icon = ICONS.'server/shared1.png';

?>