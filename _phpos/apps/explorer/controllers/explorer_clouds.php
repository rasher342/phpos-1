<?php
/*
**********************************

	PHPOS Web Operating system
	MIT License
	(c) 2013 Marcin Szczyglinski
	szczyglis83@gmail.com
	GitHUB: https://github.com/phpos/
	File version: 1.3.0, 2013.10.29
 
**********************************
*/
if(!defined('PHPOS'))	die();	


if(APP_ACTION == 'clouds')
{	
		
		$address_icon = ICONS.'server/cloud.png';
		$clouds = new phpos_clouds;
		$records = $clouds->get_my_clouds();	
		
		$html['right_items_title'] = txt('cloud_folders');
		$html['right_items_desc'] = txt('clouds_right_desc2');
		$html['right_items_img'] = 'cloud.png';
		
		$title = '
		<img src="'.ICONS.'server/cloud.png" style="width:30px; display:inline-block; vertical-align:middle" /> 
		<a title="'.$txt['cloud_folders'].'" href="javascript:void(0);" onclick="'.link_action('clouds', 'ftp_id:0,tmp_shared_id:0,shared_id:0,cloud_id:0,in_shared:0,workgroup_id:0,fs:local_files').'">
		'.txt('cloud_folders').'
		</a>
		<img src="'.THEME_URL.'icons/arrow_small_right.png" style="width:15px; display:inline-block; vertical-align:middle; padding-left:10px;padding-right:10px"/>'; 		
				
		if(count($records) != 0)
		{
			$html['icons'].= $layout->subtitle($title);	
			$html['icons'].= $layout->txtdesc(txt('clouds_right_desc'));
			
			foreach($records as $row)
			{				
				
			// --- context menu ---
				$action_open = link_action('index', 'shared_id:0,tmp_shared_id:0,ftp_id:0,workgroup_id:0,dir_id:.,cloud_id:'.$row['id'].',reset_google_token:1,root_id:root,fs:clouds_'.$row['cloud']);
				$action_edit = winopen(txt('dsc_cloud_a_edit'), 'cp', 'app_id:clouds@index','cloud_type:'.$row['cloud'].',section:edit_account,cloud_id:'.$row['id']);					
				$action_delete = "
					$.messager.confirm('".txt('delete')."', '".txt('delete_confirm')."?', function(r){
					if (r){				
						".winopen(txt('dsc_cloud_a_edit'), 'cp', 'app_id:clouds@index','section:list,after_refresh:'.WIN_ID.',action:delete,cloud_id:'.$row['id'].',delete_id:'.$row['id'])."				
					}
					});";		
				
				$contextMenu_cloud = array(				
					'open::'.txt('connect_to').'::'.$action_open.'::reload'						
				);	
				
				if($clouds->is_my_cloud($row['id']) || is_root())
				{
					$contextMenu_cloud[] = 'edit::'.txt('dsc_cloud_a_edit').'::'.$action_edit.'::edit';
					$contextMenu_cloud[] = 'delete::'.txt('delete').'::'.$action_delete.'::cancel';
				}
				
				$apiWindow->setContextMenu($contextMenu_cloud);
				$js = $apiWindow->contextMenuRender('clouds_list_'.$row['id'].WIN_ID, 'img');	
				jquery_function($js);
				unset($js);
				$apiWindow->resetContextMenu();	
			// --- context menu ---	
			
			
				$html['icons'].='
				<div id="clouds_list_'.$row['id'].WIN_ID.'" ondblclick="'.$action_open.'" class="phpos_server_icon" title="'.$row['title'].' '.$row['description'].'">
				<img src="'.PHPOS_URL.'plugins/filesystems/clouds_'.$row['cloud'].'/resources/fs.icon_big.png" />
				<p><b>'.string_cut($row['title'],30).'</b>
				<br />'.string_cut($row['description'], 30).'
				<br /><span class="desc">'.$row['cloud'].'</span></p>
				</div>';			
			}
		
			
		} else {	
				
			$html['icons'].= $layout->area_start(txt('cloud_folders')).txt('cloud_no_accounts').$layout->txtdesc(txt('st_cloud')).$layout->area_end();						
		}
		
	// --- window context menu ---		
		$contextWindow = array(		
				'newcloud::'.txt('clouds_upmenu_new').'::'.winopen(txt('clouds'), 'cp', 'app_id:clouds@index','section:list').'::edit_add',
				'manageclouds::'.txt('clouds_upmenu_manage').'::'.winopen(txt('clouds'), 'cp', 'app_id:clouds@index','section:new_account').'::cloud'			
		);
		
		$apiWindow->setContextMenu($contextWindow);
		$js= $apiWindow->contextMenuRender('phpos_explorer_div'.div(1), 'td');	
		jquery_function($js);
		unset($js);
		$apiWindow->resetContextMenu();	
	// --- window context menu ---	
}
?>