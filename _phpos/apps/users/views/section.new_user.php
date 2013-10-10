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
$new_id = helper_result('new_user_id');

if(empty($new_id))
{

	echo helper_result('new_user');
	echo $layout->title(txt('usr_new'), 'icon.png'); 
	echo $layout->txtdesc(txt('dsc_users_account_new'));
	
	$form = new phpos_forms;

	echo $form->form_start('new_user', helper_ajax('section.new_user.php'), array('app_params' => ''));
	$form->reload_after_submit(array('nowy'));
	$form->input('hidden','user_action', '', '',  'new_user');


	echo $layout->column('50%');	

	$form->title(txt('user_login_data'), txt('all_fields_req'), ICONS.'create_new.png');


	$form->condition('not_null', true, txt('login_empty'));
	$form->condition('min', 4, txt('login_min'));
	$form->condition('max', 30, txt('login_max'));
	$form->input('text','user_new_login', 'Login',  txt('dsc_users_account_login'),  '');


	$form->condition('not_null', true , txt('pass_empty'));
	$form->condition('min', 6, txt('pass_min'));
	$form->condition('max', 30, txt('pass_max'));
	$form->condition('match', 'user_new_pass2' , txt('pass_empty'));
	$form->input('password','user_new_pass', txt('pass'), txt('dsc_users_account_pass'),  '');

	$form->condition('not_null', true , txt('pass_empty'));
	$form->input('password','user_new_pass2', txt('pass_c'), txt('dsc_users_account_pass_c'),  '');


	echo $form->render();


	echo $layout->end('column');
	echo $layout->column('50%');	

	$form->title(txt('usr_account_params'), '', ICONS.'small_options.png');

	$items = array('1' => txt('yes'), '0' => txt('no'));
	$form->radio('user_new_active', txt('active'), txt('dsc_users_account_active'),  $items, '1');


	$items = array('1' => txt('user_user'), '2' => txt('user_admin'));
	$form->radio('user_new_type', txt('type'), txt('dsc_users_account_type'),  $items, '1');

/*
	$items = array('1' => txt('create_home'));
	$form->checkbox('user_new_homedir', txt('home_dir'), txt('home_dir'),  $items, '1');
*/
	$form->input('hidden','user_new_homedir', '', '',  '1');

	$languages = new phpos_languages;
	$langs_array = $languages->get_lang_list();
	$lang_items = array();

	foreach($langs_array as $lang_id)
	{
		$lang_data =  $languages->get_lang_info($lang_id);	
		$lang_name = $lang_data['eng_name'].' ('.$lang_data['local_name'].')';
		$lang_items[$lang_id] = $lang_name;
	}

	$form->select('user_new_lang', txt('language'), txt('dsc_users_account_lang'),  $lang_items, myconfig('lang'));
	$form->status();
	$form->submit('', txt('btn_create'), 'edit_add', 'right');


	//$form->button('', 'button', 'edit_add');


	echo $form->render();

	echo $layout->end('column');
	echo $layout->clr();
	echo $form->form_end();

} else {

	echo $layout->title(txt('usr_new'), 'icon.png'); 	
	
	echo $layout->column('50%');	
	
	echo helper_result('new_user');	
	echo '<img src="'.MY_RESOURCES_URL.'user_added_img.png" style="width:100px;padding-left:50px"/>';
	
	echo $layout->end('column');	
	echo $layout->column('50%');
	
	$result = helper_result('new_user_result');
	$result_id = helper_result('new_user_id');
	
	if($result == 'success' && !empty($result_id))
	{
		$usr = new phpos_users;
		$usr->set_id_user($result_id);
		
		if($usr->user_id_exists())
		{
			$usr->get_user_by_id();
		
		}
		
		include MY_APP_DIR.'views/inc.account_info.php';	
	}
	
	echo $layout->end('column');	
	echo $layout->clr();	
	
}
?>