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


	
	echo $layout->title(txt('your_account')); 
	
	$usr = new phpos_users;
	$usr->set_id_user($usr->get_logged_user());
	
	if($usr->user_id_exists())
	{
		$usr->get_user_by_id();	
	}	
	
	
	echo helper_result('my_update_user');	
	
	$form = new phpos_forms;

	echo $form->form_start('my_update', helper_ajax('section.account.php'), array('app_params' => ''));
	echo $layout->txtdesc(txt('dsc_users_change_pass'));
	
	$form->reload_after_submit(array('nowy'));
	$form->input('hidden','action', '', '',  'my_update');	
	
	echo $layout->column('50%');		
		
	$form->title(txt('change_pass'), '', ICONS.'auth_key.png');	
	
	$form->input('password','user_old_pass', txt('old_pass'),txt('dsc_users_account_old_pass_please'),  '');	
	
	$form->condition('match', 'user_new_pass2' , txt('pass_not_match'));
	$form->input('password','user_new_pass', txt('new_pass'), txt('dsc_users_account_pass'),  '');
	
	$form->input('password','user_new_pass2', txt('new_pass_c'), txt('dsc_users_account_pass_c'),  '');

	$form->title(txt('change_email'), '', ICONS.'email.png');	
	
	$form->input('text','user_new_email', 'Email', txt('dsc_users_account_email'),  $usr->get_user_email());
	
	$form->status();
	$form->submit('', txt('update'), 'edit_add');

	echo $form->render();
	
		
		
		
	echo $layout->end('column');	
	echo $form->form_end();
	
	echo $layout->column('50%');
		include MY_APP_DIR.'views/inc.account_info.php';		
	echo $layout->end('column');
	
	
	echo $layout->clr();
	
	



?>