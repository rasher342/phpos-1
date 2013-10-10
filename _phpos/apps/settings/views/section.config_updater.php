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
echo $layout->title(txt('cp_updater_autocheck_title'), 'icon.png'); 
echo $layout->txtdesc(txt('cp_updater_autocheck_desc'));
$form = new phpos_forms;

echo $form->form_start('config_updater', helper_ajax('section.config_updater.php'), array('app_params' => ''));
$form->reload_after_submit(array('nowy'));
$form->input('hidden','action', '', '',  'config_updater');




$form->title(txt('cp_updater_autocheck_title'), null, ICONS.'clock.png');

$items = array('1' => txt('yes'), '0' => txt('no'));
$form->radio('app_updater_autoupdate', txt('cp_updater_autocheck'), txt('cp_updater_autocheck_desc'),  $items, globalconfig('app_updater_autoupdate'));

if(!globalconfig('app_updater_autoupdate_timeout')) globalconfig('app_updater_autoupdate_timeout', '5');


$items = array('1' => '1s', '5' => '5s', '10' => '10s');
$form->radio('app_updater_autoupdate_timeout', txt('cp_updater_autocheck_timeout'), txt('cp_updater_autocheck_timeout_desc'),  $items, globalconfig('app_updater_autoupdate_timeout'));

echo $form->render();



	
$form->status();
$form->submit('', txt('btn_update'), 'edit_add', 'right');


//$form->button('', 'button', 'edit_add');


echo $form->render();


echo $form->form_end();



?>