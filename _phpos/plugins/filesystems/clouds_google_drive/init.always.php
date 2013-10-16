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
	
	// Reset Google Token
	
	if($_SESSION['google_refresh'])
	{
		unset($_SESSION['google_refresh']);		
	}
	
	
	if(param('reset_google_token') == 1)
	{
		if(isset($_SESSION['token']) && isset($_SESSION['google_token'])) 
		{
			unset($_SESSION['google_token']);			
		}
	}
	
	if(param('fs') != 'clouds_google_drive')
	{
		param('cloud_id', null);
		cache_param('cloud_id');	
		
	} else {

		cache_param('cloud_id');	
	} 
?>