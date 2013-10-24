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

		
$layout->set_region('center');
$layout->set_classes('phpos_explorer_files_body');			
$layout->set_id('phpos_explorer_div'.div(1));
$layout->set_style('background-image:url('.$html['protocol_bg'].'); background-repeat:no-repeat; margin-top:0; vertical-align:top; background-position:top right');	
?>

<?php echo $layout->custom(); ?>

<?php include MY_APP_DIR.'views/inc.layout_icons_table.php'; ?>
	
<?php echo $layout->end('custom'); ?>	