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


echo $layout->title(txt('cp_system_info_db_title'), 'icon.png'); 
echo $layout->txtdesc(txt('cp_system_info_db_desc'));

$form = new phpos_forms;

echo $form->form_start('sysinfo', helper_ajax(''), array('app_params' => ''));

echo $layout->column('50%');	




$form->title(txt('cp_system_info_db_adapter_title'), null, ICONS.'system_info/db_icon.png');
echo $form->render();

echo $layout->txtdesc(txt('cp_system_info_db_adapter_desc'));
$form->label(txt('cp_system_info_db_form_adapter_title'), $db_adapter, '');



echo $form->render();

echo $layout->end('column');
echo $layout->column('50%');	


$form->title(txt('cp_system_info_db_auth_title'), null, ICONS.'auth_key.png');
echo $form->render();

echo $layout->txtdesc(txt('cp_system_info_db_auth_desc'));

$form->label(txt('cp_system_info_db_form_host_title'), $db_host, '');
$form->label(txt('cp_system_info_db_form_dbname_title'), $db_dbname, '');
$form->label(txt('cp_system_info_db_form_user_title'), $db_login, '');
$form->label(txt('cp_system_info_db_form_pass_title'), txt('cp_system_info_db_form_pass_hidden'), '');
$form->label(txt('cp_system_info_db_form_prefix_title'), $db_prefix, '');


echo $form->render();
echo $layout->end('column');
echo $layout->clr();






echo $form->form_end();



?>