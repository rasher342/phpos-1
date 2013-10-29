<?php
/*
**********************************

	PHPOS Web Operating system
	MIT License
	(c) 2013 Marcin Szczyglinski
	szczyglis83@gmail.com
	GitHUB: https://github.com/phpos/
	File version: 1.2.6, 2013.10.16
 
**********************************
*/
if(!defined('PHPOS'))	die();	

if(!defined("PHPOS_IN_EXPLORER"))
{
	die();
}

			$contextMenus['FILE'] = array(				
			
				'open::'.txt('open').'::explorer_ftp_view("'.$icons[$i]['id'].'", "'.$icons[$i]['basename'].'", "'.$my_app->get_param('fs').'");::folder_open',
				'---',
				'download::'.txt('download_to_disk').'::explorer_ftp_download("'.$icons[$i]['id'].'", "'.$icons[$i]['basename'].'", "'.$my_app->get_param('fs').'");::download',	
				'---',
				'rename::'.txt('rename').'::'.winmodal(txt('rename'), 'app', 'app_id:shortcuts@folder','location:'.$context_location.',dir_id:'.$context_dir_id.',action_id:null,edit_id:'.base64_encode($icons[$i]['id']).',old_name:'.base64_encode($icons[$i]['basename']).',after_reload:'.WIN_ID).'::edit'			
		);			


		$contextMenus['DIR'] = array(		
				'open::'.txt('open').'::alert("normalopen'.$item.'");::folder_open',				
				'---',		
				'rename::'.txt('rename').'::'.winmodal(txt('rename'), 'app', 'app_id:shortcuts@folder','location:'.$context_location.',dir_id:'.$context_dir_id.',action_id:null,edit_id:'.base64_encode($icons[$i]['id']).',old_name:'.base64_encode($icons[$i]['basename']).',after_reload:'.WIN_ID).'::edit'
				
		);	

		$contextMenus['WINDOW'] = array(		
				
				'newfolder::'.txt('new_folder').'::'.winmodal(txt('new_folder'), 'app', 'app_id:shortcuts@folder','location:'.$context_location.',back:null, dir_id:'.$context_dir_id.',after_reload:'.WIN_ID).'::folder_files',
				'upload::'.txt('upload_here').'::'.winmodal('Nowa ikona', 'app', 'app_id:shortcuts@upload,width:300,height:350','desktop:1,location:'.$context_location.',back:null,dir_id:'.$context_dir_id.',after_reload:'.WIN_ID).'::disk'				
		);	
		
		
		$ftp = new phpos_ftp;
		if($ftp->is_my_ftp($my_app->get_param('ftp_id')) || is_root())
		{
			$contextMenus['WINDOW'][] = '---';
			$contextMenus['WINDOW'][] = 'edit::'.txt('dsc_ftp_a_edit').'::'.winopen(txt('dsc_ftp_a_edit'), 'cp', 'app_id:ftp@index','section:edit_account,ftp_id:'.$my_app->get_param('ftp_id')).'::ftpfolders';
		}
?>