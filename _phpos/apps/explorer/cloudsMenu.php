<?php
/*
**********************************

	PHPOS Web Operating system
	MIT License
	(c) 2013 Marcin Szczyglinski
	szczyglis83@gmail.com
	GitHUB: https://github.com/phpos/
	File version: 1.3.0, 2013.10.29
 
**********************************
*/
if(!defined('PHPOS'))	die();	


$app_menu = 
	array(				
			
		'title:'.txt('clouds_upmenu_new').',action:actionNewCloud,icon:icon-edit_add',				
		'title:'.txt('clouds_upmenu_manage').',action:actionManageClouds,icon:icon-cloud'									
	);			
		
function actionManageClouds($menu_item)
{				
	$j = winopen(txt('clouds'), 'cp', 'app_id:clouds@index','section:list');
	return 	$j;
}

function actionNewCloud($menu_item)
{				
	$j = winopen(txt('clouds'), 'cp', 'app_id:clouds@index','section:new_account');
	return 	$j;
}
?>