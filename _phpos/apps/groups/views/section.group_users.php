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


if(PHPOS_HAVE_ACCESS != $my_app->get_app_id() or !defined('PHPOS') or !defined('PHPOS_SECTION_ACCESS'))
{
	die();
}

	echo $layout->title(txt('group_section_group_users'), 'icon.png'); 	
	
	$group_id = $my_app->get_param('group_id');
	
	if(!empty($group_id))
	{
		$group = new phpos_groups;
		$group->set_id($group_id);
		$group->get_group();
					
					
		$usr = new phpos_users;
		$usr->set_id_user($usr->get_logged_user());
		
		if($usr->user_id_exists())
		{
			$usr->get_user_by_id();	
		}		

		
		echo $layout->column('50%');
		echo $layout->subtitle(txt('group_in_group'), ICONS.'status/status_ok.png');	
		echo $layout->txtdesc(txt('dsc_cp_groups_users_in'));
		
		// usrs in group
		
		$users_ids = $group->get_users_in_group();	
		$c=count($users_ids);
		if($c != 0)
		{
			$users_ids = $group->get_users_in_group();	
			$c=count($users_ids);
			
			echo $layout->tbl_start();
			echo $layout->head(array('<img src="'.ICONS.'accounts/ico_admin.png" />' => '10%', 'Login' => '40%', txt('last_activity') => '30%', txt('action') => '30%'));
			
			for($i=0; $i<$c; $i++)
			{
				$u = new phpos_users;
				$u->set_id_user($users_ids[$i]['id_user']);
				$u->get_user_by_id();		
				
				if($u->get_last_activity() != 0)
				{		
					$d = date('d.m.Y H:i:s', $u->get_last_activity());
					
				} else {
				
					$d = txt('never');
				}		
					
					
				
				
				
				
				$action = helper_reload(array('section' => 'group_users', 'remove_user_id' => $u->get_id_user()));
				echo $layout->row(array('<img src="'.ICONS.'accounts/ico_admin.png"  style="height:20px"/>', $u->get_user_login(), $d, $layout->button(txt('group_remove_user'), $action, 'edit_remove')));		
			}	
			echo $layout->tbl_end();		
			
		}	else {
		
			echo $layout->empty_list();		
		}
		
		echo $layout->end('column');

		
		// ----------------
		
		
		echo $layout->column('50%');
		echo $layout->subtitle(txt('group_out_group'), ICONS.'status/status_error.png');	
		echo $layout->txtdesc(txt('dsc_cp_groups_users_out'));		
		// usrs in group
		
	
		
		$users_ids = $group->get_users_out_group();		
		$c=count($users_ids);
			
		if($c != 0)
		{	
			
			echo $layout->tbl_start();
			echo $layout->head(array('<img src="'.ICONS.'accounts/ico_admin.png" />' => '10%', 'Login' => '40%', txt('last_activity') => '30%', txt('action') => '30%'));
			for($i=0; $i<$c; $i++)
			{
				$u = new phpos_users;
				$u->set_id_user($users_ids[$i]['id_user']);
				$u->get_user_by_id();		
				
				if($u->get_last_activity() != 0)
				{		
					$d = date('d.m.Y H:i:s', $u->get_last_activity());
					
				} else {
				
					$d = txt('never');
				}	
				
				
				$action = helper_reload(array('section' => 'group_users', 'add_user_id' => $u->get_id_user()));
				echo $layout->row(array('<img src="'.ICONS.'accounts/ico_admin.png"  style="height:20px"/>', $u->get_user_login(), $d, $layout->button(txt('group_add_user'), $action,'edit_add')));		
			}	
			echo $layout->tbl_end();	
			
		}	else {
			
			echo $layout->empty_list();		
		}		
		
		echo $layout->end('column');	
				
				

	} else {
		
		winreload(WIN_ID, array('section' => 'list')); 
	
	}

?>


