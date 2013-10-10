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


	$my_app->set_param('url', null);		
	$my_app->using('params');
	
	$url_encoded = $my_app->get_param('url');
	
	winset('width', '520');
	winset('height', '400');
	wincenter();
	
	
	
	if(!empty($url_encoded))
	{
		$url = base64_decode($url_encoded);	
		winset('title', $url);
	}
	
	
?>