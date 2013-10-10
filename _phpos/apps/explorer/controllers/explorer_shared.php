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


if(APP_ACTION == 'shared')
	{

		$html['right_items_img'] = 'shared1.png';
					
					$shared_id = $my_app->get_param('shared_id');
		$workgroup_id = $my_app->get_param('workgroup_id');
		$address_icon = ICONS.'server/shared1.png';
		
		if(!empty($workgroup_id))
		{		
			$group = new phpos_groups;
			$group->set_id($workgroup_id);
			$group->get_group();
			
			if($group->im_in_group())
			{			
				$group_name = $group->get_title();		
				
				$shared = new phpos_shared;
				$shared_id_user = $my_app->get_param('workgroup_user_id');
				$shared->set_id_user($shared_id_user);
				$records = $shared->get_user_shared();
				
				$group_user = new phpos_users;
				$group_user->set_id_user($shared_id_user);
				$group_user->get_user_by_id();
			
				$title = '<img src="'.ICONS.'server/workgroup.png'.'" style="width:30px; display:inline-block; vertical-align:middle" /> <span style="color:black">'.txt('workgroup').':</span> '.$group_name;
				
				$html['icons'].= $layout->area_start($title);
				$html['icons'].= $layout->txtdesc(txt('st_shared'));
				$html['icons'].= $layout->subtitle($group_user->get_user_login(), ICONS.'user.png');
				
				foreach($records as $row)
				{
					$tmp_usr = new phpos_users;
					$user_info = $tmp_usr->get_user_by_id($row['id_user']);		


						$action_open = link_action('index', 'reset_shared:0,shared_id:'.$row['id'].',in_shared:1,fs:local_files');						
						$contextMenu_shared_folders = array(				
							'open::'.txt('open').'::'.$action_open.'::folder_open'					
						);				
							
						$apiWindow->setContextMenu($contextMenu_shared_folders);
						$js.= $apiWindow->contextMenuRender('groups_shared_folders_'.$row['id'].WIN_ID, 'img');	
						$apiWindow->resetContextMenu();				
					
				
					$html['icons'].='<div id="groups_shared_folders_'.$row['id'].WIN_ID.'" title="<b>'.$row['title'].'</b> '.$row['desc'].'" class="phpos_server_icon"><a href="javascript:void(0);" ondblclick="'.$action_open.'"><img src="'.ICONS.'server/shared1.png" /></a><p><b>'.$row['title'].'</b><br />'.string_cut($row['description'], 20).'<br /><span class="desc">'.$user_info['user_login'].'</span></p></div>';				
				}
				
				$html['icons'].= $layout->area_end();
				
				
				// right items
				
					$html['right_items_title'] = txt('explorer_right_group_users');
					$html['right_items_desc'] = txt('explorer_right_group_users_desc');
					$html['right_items_img'] = 'shared1.png';
					
					//$group->get_group();
					$users_in_group = $group->get_users_in_group();
					
					$k = count($users_in_group);
					
					if($k != 0)
					{
						foreach($users_in_group as $grp_user)
						{
							$usr_data = new phpos_users;
							$usr_data->set_id_user($grp_user['id_user']);
							$usr_data->get_user_by_id();
							
							$right_item['name'] = $usr_data->get_user_login();
							$right_item['onclick'] = link_action('shared', 'workgroup_id:'.$workgroup_id.',workgroup_user_id:'.$grp_user['id_user'].',fs:local_files');
							$right_item['icon'] = 'user.png';
							$right_item['marked'] = false;
							if($shared_id_user == $grp_user['id_user']) $right_item['marked'] = true;
							
							$explorer_right_items[] = $right_item;
						
						}				
					}
				
				
				
			/* ================================================== */			
			} else {
				
				$html['icons']= $layout->area_start(txt('shared_error')).$layout->txtdesc(txt('st_shared')).txt('shared_not_exists').$layout->area_end();
			
			}
			
		/* ================================================== */	
		
		} else {		
			
				$tmp_html = '';				
				include(PHPOS_DIR.'plugins/server.explorer_shared.php');
				$html['icons'].= $layout->area_start($server_item_title).$layout->txtdesc(txt('st_shared')).$tmp_html.$layout->area_end();			
				$tmp_html = '';			
		}
	}
	
	if(defined('SHARED') || $my_app->get_param('in_shared')) $address_icon = ICONS.'server/shared1.png';


?>