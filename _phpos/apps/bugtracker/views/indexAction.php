<?php
/*
**********************************

	PHPOS Web Operating system
	MIT License
	(c) 2013 Marcin Szczyglinski
	szczyglis83@gmail.com
	GitHUB: https://github.com/phpos/
	File version: 1.0.0, 2013.10.11
 
**********************************
*/
if(!defined('PHPOS'))	die();	
	$layout = new phpos_layout; ?>

<?php echo $layout->start(); ?>
<?php echo $layout->main(); ?>
<?php echo $layout->start(); ?>

<?php echo $layout->set_style('padding:15px'); ?>	

<?php	echo $layout->main();		


		echo $layout->txtdesc('<b>'.txt('bugtracker_app_desc').'</b>');
		
		$form = new phpos_forms;
		$monit_success = "
		jSuccess(
			'".txt('bugtracker_sended_msg')."',
			{
				autoHide : true, 
				clickOverlay : false,
				MinWidth : 200,
				TimeShown : 9000,
				ShowTimeEffect : 1000,
				HideTimeEffect : 600,
				LongTrip :20,
				HorizontalPosition : 'right',
				VerticalPosition : 'bottom',
				ShowOverlay : false
			}
		);";
	
		$success_code = winclose(WIN_ID).$monit_success;
		
		
		echo $form->form_start('new_bug'.WIN_ID, 'http://phpos.pl/bugtracker.php', null);								
		$form->onsuccess($success_code);
		$form->reload_after_submit(array(WIN_ID));
		
		
		$form->input('hidden','send_bug', '', '',  '1');	
		$form->input('hidden','version', '', '',  PHPOS_VERSION_NAME);	
		$form->input('hidden','send_time', '', '',  time());		
		$form->input('hidden','server_ip', '', '',  $_SERVER['SERVER_ADDR']);	
		
		$form->input('text','sender_name', txt('bugtracker_name'),  txt('bugtracker_name_desc'), $start_title);
		$form->status();
		
		$send_action = "			
		$('#new_bug".WIN_ID."').submit(); 
		".$monit_success."	
		".winclose(WIN_ID)."		
		";		
		
		$form->texteditor('msg', null, null, null);			
		$form->button(txt('bugtracker_report_btn'), $send_action, 'edit_add');	

		
		echo $form->render();	
		echo $form->form_end();	
		
		echo $layout->end('main'); ?>	
	
	
	<?php echo $layout->end('layout'); ?>
	
		<?php echo $layout->end('main'); ?>
		
	<?php	echo $layout->footer(); ?>	  
	 
	<?php echo $layout->end('footer'); ?>		
		 
<?php echo $layout->end('layout'); ?>