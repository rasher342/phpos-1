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


		$form = new phpos_forms;

		$form->form_start('account_info', '', '');
		$form->title(txt('usr_account_info'), '', ICONS.'tip.png');	
		
		$form->label('ID',$usr->get_id_user(), '');
		$form->label('Login',$usr->get_user_login(), '');
		
		switch($usr->get_is_active())
		{
			case 1:
				$active_txt = txt('yes');
			break;
			
			case 0:
				$active_txt = txt('no');
			break;
		
		}
		
		$form->label(txt('active'),$active_txt, '');	
		
		
		$form->label(txt('created_at'), date('d.m.Y H:i:s', $usr->get_created_at()), '');
		
		if($usr->get_last_login() != 0)
		{		
			$last_login_txt = date('d.m.Y H:i:s', $usr->get_last_login());
			
		} else {
		
			$last_login_txt = txt('never');
		}
		
		if($usr->get_last_activity() != 0)
		{		
			$last_activity_txt = date('d.m.Y H:i:s', $usr->get_last_activity());
			
		} else {
		
			$last_activity_txt = txt('never');
		}
		
			
		
		$form->label(txt('last_login'), $last_login_txt);
		$form->label(txt('last_activity'),$last_activity_txt);
		$form->label('Email',$usr->get_user_email(), '');
		
		if(is_dir(PHPOS_HOME_DIR.$usr->get_home_dir_hash()))
		{		
			$dir_link = winopen($usr->get_user_login(), 'app', 'app_id:explorer@index', 'fs:local_files,dir_id:'.PHPOS_HOME_DIR.$usr->get_home_dir_hash());
		
			$form->label(txt('home_dir'), '<a href="javascript:void(0);" onclick="'.$dir_link.'">'.$usr->get_home_dir_hash().'</a>', '');
		} else {
			$form->label(txt('home_dir'), txt('no_homedir'), '');
		}
		
		echo $form->render();		
		echo $form->form_end();

?>