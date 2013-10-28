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

	// FILE:
	
	$contextMenus['FILE'] = array(				
				'open::'.txt('open').'::explorer_open_in_browser("'.$icons[$i]['id'].'");::folder_open',
				'---',		
				'open_with::'.txt('open_with').'::alert();::folder_open',
					array('openwith1::'.txt('in_web_browser').'::explorer_open_in_browser("'.$icons[$i]['id'].'");::browser'
					));
					
	if(!$readonly || is_root())
	{
		$contextMenus['FILE'][] = '---';
		$contextMenus['FILE'][]	=
			'rename::'.txt('rename').'::'.winmodal(txt('rename'), 'app', 'app_id:shortcuts@folder','location:'.$context_location.',dir_id:'.$context_dir_id.',edit_id:'.base64_encode($icons[$i]['id']).',old_name:'.base64_encode($icons[$i]['basename']).',after_reload:'.WIN_ID).'::edit';
	}
				
	$contextMenus['FILE'][] = '---';	
			
	$contextMenus['FILE'][]	=	
				'download::'.txt('download_to_disk').'::'.browser_url(PHPOS_WEBROOT_URL.'phpos_downloader.php?hash='.md5(PHPOS_KEY).'&download_type='.base64_encode('local_file').'&file='.base64_encode(str_replace(PHPOS_WEBROOT_DIR, '', $icons[$i]['id']))).'::download';
				
	
					
			
	// DIR:

	$contextMenus['DIR'] = array(		
				'open::'.txt('open').'::alert("normalopen'.$item.'");::folder_open'			
				);
			
	if(!$readonly || is_root())
	{
		$contextMenus['DIR'][] = '---';
		$contextMenus['DIR'][] =		
		'rename::'.txt('rename').'::'.winmodal(txt('rename'), 'app', 'app_id:shortcuts@folder','location:'.$context_location.',dir_id:'.$context_dir_id.',edit_id:'.base64_encode($icons[$i]['id']).',old_name:'.base64_encode($icons[$i]['basename']).',after_reload:'.WIN_ID).'::edit';
	}
	
	$contextMenus['DIR'][] = '---';	
			
	$contextMenus['DIR'][]	=	
				'shortcuts::'.txt('link_on_desktop').'::explorer_link_to_folder("'.base64_encode($icons[$i]['id']).'", "'.base64_encode($icons[$i]['basename']).'");::edit_add';
				
		
	// WINDOW:

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
	
	
						
		$contextMenus['WINDOW'][]	=	
				'shortcuts::'.txt('link_on_desktop').'::explorer_link_to_folder("'.base64_encode($context_dir_id).'", "'.base64_encode(basename($context_dir_id)).'");::edit_add';
	
	
	if(APP_ACTION == 'desktop')
	{
		//$contextMenus['WINDOW'][] = '---';
		$contextMenus['WINDOW'][] = 'wallpaper::'.txt('change_desktop_wallpaper').'::'.winopen(txt('account_settings'), 'cp', 'app_id:users@index','section:wallpapers').'::application';	
		//$contextMenus['WINDOW'][] = '---';
		//$contextMenus['WINDOW'][] = '---';		
		
			$action = "phpos.desktopSwitch('database'); $('#desktop_switch_left').click(); ";			
			$contextMenus['WINDOW'][] = 'todb::'.txt('context_to_db').'::'.$action.'::application';	 
	}	
?>