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

<?php	echo $layout->main();	?>	
<?php	echo $layout->title('Updater'); ?>	  


<?php

$updater = new phpos_updater;



echo $layout->column('50%');

echo $layout->subtitle(txt('cp_updater_check_title'), MY_RESOURCES_URL.'window_icon.png');
echo $layout->txtdesc(txt('cp_updater_desc_main'));

$my_version = PHPOS_VERSION;
$my_version_name = '<br /> <span style="color:#878787">('.PHPOS_VERSION_NAME.')</span>';


if($updater->check_online())
{
		$download_url = 'http://'.$updater->get_zip();
		$last_version = $updater->get_version();
		$last_version_name = '<br /> <span style="color:#878787">('.$updater->get_name().')</span>';

		if($updater->is_actual())
		{
			$my_version = '<span style="color:green;font-weight:bold;font-size:15px">'.$my_version.'</span>';
			$last_version = '<span style="color:green;font-weight:bold;font-size:15px">'.$last_version.'</span>';
			$msg = $layout->div_ok(txt('cp_updater_check_status_actual'));			

		} else {
		
			$my_version = '<span style="color:red;font-weight:bold;font-size:15px">'.$my_version.'</span>';
			$last_version = '<span style="color:green;font-weight:bold;font-size:15px">'.$last_version.'</span>';
			$msg = $layout->div_error(txt('cp_updater_check_status_notactual'));
			$need_update = 1;
		}


		echo $layout->tbl_start();
		echo $layout->head(array(txt('cp_updater_last_version') => '50%', txt('cp_updater_your_version') => '50%'));
		echo $msg;
		echo $layout->row(array($last_version.$last_version_name, $my_version.$my_version_name));		
		echo $layout->row(array(txt('cp_updater_rel_date').': '.$updater->get_build(),txt('cp_updater_your_date').': '.PHPOS_BUILD));	
		echo $layout->tbl_end();	

		echo $layout->subtitle(txt('cp_updater_changelog').' ('.$updater->get_name().')', ICONS.'notes.png');
		echo $layout->txtdesc(txt('cp_updater_desc_changes'));
		
		echo $layout->tbl_start();
		$changes = $updater->get_changes();
		$changes_array = explode("\n", $changes);
		if(is_array($changes_array))
		{
			foreach($changes_array as $entry)
			{
				echo $layout->row(array($entry));	
			}
		}
		echo $layout->tbl_end();	


} else {
	
	echo $layout->div_error($updater->get_conn_error());
}


echo $layout->end('column');

echo $layout->column('50%');

	if($need_update ==1)
	{
		echo $layout->subtitle(txt('cp_updater_online_info'), MY_RESOURCES_URL.'window_icon.png');
		echo $layout->txtdesc(txt('cp_updater_desc_info'));
		
		$type = $updater->get_type();
		switch($type)
		{
			case 'critical':
			$type_style = 'font-weight:bold; color: #5e2426';
			break;
			
			case 'bugs':
			$type_style = 'font-weight:bold; color: #418b3f';
			break;
			
			case 'features':
			$type_style = 'font-weight:bold; color: #4861ac';
			break;
		}
		
		$upd_type = '<span style="'.$type_style.'">'.$type.'</span>';

		echo $layout->tbl_start();
		echo $layout->row(array('<b>'.txt('cp_updater_update_type').'</b>', $upd_type));
		echo $layout->row(array('<b>'.txt('cp_updater_update_info').'</b>', $updater->get_msg()));
		echo $layout->tbl_end();	
	}


echo $layout->subtitle(txt('cp_updater_download_last'), ICONS.'download.png');
echo $layout->txtdesc(txt('cp_updater_desc_download'));

echo $layout->button(txt('cp_updater_download_btn_www'),'window.open(\''.PHPOS_ONLINE.'?v=download\', \'_blank\')','download1'); 
echo $layout->button(txt('cp_updater_download_btn_git'),'window.open(\'https://github.com/phpos/phpos/archive/release.zip\', \'_blank\')','download1');
echo $layout->tbl_start();
echo $layout->head(array('' => '50%', 'Link' => '50%'));
echo $layout->row(array(txt('updater_tray_visit_www'), '<a href="'.PHPOS_ONLINE.'" target="_blank">'.PHPOS_ONLINE.'</a>'));
echo $layout->row(array(txt('cp_updater_download_zip'), '<a href="'.$download_url.'" target="_blank">http://'.$updater->get_zip().'</a>'));		
echo $layout->row(array('GitHUB:', '<a href="'.PHPOS_GITHUB.'" target="_blank">'.PHPOS_GITHUB.'</a>'));	


echo $layout->tbl_end();	

echo $layout->end('column');
echo $layout->clr();

?>

		 
<?php echo $layout->end('main'); ?>	
	
	
	<?php echo $layout->end('layout'); ?>
		<?php echo $layout->end('main'); ?>
		
	<?php	echo $layout->footer(); ?>	
  
	 
	<?php echo $layout->end('footer'); ?>		
		 
<?php echo $layout->end('layout'); ?>
