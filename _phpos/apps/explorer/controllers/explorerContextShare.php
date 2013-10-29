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
	$icons[$i]['is_shared'] = false;
	// share
	if($context_fs == 'local_files' && $phposFS->is_directory($icons[$i]))
	{						
		$shared = new phpos_shared;					
		
		if(!defined('SHARED'))
		{
			$plugged_context_menu[] = '---';							
			if(!$shared->is_folder_shared($icons[$i]['id']))
			{				
				$plugged_context_menu[] = 'share::'.txt('share_folder').'::'.winmodal(txt('share_folder'), 'app', 'app_id:shortcuts@share,width:300,height:350','desktop:1,location:'.$context_location.',dir_id:'.$context_dir_id.',shared_id:'.base64_encode($icons[$i]['id']).',after_reload:'.WIN_ID).'::ftpfolder';
				
			} else {
			
				$icons[$i]['is_shared'] = true;
				$plugged_context_menu[] = 'share::'.txt('stop_share_folder').'::'.winmodal(txt('share_folder'), 'app', 'app_id:shortcuts@share,width:300,height:350','stop_share:1,desktop:1,location:'.$context_location.',dir_id:'.$context_dir_id.',shared_id:'.base64_encode($icons[$i]['id']).',after_reload:'.WIN_ID).'::cancel';					
			}
		}						
	}
?>