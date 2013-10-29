<?php
$js_menus = "
function explorer_clouds_google_drive_localdownload(file_id)
	{	
		jNotify(
				'".txt('wait_for_download')."',
				{
					autoHide : true, 
					clickOverlay : false,
					MinWidth : 300,
					TimeShown : 7000,
					ShowTimeEffect : 1000,
					HideTimeEffect : 600,
					LongTrip :20,
					HorizontalPosition : 'right',
					VerticalPosition : 'bottom',
					ShowOverlay : false
			});
			
		phpos.windowRefresh('".WIN_ID."', 'action_id:googledrive_download_local,action_param:'+file_id);		
	}
	
function explorer_clouds_google_drive_serverdownload(file_id)
	{	
		jNotify(
				'".txt('wait_for_download')."',
				{
					autoHide : true, 
					clickOverlay : false,
					MinWidth : 300,
					TimeShown : 7000,
					ShowTimeEffect : 1000,
					HideTimeEffect : 600,
					LongTrip :20,
					HorizontalPosition : 'right',
					VerticalPosition : 'bottom',
					ShowOverlay : false
			});
			
		phpos.windowRefresh('".WIN_ID."', 'action_id:googledrive_download_server,action_param:'+file_id);		
	}
	";
	$explorer->addJs($js_menus);


		
?>