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


	global $footer;
	echo $layout->back_button(null, helper_reload(array('msg_id' => null)), null, null);
	
		$msg = new phpos_messages;
		$msg_data = $msg->get_msg($my_app->get_param('msg_id'));
	
		$form = new phpos_forms;

		//$form->onsuccess(helper_reload(array('section' => 'sended')));
		echo $form->form_start('', '', array('app_params' => ''));				
		
		
		$form->texteditor('msg_body', null, null, $msg_data['msg']);			
		
		
		if($msg->is_to_me($my_app->get_param('msg_id')))
		{
			$u = new phpos_users;
			$u->set_id_user($msg_data['id_user_from']);
			$u->get_user_by_id();		
		
			$authors = '<span style="color:black; font-weight:bold;font-size:16px">'.txt('messager_tbl_from').': '.$u->get_user_login().' </span>';				
			
			$form->button(txt('messager_btn_reply'), helper_reload(array('section' => 'new', 'reply_id' => $my_app->get_param('msg_id'))), 'reply');	
			
		} else {
			
			$u = new phpos_users;
			$u->set_id_user($msg_data['id_user_to']);
			$u->get_user_by_id();	
			
			$authors = '<span style="color:black; font-weight:bold;font-size:16px">'.txt('messager_tbl_to').': '.$u->get_user_login().' </span>';
		}
		
	
		$footer = '<img src="'.MY_RESOURCES_URL.'msg2.png" />'.$authors.' <b style="padding-left:30px;color:black">'.txt('messager_sent').':</b> '.date('Y.m.d. H:i', $msg_data['sended_at']);
		
		echo $form->render();	
		echo $form->form_end();	
	
	?>