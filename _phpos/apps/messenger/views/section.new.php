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


	
		echo $layout->title(txt('messager_section_new_desc'));   
		
		$my_app->set_param('msg_id', null);	
		cache_param('msg_id');
		
		$form = new phpos_forms;

		$form->onsuccess(helper_reload(array('section' => 'sended')));
		echo $form->form_start('new_msg', '', array('app_params' => ''));								
		
		$form->input('hidden','action', '', '',  'new_msg');
		
		echo $layout->column('50%');
		$form->condition('not_null', true, txt('login_empty'));
		$form->input('text','msg_title', txt('messager_form_title'),  txt('messager_form_title_desc'), $start_title);
		$form->status();
		echo $form->render();	
		echo $layout->end('column');	
		
		
		echo $layout->column('50%');		
		
		$users = new phpos_users;		
		$users_ids = $users->get_users('ALL');
		
		$i = 0;
		$my_id = logged_id();
		foreach($users_ids as $id)
		{
			$usr_info = new phpos_users;
			$usr_info->set_id_user($id);
			$usr_info->get_user_by_id();		
			
			$items[$id] = $usr_info->get_user_login();
			if($my_id == $id) $items[$id] = txt('messager_tbl_me');
			$i++;
		}	
		
		
		$reply_id = $my_app->get_param('reply_id');		
		
		$start_user_to = '';
		$start_title = '';
		$start_msg = '';
		
		if($reply_id !== null)
		{
			$msg = new phpos_messages;
			$reply = $msg->get_msg($reply_id);
	
			$start_user_to = $reply['id_user_from'];
			$start_title = 'Re: '.$reply['title'];
			$start_msg = '<br /><br />------------------------<br /><b>Reply for message:</b><br />Sent: '.date('Y.m.d H:i:s', $reply['sended_at']).'<br /><i>'.$reply['msg'].'</i><br />------------------------';		
		}		
		
		$form->select('msg_to', txt('messager_form_to'), txt('messager_form_to_desc'),  $items, $start_user_to);		
		echo $form->render();	
		echo $layout->end('column');
		echo $layout->clr();	
		
		$form->texteditor('msg_body', null, null, $start_msg);			
		
		$form->submit('', txt('messager_btn_send'));		
		
		echo $form->render();	
		echo $form->form_end();	
?>