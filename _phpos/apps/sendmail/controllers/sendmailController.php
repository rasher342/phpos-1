<?php
/*
**********************************

	PHPOS Web Operating system
	MIT License
	(c) 2013 Marcin Szczyglinski
	szczyglis83@gmail.com
	GitHUB: https://github.com/phpos/
	File version: 1.0.0, 2013.10.12
 
**********************************
*/
if(!defined('PHPOS'))	die();	

if(PHPOS_HAVE_ACCESS != $my_app->get_app_id() or !defined('PHPOS'))
{
	die();
}	

if(globalconfig('demo_mode') != 1 || is_root())
{
	if(form_submit('new_mail'))
	{
		if($_POST['action'] == 'new_mail')
		{						
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";				
			$headers .= 'To: <'.$_POST['mail_to_email'].'>' . "\r\n";
			$headers .= 'From: '.$_POST['mail_from_name'].' <'.$_POST['mail_from_email'].'>' . "\r\n";		
			$headers .= 'Reply-To: <'.$_POST['mail_from_email'].'>' . "\r\n";					
			
			$to = $_POST['mail_to_email'];
			$subject = $_POST['mail_to_subject'];
			$message = $_POST['msg']; 			

			@mail($to, $subject, $message, $headers);
		}	
	}		
}
			
	$js = " $('textarea#editor').ckeditor();";
	$my_app->jquery_onready($js);	
	$my_app->jquery_onready(msg::showMessages());	

?>