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


global $readonly, $my_app, $context_fs, $tmp_shared_id;



$app_menu = 
	array(				
			
				
				'title:'.txt('my_server').',action:actionGoServer,icon:icon-myserver',
			
				
									
	);								
		
	

function actionGoServer($menu_item)
{		
	$j = 'phpos.windowActionChange(\''.WIN_ID.'\', \'my_server\')';
	return 	$j;
}



?>