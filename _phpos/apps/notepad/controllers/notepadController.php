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


	$my_app->set_param('loadAPI', null);
	$my_app->set_param('loadFS', null);
	$my_app->set_param('loadID', null);
	$my_app->set_param('firstLoad', null);
	
	$my_app->set_param('id_file', null);
	$my_app->set_param('notepad', null);
	$my_app->set_param('file_info', null);
	$my_app->set_param('action', null);	
	$my_app->set_param('content', null);	
	$my_app->set_param('allowed_extensions', null);
	
	$my_app->using('params');
	cache_param('id_file');
	cache_param('notepad');
	cache_param('file_info');
	cache_param('action');	
	cache_param('content');
	
	
	$allowed = array('notepad','txt','log','html','htm');
	$my_app->set_param('allowed_extensions', $allowed);
	cache_param('allowed_extensions');
			
	$explorerAPI = new phpos_explorerAPI;
	
	if($my_app->get_param('loadAPI'))
	{		
		$explorerAPI->openfile();				
	}	
	
	
	if($my_app->get_param('action') == 'new_file')
	{
		$explorerAPI->clear_all_data();
		$my_app->set_param('notepad', null);
		$my_app->set_param('action', null);
		$my_app->set_param('file_info', null);
		$my_app->set_param('id_file', null);
	
		winreload();
		
		cache_param('id_file');		
		cache_param('notepad');	
		cache_param('action');	
		cache_param('file_info');
		cache_param('action');
	}
	
	
	
		
	if($explorerAPI->is_saved_file_info())
	{
		$my_app->set_param('file_info', $explorerAPI->get_saved_file_info());
		cache_param('file_info');
	}
		
		
	if(form_submit('notepadform'))
	{		
		if($_POST['action'] == 'save_as')
		{
			console::log(array(
			'@FORM' => 'submit(notepadform, save_as)'
			));	
			
			$my_app->set_param('notepad', $_POST['txt']);	
			cache_param('notepad');		
			$explorerAPI->set_action('save_as');
			$explorerAPI->cache_data_to_save($_POST['txt']);		
			$_POST['action'] = null;
			//echo '<script>alert("ff");</script>';
			//echo '<script>'.$explorerAPI->savefile_dialog().'</script>';
		}
		
		if($_POST['action'] == 'save')
		{
			console::log(array(
			'@FORM' => 'submit(notepadform, save)'
			));	
			
			$my_app->set_param('notepad', $_POST['txt']);	
			cache_param('notepad');		
			$explorerAPI->set_action('save');			
			$explorerAPI->cache_data_to_save($_POST['txt']);		
			$_POST['action'] = null;
			//echo '<script>'.$explorerAPI->savefile_dialog().'</script>';
		}
		
	}	else {	
	
		if($explorerAPI->data_loaded() && $_POST['action'] === null)
		{
			if($explorerAPI->get_file_data() !== null)
			{
				$my_app->set_param('notepad', $explorerAPI->get_file_data());
			}
			$my_app->set_param('file_info', $explorerAPI->get_file_info());
			cache_param('file_info');
			$explorerAPI->clear_data();
			
		}	else {
		
			if($my_app->get_param('id_file') != null)
			{
				if($explorerAPI->have_db_content($my_app->get_param('id_file')))
				{
					$content = $explorerAPI->get_db_content($my_app->get_param('id_file'));
					$info = $explorerAPI->get_db_info($my_app->get_param('id_file'));
					$info['fs'] = 'db_mysql';
					$my_app->set_param('file_info', $info);
					cache_param('file_info');
					
					$my_app->set_param('notepad', $content);	
					cache_param('notepad');	
				}
			}
			
		
		}
	}
	

	
	
	cache_param('notepad');	
	
	
		$js = " 			
			$('textarea#editor_".WIN_ID."').ckeditor();							
		";
		$my_app->jquery_onready($js);	
		$my_app->set_param('firstLoad', 1);	
		cache_param('firstLoad');			
	
	
	$my_app->using('menu');
	$html['menu'] = $my_app->window->get_layout_menu_html();		
	
?>