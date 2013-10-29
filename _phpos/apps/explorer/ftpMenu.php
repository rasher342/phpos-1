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


$app_menu = 
	array(				
			
				'title:'.txt('ftp_upmenu_new').',action:actionNewFTP,icon:icon-edit_add',				
				'title:'.txt('ftp_upmenu_manage').',action:actionManageFTP,icon:icon-ftpfolders'
									
	);								
		

		
		
		
function actionManageFTP($menu_item)
{				
	$j = winopen(txt('ftp'), 'cp', 'app_id:ftp@index','section:list');
	return 	$j;
}

function actionNewFTP($menu_item)
{				
	$j = winopen(txt('ftp'), 'cp', 'app_id:ftp@index','section:new_account');
	return 	$j;
}
?>