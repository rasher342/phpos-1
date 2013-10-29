<?php
/*
**********************************

	PHPOS Web Operating system
	MIT License
	(c) 2013 Marcin Szczyglinski
	szczyglis83@gmail.com
	GitHUB: https://github.com/phpos/
	File version: 1.2.8, 2013.10.25
 
**********************************
*/
if(!defined('PHPOS'))	die();	

if(!defined("PHPOS_IN_EXPLORER"))
{
	die();
}

		$contextMenus['FILE'] = array(				
				'open::'.txt('open').'::alert();::google_drive',
				'---',									
				'rename::'.txt('rename').'::'.winmodal(txt('rename'), 'app', 'app_id:shortcuts@folder','location:'.$context_location.',dir_id:'.$context_dir_id.',edit_id:'.base64_encode($icons[$i]['id']).',old_name:'.base64_encode($icons[$i]['basename']).',after_reload:'.WIN_ID).'::edit'			
		);		

		$contextMenus['FILE'][] = '---';	
			
	  $contextMenus['FILE'][]	=	
		'downloadl::'.txt('download_to_disk').'::explorer_clouds_google_drive_localdownload("'.$icons[$i]['id'].'", "'.$icons[$i]['basename'].'", "'.$my_app->get_param('fs').'");::download';	
		$contextMenus['FILE'][]	=	
		'downloads::'.txt('download_to_server').'::explorer_clouds_google_drive_serverdownload("'.$icons[$i]['id'].'", "'.$icons[$i]['basename'].'", "'.$my_app->get_param('fs').'");::download';	


		$contextMenus['DIR'] = array(		
				'open::Open folder::::open',			
				'rename::'.txt('rename').'::'.winmodal(txt('rename'), 'app', 'app_id:shortcuts@folder','location:'.$context_location.',dir_id:'.$context_dir_id.',edit_id:'.base64_encode($icons[$i]['id']).',old_name:'.base64_encode($icons[$i]['basename']).',after_reload:'.WIN_ID).'::edit'				
				
		);	

		$contextMenus['WINDOW'] = array(		
				'newshortcut::Open this folder in Google::'.winmodal(txt('new_shortcut'), 'app', 'app_id:shortcuts@index,width:300,height:350','desktop:1,location:'.$context_location.',dir_id:'.$context_dir_id.',after_reload:'.WIN_ID).'::edit_add',
				'newfolder::'.txt('new_folder').'::'.winmodal(txt('new_folder'), 'app', 'app_id:shortcuts@folder','location:'.$context_location.',back:null,dir_id:'.$context_dir_id.',after_reload:'.WIN_ID).'::folder_files'			
		);
		
		
		$cloud = new phpos_clouds;
		if($cloud->is_my_cloud($my_app->get_param('cloud_id')) || is_root())
		{
			$contextMenus['WINDOW'][] = '---';
			$contextMenus['WINDOW'][] = 'edit::'.txt('dsc_cloud_a_edit').'::'.winopen(txt('dsc_cloud_a_edit'), 'cp', 'app_id:clouds@index','section:edit_account,cloud_type:google_drive,cloud_id:'.$my_app->get_param('cloud_id')).'::google_drive';
		}
?>