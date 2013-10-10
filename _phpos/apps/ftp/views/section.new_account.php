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
$new_id = helper_result('new_ftp_id');
if(empty($new_id))
{

echo helper_result('new_ftp');
echo $layout->title(txt('add_new_ftp'), 'icon.png'); 
echo $layout->txtdesc(txt('dsc_ftp_title'));
$form = new phpos_forms;

echo $form->form_start('new_ftp', helper_ajax('section.new_account.php'), array('app_params' => ''));
$form->reload_after_submit(array('nowy'));
$form->input('hidden','action', '', '',  'new_ftp');


echo $layout->column('50%');	

$form->title(txt('dsc_ftp_desc_new'), null, ICONS.'create_new.png');


$form->condition('not_null', true, txt('form_empty_field').txt('title'));
$form->input('text','ftp_new_title', txt('title'), txt('dsc_ftp_name'),  '');


$form->input('text','ftp_new_desc', txt('desc'), txt('dsc_ftp_desc'),  '');

if(is_root() || is_admin())
{
	$items = array('0' => txt('no'), '1' => txt('yes'));
	$form->radio('ftp_new_public', txt('ftp_form_public'), txt('ftp_form_public_desc'),  $items, '0');
	
} else {
	
	$form->input('hidden','ftp_new_public', '', '',  '0');
}


echo $form->render();


echo $layout->end('column');
echo $layout->column('50%');	

$form->title(txt('ftp_authentication'), '', ICONS.'system_info/key_icon.png');

$form->condition('not_null', true, txt('form_empty_field').'Host');
$form->input('text','ftp_new_host', 'Host/IP', txt('dsc_ftp_host'),  '');

$form->condition('not_null', true, txt('form_empty_field').'Login');
$form->input('text','ftp_new_login', 'Login', txt('dsc_ftp_login'),  '');

$form->condition('not_null', true, txt('form_empty_field').txt('password'));
$form->input('password','ftp_new_pass', txt('password'), txt('dsc_ftp_pass'),  '');

$form->input('text','ftp_new_port', 'Port', txt('dsc_ftp_port'),  '21');

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
	
	echo helper_result('new_ftp');	
	
	echo '<script>'.winreload(WIN_ID, array('section' => 'list')).'</script>';
		//echo '<img src="'.MY_RESOURCES_URL.'user_added_img.png" style="width:100px;padding-left:50px"/>';
	
	echo $layout->end('column');	
	echo $layout->column('50%');
	

	
	echo $layout->end('column');	
	echo $layout->clr();
	



	
}
?>