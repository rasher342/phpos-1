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


// if section access
$new_id = helper_result('update_ftp_id');

$ftp_id = $my_app->get_param('ftp_id');



if(!empty($ftp_id))
{
		$ftp = new phpos_ftp;
		
		if($ftp->is_my_ftp($ftp_id) || is_root() || is_admin())
		{		
			$ftp->set_id($ftp_id);
			$ftp->get_ftp();		

			
			echo $layout->title(txt('edit_ftp'), 'icon.png'); 
			echo $layout->txtdesc(txt('dsc_ftp_title'));
			echo helper_result('update_ftp');
			
			
			$form = new phpos_forms;

			echo $form->form_start('update_ftp', helper_ajax('section.edit_account.php'), array('app_params' => ''));
			$form->reload_after_submit(array('nowy'));
			$form->input('hidden','action', '', '',  'update_ftp');


			echo $layout->column('50%');	

		$form->title($ftp->get_title(), null, ICONS.'accounts/small_users.png');


			$form->condition('not_null', true, txt('form_empty_field').txt('title'));
			$form->input('text','ftp_new_title', txt('title'), txt('dsc_ftp_name'),  $ftp->get_title());
			
			$form->input('text','ftp_new_desc', txt('desc'), txt('dsc_ftp_desc'),  $ftp->get_desc());


			echo $form->render();


			echo $layout->end('column');
			echo $layout->column('50%');	

			$form->title(txt('ftp_authentication'), '', ICONS.'small_options.png');

			$form->condition('not_null', true, txt('form_empty_field').'Host');
			$form->input('text','ftp_new_host', 'Host/IP', txt('dsc_ftp_host'),  $ftp->get_host());

			$form->condition('not_null', true, txt('form_empty_field').'Login');
			$form->input('text','ftp_new_login', 'Login', txt('dsc_ftp_login'), $ftp->get_login());

			$form->condition('not_null', true, txt('form_empty_field').txt('password'));
			$form->input('password','ftp_new_pass', txt('password'), txt('dsc_ftp_pass'),  $ftp->get_password());

			$form->input('text','ftp_new_port', 'Port', txt('dsc_ftp_port'),  $ftp->get_port());

			$form->status();
			
			$delete_action = "
			$.messager.confirm('".txt('delete')."', '".txt('delete_confirm')."?', function(r){
			if (r){
				phpos.windowRefresh('".WIN_ID."', 'section:list,action:delete,delete_id:".$ftp->get_id()."');	
			}
			});	";
			
			
			$form->button(txt('delete'), $delete_action, 'cancel');
			$form->submit('', txt('btn_update'), 'edit_add');


			//$form->button('', 'button', 'edit_add');


			echo $form->render();

			echo $layout->end('column');
			echo $layout->clr();
			echo $form->form_end();
		
		} else {
			
			echo txt('access_denied');
		}

} else {
		
		winreload(WIN_ID, array('section' => 'list')); 
		//echo $layout->nothing_to_edit('At first, select record from list');
		//link_action('app')
		//jquery_onready(link_action('list', ''));	
}
?>