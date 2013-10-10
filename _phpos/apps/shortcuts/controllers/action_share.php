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


if(form_submit('share_folder'))
{	
	$shared = new phpos_shared;
	
	if(globalconfig('demo_mode') != 1 || is_root())
	{
		$shared->share_folder($_POST['new_folder_name'], $_POST['new_folder_desc'], 'local_files', $shared_id, $_POST['new_folder_readonly']);	
	}
		
	msg::ok(txt('shared'));
	
}
?>