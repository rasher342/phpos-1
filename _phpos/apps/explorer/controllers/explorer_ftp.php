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


if(APP_ACTION == 'ftp')
{			
	$address_icon = ICONS.'server/ftp.png';
	$ftp = new phpos_ftp;
	$records = $ftp->get_my_ftp();	
	
	$html['right_items_title'] = txt('explorer_right_ftp');
	$html['right_items_desc'] = txt('explorer_right_ftp_desc');
	$html['right_items_img'] = 'ftp.png';		
	
	if(count($records) != 0)
	{
		$title = '<img src="'.ICONS.'server/ftp.png" style="width:30px; display:inline-block; vertical-align:middle" /> 
		<a title="'.txt('ftp_folders').'" href="javascript:void(0);" onclick="'.link_action('ftp', 'ftp_id:0,tmp_shared_id:0,shared_id:0,cloud_id:0,in_shared:0,workgroup_id:0,fs:ftp').'">
		'.txt('ftp_folders').'
		</a>
		<img src="'.THEME_URL.'icons/arrow_small_right.png" style="width:15px; display:inline-block; vertical-align:middle; padding-left:10px;padding-right:10px"/> ';			
		
		
		$html['icons'].= $layout->subtitle($title);	
		//$html['icons'].= $layout->area_start(txt('ftp_folders'));
		$html['icons'].= $layout->txtdesc(txt('st_ftp'));
		
		foreach($records as $row)
		{	
		
		// --- context menu ---
			$action_open = link_action('index', 'ftp_id:'.$row['id'].',fs:ftp');
			$action_edit = winopen(txt('dsc_ftp_a_edit'), 'cp', 'app_id:ftp@index','section:edit_account,ftp_id:'.$row['id']);					
			$action_delete = "
				$.messager.confirm('".txt('delete')."', '".txt('delete_confirm')."?', function(r){
				if (r){				
					".winopen(txt('dsc_ftp_a_edit'), 'cp', 'app_id:ftp@index','section:list,after_refresh:'.WIN_ID.',action:delete,ftp_id:'.$row['id'].',delete_id:'.$row['id'])."				
				}
				});";		
			
			$contextMenu_ftp = array(				
				'open::'.txt('connect_to').'::'.$action_open.'::reload'						
			);	
			
			if($ftp->is_my_ftp($row['id']) || is_root())
			{
				$contextMenu_ftp[] = 'edit::'.txt('dsc_ftp_a_edit').'::'.$action_edit.'::edit';
				$contextMenu_ftp[] = 'delete::'.txt('delete').'::'.$action_delete.'::cancel';
			}
			
			$apiWindow->setContextMenu($contextMenu_ftp);
			$js= $apiWindow->contextMenuRender('ftp_list_'.$row['id'].WIN_ID, 'img');	
			jquery_function($js);
			unset($js);
			$apiWindow->resetContextMenu();	
		// --- context menu ---			
			
			
			$html['icons'].=	'
			<div id="ftp_list_'.$row['id'].WIN_ID.'" ondblclick="'.$action_open.'" class="phpos_server_icon" title="'.$row['title'].' '.$row['host'].'">
			<img src="'.ICONS.'server/ftp.png" />
			<p><b>'.string_cut($row['title'],30).'</b>
			<br />'.string_cut($row['description'], 30).'
			<br /><span class="desc">'.string_cut($row['host'], 30).'</span></p>
			</div>';		
		}	
		
	} else {	
			
		$html['icons'].= $layout->area_start(txt('ftp_folders')).txt('ftp_no_accounts').$layout->txtdesc(txt('st_ftp')).$layout->area_end();						
	}
	// --- window context menu ---	
		$contextWindow = array(		
				'newcloud::'.txt('ftp_upmenu_new').'::'.winopen(txt('ftp'), 'cp', 'app_id:ftp@index','section:list').'::edit_add',
				'manageclouds::'.txt('ftp_upmenu_manage').'::'.winopen(txt('ftp'), 'cp', 'app_id:ftp@index','section:new_account').'::ftpfolders'			
		);
		
		$apiWindow->setContextMenu($contextWindow);
		$js= $apiWindow->contextMenuRender('phpos_explorer_div'.div(1), 'td');	
		jquery_function($js);
		unset($js);
		$apiWindow->resetContextMenu();	
	// --- window context menu ---	
}
?>