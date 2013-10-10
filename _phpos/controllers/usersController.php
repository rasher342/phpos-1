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

	
	$usr = new phpos_users;
	if(!$usr->user_is_logged())
	{
		header("Location: ".PHPOS_WEBROOT."phpos_login.php");
		exit;
	}
?>