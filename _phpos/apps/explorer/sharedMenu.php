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


global $my_app;
$workgroup_id = $my_app->get_param('workgroup_id');


$app_menu = 
	array(	
			
							
				'title:'.txt('group_back_to').',action:actionBackToGroup,icon:icon-back'
									
	);								

		
function actionBackToGroup($menu_item)
{				
	global $my_app;
	$j = link_action('workgroup', 'workgroup_id:'.$my_app->get_param('workgroup_id'));	
	return 	$j;
}		

function actionEditGroupUsers($menu_item)
{				
	global $my_app;
	
	$j = winopen(txt('group_section_edit_group'), 'cp', 'app_id:groups@groups_admin','section:group_users,group_id:'.$my_app->get_param('workgroup_id'));		
	return 	$j;
}	
		
function actionManageGroups($menu_item)
{				
	$j = winopen(txt('group_section_list'), 'cp', 'app_id:groups@groups_admin','section:list');
	return 	$j;
}

function actionNewGroup($menu_item)
{				
	$j = winopen(txt('group_section_new_group'), 'cp', 'app_id:groups@groups_admin','section:new_group');
	return 	$j;
}
?>