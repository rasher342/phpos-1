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
	echo helper_result('delete_ftp');
	echo $layout->txtdesc(txt('dsc_ftp_title'));
	echo $layout->column('33%');
	
	echo $layout->subtitle(txt('ftp_my'));
	echo $layout->txtdesc(txt('dsc_ftp_list_own'));

	$ftp = new phpos_ftp;

	$ftp_ids = $ftp->get_my_ftp();		
	$c=count($ftp_ids);	
	
	if($c != 0)
	{		
		echo $layout->tbl_start();
		$layout->td_classes(array('', '', 'tbl_grey'));
		echo $layout->head(array('<img src="'.ICONS.'accounts/small_users.png" />' => '20%', txt('ftp_account') => '40%', 'Host' => '40%'));
		for($i=0; $i<$c; $i++)
		{
			$f = new phpos_ftp;
			$f->set_id($ftp_ids[$i]['id']);
			$f->get_ftp();	
			
			//$usr_count = $f->count_users();

			$u = new phpos_users;
			$u->set_id_user($group_ids[$i]['id_owner']);
			$u->get_user_by_id();
				
			echo $layout->row(array('<img src="'.ICONS.'accounts/small_users.png"  style="height:20px"/>', '<a href="javascript:void(0);" onclick="'.helper_reload(array('section' => 'edit_account', 'ftp_id' => $f->get_id())).'">'.$f->get_title().'</a>', $f->get_host()), $f->get_desc());		
		}	
		echo $layout->tbl_end();		
		
	} else {
	
		echo $layout->txtdesc(txt('dsc_ftp_list_empty'));	
	}
	
	
	
	
echo $layout->end('column');


if(is_root() || is_admin())
{
			echo $layout->column('33%');
			echo $layout->subtitle(txt('ftp_all'));
			echo $layout->txtdesc(txt('dsc_ftp_list_all'));

			$ftp = new phpos_ftp;

			$ftp_ids = $ftp->get_all();		
			$c=count($ftp_ids);	
				
	if($c != 0)
	{	
	
			echo $layout->tbl_start();
			$layout->td_classes(array('', '', 'tbl_grey'));
			echo $layout->head(array('<img src="'.ICONS.'accounts/small_users.png" />' => '20%', txt('ftp_account') => '40%', 'Host' => '40%'));
			for($i=0; $i<$c; $i++)
			{
				$f = new phpos_ftp;
				$f->set_id($ftp_ids[$i]['id']);
				$f->get_ftp();	
				
				//$usr_count = $f->count_users();

				$u = new phpos_users;
				$u->set_id_user($group_ids[$i]['id_owner']);
				$u->get_user_by_id();
					
				echo $layout->row(array('<img src="'.ICONS.'accounts/small_users.png"  style="height:20px"/>', '<a href="javascript:void(0);" onclick="'.helper_reload(array('section' => 'edit_account', 'ftp_id' => $f->get_id())).'">'.$f->get_title().'</a>', $f->get_host()), $f->get_desc());		
			}	
			echo $layout->tbl_end();	
			
	} else {
		
			echo $layout->txtdesc(txt('dsc_ftp_list_empty'));	
	}
					

	echo $layout->end('column');
}

	echo $layout->column('33%');
	echo $layout->subtitle(txt('ftp_public'));
	
	if(is_root() || is_admin())
	{
		echo $layout->txtdesc(txt('dsc_ftp_list_public'));
	} else {
		echo $layout->txtdesc(txt('dsc_ftp_list_public_user'));
	}

	$ftp = new phpos_ftp;

	$ftp_ids = $ftp->get_public_ftp();		
	$c=count($ftp_ids);	
		
	if($c != 0)
	{		
		echo $layout->tbl_start();
		$layout->td_classes(array('', '', 'tbl_grey'));
		echo $layout->head(array('<img src="'.ICONS.'accounts/small_users.png" />' => '20%', txt('ftp_account') => '40%', 'Host' => '40%'));
		for($i=0; $i<$c; $i++)
		{
			$f = new phpos_ftp;
			$f->set_id($ftp_ids[$i]['id']);
			$f->get_ftp();	
			
			//$usr_count = $f->count_users();

			$u = new phpos_users;
			$u->set_id_user($group_ids[$i]['id_owner']);
			$u->get_user_by_id();
				
			echo $layout->row(array('<img src="'.ICONS.'accounts/small_users.png"  style="height:20px"/>', '<a href="javascript:void(0);" onclick="'.helper_reload(array('section' => 'edit_account', 'ftp_id' => $f->get_id())).'">'.$f->get_title().'</a>', $f->get_host()), $f->get_desc());		
		}	
		
			echo $layout->tbl_end();	
		
	} else {
	
		echo $layout->txtdesc(txt('dsc_ftp_list_empty'));	
	}
	

	

echo $layout->end('column');

echo $layout->clr();




?>