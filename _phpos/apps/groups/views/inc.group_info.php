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
		
		$form->input('title', '', 'Account information', '',  '');
		$form->label('ID',$usr->get_id_user(), '');
		$form->label('Login',$usr->get_user_login(), '');
		$form->label('Active',$usr->get_is_active(), '');
		$form->label('Account created',date('d.m.Y H:i:s', $usr->get_created_at()), '');
		$form->label('Last login', $usr->get_last_login());
		$form->label('Last activity',$usr->get_last_activity(), '');
		$form->label('Email',$usr->get_user_email(), '');
		
		if(is_dir(PHPOS_WEBROOT_DIR.'home/'.$usr->get_home_dir_hash()))
		{
		$form->label('Home folder', '<a href="javascript:void(0);" onclick="phpos.windowCreate(\'Explorer\',\'explorer2\', \'app_id:explorer2\', \'fs:local_files,dir_id:'.PHPOS_WEBROOT_DIR.'home/'.$usr->get_home_dir_hash().'\');">home/'.$usr->get_home_dir_hash().'</a>', '');
		} else {
		$form->label('Home folder', 'No homedir (create)', '');
		}
		echo $form->render();		
		echo $form->form_end();

?>