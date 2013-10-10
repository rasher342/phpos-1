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
			
				
				'title:'.txt('control_panel').',action:actionGoCP,icon:icon-login'
				
									
	);								
		
	if(is_root() || is_admin())
	{
		$app_menu[] = 'title:'.txt('sys_info').',action:actionGoInfo,icon:icon-myserver';
	}


function actionGoCP($menu_item)
{		
	$j = 'phpos.windowActionChange(\''.WIN_ID.'\', \'cp\')';
	return 	$j;
}
function actionGoInfo($menu_item)
{		
	$j = winopen(txt('sys_info'), 'cp', 'app_id:system_info@index');
	return 	$j;
}
?>