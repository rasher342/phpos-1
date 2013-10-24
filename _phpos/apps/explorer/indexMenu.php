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


// View change

$item_view['icons'] = 'Icons';
$item_view['list'] = 'List';
$item_view['thumbs'] = 'Thumbnails';

switch($my_app->get_param('view_type'))
{
	case 'icons':
		$item_view['icons'] = '<b>Icons</b>';
	break;
	
	case 'list':
		$item_view['list'] = '<b>List</b>';
	break;
	
	case 'thumbs':
		$item_view['thumbs'] = '<b>Thumbnails</b>';
	break;
}



$app_menu = 
	array(				
			
				'title:<b>'.txt('new_folder').'</b>,action:actionNewFolder,icon:icon-folder_files',
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
	
	$app_menu[] = 'title:'.$item_view['icons'].',view_type:icons,check:view_type,if:'.$my_app->get_param('view_type').',action:actionChangeView,icon:icon-application';
	
	if($my_app->get_param('view_type') == 'icons')
	{			
		$app_menu[] = 'title:'.txt('icon_size').',action:actionChangeIcons,icon:icon-application';
		$app_menu[] = array(
							'title:'.txt('icon_size_s').',icon_size:small,check:icon_size,if:'.$my_app->get_param('icon_size').',action:actionChangeIcons',
							'title:'.txt('icon_size_m').',icon_size:medium,check:icon_size,if:'.$my_app->get_param('icon_size').',action:actionChangeIcons'
								);
	}	

	
	$app_menu[] = 'title:'.$item_view['list'].',view_type:list,check:view_type,if:'.$my_app->get_param('view_type').',action:actionChangeView,icon:icon-application';
	
	$app_menu[] = 'title:'.$item_view['thumbs'].',view_type:thumbs,check:view_type,if:'.$my_app->get_param('view_type').',action:actionChangeView,icon:icon-application';	
	
	$app_menu[] = 'title:Sort by,action:actionChangeIcons,icon:icon-application';
		$app_menu[] = array(
							'title:Type,sort_by:extension,check:sort_by,if:'.$my_app->get_param('sort_by').',action:actionChangeSort',
							'title:Name,sort_by:filename,check:sort_by,if:'.$my_app->get_param('sort_by').',action:actionChangeSort',
							'title:Date,sort_by:modified_at,check:sort_by,if:'.$my_app->get_param('sort_by').',action:actionChangeSort',
							'title:Size,sort_by:size,check:sort_by,if:'.$my_app->get_param('sort_by').',action:actionChangeSort',
							'title:<b>Ascending</b>,sort_order:asc,check:sort_order,if:'.$my_app->get_param('sort_order').',action:actionChangeSortOrder',
							'title:<b>Descending</b>,sort_order:desc,check:sort_order,if:'.$my_app->get_param('sort_order').',action:actionChangeSortOrder'
								);
								
	$app_menu[] = 'title:File Extensions,action:actionChangeIcons,icon:icon-application';
		$app_menu[] = array(
							'title:Show,show_extensions:1,check:show_extensions,if:'.$my_app->get_param('show_extensions').',action:actionChangeExt',
							'title:Hide,show_extensions:0,check:show_extensions,if:'.$my_app->get_param('show_extensions').',action:actionChangeExt'
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

function actionChangeSort($menu_item)
{		
	$j = helper_reload(array('sort_by' => $menu_item['sort_by']));
	return 	$j;
}

function actionChangeExt($menu_item)
{		
	$j = helper_reload(array('show_extensions' => $menu_item['show_extensions']));
	return 	$j;
}

function actionChangeSortOrder($menu_item)
{		
	$j = helper_reload(array('sort_order' => $menu_item['sort_order']));
	return 	$j;
}

function actionChangeView($menu_item)
{		
	$j = helper_reload(array('view_type' => $menu_item['view_type']));
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