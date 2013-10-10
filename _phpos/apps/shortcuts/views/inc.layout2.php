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


wincenter();
$layout = new phpos_layout; ?>

<?php $layout->set_fit('true');
echo $layout->start(); ?>

		<?php $layout->set_fit('true');
		echo $layout->main(); ?>
		
				

						<?php
						$layout->set_fit('true');
						echo $layout->main();
						echo $html;
						?>

						<?php echo $layout->end('main'); ?>		

						
				
				

				
				
				
				
				
				
				

		<?php echo $layout->end('main'); ?>			



<?php	
				
	if(APP_ACTION != 'index')
	{
	$layout->set_region('south');
	$layout->set_split('false');	
	$layout->set_fit('true');
	$layout->set_style('width:100%;height:100px');

	echo $layout->custom();		
	echo $next_button;
	echo $layout->end('custom');
	
	} else {
	
		echo $layout->footer();
		echo $layout->end('footer');
	
	}
?>
		
		

		

<?php echo $layout->end('layout'); ?>