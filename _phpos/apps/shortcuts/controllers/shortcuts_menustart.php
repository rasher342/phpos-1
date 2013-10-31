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
	$link_id = $my_app->get_param('link_id');

	echo 'link_param-'.$link_param.'<br>';
	echo 'link_id-'.$link_id.'<br>';	

	if(!empty($link_id))
	{
		$shortcut = new phpos_shortcuts;
		$row = $shortcut->get_shortcut($link_id);
		$start_title = $row['file_title'];
	}


		$monit_success = "
		phpos.waiting_show();	
		jSuccess(
			'".txt('created')."',
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
		
		winset('title', txt('new_icon_title').' - Menu Start');
		winset('width', '600');
		winset('height', '300');
		wincenter();
		
		$form = new phpos_forms;
		$form->onsuccess($success_code);
		$html.= $form->form_start('new_menustart', helper_ajax('menustartAction.php'), array('app_params' => ''));
		
	
		$after_reload = $my_app->get_param('after_reload');		
		
		$form->reload_after_submit(array($after_reload));					
					
		$form->input('hidden','new_link_type', '', '',  'menustart');	
		
		$form->status();
		$form->condition('not_null', true, txt('name_empty'));					
		$form->input('text','new_link_name', txt('icon_name'), '',  $start_title);	
		
		
		$form->submit_btn(txt('btn_create'));
		$html.= $form->render();					
		$html.= $form->form_end();



?>