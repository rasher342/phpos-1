<?php
/*
**********************************

	PHPOS Web Operating system
	MIT License
	(c) 2013 Marcin Szczyglinski
	szczyglis83@gmail.com
	GitHUB: https://github.com/phpos/
	File version: 1.0.0, 2013.10.10
 
**********************************
*/
if(!defined('PHPOS'))	die();	


	$app_id = 'groups';
	
	$plugin = 'app';
	$access_level = 2;
	$cp_access_level = 2;
	$hidden = 1;
	$default_action = 'index';	
	$default_section = 'list';
	$multiple_windows = true;
	
	
	$version = '1.0.0 beta';
	$build = '2013.10.10';
	$author = 'Marcin Szczyglinski';
	$website = 'http://www.phpos.pl';
	$github = 'https://github.com/phpos/phpos/';
	$email = 'szczyglis83@gmail.com';
	
	$title = txt('groups_title');
	$desc = txt('groups_desc');
	$icon = 'workgroups.png';
	
	$install_sql = false;
	$db_schema = 'sql/database.sql';
	$installer = 'install.php';
	
	$control_panels = array(	
		array('groups_admin', txt('groups_cp_admin'), ICONS.'workgroups.png', txt('groups_cp_admin_desc'), 2)			
	);
	
	$section['group_users'] = array(		
		'access_level' => 2
	);	
	
	$section['new_group'] = array(		
		'access_level' => 2
	);	
	
	$section['edit_group'] = array(		
		'access_level' => 2
	);
	
	$section['list'] = array(		
		'access_level' => 2
	);
	
	
	$actions['groups_admin'] = array(		
		'access_level' => 2
	);	

?>