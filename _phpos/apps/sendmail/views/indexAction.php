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

if(globalconfig('demo_mode') == 1 && !is_root())
{
	echo '<h3>Sending emails is blocked in online demo.</h3>';
}
		
		$form = new phpos_forms;
		$monit_success = "
		jSuccess(
			'Email was sent',
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
	
		echo $form->form_start('new_mail', '', array('app_params' => ''));
		
		$form->input('hidden','action', '', '',  'new_mail');
		
		$form->condition('not_null', true, 'Name is empty!');
		$form->input('text','mail_from_name', 'Your name',  null, null);
		
		$form->condition('not_null', true, 'Your email is empty!');
		$form->input('text','mail_from_email', 'Your email',  null, null);
		
		$form->condition('not_null', true, 'Receiver email is empty!');
		$form->input('text','mail_to_email', 'To',  null, null);
		
		$form->condition('not_null', true, 'Subject is empty!');
		$form->input('text','mail_to_subject', 'Subject',  null, null);
		
		$form->status();
		
		$send_action = "			
		$('#new_mail').submit(); 
		".$monit_success."			
		";		
		
		$form->texteditor('msg', null, null, null);			
		$form->button('Send email', $send_action, 'edit_add');	
		
		echo $form->render();	
		echo $form->form_end();	
		
		echo $layout->end('main'); ?>	
	
	
	<?php echo $layout->end('layout'); ?>
	
		<?php echo $layout->end('main'); ?>
		
	<?php	echo $layout->footer(); ?>	  
	 
	<?php echo $layout->end('footer'); ?>		
		 
<?php echo $layout->end('layout'); ?>