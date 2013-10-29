<?php	
/*
**********************************

	PHPOS Web Operating system
	MIT License
	(c) 2013 Marcin Szczyglinski
	szczyglis83@gmail.com
	GitHUB: https://github.com/phpos/
	File version: 1.2.9, 2013.10.29
 
**********************************
*/
if(!defined('PHPOS'))	die();	

		
	$layout->set_region('north');
	$layout->set_split('true');
	$layout->set_style('background:#f2f9fc');
	$layout->set_id('phpos_explorer_header');
	$layout->set_height(80);
?>

<?php echo $layout->custom(); ?>			

<?php include MY_APP_DIR.'views/inc.explorer_toolbar.php'; ?>
	
<?php echo $layout->end('custom'); ?>	