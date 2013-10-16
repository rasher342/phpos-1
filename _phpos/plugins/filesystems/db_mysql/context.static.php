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
				'open::'.txt('open').'::alert("normalopen'.$item.'");::folder_open',
				'---',				
				'rename::'.txt('rename').'::'.winmodal(txt('rename'), 'app', 'app_id:shortcuts@folder','location:'.$context_location.',dir_id:'.$context_dir_id.',edit_id:'.base64_encode($icons[$i]['id']).',old_name:'.base64_encode($icons[$i]['basename']).',after_reload:'.WIN_ID).'::edit'
			
		);			


		$contextMenus['DIR'] = array(		
				'open::Otwórz folder::phpos.windowRefresh("'.$apiWindow->getID().'","dir_id:'.$phposFS->addLastSlash($icons[$i]['id']).'");::open',		
				'---',				
				'rename::'.txt('rename').'::'.winmodal(txt('rename'), 'app', 'app_id:shortcuts@folder','location:'.$context_location.',dir_id:'.$context_dir_id.',edit_id:'.base64_encode($icons[$i]['id']).',old_name:'.base64_encode($icons[$i]['basename']).',after_reload:'.WIN_ID).'::edit'				
				
		);	

		$contextMenus['WINDOW'] = array(		
				'newshortcut::'.txt('new_shortcut').'::'.winmodal(txt('new_shortcut'), 'app', 'app_id:shortcuts@index,width:300,height:350','desktop:1,location:'.$context_location.',dir_id:'.$context_dir_id.',after_reload:'.WIN_ID).'::edit_add',
				'newfolder::'.txt('new_folder').'::'.winmodal(txt('new_folder'), 'app', 'app_id:shortcuts@folder','location:'.$context_location.',back:null,dir_id:'.$context_dir_id.',after_reload:'.WIN_ID).'::folder_files'			
		);
		
	if(APP_ACTION == 'desktop')
	{
		//$contextMenus['WINDOW'][] = '---';
		$contextMenus['WINDOW'][] = 'wallpaper::'.txt('change_desktop_wallpaper').'::'.winopen(txt('account_settings'), 'cp', 'app_id:users@index','section:wallpapers').'::application';	
		//$contextMenus['WINDOW'][] = '---';
		//$contextMenus['WINDOW'][] = '---';
	
			$action = "phpos.desktopSwitch('local_files'); $('#desktop_switch_right').click(); ";
			$contextMenus['WINDOW'][] = 'tolocal::'.txt('context_to_local').'::'.$action.'::application';	
		
	 
	}
?>