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

if(PHPOS_HAVE_ACCESS != $my_app->get_app_id() or !defined('PHPOS'))
{
	die();
}

	$my_app->set_param('delete_id', '');
	$my_app->set_param('delete_sended_id', null);
	$my_app->set_param('delete_received_id', null);
	
	$my_app->set_param('msg_id', null);	
	$my_app->set_param('reply_id', null);	
	$my_app->set_param('section', 'received');
	$my_app->set_param('action', null);

	
	$my_app->using('params');
	$my_app->using('toolbar');	
	winConfig('use_sections');

	cache_param('section');
	cache_param('delete_sended_id');
	cache_param('delete_received_id');
	cache_param('reply_id');
	
	//cache_param('msg_id');
	
	$msg = new phpos_messages;
	
	if($my_app->get_param('msg_id') !== null && $my_app->get_param('delete_received_id') === null)
	{
		if(globalconfig('demo_mode') != 1 || is_root())
		{
			if(!$msg->is_readed(($my_app->get_param('msg_id'))) && $msg->is_to_me($my_app->get_param('msg_id'))) $msg->set_as_readed($my_app->get_param('msg_id'));
		}
	}
	
if(globalconfig('demo_mode') != 1 || is_root())
{		
	if($my_app->get_param('delete_sended_id') !== null)
	{		
		$msg->delete_sended($my_app->get_param('delete_sended_id'));
		savelog('MSG#DELETED:'.$my_app->get_param('delete_sended_id'));
		$my_app->set_param('delete_sended_id', null);
		cache_param('delete_sended_id');	
		
	}
	
	if($my_app->get_param('delete_received_id') !== null)
	{
		$msg->delete_received($my_app->get_param('delete_received_id'));
		savelog('MSG#DELETED:'.$my_app->get_param('delete_received_id'));
		$my_app->set_param('delete_received_id', null);
		cache_param('delete_received_id');	
	}
	
	
	if(form_submit('new_msg'))
	{
		if($_POST['action'] == 'new_msg')
		{			
			$msg->send(intval($_POST['msg_to']), strip_tags($_POST['msg_title']), $_POST['msg_body']);		
			$_POST['action'] = null;
			savelog('MSG#SEND_NEW');
			$msg->delete_sended($my_app->get_param('reply_id'));
			$my_app->set_param('reply_id', null);
			cache_param('reply_id');	
		}	
	}	
}		
	
	$js = " $('textarea#editor').ckeditor();";
	$my_app->jquery_onready($js);	
	$my_app->jquery_onready(msg::showMessages());	

?>