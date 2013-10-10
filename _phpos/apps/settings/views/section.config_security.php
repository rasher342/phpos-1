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


echo helper_result('config_update');
echo $layout->title(txt('cp_security_title'), 'icon.png'); 
echo $layout->txtdesc(txt('cp_security_desc'));
$form = new phpos_forms;

echo $form->form_start('config_security', helper_ajax('section.config_security.php'), array('app_params' => ''));
$form->reload_after_submit(array('nowy'));
$form->input('hidden','action', '', '',  'config_security');

echo $layout->column('50%');	



if(!globalconfig('disable_access_users')) globalconfig('disable_access_users', '0');
if(!globalconfig('disable_access_admins')) globalconfig('disable_access_admins', '0');
if(!globalconfig('disable_upload')) globalconfig('disable_upload', '0');
if(!globalconfig('readonly')) globalconfig('readonly', '0');
if(!globalconfig('demo_mode')) globalconfig('demo_mode', '0');

$form->title(txt('cp_security_logins_title'), null, ICONS.'user.png');

$items = array('0' => txt('no'), '1' => txt('yes'));
$form->radio('disable_access_users', txt('cp_security_disable_login_users'), txt('cp_security_disable_login_users_desc'),  $items, globalconfig('disable_access_users'));

$items = array('0' => txt('no'), '1' => txt('yes'));
$form->radio('disable_access_admins', txt('cp_security_disable_login_admins'), txt('cp_security_disable_login_admins_desc'),  $items, globalconfig('disable_access_admins'));

$items = array('0' => txt('no'), '1' => txt('yes'));
$form->radio('readonly', txt('cp_security_disable_explorer'), txt('cp_security_disable_explorer_desc'),  $items, globalconfig('readonly'));

$items = array('0' => txt('no'), '1' => txt('yes'));
$form->radio('demo_mode', txt('cp_demomode'), txt('cp_demomode_desc'),  $items, globalconfig('demo_mode'));


echo $form->render();

echo $layout->end('column');
echo $layout->column('50%');	

$form->title(txt('cp_security_upload'), '', ICONS.'dragdrop.png');

$items = array('0' => txt('no'), '1' => txt('yes'));
$form->radio('disable_upload', txt('cp_security_disable_upload'), txt('cp_security_disable_upload_desc'),  $items, globalconfig('disable_upload'));

$form->textarea('upload_whitelist', txt('cp_security_upload_whitelist'), txt('cp_security_upload_whitelist_desc'),  globalconfig('upload_whitelist'));

$form->textarea('upload_blacklist', txt('cp_security_upload_blacklist'), txt('cp_security_upload_blacklist_desc'),  globalconfig('upload_blacklist'));




	
$form->status();
$form->submit('', txt('btn_update'), 'edit_add', 'right');


//$form->button('', 'button', 'edit_add');


echo $form->render();

echo $layout->end('column');
echo $layout->clr();

echo $form->form_end();



?>