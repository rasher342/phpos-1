<?php
/*
**********************************

	PHPOS Web Operating system
	MIT License
	(c) 2013 Marcin Szczyglinski
	szczyglis83@gmail.com
	GitHUB: https://github.com/phpos/
	File version: 1.3.1, 2013.10.30
 
**********************************
*/
if(!defined('PHPOS'))	die();	

//console::inline(session_id());

if($context_fs != 'db_mysql' && !$readonly)
{
				
	$dropzone = '

	$("div#phpos_explorer_div'.div(1).'").dropzone({ url: "'.helper_post('null').'", 
	createImageThumbnails: false,	autoProcessQueue: true, parallelUploads: 100,
	init: function() {
	
	
	
	
	this.on("totaluploadprogress", function(progress,progressSent,bytesSent) {
	
	$("#progress_bar").progressbar({
    value: Math.floor(progress)
	});
	
	if(Math.floor(progress) == 100)
	{
	
		$("#progress_bar").css("display", "none");
		$("#progress_bar").progressbar({
    value:0
		});
		
		jSuccess(
					"'.txt('uploaded').'",
					{
						autoHide : true, 
						clickOverlay : false,
						MinWidth : 300,
						TimeShown : 2000,
						ShowTimeEffect : 1000,
						HideTimeEffect : 600,
						LongTrip :20,
						HorizontalPosition : "right",
						VerticalPosition : "bottom",
						ShowOverlay : false
					});
					
			var html = $("#phpos_console_data").html();
			var new_data = "Upload success.<br />" + html;
			$("#phpos_console_data").html(new_data);	
			phpos.waiting_hide();
			
		'.link_action(APP_ACTION, 'hide_upload_status:1').'
		
		}
	
	});
	
	this.on("sending", function(file) {
	$("#progress_bar").css("display", "block");
	
		var notify = 0;
		
		if(notify == 0)
		{
			phpos.waiting_show();			
			notify = 1;
		}
	});
	

  } 
	});
	
	
	$(".upload_form").submit(function() {
		phpos.waiting_show();	
	});
	
	
	
	';		
}			
?>