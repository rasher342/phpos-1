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

if(APP_ACTION == 'desktop') 
{			
	$dir_hash = $my_user->get_home_dir_hash();
	$home_dir = PHPOS_HOME_DIR.$dir_hash.'/_Desktop';
	
	if(is_dir($home_dir)) 
	{
		$my_app->set_param('root_id', $home_dir);
		//$this->root_directory_id = $home_dir;		
	}					
}
?>