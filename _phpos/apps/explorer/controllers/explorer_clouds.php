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


if(APP_ACTION == 'clouds')
	{		
		
		$address_icon = ICONS.'server/google_drive.png';
		$clouds = new phpos_clouds;
		$records = $clouds->get_my_clouds();	
		
		$html['right_items_title'] = txt('explorer_right_clouds');
		$html['right_items_desc'] = txt('explorer_right_cloud_desc');
		$html['right_items_img'] = 'google_drive.png';
		
		
		
		if(count($records) != 0)
		{
			$html['icons'].= $layout->area_start(txt('clouds_folders'));
			$html['icons'].= $layout->txtdesc(txt('st_clouds'));
			
			foreach($records as $row)
			{				
				
				$action_open = link_action('index', 'reset_google_token:1,root_id:.,dir_id:.,cloud_id:'.$row['id'].',fs:clouds_google_drive');
				$action_edit = winopen(txt('dsc_cloud_a_edit'), 'cp', 'app_id:clouds@index','section:edit_account,cloud_id:'.$row['id']);		
				
				$action_delete = "
					$.messager.confirm('".txt('delete')."', '".txt('delete_confirm')."?', function(r){
					if (r){
					
						".winopen(txt('dsc_ftp_a_edit'), 'cp', 'app_id:clouds@index','section:list,after_refresh:'.WIN_ID.',action:delete,cloud_id:'.$row['id'].',delete_id:'.$row['id'])."				
					}
					});";		
				
				$contextMenu_ftp = array(				
							'open::'.txt('open').'::'.$action_open.'::folder_open',
							'edit::'.txt('dsc_cloud_a_edit').'::'.$action_edit.'::edit',
							'delete::'.txt('delete').'::'.$action_delete.'::cancel'	
					);				
								
				$apiWindow->setContextMenu($contextMenu_ftp);
				$js.= $apiWindow->contextMenuRender('clouds_list_'.$row['id'].WIN_ID, 'img');	
				$apiWindow->resetContextMenu();	
								
				
				
				$html['icons'].=	'<div id="clouds_list_'.$row['id'].WIN_ID.'" ondblclick="'.$action_open.'" class="phpos_server_icon" title="<b>'.$row['title'].'</b> '.$row['type'].'"><img src="'.ICONS.'server/google_drive.png" /><p><b>'.string_cut($row['title'],30).'</b><br />'.string_cut($row['description'], 30).'<br /><span class="desc">'.string_cut($row['host'], 30).'</span></p></div>';
			
			}
			$html['icons'].= $layout->area_end();
			
		} else {	
				
			$html['icons'].= $layout->area_start(txt('cloud_folders')).txt('cloud_no_accounts').$layout->txtdesc(txt('st_cloud')).$layout->area_end();						
		}
	}


?>