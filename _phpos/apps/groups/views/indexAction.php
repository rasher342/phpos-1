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
<?php echo $layout->menu(); ?>
<?php echo $layout->end('menu'); ?>
<?php echo $layout->main(); ?>
<?php echo $layout->start(); ?>
<?php echo $layout->toolbar(); ?>
<?php echo $layout->end('toolbar'); ?>
<?php echo $layout->set_style('padding:15px'); ?>
	

<?php
echo $layout->title($app_param['root_action']); 
	
switch($my_app->get_param('section'))
{
 case 'users_list':
	echo $layout->main();	
	echo $layout->title('Browse user accounts');   
	$my_app->section('users_list');	
 break;
 
  case 'list':
	echo $layout->main();	
	echo $layout->title('Browsessss user accounts');   
	$my_app->section('list');	
 break;
 
 
 case 'new_user':	
	 $layout->set_href(helper_ajax('section.new_user.php'));
	 $layout->set_id('nowy');
	 echo $layout->main(); 	
 break;
 
 case 'account':
	 $layout->set_id('account_info');
	 echo $layout->main();
	 $my_app->section('account');		
 break;
 
   case 'test':
	echo $layout->main();	
	echo $layout->title('Browsessss user accounts');   
	$my_app->section('test');	
 break;
 
 
}
?>


		 
<?php echo $layout->end('main'); ?>	
	
	
	<?php echo $layout->end('layout'); ?>
		<?php echo $layout->end('main'); ?>
		
	<?php	echo $layout->footer(); ?>			
	
	
   <div> User account management </div>
	 
	<?php echo $layout->end('footer'); ?>		
		 
<?php echo $layout->end('layout'); ?>



