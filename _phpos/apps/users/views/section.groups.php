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


if(!defined('PHPOS_SECTION_ACCESS'))
{
	die();
}


echo $layout->column('33%');
	echo $layout->subtitle(txt('groups_my'), ICONS.'workgroups.png');
	echo $layout->txtdesc(txt('groups_my_desc'));

	$groups = new phpos_groups;

	$group_ids = $groups->get_my_groups();		
	$c=count($group_ids);	
	
	echo $layout->tbl_start();
	$layout->td_classes(array('', '', 'tbl_grey'));
	
	if($c != 0)
	{		
		echo $layout->head(array('<img src="'.ICONS.'workgroups.png" />' => '20%', txt('name') => '40%', txt('owner') => '40%'));
		
		for($i=0; $i<$c; $i++)
		{
			$g = new phpos_groups;
			$g->set_id($group_ids[$i]['id']);
			$g->get_group();	
			
			$usr_count = $g->count_users();

			$u = new phpos_users;
			$u->set_id_user($group_ids[$i]['id_owner']);
			$u->get_user_by_id();
				
			echo $layout->row(array($usr_count, $g->get_title(), $u->get_user_login()), $g->get_desc());		
		}	
	} else {
		
		echo $layout->empty_list();		
	}

	
	echo $layout->tbl_end();		

echo $layout->end('column');

if(is_root()) {
	echo $layout->column('33%');
	echo $layout->subtitle(txt('groups_all'), ICONS.'workgroups.png');
	echo $layout->txtdesc(txt('groups_all_desc'));

	$groups = new phpos_groups;

	$group_ids = $groups->get_all();		
	$c=count($group_ids);	
	
	echo $layout->tbl_start();
	$layout->td_classes(array('', '', 'tbl_grey'));
	
	if($c != 0)
	{		
		echo $layout->head(array('<img src="'.ICONS.'workgroups.png" />' => '20%', txt('name') => '40%', txt('owner') => '40%'));
		
		for($i=0; $i<$c; $i++)
		{
			$g = new phpos_groups;
			$g->set_id($group_ids[$i]['id']);
			$g->get_group();	
			
			$usr_count = $g->count_users();

			$u = new phpos_users;
			$u->set_id_user($group_ids[$i]['id_owner']);
			$u->get_user_by_id();
				
			echo $layout->row(array($usr_count, '<a href="javascript:void(0);" onclick="'.helper_reload(array('section' => 'group_users', 'group_id' => $g->get_id())).'">'.$g->get_title().'</a>', $u->get_user_login()), $g->get_desc());		
		}	
	} else {
		
		echo $layout->empty_list();		
	}
	
	
	echo $layout->tbl_end();		

	echo $layout->end('column');
}


if(is_root() || is_admin())
{
	echo $layout->column('33%');
	echo $layout->subtitle(txt('groups_owner'), ICONS.'workgroups.png');
	echo $layout->txtdesc(txt('groups_own_desc'));

	$groups = new phpos_groups;

	$group_ids = $groups->get_my_own_groups();		
	$c=count($group_ids);	
	
	echo $layout->tbl_start();
	$layout->td_classes(array('', '', 'tbl_grey'));
	
	if($c != 0)
	{
		echo $layout->head(array('<img src="'.ICONS.'workgroups.png" />' => '20%', txt('name') => '40%', txt('owner') => '40%'));
		for($i=0; $i<$c; $i++)
		{
			$g = new phpos_groups;
			$g->set_id($group_ids[$i]['id']);
			$g->get_group();	
			
			$usr_count = $g->count_users();

			$u = new phpos_users;
			$u->set_id_user($group_ids[$i]['id_owner']);
			$u->get_user_by_id();
				
			echo $layout->row(array($usr_count, '<a href="javascript:void(0);" onclick="'.helper_reload(array('section' => 'group_users', 'group_id' => $g->get_id())).'">'.$g->get_title().'</a>', $u->get_user_login()), $g->get_desc());		
		}	
	} else {
		
		echo $layout->empty_list();		
	}
	
	
	
	echo $layout->tbl_end();		

	echo $layout->end('column');
}

echo $layout->clr();




?>