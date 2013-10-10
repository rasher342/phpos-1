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
	$my_app->using('params');
	
	$url_encoded = $my_app->get_param('url');
	
	if(!empty($url_encoded))
	{
		$url = base64_decode($url_encoded);
		$jquery = "
	
		var a = document.createElement('a');
		a.href='".$url."';
		a.target = '_new';
		document.body.appendChild(a);
		a.click();		
		
		//var url = '".$url."';
		//var w = window.open(url, '_new','location=1,menubar=1,status=1');
		".winclose(WIN_ID)."
		";
		
		$my_app->jquery_onready($jquery);
	}
	
	
?>