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


if(form_submit('new_link'))
{
		$shortcut = new phpos_shortcuts;		
		$app_id = $my_app->get_param('link_param');
		
		// app params
		
		$app = new phpos_app;
		$app->set_app_id($app_id);
		$app->load_config();	
				
		$params = $app->get_available_params();
		$c = count($params);
		if($c != 0)
		{			
			$post_app_params = array();
			
			foreach($params as $key => $data)
			{				
				$post_param = 'param_'.$key;
				if(isset($_POST[$post_param]))
				{
					$post_app_params[$key] = $_POST[$post_param];				
				}
			}			
		}
		

 
		$location_id = $my_app->get_param('location');
		$id_parent = 0;
		
		switch($location_id)
		{
			case 'desktop':
				$location = 'desktop';
			break;
			
			case 'menustart':
				$location = 'menustart';
			break;		
			
			case 'db':
				$location = 'db';
			break;	
			
			case 'edit':
				$location = 'edit';
			break;	
		}
		 

 
		$db_parent = $my_app->get_param('dir_id');
		if(!empty($db_parent)) $id_parent = $db_parent;		
	
		if(globalconfig('demo_mode') != 1 || is_root())
		{
		
			if($location != 'edit')
			{
				$shortcut->add($_POST['new_link_name'], $_POST['new_link_type'], $app_id, $_POST['new_link_action'], $_POST['new_link_icon'], $post_app_params, $location, $id_parent);
				msg::ok(txt('created'));
				
			} else {
			
				$shortcut->update($_POST['new_link_name'], $_POST['new_link_type'], $app_id, $_POST['new_link_action'], $_POST['new_link_icon'], $post_app_params, $location, $my_app->get_param('link_id'));
				msg::ok(txt('updated'));		
			}
		
		}
}
?>