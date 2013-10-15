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

			
		$layout->set_region('west');
		$layout->set_split('true');			
		$layout->set_id('phpos_explorer_left_window');
?>
			
<?php echo $layout->custom(); ?>			
	
<div style="padding:20px; background-color:#f2f9fc"><?php echo $html['left_tree'];?></div>				
	
<?php echo $layout->end('custom'); ?>	