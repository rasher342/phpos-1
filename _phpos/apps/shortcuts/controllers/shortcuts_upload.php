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
		
		$wincfg['title'] = txt('shortcuts_window_title_upload');
		$wincfg['width'] = '600';
		$wincfg['height'] = '370';		
		$wincfg['back_action'] = 'index';
		if($back == 1) $wincfg['back'] = txt('shortcuts_window_back_to_index');	
		
		$button = txt('shortcuts_window_btn_upload');
	
		$input_title = txt('folder_name');		
		$form_id = 'new_upload'.WIN_ID;
		$default_value = '';
		$succ_msg = txt('shortcuts_window_msg_upload');

		$monit_success = "
		phpos.waiting_show();	
		jSuccess(
			'".$succ_msg."',
			{
				autoHide : true, 
				clickOverlay : false,
				MinWidth : 200,
				TimeShown : 5000,
				ShowTimeEffect : 1000,
				HideTimeEffect : 600,
				LongTrip :20,
				HorizontalPosition : 'right',
				VerticalPosition : 'bottom',
				ShowOverlay : false
			}
		);";

		$success_code = winclose(WIN_ID).$monit_success;
		

	
		

/*
**************************
*/
							
	
		$app = new phpos_app;
		$app->set_app_id($link_param);
		$app->load_config();				
		
		$after_reload = $my_app->get_param('after_reload');	
		
		$form = new phpos_forms;
		$form->onsuccess($success_code);
		$html.= $layout->subtitle(txt('shortcuts_upload_title'),MY_RESOURCES.'upload.png');
		$html.= $layout->txtdesc(txt('shortcuts_upload_desc'));
	
		$html.= $form->form_start($form_id, helper_post_outside('null','', $after_reload), array('app_params' => ''));		
			
		
		$form->reload_after_submit(array($after_reload));
		
		if(!empty($edit_id)) $form->input('hidden','edit_id', '', '', strip_tags(base64_decode($edit_id)));			
		
		$form->status();
		$form->condition('not_null', true, txt('name_empty'));					
		$form->input('file','file', txt('shortcuts_upload_file_title'), txt('shortcuts_upload_file_desc'),  $default_value);		
		$html.= $form->render();	
	
		$form->submit_btn($button);
		$next_button = $form->render();			
		$html.= $form->form_end();;



?>