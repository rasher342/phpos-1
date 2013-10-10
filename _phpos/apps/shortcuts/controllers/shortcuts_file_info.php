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


	$link_param = $my_app->get_param('link_param');


	$input_title = txt('folder_name');
	$button = txt('btn_create');
	$form_id = 'new_folder';
	$default_value = '';
	$succ_msg = txt('created');
	
	$fs = $my_app->get_param('fs');		

	$success_code = winclose(WIN_ID).$monit_success;
	
	winset('title', txt('fileinfo_title'));
	winset('width', '600');
	winset('height', '400');
	wincenter();
			

	$app = new phpos_app;
	$app->set_app_id($link_param);
	$app->load_config();				
	

	
	$form = new phpos_forms;
			
	
	$html.= $form->form_start($form_id, helper_post_outside('null','', $after_reload), array('app_params' => ''));					

				
	$form->label(txt('fileinfo_name') , base64_decode($my_app->get_param('file_name')));		
	$form->label(txt('fileinfo_dir') , base64_decode($my_app->get_param('dir_name')));										
	$form->label(txt('fileinfo_fs') ,$fs);
	$form->label(txt('fileinfo_type') , base64_decode($my_app->get_param('file_type')));
	$form->label(txt('fileinfo_created') , date(DATE_FORMAT, base64_decode($my_app->get_param('file_created'))));
	$form->label(txt('fileinfo_modified') , date(DATE_FORMAT, base64_decode($my_app->get_param('file_modified'))));
	$form->label(txt('fileinfo_chmod') , file_chmod(base64_decode($my_app->get_param('file_chmod'))));

	$html.= $form->render();					
	$html.= $form->form_end();



?>