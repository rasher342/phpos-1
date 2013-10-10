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


if(DEBUG)
{
	define("PHPOS_IN_DEBUG", true);
	require_once(PHPOS_DIR.'controllers/debuggerController.php'); 
	require_once(PHPOS_DIR.'classes/class.phpos_debugger.php'); 	
}
?>