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

if(!defined('CP_ACCESS')) die(); ?>
<?php $layout = new phpos_layout; ?>

<?php echo $layout->start(); ?>
<?php echo $layout->main(); ?>
<?php echo $layout->start(); ?>
<?php echo $layout->toolbar(); ?>
<?php echo $layout->end('toolbar'); ?>
<?php echo $layout->set_style('padding:15px'); ?>
	

<?php
	
switch($my_app->get_param('section'))
{
 
 
 case 'system_info_phpos':	
	 $layout->set_href(helper_ajax('section.system_info_phpos.php'));
	 $layout->set_id('nowy');
	 echo $layout->main(); 	
 break;
 
 case 'system_info_php':	
	 $layout->set_href(helper_ajax('section.system_info_php.php'));
	 $layout->set_id('nowy');
	 echo $layout->main(); 	
 break;
 
 case 'system_info_db':	
	 $layout->set_href(helper_ajax('section.system_info_db.php'));
	 $layout->set_id('nowy');
	 echo $layout->main(); 	
 break;
 
 case 'system_info_server':	
	 $layout->set_href(helper_ajax('section.system_info_server.php'));
	 $layout->set_id('nowy');
	 echo $layout->main(); 	
 break;
 
 case 'system_info_key':	
	 $layout->set_href(helper_ajax('section.system_info_key.php'));
	 $layout->set_id('nowy');
	 echo $layout->main(); 	
 break;
 
 

}
?>
		 
<?php echo $layout->end('main'); ?>	
	
	
	<?php echo $layout->end('layout'); ?>
		<?php echo $layout->end('main'); ?>
		
	<?php	echo $layout->footer(); ?>		
  
	 
	<?php echo $layout->end('footer'); ?>		
		 
<?php echo $layout->end('layout'); ?>