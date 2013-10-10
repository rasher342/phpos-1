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
$new_id = helper_result('new_group_id');
if(empty($new_id))
{

echo helper_result('new_group');
echo $layout->title(txt('group_new'), 'icon.png'); 
echo $layout->txtdesc(txt('dsc_cp_newgroup'));

$form = new phpos_forms;

echo $form->form_start('new_group', helper_ajax('section.new_group.php'), array('app_params' => ''));
$form->reload_after_submit(array('nowy'));
$form->input('hidden','action', '', '',  'new_group');


echo $layout->column('50%');	

$form->title(txt('group_new'),null, ICONS.'create_new.png');


$form->condition('not_null', true, txt('form_empty_field').txt('name'));
$form->input('text','group_new_name', txt('name'), txt('dsc_cp_newgroup_name'),  '');



$form->input('text','group_new_desc', txt('desc'), txt('dsc_cp_newgroup_desc'),  '');


echo $form->render();


echo $layout->end('column');
echo $layout->column('50%');	

$form->title(txt('group_msg'), '', ICONS.'email.png');


$form->textarea('group_new_msg', txt('group_msg'), txt('dsc_cp_newgroup_msg'),  '');
$form->status();

$form->submit('', txt('btn_create'), 'edit_add', 'right');


//$form->button('', 'button', 'edit_add');


echo $form->render();

echo $layout->end('column');
echo $layout->clr();
echo $form->form_end();



} else {




	echo $layout->title('Adding new workgroup', 'icon.png'); 	
	
	echo $layout->column('50%');	
	
		echo helper_result('new_group');	
		echo '<img src="'.MY_RESOURCES_URL.'user_added_img.png" style="width:100px;padding-left:50px"/>';
	
	echo $layout->end('column');	
	echo $layout->column('50%');
	
	$result = helper_result('new_group_result');
	$result_id = helper_result('new_group_id');
	
		if($result == 'success' && !empty($result_id))
		{
			$usr = new phpos_users;
			$usr->set_id_user($result_id);
			
			if($usr->user_id_exists())
			{
				$usr->get_user_by_id();
			
			}
			
			include MY_APP_DIR.'views/inc.group_info.php';	
		}
	
	echo $layout->end('column');	
	echo $layout->clr();
	



	
}
?>