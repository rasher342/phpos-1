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

		$clipboard= new phpos_clipboard;
				
	
			$plugged_context_menu[] = '---';
			$plugged_context_menu[] = 'copy::'.txt('copy').'::explorer_copy("'.WIN_ID.'", "'.$icons[$i]['id'].'", "'.$icons[$i]['basename'].'", "'.$my_app->get_param('fs').'");::copy';
			if($my_app->get_param('fs') != 'db_mysql') 
			{
				$plugged_context_menu[] = 'copy_serv::'.txt('copy_server').'::explorer_copy_server("'.WIN_ID.'", "'.$icons[$i]['id'].'", "'.$icons[$i]['basename'].'", "'.$my_app->get_param('fs').'");::copy';
			}
			$plugged_context_menu[] = 'cut::'.txt('cut').'::explorer_cut("'.WIN_ID.'", "'.$icons[$i]['id'].'", "'.$icons[$i]['basename'].'", "'.$my_app->get_param('fs').'");::cut';			
		
		
			if($clipboard->is_clipboard($my_app->get_param('fs')) && $phposFS->is_directory($icons[$i]))				
			{
				if($clipboard->is_my_clipboard($my_app->get_param('fs'))) 
				{							
					$mode = $clipboard->get_mode();
					if($mode == 'copy')
					{
						$plugged_context_menu[] = 'paste::'.txt('paste').'::explorer_paste("'.WIN_ID.'", "'.$icons[$i]['id'].'", null);::paste';
						
					} elseif($mode == 'cut') {
						
						$plugged_context_menu[] = 'paste::'.txt('paste').'::explorer_paste_cut("'.WIN_ID.'", "'.$clipboard->get_source_win().'", "'.$icons[$i]['id'].'", null);::paste';
					}											
				}
			}	
		
?>