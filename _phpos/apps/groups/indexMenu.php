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
			
				'title:'.txt('plugins').',action:actionNewFolder,icon:icon-application',
				array(
						 'title:Lightbox,action:actionNewFolder'											 
				),
				'title:'.txt('new_folder').',action:actionNewFolder,icon:icon-folder_files'
									
	);								
		

		
		
		
function actionNewFolder($menu_item)
{				
	$j = 'newfolder();';
	return 	$j;
}
?>