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


$layout = new phpos_layout;
$layout->set_fit('true');
$layout->set_style('background:transparent');
$layout->set_id('phpos_explorer_window');

$explorerAPI = $my_app->get_param('api_dialog');

if($explorerAPI)
{	
	winset('width', 1100);
	winset('height', 600);	
	wincenter();
}



?>

<?php echo $layout->start(); ?>	

			<?php 
			if(!$explorerAPI) 
			{
				include MY_APP_DIR.'views/inc.layout_header.php'; 	
				
			} else {
					
				include MY_APP_DIR.'views/inc.layout_header_api.php'; 	
				
			}
			?>		
			<?php include MY_APP_DIR.'views/inc.explorer_left_tree.php'; ?>					
			<?php include MY_APP_DIR.'views/inc.layout_icons_area.php'; ?>		
		
<?php 
if(!$explorerAPI)
{
	include MY_APP_DIR.'views/inc.explorer_footer.php'; 
	
} else {
	
	if($my_app->get_param('api_dialog_type') != 'open_file')	
	{
		include MY_APP_DIR.'views/inc.explorer_api_footer.php';
		
	} else{
		
		include MY_APP_DIR.'views/inc.explorer_footer.php'; 
	}
}

?>
		
<?php echo $layout->end('layout'); ?>


		
<?php include MY_APP_DIR.'views/inc.explorer_dropzone_js.php'; ?>
<?php include MY_APP_DIR.'views/jquery.php'; ?>