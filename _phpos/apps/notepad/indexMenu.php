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


global $readonly, $my_app, $context_fs, $tmp_shared_id;
	
$actions = array();
$app_menu[] = 'title:'.txt('app_notepad_new').',action:actionNew,icon:icon-file';
$app_menu[] = 'title:'.txt('open').',action:actionOpen,icon:icon-folder_files';

if($my_app->get_param('file_info') !== null) $app_menu[] = 'title:'.txt('save').',action:actionSave,icon:icon-filesave';	
$app_menu[] = 'title:'.txt('save_as').',action:actionSaveAs,icon:icon-filesave';	


function actionOpen($menu_item)
{		
	global $my_app;
	$explorerAPI = new phpos_explorerAPI;
	$explorerAPI->set_allowed_extensions($my_app->get_param('allowed_extensions'));
	$j = $explorerAPI->openfile_dialog();
	return 	$j;
}

function actionSaveAs($menu_item)
{	
	$j = "
	//alert('savingas');
	$('#notepadform input[name=action]').val('save_as');
	$('#notepadform').submit(); 
	";
	return 	$j;
}

function actionSave($menu_item)
{	
	$j = "
	$('#notepadform input[name=action]').val('save');
	$('#notepadform').submit(); 
	";
	return 	$j;
}

function actionNew($menu_item)
{		
	$j = helper_reload(array('action' => 'new_file'));
	return 	$j;
}
?>