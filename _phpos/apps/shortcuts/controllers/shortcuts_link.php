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
	$location_id = $my_app->get_param('location');
	
		$wincfg['title'] = txt('shortcuts_window_title_new_url');
		$wincfg['width'] = '600';
		$wincfg['height'] = '400';		
		$wincfg['back_action'] = 'index';
		$wincfg['back'] = txt('shortcuts_window_back_to_index');	
		
		$button = txt('shortcuts_window_btn_new_url');
		
	if($location_id != 'edit')
	{
		$succ_msg = txt('shortcuts_window_msg_url_created');
	} else {
		$succ_msg = txt('shortcuts_window_msg_url_updated');
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


	$app = new phpos_app;
	$app->set_app_id($link_param);
	$app->load_config();
	
	
	
	$html.= $layout->subtitle(txt('shortcuts_url_title'),MY_RESOURCES.'link_icon.png');
	$html.= $layout->txtdesc(txt('shortcuts_url_desc'));
	
	$form = new phpos_forms;
	$form->onsuccess($success_code);
	$html.= $form->form_start('new_url_link', helper_ajax('linkAction.php'), array('app_params' => ''));
	

	$after_reload = $my_app->get_param('after_reload');		
	
	$form->reload_after_submit(array($after_reload));					
				
	$form->input('hidden','new_link_type', '', '',  'link');	
	
	$link_id = $my_app->get_param('link_id');		
	
	if(!empty($link_id))
	{
		$wincfg['back'] = null;
		$shortcut = new phpos_shortcuts;
		$db_shortcut = $shortcut->get_shortcut($link_id);
		$db_params = $shortcut->get_params_from_db($link_id);	
		$url = base64_decode($db_params['url']);
		$start_link_title = $db_shortcut['file_title'];		
		$button = txt('shortcuts_window_btn_update_url');	
		$wincfg['title'] = txt('shortcuts_window_title_update_url');		
	}					
	
	
	$form->status();
	$form->condition('not_null', true, txt('name_empty'));					
	$form->input('text','new_link_name', txt('shortcuts_form_icon_name'), txt('shortcuts_form_icon_name_desc'),  $start_link_title);		
	
	$form->condition('not_null', true, txt('url_empty'));			
	$form->input('text','new_link_url', txt('shortcuts_url_form_url'), txt('shortcuts_url_form_url_desc'),  $url);			
	
	$icons = new phpos_icons;
	$c = $icons->count_icons();
	$items = array('null' => '---');
	
	if($c != 0)
	{			
		$icons_list = $icons->get_icon_list();
		
		foreach($icons_list as $icon_name)
		{
			$items[$icon_name] = $icon_name;
		}						
	}
	
	$form->title(txt('shortcuts_icon_for_title'), '', MY_RESOURCES.'icon.png');
	$form->select('new_link_icon', txt('shortcuts_icon_for_name'), txt('shortcuts_icon_for_desc'),  $items, $db_shortcut['icon']);
		
	$html.= $form->render();	
	
	$form->submit_btn($button);
	$next_button = $form->render();			
	$html.= $form->form_end();



?>