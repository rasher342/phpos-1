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
			$html['icons'].= $layout->area_start(txt('ftp_folders'));
			$html['icons'].= $layout->txtdesc(txt('st_ftp'));
			
			foreach($records as $row)
			{				
				
				$action_open = link_action('index', 'ftp_id:'.$row['id'].',fs:ftp');
				$action_edit = winopen(txt('dsc_ftp_a_edit'), 'cp', 'app_id:ftp@index','section:edit_account,ftp_id:'.$row['id']);		
				
				$action_delete = "
					$.messager.confirm('".txt('delete')."', '".txt('delete_confirm')."?', function(r){
					if (r){
					
						".winopen(txt('dsc_ftp_a_edit'), 'cp', 'app_id:ftp@index','section:list,after_refresh:'.WIN_ID.',action:delete,ftp_id:'.$row['id'].',delete_id:'.$row['id'])."				
					}
					});";		
				
				$contextMenu_ftp = array(				
							'open::'.txt('open').'::'.$action_open.'::folder_open',
							'edit::'.txt('dsc_ftp_a_edit').'::'.$action_edit.'::edit',
							'delete::'.txt('delete').'::'.$action_delete.'::cancel'	
					);				
								
				$apiWindow->setContextMenu($contextMenu_ftp);
				$js.= $apiWindow->contextMenuRender('ftp_list_'.$row['id'].WIN_ID, 'img');	
				$apiWindow->resetContextMenu();	
								
				
				
				$html['icons'].=	'<div id="ftp_list_'.$row['id'].WIN_ID.'" ondblclick="'.$action_open.'" class="phpos_server_icon" title="<b>'.$row['title'].'</b> '.$row['host'].'"><img src="'.ICONS.'server/ftp.png" /><p><b>'.string_cut($row['title'],30).'</b><br />'.string_cut($row['description'], 30).'<br /><span class="desc">'.string_cut($row['host'], 30).'</span></p></div>';
			
			}
			$html['icons'].= $layout->area_end();
			
		} else {	
				
			$html['icons'].= $layout->area_start(txt('ftp_folders')).txt('ftp_no_accounts').$layout->txtdesc(txt('st_ftp')).$layout->area_end();						
		}
	}


?>