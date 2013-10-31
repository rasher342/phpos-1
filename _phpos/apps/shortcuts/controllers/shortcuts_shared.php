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
	
		$wincfg['title'] = txt('shortcuts_window_title_share');
		$wincfg['width'] = '600';
		$wincfg['height'] = '520';		

	
		$input_title = txt('folder_name');
		$button = txt('shortcuts_share_btn');
		$form_id = 'share_folder';
		$default_value = '';
		$succ_msg = txt('shortcuts_window_msg_shared');
		
		// if edit /rename
		$shared_id = basename(base64_decode($my_app->get_param('shared_id')));
		
		/*
		$old_name = $my_app->get_param('old_name');
		if(!empty($old_name)) 
		{
			$input_title = 'Change name';
			$button = 'Save';
			$form_id = 'new_rename';					
			$default_value = strip_tags(base64_decode($old_name));
			$succ_msg = 'Updated';
		}*/
		
		
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
		
		$html.= $layout->subtitle(txt('shortcuts_share_title'),MY_RESOURCES_URL.'shared.png');
		$html.= $layout->txtdesc(txt('shortcuts_share_desc'));
		
		$html.= $layout->subtitle(txt('shortcuts_share_id_title'),MY_RESOURCES_URL.'folder.png');
		
		$form = new phpos_forms;
		$form->onsuccess($success_code);
		$html.= $form->form_start($form_id, helper_ajax('shareAction.php'), array('app_params' => ''));
								
		
		$form->reload_after_submit(array($after_reload));
	
		
		$form->status();
		$form->label(txt('shortcuts_share_form_folder').': ',$shared_id, txt('shortcuts_share_form_folder_desc'));
		$html.= $form->render();	
		
		$html.= $layout->subtitle(txt('shortcuts_share_network_name'),MY_RESOURCES_URL.'shared.png');
		$html.= $layout->txtdesc(txt('shortcuts_share_network_name_desc'));
		
		$form->condition('not_null', true, txt('name_empty'));					
		$form->input('text','new_folder_name', txt('shortcuts_share_form_name'), txt('shortcuts_share_network_name_tip'),  $default_value);						
					
		$form->input('text','new_folder_desc', txt('shortcuts_share_form_desc'), txt('shortcuts_share_form_desc_desc'),  $default_value);$html.= $form->render();			
		
		$html.= $layout->subtitle(txt('shortcuts_share_access_title'),MY_RESOURCES_URL.'perms.png');
		
		$items = array('1' => txt('yes'), '0' => txt('no'));
		$form->radio('new_folder_readonly', txt('shortcuts_share_form_readonly'), txt('shortcuts_share_form_readonly_desc'),  $items, '1');
		
		$html.= $form->render();	
		$form->submit_btn($button);
		$next_button = $form->render();			
		$html.= $form->form_end();

?>