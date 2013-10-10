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

$cloud_id = $my_app->get_param('cloud_id');
$cloud_type = $my_app->get_param('cloud_type');


if(!empty($cloud_id))
{
		$cloud = new phpos_clouds;
		
		if($cloud->is_my_cloud($cloud_id) || is_root())
		{		
			$cloud->set_id($cloud_id);
			$cloud->get_cloud();		

			
			echo $layout->title(txt('edit_cloud'), 'icon.png'); 
			echo $layout->txtdesc(txt('dsc_cloud_title'));
			echo helper_result('update_cloud');
			
			
			$form = new phpos_forms;

			echo $form->form_start('update_cloud', helper_ajax('section.edit_account.php'), array('app_params' => ''));
			$form->reload_after_submit(array('nowy'));
			$form->input('hidden','action', '', '',  'update_cloud');


			echo $layout->column('50%');	

			$form->title($cloud->get_title(), null, $cloud->get_cloud_icon());


			$form->condition('not_null', true, txt('form_empty_field').txt('title'));
			$form->input('text','cloud_new_title', txt('title'), txt('dsc_cloud_name'),  $cloud->get_title());
			
			$form->input('text','cloud_new_desc', txt('desc'), txt('dsc_cloud_desc'),  $cloud->get_desc());

			
			if(is_root() || is_admin())
			{
				$items = array('1' => txt('yes'), '0' => txt('no'));
				$form->radio('cloud_new_public', txt('public'), txt('dsc_cloud_public'),  $items, $cloud->get_is_public());
			} else {
				$form->input('hidden','cloud_new_public', '', '',  0);
			}



			echo $form->render();

			include MY_APP_DIR.'views/cloud_help_google.php';

			echo $layout->end('column');
			echo $layout->column('50%');	

			

			
			
			
switch($cloud_type)
{
	case 'google_drive':
		$form->title(txt('cloud_authentication'), '', ICONS.'auth_key.png');



		$form->condition('not_null', true, txt('form_empty_field').'ClientID');
		$form->input('text','cloud_new_login', 'ClientID', txt('dsc_cloud_login'),  $cloud->get_login());

		$form->condition('not_null', true, txt('form_empty_field').'Secret');
		$form->input('password','cloud_new_pass', 'Secret', txt('dsc_cloud_pass'),  $cloud->get_password());

		$form->input('text','cloud_new_url', 'Redirect URL', txt('dsc_cloud_port'),  $cloud->get_url());
	
	break;
}
			
			
			
			
			
			
			
			
			
			$form->status();
			
			$delete_action = "
			$.messager.confirm('".txt('delete')."', '".txt('delete_confirm')."?', function(r){
			if (r){
				phpos.windowRefresh('".WIN_ID."', 'section:list,action:delete,delete_id:".$cloud->get_id()."');	
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
			
			echo $layout->access_denied();	
		}

} else {
		
		winreload(WIN_ID, array('section' => 'list')); 
		//echo $layout->nothing_to_edit('At first, select record from list');
		//link_action('app')
		//jquery_onready(link_action('list', ''));	
}
?>