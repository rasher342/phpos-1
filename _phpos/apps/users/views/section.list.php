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

echo helper_result('delete_user');
	
echo $layout->txtdesc(txt('dsc_users_edit_list'));
echo $layout->column('33%');
echo $layout->subtitle(txt('users'),ICONS.'accounts/ico_user.png');
echo $layout->txtdesc(txt('dsc_users_list_users'));

$users = new phpos_users;
$how_many = $users->count_users('USERS');

if($how_many != 0)
{
	$users_ids = $users->get_users('USERS');		
	$c=count($users_ids);
	
	echo $layout->tbl_start();
	$layout->td_classes(array('', '', 'tbl_grey'));
	echo $layout->head(array('<img src="'.ICONS.'accounts/ico_user.png" />' => '10%', 'Login' => '50%', txt('last_activity') => '40%'));
	for($i=0; $i<$c; $i++)
	{
		$u = new phpos_users;
		$u->set_id_user($users_ids[$i]);
		$u->get_user_by_id();	
		
		if($u->get_last_activity() != 0)
		{		
			$d = date('d.m.Y H:i:s', $u->get_last_activity());
			
		} else {
		
			$d = txt('never');
		}
		
		
		echo $layout->row(array('<img src="'.ICONS.'accounts/ico_user.png"  style="height:20px"/>', '<a href="javascript:void(0);" onclick="'.helper_reload(array('section' => 'edit_account', 'user_id' => $u->get_id_user())).'">'.$u->get_user_login().'</a>', $d), txt('dsc_users_click'));		
	}	
	echo $layout->tbl_end();	
	
} else {
	
	echo $layout->empty_list();		
}

echo $layout->end('column');


echo $layout->column('33%');
echo $layout->subtitle(txt('user_admins'),ICONS.'accounts/ico_admin.png');
echo $layout->txtdesc(txt('dsc_users_list_admins'));
$users = new phpos_users;
$how_many = $users->count_users('ADMINS');
if($how_many != 0)
{
	$users_ids = $users->get_users('ADMINS');		
	$c=count($users_ids);
	
	echo $layout->tbl_start();
	echo $layout->head(array('<img src="'.ICONS.'accounts/ico_admin.png" />' => '10%', 'Login' => '50%', txt('last_activity') => '40%'));
	for($i=0; $i<$c; $i++)
	{
		$u = new phpos_users;
		$u->set_id_user($users_ids[$i]);
		$u->get_user_by_id();		
		
		if($u->get_last_activity() != 0)
		{		
			$d = date('d.m.Y H:i:s', $u->get_last_activity());
			
		} else {
		
			$d = txt('never');
		}
		
		echo $layout->row(array('<img src="'.ICONS.'accounts/ico_admin.png"  style="height:20px"/>', '<a href="javascript:void(0);" onclick="'.helper_reload(array('section' => 'edit_account', 'user_id' => $u->get_id_user())).'">'.$u->get_user_login().'</a>', $d), txt('dsc_users_click'));		
	}	
	echo $layout->tbl_end();		
	
} else {	

	echo $layout->empty_list();		
}

echo $layout->end('column');



echo $layout->column('33%');
echo $layout->subtitle(txt('banned_users'),ICONS.'status_error.png');
echo $layout->txtdesc(txt('dsc_users_list_banned'));
$users = new phpos_users;
$how_many = $users->count_users('INACTIVE');
if($how_many != 0)
{
	$users_ids = $users->get_users('INACTIVE');		
	$c=count($users_ids);
	
	echo $layout->tbl_start();
	echo $layout->head(array('<img src="'.ICONS.'accounts/small_users.png" />' => '10%', 'Login' => '50%', txt('last_activity') => '40%'));
	for($i=0; $i<$c; $i++)
	{
		$u = new phpos_users;
		$u->set_id_user($users_ids[$i]);
		$u->get_user_by_id();	
		
		if($u->get_last_activity() != 0)
		{		
			$d = date('d.m.Y H:i:s', $u->get_last_activity());
			
		} else {
		
			$d = txt('never');
		}			
		
		echo $layout->row(array('<img src="'.ICONS.'accounts/small_users.png" style="height:20px"/>', '<a href="javascript:void(0);" onclick="'.helper_reload(array('section' => 'edit_account', 'user_id' => $u->get_id_user())).'">'.$u->get_user_login().'</a>', $d), txt('dsc_users_click'));		
	}	
	echo $layout->tbl_end();		
} else {
	
	echo $layout->empty_list();		
}

echo $layout->end('column');

echo $layout->clr();




?>