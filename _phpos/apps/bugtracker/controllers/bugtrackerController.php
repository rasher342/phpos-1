<?php
/*
**********************************

	PHPOS Web Operating system
	MIT License
	(c) 2013 Marcin Szczyglinski
	szczyglis83@gmail.com
	GitHUB: https://github.com/phpos/
	File version: 1.0.0, 2013.10.11
 
**********************************
*/
if(!defined('PHPOS'))	die();	

if(PHPOS_HAVE_ACCESS != $my_app->get_app_id() or !defined('PHPOS'))
{
	die();
}	
	
	$js = " $('textarea#editor').ckeditor();";
	$my_app->jquery_onready($js);	
	$my_app->jquery_onready(msg::showMessages());	

?>