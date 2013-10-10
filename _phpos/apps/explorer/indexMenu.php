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



$app_menu = 
	array(				
			
				'title:'.txt('new_folder').',action:actionNewFolder,icon:icon-folder_files',
				'title:'.txt('my_server').',action:actionGoServer,icon:icon-myserver',
				'title:'.txt('control_panel').',action:actionGoCP,icon:icon-login'
				
									
	);								
		
	
if(!empty($tmp_shared_id))
{
	$shared = new phpos_shared;
	if($shared->is_my($tmp_shared_id))	$app_menu[] = 'title:'.txt('stop_share_folder').',action:actionStopShare,icon:icon-cancel';
}
	
	if(!$readonly && $context_fs != 'db_mysql')
	{
		$app_menu[] = 'title:'.txt('upload').',action:actionUpload,icon:icon-download';
	}
		
	$app_menu[] = 'title:'.txt('icon_size').',action:actionChangeIcons,icon:icon-application';
	$app_menu[] = array(
						'title:'.txt('icon_size_s').',icon_size:small,check:icon_size,if:'.$my_app->get_param('icon_size').',action:actionChangeIcons',
						'title:'.txt('icon_size_m').',icon_size:medium,check:icon_size,if:'.$my_app->get_param('icon_size').',action:actionChangeIcons'
							);
		
	
if($context_fs == 'ftp')
{
	$check_ftp = new phpos_ftp;
	if(is_root() || ($check_ftp->is_my($my_app->get_param('ftp_id'))))
	{
		$app_menu[] = 'title:'.txt('dsc_ftp_a_edit').',action:actionEditFtp,icon:icon-edit';
	}


}	

function actionEditFtp($menu_item)
{				
	global $my_app;
	
	$j = winopen(txt('dsc_ftp_a_edit'), 'cp', 'app_id:ftp@index','section:edit_account,ftp_id:'.$my_app->get_param('ftp_id'));		
	return 	$j;
}

	
	
		
function actionNewFolder($menu_item)
{				
	global $context_location, $context_dir_id;
	$j = winmodal(txt('new_folder'), 'app', 'app_id:shortcuts@folder','location:'.$context_location.',back:null, dir_id:'.$context_dir_id.',after_reload:'.WIN_ID);
	return 	$j;
}

function actionUpload($menu_item)
{				
	global $context_location, $context_dir_id;
	$j = winmodal(txt('upload'), 'app', 'app_id:shortcuts@upload','app_id:shortcuts@upload,width:300,height:350','desktop:1,location:'.$context_location.',back:null,dir_id:'.$context_dir_id.',after_reload:'.WIN_ID);
	return 	$j;
}

function actionChangeIcons($menu_item)
{		
	$j = helper_reload(array('icon_size' => $menu_item['icon_size']));
	return 	$j;
}

function actionGoServer($menu_item)
{		
	$j = 'phpos.windowActionChange(\''.WIN_ID.'\', \'my_server\')';
	return 	$j;
}

function actionGoCP($menu_item)
{		
	$j = 'phpos.windowActionChange(\''.WIN_ID.'\', \'cp\')';
	return 	$j;
}

function actionStopShare($menu_item)
{		
	global $my_app;
	$j = winmodal(txt('share_folder'), 'app', 'app_id:shortcuts@share,width:300,height:350','stop_share:1,desktop:1,location:'.$context_location.',dir_id:'.$context_dir_id.',shared_id:'.base64_encode($my_app->get_param('dir_id')).',after_reload:'.WIN_ID);
	return 	$j;
}


?>