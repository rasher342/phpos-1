<?php
/*
**********************************

	PHPOS Web Operating system
	MIT License
	(c) 2013 Marcin Szczyglinski
	szczyglis83@gmail.com
	GitHUB: https://github.com/phpos/
	File version: 1.2.7, 2013.10.24
 
**********************************
*/
if(!defined('PHPOS'))	die();	


if($context_fs != 'db_mysql' && !$readonly)
{
				
	$dropzone = '

	$("div#phpos_explorer_div'.div(1).'").dropzone({ url: "'.helper_post('null').'", 
	createImageThumbnails: false,	autoProcessQueue: true, parallelUploads: 100,
	init: function() {
	
	this.on("sending", function(file) {
	
	jNotify(
				"'.txt('uploading').'",
				{
					autoHide : true, 
					clickOverlay : false,
					MinWidth : 300,
					TimeShown : 4000,
					ShowTimeEffect : 1000,
					HideTimeEffect : 600,
					LongTrip :20,
					HorizontalPosition : "right",
					VerticalPosition : "bottom",
					ShowOverlay : false
				});

			
		
		});
	
	
	
	
  this.on("complete", function(file) {
	
	/*
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
		*/
		'.helper_reload().' 		
		
		});
  } 
	});
';	
				
}			
?>