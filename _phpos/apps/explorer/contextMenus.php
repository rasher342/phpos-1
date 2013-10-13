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


if(!defined("PHPOS_IN_EXPLORER"))
{
	die();
}


switch($context_fs)
{
	case 'db_mysql':	
		$contextMenus['FILE'] = array(				
				'open::'.txt('open').'::alert("normalopen'.$item.'");::folder_open',
				'---',				
				'rename::'.txt('rename').'::'.winmodal(txt('rename'), 'app', 'app_id:shortcuts@folder','location:'.$context_location.',dir_id:'.$context_dir_id.',edit_id:'.base64_encode($icons[$i]['id']).',old_name:'.base64_encode($icons[$i]['basename']).',after_reload:'.WIN_ID).'::edit'
			
		);			


		$contextMenus['DIR'] = array(		
				'open::Otwórz folder::phpos.windowRefresh("'.$apiWindow->getID().'","dir_id:'.$phposFS->addLastSlash($icons[$i]['id']).'");::open',			
				'rename::'.txt('rename').'::'.winmodal(txt('rename'), 'app', 'app_id:shortcuts@folder','location:'.$context_location.',dir_id:'.$context_dir_id.',edit_id:'.base64_encode($icons[$i]['id']).',old_name:'.base64_encode($icons[$i]['basename']).',after_reload:'.WIN_ID).'::edit'				
				
		);	

		$contextMenus['WINDOW'] = array(		
				'newshortcut::'.txt('new_shortcut').'::'.winmodal(txt('new_shortcut'), 'app', 'app_id:shortcuts@index,width:300,height:350','desktop:1,location:'.$context_location.',dir_id:'.$context_dir_id.',after_reload:'.WIN_ID).'::edit_add',
				'newfolder::'.txt('new_folder').'::'.winmodal(txt('new_folder'), 'app', 'app_id:shortcuts@folder','location:'.$context_location.',back:null,dir_id:'.$context_dir_id.',after_reload:'.WIN_ID).'::folder_files'			
		);
	

	break;
	
	case 'clouds_google_drive':	
		$contextMenus['FILE'] = array(				
				'open::'.txt('open').'::alert("normalopen'.$item.'");::folder_open',
				'---',				
				'rename::'.txt('rename').'::'.winmodal(txt('rename'), 'app', 'app_id:shortcuts@folder','location:'.$context_location.',dir_id:'.$context_dir_id.',edit_id:'.base64_encode($icons[$i]['id']).',old_name:'.base64_encode($icons[$i]['basename']).',after_reload:'.WIN_ID).'::edit'
			
		);			


		$contextMenus['DIR'] = array(		
				'open::Otwórz folder::phpos.windowRefresh("'.$apiWindow->getID().'","dir_id:'.$phposFS->addLastSlash($icons[$i]['id']).'");::open',			
				'rename::'.txt('rename').'::'.winmodal(txt('rename'), 'app', 'app_id:shortcuts@folder','location:'.$context_location.',dir_id:'.$context_dir_id.',edit_id:'.base64_encode($icons[$i]['id']).',old_name:'.base64_encode($icons[$i]['basename']).',after_reload:'.WIN_ID).'::edit'				
				
		);	

		$contextMenus['WINDOW'] = array(		
				'newshortcut::'.txt('new_shortcut').'::'.winmodal(txt('new_shortcut'), 'app', 'app_id:shortcuts@index,width:300,height:350','desktop:1,location:'.$context_location.',dir_id:'.$context_dir_id.',after_reload:'.WIN_ID).'::edit_add',
				'newfolder::'.txt('new_folder').'::'.winmodal(txt('new_folder'), 'app', 'app_id:shortcuts@folder','location:'.$context_location.',back:null,dir_id:'.$context_dir_id.',after_reload:'.WIN_ID).'::folder_files'			
		);
	

	break;
	
	
	
	
	case 'local_files':
			$contextMenus['FILE'] = array(				
				'open::'.txt('open').'::explorer_open_in_browser("'.$icons[$i]['id'].'");::folder_open',
				'---',		
				'open_with::'.txt('open_with').'::alert();::icon',
					array('openwith1::'.txt('in_web_browser').'::explorer_open_in_browser("'.$icons[$i]['id'].'");'
					));
					
			if(!$readonly || is_root())
			{
				$contextMenus['FILE'][] = '---';
				$contextMenus['FILE'][]	=
					'rename::'.txt('rename').'::'.winmodal(txt('rename'), 'app', 'app_id:shortcuts@folder','location:'.$context_location.',dir_id:'.$context_dir_id.',edit_id:'.base64_encode($icons[$i]['id']).',old_name:'.base64_encode($icons[$i]['basename']).',after_reload:'.WIN_ID).'::edit';
			}
				
			$contextMenus['FILE'][] = '---';	
			
			$contextMenus['FILE'][]	=	
				'download::'.txt('download').'::'.browser_url(PHPOS_WEBROOT_URL.'phpos_downloader.php?hash='.md5(PHPOS_KEY).'&download_type='.base64_encode('local_file').'&file='.base64_encode(str_replace(PHPOS_WEBROOT_DIR, '', $icons[$i]['id']))).'::download';
					
				
			
				


		$contextMenus['DIR'] = array(		
				'open::'.txt('open').'::alert("normalopen'.$item.'");::folder_open',
				'open_with::'.txt('open_with').'::alert();::icon',
					array('openwith1::'.txt('in_new_win').'::explorer_open_in_browser("'.$icons[$i]['id'].'");')	
				);
				
		if(!$readonly || is_root())
		{
				$contextMenus['DIR'][] = '---';
				$contextMenus['DIR'][] =		
				'rename::'.txt('rename').'::'.winmodal(txt('rename'), 'app', 'app_id:shortcuts@folder','location:'.$context_location.',dir_id:'.$context_dir_id.',edit_id:'.base64_encode($icons[$i]['id']).',old_name:'.base64_encode($icons[$i]['basename']).',after_reload:'.WIN_ID).'::edit';
		}
				
		

		if(!$readonly || is_root())
		{
			$contextMenus['WINDOW'][] = 					
					'newfolder::'.txt('new_folder').'::'.winmodal(txt('new_folder'), 'app', 'app_id:shortcuts@folder','location:'.$context_location.',back:null, dir_id:'.$context_dir_id.',after_reload:'.WIN_ID).'::folder_files';
					
			if(globalconfig('disable_upload') != 1 || is_root())
			{
				$contextMenus['WINDOW'][] = 			
					'upload::'.txt('upload_here').'::'.winmodal('Nowa ikona', 'app', 'app_id:shortcuts@upload,width:300,height:350','desktop:1,location:'.$context_location.',back:null,dir_id:'.$context_dir_id.',after_reload:'.WIN_ID).'::disk';
			}
			
			
		} else {
		
			$contextMenus['WINDOW'] = array(	
			'read::This folder is readonly::;::login'
			
			);
		}
	
	break;
	
	
	
	
	
	
	case 'ftp':
			$contextMenus['FILE'] = array(				
			
				'open::'.txt('open').'::explorer_ftp_view("'.$icons[$i]['id'].'", "'.$icons[$i]['basename'].'", "'.$my_app->get_param('fs').'");::folder_open',
				'---',
				'download::'.txt('download').'::explorer_ftp_download("'.$icons[$i]['id'].'", "'.$icons[$i]['basename'].'", "'.$my_app->get_param('fs').'");::download',	
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
	
	
	break;
}


	if(APP_ACTION == 'desktop')
	{
		//$contextMenus['WINDOW'][] = '---';
		$contextMenus['WINDOW'][] = 'wallpaper::'.txt('change_desktop_wallpaper').'::'.winopen(txt('account_settings'), 'cp', 'app_id:users@index','section:wallpapers').'::application';	
		//$contextMenus['WINDOW'][] = '---';
		//$contextMenus['WINDOW'][] = '---';
		
		if($context_fs == 'local_files')
		{	
			$action = "phpos.desktopSwitch('database'); $('#desktop_switch_left').click(); ";			
			$contextMenus['WINDOW'][] = 'todb::'.txt('context_to_db').'::'.$action.'::application';	
			
		} else {
		
			$action = "phpos.desktopSwitch('local_files'); $('#desktop_switch_right').click(); ";
			$contextMenus['WINDOW'][] = 'tolocal::'.txt('context_to_local').'::'.$action.'::application';	
		}
	 
	}
?>