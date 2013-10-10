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


if(PHPOS_HAVE_ACCESS != $my_app->get_app_id() or !defined('PHPOS'))
{
	die();
}


	$my_app->set_param('url', null);	
	$my_app->set_param('first_time', 1);	
	
	$my_app->using('params');
	
	cache_param('url');	
	
	
	$tmp_url = $my_app->get_param('url');
	if(!empty($tmp_url)) $url = base64_decode($tmp_url);
	
	
	

?>