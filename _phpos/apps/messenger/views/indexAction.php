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

$layout = new phpos_layout; ?>

<?php echo $layout->start(); ?>
<?php echo $layout->main(); ?>
<?php echo $layout->start(); ?>
<?php echo $layout->toolbar(); ?>
<?php echo $layout->end('toolbar'); ?>
<?php echo $layout->set_style('padding:15px'); ?>
	

<?php
	
	$footer = null;
switch($my_app->get_param('section'))
{  
 case 'sended':
	echo $layout->main();	
	echo $layout->title(txt('messager_section_sended'));   
	$my_app->section('sended');	
 break; 
 
  case 'received':
	echo $layout->main();	
	echo $layout->title(txt('messager_section_received'));   
	$my_app->section('received');	
 break; 

 
 case 'new':
	 $layout->set_href(helper_ajax('section.new.php'));
	 $layout->set_id('nowy');
	 echo $layout->main(); 	
 break;
 
 
}
?>


		 
<?php echo $layout->end('main'); ?>	
	
	
	<?php echo $layout->end('layout'); ?>
		<?php echo $layout->end('main'); ?>
		
	<?php	echo $layout->footer($footer); ?>			
	
	
   
	 
	<?php echo $layout->end('footer'); ?>		
		 
<?php echo $layout->end('layout'); ?>



