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


if($my_app->get_param('to_menustart') == 1)
{
		$shortcut = new phpos_shortcuts;	
		
		$link_id = $my_app->get_param('link_id');
		
		if(globalconfig('demo_mode') != 1 || is_root())
		{
			if($shortcut->new_menustart($link_id)) msg::ok(txt('msg_added_to_menustart'));	
		}
		$my_app->jquery_onready(winclose(WIN_ID)); 
}
?>