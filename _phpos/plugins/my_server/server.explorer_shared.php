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

$server_item_title = txt('shared_folders');
$shared = new phpos_shared;
$records = $shared->get_my_shared();

if(count($records) != 0)
{
	foreach($records as $row)
	{
		// --- context menu ---
			$action_open = link_action('index', 'reset_shared:0,shared_id:'.$row['id'].',in_shared:1,fs:local_files');						
			$contextMenu_shared_folders = array(				
				'open::'.txt('open').'::'.$action_open.'::folder_open'					
			);				
			
			$contextMenu_shared_folders[]	=	
			'shortcuts::'.txt('link_on_desktop').'::explorer_link_to_folder("'.$row['folder_id'].'", "'.base64_encode($row['title']).'");::edit_add';						
			
			if($shared->is_my($row['id']))
			{
				$contextMenu_shared_folders[] = 'share::'.txt('stop_share_folder').'::'.winmodal(txt('share_folder'), 'app', 'app_id:shortcuts@share,width:300,height:350','stop_share:1,desktop:1,location:db,dir_id:'.$my_app->get_param('dir_id').',shared_id:'.$row['folder_id'].',after_reload:'.WIN_ID).'::cancel';	
			}	
			
			$apiWindow->setContextMenu($contextMenu_shared_folders);
			$js = $apiWindow->contextMenuRender('groups_shared_folders_'.$row['id'].WIN_ID, 'img');	
			jquery_function($js);
			unset($js);
			$apiWindow->resetContextMenu();				
		// --- context menu ---			
		
		
		$tmp_html.=	'<div id="groups_shared_folders_'.$row['id'].WIN_ID.'" ondblclick="'.$action_open.'" class="phpos_server_icon" title="'.$row['title'].' '.$row['description'].'"><img src="'.ICONS.'server/shared1.png" /><p><b>'.string_cut($row['title'],30).'</b><br />'.string_cut(basename(base64_decode($row['folder_id'])), 30).'<br /><span class="desc">'.string_cut($row['description'], 30).'</span></p></div>';
	}
} else {

	$tmp_html= txt('shared_no_folders');
}
?>