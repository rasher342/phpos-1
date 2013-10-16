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
	if($icons[$i]['no_delete'] != 1 && (!$readonly || is_root())) 
	{
		$plugged_context_menu[] = '---';
		$plugged_context_menu[] = 'del::'.txt('delete').'::explorer_delete_file("'.WIN_ID.'", "'.$icons[$i]['id'].'", "'.$icons[$i]['basename'].'");::delete';
	}
?>