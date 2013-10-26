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


if(APP_ACTION == 'index')
	{
		switch($my_app->get_param('fs'))
		{
			case 'local_files':
				$html['right_items_title'] = txt('explorer_right_local');
				if(!$readonly || is_root()) 
				{
					$html['right_items_desc'] = txt('explorer_right_local_desc_drag_active');
					
				} else {
				
					$html['right_items_desc'] = '<span style="color:#7f1f1d">'.txt('readonly_right_msg').'</span>';					
				}				
				$html['right_items_img'] = 'hdd.png';
			break;
			
			case 'db_mysql':
				$html['right_items_title'] = txt('explorer_right_db');
				$html['right_items_desc'] = txt('explorer_right_db_desc');
				$html['right_items_img'] = 'db.png';
			break;
			
			case 'ftp':
				$html['right_items_title'] = txt('explorer_right_ftp');
				$html['right_items_desc'] = $ftp_connect_status.txt('explorer_right_local_desc_drag_active');
				$html['right_items_img'] = 'ftp.png';
			break;	
			
			case 'clouds_google_drive':
				$html['right_items_title'] = txt('fs_clouds_right');
				$html['right_items_desc'] =  $cloud_connect_status.'<br />'.txt('googledrive_right_info_nologged');
				$html['right_items_img'] = 'google_drive.png';
			break;
		}	
	}
				
/*.............................................. */		
	
 	$html['right_items_empty'] = 'Empty list';
	$html['right_items'] = '<img src="'.ICONS.'server/'.$html['right_items_img'].'" style="width:192px;height:192px"/><br />'. $layout->subtitle(txt($html['right_items_title'])); 
					
/*.............................................. */		
	
	if(!empty($html['right_items_desc'])) $html['right_items'].= $layout->txtdesc($html['right_items_desc']);  
	
	$html['right_items_title'] = null;
	$html['right_items_img'] = null;
	$html['right_icon'] = null;
					
/*.............................................. */		
	
	if(is_array($explorer_right_items))
	{
		$c = count($explorer_right_items);
		
		if($c != 0)
		{
			foreach($explorer_right_items as $items)
			{
				$item_name = $items['name'];
				$item_onclick = $items['onclick'];
				$item_icon = $items['icon'];
				$item_marked = $items['marked'];
				
				$span = '';
				if($item_marked) $span = 'font-weight:bold';
				
				$html['right_items'].= '<img src="'.ICONS.'server_right_icons/'.$item_icon.'" style="width:20px; display:inline-block; vertical-align:middle" /> <span style="'.$span.'"><a href="javascript:void(0);" onclick="'.$item_onclick.'">'.$item_name.'</a></span><br />';			
			}
					
/*.............................................. */		
			
		}	else {
			
			$html['right_items'].= $html['right_items_empty'];
		}
	}

?>