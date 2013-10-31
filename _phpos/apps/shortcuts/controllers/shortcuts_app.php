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


// apps list 
if(empty($link_param))
{			
		$app_choose = true;
		
		$wincfg['title'] = txt('shortcuts_window_title_app');
		$wincfg['width'] = '350';
		$wincfg['height'] = '430';		
		$wincfg['back_action'] = 'index';
		$wincfg['back'] = txt('shortcuts_window_back_to_index');	
	
	$apps = new phpos_app;
	$app_list = $apps->my_apps_list();
	$c = count($app_list);
	
	if($c != 0)
	{
		
		$html.= $layout->txtdesc(txt('shortcuts_app_form_step1_desc'));
	
		$html.= '<div id="phpos_shortcuts_apps" style="padding:15px">';
		
		foreach ($app_list as $item)	
		{
			$apps->set_app_id($item);
			$apps->load_config();
			
			$is_hide = $apps->get_hidden();
			if(!$is_hide)
			{						
				$action = link_action('app', 'link_type:app,link_param:'.$item);
				$html.= '<div class="shortcuts_app_item" title="'.$apps->get_desc().'" onclick="'.$action.'"><img src="'.$apps->get_icon().'"><span>'.$apps->get_title().'</span></div>';		
			}
		}
		
		$html.= '</div>';
		
		$js_code = "
		$('.shortcuts_app_item').mouseenter(function()
		{
			$(this).removeClass('mouseleave').addClass('mouseenter');	
		});
		
		$('.shortcuts_app_item').mouseleave(function()
		{
			$(this).removeClass('mouseenter').addClass('mouseleave');	
		});
		";				
		
		$my_app->jquery_onready($js_code);
	
	} 
	 
/*
**************************
*/

} else {
		
		// app params
		
		$location_id = $my_app->get_param('location');
		$wincfg['title'] = txt('shortcuts_window_title_app_step2');
		$wincfg['width'] = '600';
		$wincfg['height'] = '550';	
		
		$button = txt('shortcuts_window_btn_app_new');
		
		if($location_id != 'edit')
		{
			$succ_msg = txt('shortcuts_window_msg_app_created');
		} else {
			$succ_msg = txt('shortcuts_window_msg_app_updated');
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
		
		if($back == 1)	$html.= $layout->back_button(txt('shortcuts_window_back_to_apps'), link_action('app', 'link_param:0'), txt('shortcuts_window_back_to_apps'), null);
		$html.= $layout->subtitle($app->get_title(), $app->get_icon());
		$html.= $layout->subtitle(txt('shortcuts_app_form_choose_params'),MY_RESOURCES_URL.'upload.png');
		$html.= $layout->txtdesc(txt('shortcuts_app_form_choose_params_desc'));
		
		$form = new phpos_forms;
		$form->onsuccess($success_code);
		$html.= $form->form_start('new_link', helper_ajax('appAction.php'), array('app_params' => ''));
		
	
		$after_reload = $my_app->get_param('after_reload');		
		
		$form->reload_after_submit(array($after_reload));
		
		$form->input('hidden','user_action_new', '', '',  '1');					
		$form->input('hidden','new_link_type', '', '',  'app');	
		
		
		$start_link_title = $app->get_title();
		
		// if from DB
		$link_id = $my_app->get_param('link_id');	
		
		if(!empty($link_id))
		{
			$wincfg['back'] = null;
			$shortcut = new phpos_shortcuts;
			$db_shortcut = $shortcut->get_shortcut($link_id);
			$db_params = $shortcut->get_params_from_db($link_id);	
			$start_link_title = $db_shortcut['file_title'];
			$start_app_action = $db_shortcut['app_action'];
			$button = txt('shortcuts_window_btn_app_update');
			$wincfg['title'] = txt('shortcuts_window_title_app_update');		
		}				
		
		
		$form->status();
		$form->condition('not_null', true, txt('name_empty'));					
		$form->input('text','new_link_name', txt('shortcuts_form_icon_name'), txt('shortcuts_form_icon_name_desc'),  $start_link_title);					
		
		$actions = $app->get_actions();
		
		
		$c = count($actions);
		if($c != 0)
		{
			$form->title(txt('start_window'), '', MY_RESOURCES_URL.'start.png');						
			$items = array();		
			
			foreach($actions as $key => $data)
			{									
				$items[$key] = $data['name'];							
				$default_value = $app->get_default_action();							
			}		
			
			if(is_array($db_shortcut))
			{
				$default_value = $db_shortcut['app_action'];
			}
			
			$form->select('new_link_action', txt('action_name'), txt('shortcuts_app_form_actions_desc'),  $items, $default_value);						
		}
		
 
/*
**************************
*/

		$params = $app->get_available_params();
		
		$c = count($params);
		if($c != 0)
		{			
			$form->title(txt('start_parameters'), '', MY_RESOURCES_URL.'params.png');
			
			foreach($params as $key => $data)
			{
				$items = array();
				
				$param_values = $app->app_param_values($key);
				
				$k = count($param_values);
				if($k != 0)
				{
					foreach($param_values as $val)
					{								
						//echo $val;
						$items[$val] = $val;
					}
				}
				
				$default_value = $data['default'];
				
				// if link_id get default from id							
				if(is_array($db_params))
				{								
					$default_value = $db_params[$key];
				}
				
				$form->select('param_'.$key, $data['name'], txt('shortcuts_app_form_param_desc'),  $items, $default_value);
			}			
		}					
		
		// icon
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
		$form->title(txt('shortcuts_icon_for_title'), '', MY_RESOURCES_URL.'icon.png');
		$form->select('new_link_icon', txt('shortcuts_icon_for_name'), txt('shortcuts_icon_for_desc'),  $items, $db_shortcut['icon']);
	$html.= $form->render();	
	
	$form->submit_btn($button);
	$next_button = $form->render();			
	$html.= $form->form_end();;
	
}	



?>