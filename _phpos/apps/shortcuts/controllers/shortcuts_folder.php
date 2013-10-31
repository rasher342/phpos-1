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

		$wincfg['title'] = txt('shortcuts_window_title_new_folder');
		$wincfg['width'] = '600';
		$wincfg['height'] = '330';		
		$wincfg['back_action'] = 'index';
		if($back == 1) $wincfg['back'] = txt('shortcuts_window_back_to_index');	
	
		$input_title = txt('folder_name');
		$input_tip = txt('shortcuts_newdir_tip');
		$button = txt('shortcuts_window_btn_new_dir');
		$form_id = 'new_folder';
		$default_value = '';
		$succ_msg = txt('shortcuts_window_msg_new_dir');
		
		// if edit /rename
		$edit_id = $my_app->get_param('edit_id');
		$old_name = $my_app->get_param('old_name');
		
		if(!empty($old_name)) 
		{
			$wincfg['back'] = null;
			$wincfg['title'] = txt('shortcuts_window_title_rename');
			$input_title = txt('shortcuts_rename_title');
			$input_tip = txt('shortcuts_rename_tip');
			$button = txt('shortcuts_window_btn_rename');
			$form_id = 'new_rename';					
			$default_value = strip_tags(base64_decode($old_name));
			$succ_msg = txt('shortcuts_window_msg_rename');
		}
		
		
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
		
		if(empty($old_name)) 
		{
			$html.= $layout->subtitle(txt('shortcuts_newdir_title'),MY_RESOURCES_URL.'folder.png');
			$html.= $layout->txtdesc(txt('shortcuts_newdir_desc'));
			
		} else {
		
			$html.= $layout->subtitle(txt('shortcuts_rename_title'),MY_RESOURCES_URL.'rename.png');
			$html.= $layout->txtdesc(txt('shortcuts_rename_desc'));		
		}
		
	
		$html.= $form->form_start($form_id, helper_post_outside('null','', $after_reload), array('app_params' => ''));		
			
		
		$form->reload_after_submit(array($after_reload));
		
		if(!empty($edit_id)) $form->input('hidden','edit_id', '', '', strip_tags(base64_decode($edit_id)));			
		
		$form->status();
		$form->condition('not_null', true, txt('name_empty'));					
		$form->input('text','new_folder_name', $input_title, $input_tip,  $default_value);		
		$html.= $form->render();		
		
		$form->submit_btn($button);
		$next_button = $form->render();		
		//$html.= $form->render();					
		$html.= $form->form_end();



?>