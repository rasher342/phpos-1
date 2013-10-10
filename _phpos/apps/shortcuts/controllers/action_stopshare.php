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


$shared_id = $my_app->get_param('shared_id');

if($stop_share == 1)
{	
		$shared = new phpos_shared;
		
		if(globalconfig('demo_mode') != 1 || is_root())
		{		
			$shared->unshare_folder($shared_id);	
		}
		
		msg::ok(txt('msg_stop_shared'));	
		
		$my_app->jquery_onready(winclose(WIN_ID)."  $('#".$my_app->get_param('after_reload')."').panel('refresh'); ");		
		
}
?>