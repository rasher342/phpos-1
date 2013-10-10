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
<?php echo $layout->set_style('padding:15px'); ?>
<?php echo $layout->main(); ?>

<?php echo $layout->title($url, 'icon.png'); ?>

<?php

	if(!empty($url)) 
	{
		echo '<iframe sandbox="allow-same-origin allow-scripts allow-popups allow-forms"
    src="'.$url.'"  seamless="seamless" style="border: 0; width: 100%; height:100%;"></iframe>';
	}

?>

<?php echo $layout->end('main'); ?>	


<?php echo $layout->end('layout'); ?>
<?php echo $layout->end('main'); ?>

<?php	echo $layout->footer(); ?>		


<?php echo $layout->end('footer'); ?>		

<?php echo $layout->end('layout'); ?>