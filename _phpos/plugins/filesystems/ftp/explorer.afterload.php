<?php
$js_menus = "
function explorer_ftp_download(file_id, file_name, file_type)
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
			
		phpos.windowRefresh('".WIN_ID."', 'action_id:ftp_download,action_param:'+file_id+',action_param2:'+file_type);		
	}
	
	function explorer_ftp_view(file_id, file_name, file_type)
	{	
		jNotify(
				'".txt('wait_for_download')."',
				{
					autoHide : true, 
					clickOverlay : false,
					MinWidth : 300,
					TimeShown : 5000,
					ShowTimeEffect : 1000,
					HideTimeEffect : 600,
					LongTrip :20,
					HorizontalPosition : 'right',
					VerticalPosition : 'bottom',
					ShowOverlay : false
			});	
		
		
		
		phpos.windowRefresh('".WIN_ID."', 'action_id:ftp_view,action_param:'+file_id+',action_param2:'+file_type);		
	}
	";
$explorer->addJs($js_menus);
?>