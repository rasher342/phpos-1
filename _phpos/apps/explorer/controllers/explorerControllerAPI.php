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

	if(param('allowed_ext') !== null)
	{
		$allowed_extensions = explode(';', param('allowed_ext'));	
	}
	
	
	cache_param('navigation_index');	
	cache_param('action_status');	
	cache_param('readonly');
	cache_param('win_id');
	cache_param('api_dialog');
	cache_param('api_dialog_type');
	cache_param('api_file_ext');
	cache_param('explorer_save_as_filename');
	cache_param('api_action');
	
	console::log(array('explorerAPI' => 'init()'));

	if(!empty($_POST['explorer_save_as_filename'])) 
	{
		$filename = filter::fname($_POST['explorer_save_as_filename']);
		param('explorer_save_as_filename', $filename);	
		console::log('@APIaction.explorer_save_as_filename: '.$filename);
	}
	
/*.............................................. */		
	

	$explorerAPI = new phpos_explorerAPI;
	$explorerAPI->set_window_id(param('win_id'));
	param('api_action', $explorerAPI->get_action());
	cache_param('api_action');	
						
/*.............................................. */		
	
	if(param('api_open_id') != null)
	{
		$open_file_id = base64_decode(param('api_open_id'));
		param('opened_file_id', $open_file_id);
		console::log('@APIaction.opened_file_id: '.$open_file_id);
		cache_param('opened_file_id');
	}	
	
/*.............................................. */		
	
	// api load file
	if(param('api_dialog') !== null && param('opened_file_id') !== null)
	{
		$phposFS->set_api_file_id(param('opened_file_id'));		
		$api_file_content = $phposFS->get_file_content();
					
/*.............................................. */		
		
		if(!is_array($_SESSION['phpos_files_handler'])) $_SESSION['phpos_files_handler'] = array();
		$_SESSION['phpos_files_handler'][param('win_id')] = array();
		
					
/*.............................................. */		
		
		if(param('fs') == 'db_mysql')
		{	
			$f['id'] = param('opened_file_id');
			$_SESSION['phpos_files_handler'][param('win_id')]['file_info'] = $phposFS->get_file_info($f);	
			
		} else {
		
			$_SESSION['phpos_files_handler'][param('win_id')]['file_info'] = $phposFS->get_file_info(param('opened_file_id'));
		}
					
/*.............................................. */		
		
		$_SESSION['phpos_files_handler'][param('win_id')]['file_data'] = $api_file_content;
		
		param('opened_file_id', null);
		echo "<script>phpos.windowRefresh('".param('win_id')."',''); ".winclose(WIN_ID)."</script>";			
	}	
	
					
/*.............................................. */		
	
	
	if(param('api_action') == 'save')
	{
		console::log(array('explorerAPI' => 'save'));
		
		if(globalconfig('demo_mode') != 1 || is_root())
		{
			if(param('api_dialog') !== null && param('api_dialog_type') == 'save_as_file')
			{
				$file_info = $explorerAPI->get_file_info();
				$data = $explorerAPI->get_cached_data_to_save();		
				if($data == null) $data = ' ';
				if($phposFS->update_file_content($file_info, $data))
				{
					$saved_file_info['fs'] = param('fs');
					$explorerAPI->set_saved_file_info($file_info);
					
					$phposFS->set_api_file_id($file_info['id']);		
					$api_file_content = $phposFS->get_file_content();
					
					if(!is_array($_SESSION['phpos_files_handler'])) $_SESSION['phpos_files_handler'] = array();
					$_SESSION['phpos_files_handler'][param('win_id')] = array();
					$_SESSION['phpos_files_handler'][param('win_id')]['file_data'] = $api_file_content;
					$_SESSION['phpos_files_handler'][param('win_id')]['file_info'] = $file_info;
					
					$monit_success = "
				jSuccess(
					'".txt('file_saved')."',
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
					
					
					echo "<script>".$monit_success." phpos.windowRefresh('".param('win_id')."',''); ".winclose(WIN_ID)."</script>";
				}			
			}		
		} 
	}
	
	
					
/*.............................................. */		
	
	
	
	if(param('api_action') == 'save_as')
	{	
		console::log(array('explorerAPI' => 'save_as'));
		
		if(globalconfig('demo_mode') != 1 || is_root())
		{		
			if(param('api_dialog') !== null && param('api_dialog_type') == 'save_as_file' && param('explorer_save_as_filename') !== null)
			{				
				$data = $explorerAPI->get_cached_data_to_save();
				$app_data = $explorerAPI->get_cached_app_data();				
				
				$monit_success = "
					jSuccess(
						'".txt('file_saved')."',
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
					
						
	/*.............................................. */		
					
				if(is_array($app_data))
				{
					if($data == null) $data = ' ';
					$explorer_save_as_filename = param('explorer_save_as_filename').'.'.param('api_file_ext');
					
					console::log(array('explorerAPI' => 'prepare_to_save_as'));
					
					
					if(false !== ($saved_file_info = $phposFS->save_file_content($explorer_save_as_filename, $data)))
					{
						console::log(array(
						'explorerAPI' => 'save_file_content()',
						'explorer_save_as_filename' => $explorer_save_as_filename
						), 'ok');
						
						$saved_file_info['fs'] = param('fs');
						$explorerAPI->clear_savedata();
						
						if($explorerAPI->set_saved_file_info($saved_file_info))
						{
							console::log(array(
							'explorerAPI' => 'set_saved_file_info()'							
							), 'ok');
						
						} else {
							
							console::log(array(
							'explorerAPI' => 'set_saved_file_info()'							
							), 'error');						
						}
						
						param('api_action', null);
						cache_param('api_action');
						
						echo "<script>".$monit_success." phpos.windowRefresh('".param('win_id')."',''); ".winclose(WIN_ID)."</script>";
					}
					
				} else {
				
					console::log(array('explorerAPI' => 'app_data NOT EXISTS'), 'error');
					echo "<script>".$monit_success." phpos.windowRefresh('".param('win_id')."',''); ".winclose(WIN_ID)."</script>";
				}
			}				
		}	
	}
?>