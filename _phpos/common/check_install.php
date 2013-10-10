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


	if(file_exists(PHPOS_DIR.'config/installed.php'))
	{
		include PHPOS_DIR.'config/installed.php';		
	}

	if(empty($phpos_installed_time))
	{
		header("Location: phpos_install.php");
		exit;
	}

	if(!file_exists(PHPOS_DIR.'config/database.php'))
	{
		header("Location: phpos_install.php");
		exit;
	}

	if(!file_exists(PHPOS_DIR.'config/security_key.php'))
	{
		header("Location: phpos_install.php");
		exit;
		
	} else {

		include PHPOS_DIR.'config/security_key.php';
		define('PHPOS_KEY', $phpos_key);		
	}
?>