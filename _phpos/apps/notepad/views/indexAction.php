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

<?php echo $layout->set_style('padding:15px'); ?>	

<?php	echo $layout->main();	?>	



<?php
$explorerAPI = new phpos_explorerAPI;
$explorerAPI->set_file_extension('txt');
$explorerAPI->set_allowed_extensions($my_app->get_param('allowed_extensions'));

//echo 'id file: '.$my_app->get_param('id_file').'<br>';
if($my_app->get_param('file_info') !== null)
{	
	$file_info = $my_app->get_param('file_info');
	winset('title', $file_info['basename']);
	
	$explorerAPI->set_file_info($file_info);
	
	$str_file = '<span style="color:black; font-weight:bold">'.$file_info['basename'].' </span>';
	
	$str_fileinfo = '<img src="'.MY_RESOURCES_URL.'db_file.png" style="height:15px"/>'.$str_file.' <b style="padding-left:30px;color:#000">'.txt('last_mod').':</b> '.date('Y.m.d. H:i', $file_info['modified_at']).', <b style="color:black">'.txt('filesystem').':</b> '.txt('fs_'.$file_info['fs']);
	
	echo "<script>$('#notepadform input[name=action]').val('save');</script>";
	
	
	//echo $layout->subtitle('<span style="color:black">'.$file_info['basename'].' </span>', MY_RESOURCES_URL.'db_file.png');
	
	
} else {

	$str_fileinfo = '<img src="'.MY_RESOURCES_URL.'db_file.png" style="height:15px"/><span style="color:#000; font-weight:bold">'.txt('app_notepad_new_unsaved').'</span>';	
	
}
		
		$save_action = "			
		$('#notepadform input[name=action]').val('save');
		$('#notepadform').submit(); 		
		";
		
		$save_as_action = "			
		$('#notepadform input[name=action]').val('save_as');
		$('#notepadform').submit(); 		
		";

		$forma = new phpos_forms;

		//forma->onsuccess('alert("succ");');
		$forma->onsuccess($explorerAPI->savefile_dialog());
		$after_reload = WIN_ID;
		echo $forma->form_start('notepadform', helper_post_outside('null','', $after_reload), array('app_params' => ''));
								
		$forma->input('hidden','win_id', '', '',  WIN_ID);
		$forma->input('hidden','action', '', '',  'save_as');
		//$forma->reload_after_submit(array(WIN_ID));
		
		$forma->texteditor('txt', null, null,  $my_app->get_param('notepad'));				
		
		if(is_array($file_info)) $forma->button(txt('save'), $save_action, 'filesave');
		$forma->button(txt('save_as'), $save_as_action, 'edit_add');
		$forma->status();
		
		echo $forma->render();	
		echo $forma->form_end();	
	/*	
	echo '<pre>';
	print_r($_SESSION['phpos_savefiles_handler']);
	echo '</pre>';
*/


?>
		 
<?php echo $layout->end('main'); ?>	
	
	
	<?php echo $layout->end('layout'); ?>
		<?php echo $layout->end('main'); ?>
		
	<?php	echo $layout->footer($str_fileinfo); ?>	  
	 
	<?php echo $layout->end('footer'); ?>		
		 
<?php echo $layout->end('layout'); ?>