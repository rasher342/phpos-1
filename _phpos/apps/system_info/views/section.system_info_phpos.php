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


echo $layout->title(txt('cp_system_info_phpos_title'), 'icon.png'); 
echo $layout->txtdesc(txt('cp_system_info_phpos_desc'));

$form = new phpos_forms;

echo $form->form_start('sysinfo', helper_ajax(''), array('app_params' => ''));

echo $layout->column('50%');	


$form->title(txt('cp_system_info_phpos_form_title_version'), null, ICONS.'system_info/phpos_icon.png');
echo $form->render();
echo $layout->txtdesc(txt('cp_system_info_phpos_version_dsc'));


$form->label(txt('cp_system_info_phpos_form_version'), PHPOS_VERSION, '');
$form->label(txt('cp_system_info_phpos_form_version_name'), PHPOS_VERSION_NAME, '');
$form->label(txt('cp_system_info_phpos_form_build'), PHPOS_BUILD, '');

$form->title(txt('cp_system_info_phpos_form_title_time'), null, ICONS.'clock.png');
$form->label(txt('cp_system_info_phpos_form_time_install'), date('d.m.Y H:i:s', intval(globalconfig('install_time'))), '');
$form->label(txt('cp_system_info_phpos_form_time_update'), date('d.m.Y H:i:s', intval(globalconfig('update_time'))), '');

$form->title(txt('cp_system_info_phpos_form_title_paths'), null, ICONS.'folder.png');
echo $form->render();
echo $layout->txtdesc(txt('cp_system_info_phpos_paths_dsc'));

$form->label('PHPOS_DIR', PHPOS_DIR, '');
$form->label('PHPOS_URL', PHPOS_URL, '');

$form->label('PHPOS_WEBROOT_DIR', PHPOS_WEBROOT_DIR, '');
$form->label('PHPOS_WEBROOT_URL', PHPOS_WEBROOT_URL, '');



echo $form->render();

echo $layout->end('column');
echo $layout->column('50%');	


$www = '';
$tmp_www = PHPOS_ONLINE;
if(!empty($tmp_www))
{
	$www = '<a href="'.PHPOS_ONLINE.'?from=phpos_client" target="_blank">'.PHPOS_ONLINE.'</a>';
}

$github = '';
$tmp_github = PHPOS_GITHUB;
if(!empty($tmp_github))
{
	$github = '<a href="'.PHPOS_GITHUB.'" target="_blank">'.PHPOS_GITHUB.'</a>';
}

$form->title('', null, ICONS.'github.png');
echo $form->render();
echo $layout->txtdesc(txt('cp_system_info_phpos_github_dsc'));

$form->label('GitHUB URL', $github, '');

$form->title(txt('cp_system_info_phpos_form_title_www'), null, ICONS.'btnrow_browser.png');
echo $form->render();
echo $layout->txtdesc(txt('cp_system_info_phpos_www_dsc'));
$form->label('PHPOS URL', $www, '');



$form->title(txt('cp_system_info_phpos_form_title_contact'), null, ICONS.'email.png');
echo $form->render();
echo $layout->txtdesc(txt('cp_system_info_phpos_contact_dsc'));

$email = '';
$tmp_email = PHPOS_EMAIL;
if(!empty($tmp_email))
{
	$email = '<a href="mailto:'.PHPOS_EMAIL.'?subject=from_phpos_client">'.PHPOS_EMAIL.'</a>';
}

$form->label('Email', $email, '');


$form->title(txt('cp_system_info_phpos_form_title_home'), null, ICONS.'home.png');
echo $form->render();
echo $layout->txtdesc(txt('cp_system_info_phpos_homedirs_dsc'));

$form->label('PHPOS_HOME_DIR', PHPOS_HOME_DIR, '');
$form->label('PHPOS_HOME_URL', PHPOS_HOME_URL, '');

echo $form->render();
echo $layout->end('column');
echo $layout->clr();






echo $form->form_end();



?>