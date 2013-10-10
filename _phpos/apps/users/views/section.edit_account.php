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
$user_id = $my_app->get_param('user_id');

if(!empty($user_id))
{	
	$usr = new phpos_users;
			
	if(is_root() || is_admin())
	{		
		$usr->set_id_user($user_id);
		$usr->get_user_by_id();		

		echo helper_result('update_user');
		echo $layout->title(txt('edit_user'), 'icon.png'); 
		echo $layout->txtdesc(txt('dsc_users_edit_list'));
					
		$form = new phpos_forms;

		echo $form->form_start('update_user', helper_ajax('section.edit_account.php'), array('app_params' => ''));
		$form->reload_after_submit(array('nowy'));
		$form->input('hidden','action', '', '',  'update_user');


		echo $layout->column('50%');	

	$form->title(txt('user_login_data'), txt('all_fields_req'), ICONS.'accounts/toolbar_edit.png');


		$form->label('Login',$usr->get_user_login(), '');

		//$form->condition('not_null', true , 'Password is empty');
		//$form->condition('min', 6, 'Password must have min 6 chars');
		//$form->condition('max', 30, 'Password can have max 30 chars');
		$form->condition('match', 'user_new_pass2' , txt('pass_not_match'));
		$form->input('password','user_new_pass', '<span style=color:#7e1414>'.txt('new_pass').'</span>', txt('dsc_users_account_pass'),  '');

		//$form->condition('not_null', true , 'Password confirmation is empty');
		$form->input('password','user_new_pass2', '<span style=color:#7e1414>'.txt('new_pass_c').'</span>', txt('dsc_users_account_pass_c'),  '');

		$form->input('text','user_new_email', 'Email', txt('dsc_users_account_email'),  $usr->get_user_email());

		echo $form->render();


		echo $layout->end('column');
		echo $layout->column('50%');	

		$form->title(txt('usr_account_params'), '', ICONS.'small_options.png');

		$items = array('1' => txt('yes'), '0' => txt('no'));
		$form->radio('user_new_active', txt('active'), txt('dsc_users_account_active'),  $items, $usr->get_is_active());


		$items = array('1' => txt('user_user'), '2' => txt('user_admin'));
		$form->radio('user_new_type', 'Type', txt('dsc_users_account_type'),  $items, $usr->get_user_type());

		$languages = new phpos_languages;
		$langs_array = $languages->get_lang_list();
		$lang_items = array();

		foreach($langs_array as $lang_id)
		{
			$lang_data =  $languages->get_lang_info($lang_id);	
			$lang_name = $lang_data['eng_name'].' ('.$lang_data['local_name'].')';
			$lang_items[$lang_id] = $lang_name;
		}

		$new_cfg = new phpos_config('no_get');
		$new_cfg->set_id_user($user_id);
		$lang = $new_cfg->get_user('lang');

	
		$form->select('user_new_lang', txt('language'), txt('dsc_users_account_lang'),  $lang_items, $lang);
		$form->status();
		
		$delete_action = "
			$.messager.confirm('".txt('delete')."', '".txt('delete_confirm')."?', function(r){
			if (r){
				phpos.windowRefresh('".WIN_ID."', 'section:list,action:delete,delete_id:".$user_id."');	
			}
			});	";
			
			
		$form->button(txt('delete'), $delete_action, 'cancel');
		$form->submit('', txt('update'), 'edit_add');


		//$form->button('', 'button', 'edit_add');


		echo $form->render();


		echo $layout->end('column');
		echo $layout->clr();
		echo $form->form_end();


		// user info
		echo $layout->area_start();
		include MY_APP_DIR.'views/inc.account_info.php';	
		echo $layout->area_end();
			
	} else {
		
		echo txt('access_denied');
	}

} else {
		
		winreload(WIN_ID, array('section' => 'list')); 
	
}
?>