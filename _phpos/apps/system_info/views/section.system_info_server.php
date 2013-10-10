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


echo $layout->title(txt('cp_system_info_server_title'), 'icon.png'); 
echo $layout->txtdesc(txt('cp_system_info_server_desc'));

$form = new phpos_forms;

echo $form->form_start('sysinfo', helper_ajax(''), array('app_params' => ''));

echo $layout->column('50%');	


$form->title(txt('cp_system_info_server_form_basic_title'), null, ICONS.'system_info/server_icon.png');
$form->label(txt('cp_system_info_server_form_ip_title'), $_SERVER['SERVER_ADDR'], '');
$form->label(txt('cp_system_info_server_form_os_title'), PHP_OS, '');
$form->label(txt('cp_system_info_server_form_name_title'), $_SERVER['SERVER_NAME'], '');
$form->label(txt('cp_system_info_server_form_soft_title'), $_SERVER['SERVER_SOFTWARE'], '');
$form->label(txt('cp_system_info_server_form_protocol_title'), $_SERVER['SERVER_PROTOCOL'], '');


echo $form->render();

echo $layout->end('column');
echo $layout->column('50%');	

echo $form->render();
echo $layout->end('column');
echo $layout->clr();






echo $form->form_end();



?>