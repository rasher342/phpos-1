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


if(!defined('PHPOS_SECTION_ACCESS'))
{
	die();
}
	echo helper_result('delete_cloud');
	echo $layout->txtdesc(txt('dsc_cloud_title'));
	echo $layout->column('33%');
	
	echo $layout->subtitle(txt('cloud_my'), MY_RESOURCES_URL.'cloud_icon.png');
	echo $layout->txtdesc(txt('dsc_cloud_list_own'));

	$clouds = new phpos_clouds;

	$clouds_ids = $clouds->get_only_my_clouds();		
	$c=count($clouds_ids);	
	
	if($c != 0)
	{		
		echo $layout->tbl_start();
		$layout->td_classes(array('', '', 'tbl_grey'));
		echo $layout->head(array('<img src="'.MY_RESOURCES_URL.'cloud_icon.png" />' => '20%', txt('cloud_account') => '40%', txt('cloud_type') => '40%'));
		for($i=0; $i<$c; $i++)
		{
			$cl = new phpos_clouds;
			$cl->set_id($clouds_ids[$i]['id']);
			$cl->get_cloud();	
			
				
			echo $layout->row(array('<img src="'.$cl->get_cloud_icon().'"  style="height:20px"/>', '<a href="javascript:void(0);" onclick="'.helper_reload(array('section' => 'edit_account', 'cloud_id' => $cl->get_id(), 'cloud_type' => $cl->get_cloud_type())).'">'.$cl->get_title().'</a>', $cl->get_cloud_name()), $cl->get_desc());		
		}	
		echo $layout->tbl_end();		
		
	} else {
	
			echo $layout->empty_list();	
	}
	
	
	
	
echo $layout->end('column');


if(is_root() || is_admin())
{
			echo $layout->column('33%');
			echo $layout->subtitle(txt('cloud_all'), MY_RESOURCES_URL.'cloud_icon.png');
			echo $layout->txtdesc(txt('dsc_cloud_list_all'));
			
		$clouds = new phpos_clouds;

	$clouds_ids = $clouds->get_all();		
	$c=count($clouds_ids);	
				
if($c != 0)
	{		
		echo $layout->tbl_start();
		$layout->td_classes(array('', '', 'tbl_grey'));
		echo $layout->head(array('<img src="'.MY_RESOURCES_URL.'cloud_icon.png" />' => '20%', txt('cloud_account') => '40%', txt('cloud_type') => '40%'));
		for($i=0; $i<$c; $i++)
		{
			$cl = new phpos_clouds;
			$cl->set_id($clouds_ids[$i]['id']);
			$cl->get_cloud();	
			
				
			echo $layout->row(array('<img src="'.$cl->get_cloud_icon().'"  style="height:20px"/>', '<a href="javascript:void(0);" onclick="'.helper_reload(array('section' => 'edit_account', 'cloud_id' => $cl->get_id(), 'cloud_type' => $cl->get_cloud_type())).'">'.$cl->get_title().'</a>', $cl->get_cloud_name()), $cl->get_desc());		
		}	
		echo $layout->tbl_end();		
		
	} else {
		
				echo $layout->empty_list();	
	}
					

	echo $layout->end('column');
}

	echo $layout->column('33%');
	echo $layout->subtitle(txt('cloud_public'), MY_RESOURCES_URL.'cloud_icon.png');
	
	if(is_root() || is_admin())
	{
		echo $layout->txtdesc(txt('dsc_cloud_list_public'));
	} else {
		echo $layout->txtdesc(txt('dsc_cloud_list_public_user'));
	}
		
	$clouds = new phpos_clouds;

	$clouds_ids = $clouds->get_public_clouds();		
	$c=count($clouds_ids);	
		
	if($c != 0)
	{		
		echo $layout->tbl_start();
		$layout->td_classes(array('', '', 'tbl_grey'));
		echo $layout->head(array('<img src="'.MY_RESOURCES_URL.'cloud_icon.png" />' => '20%', txt('cloud_account') => '40%', txt('cloud_type') => '40%'));
		for($i=0; $i<$c; $i++)
		{
			$cl = new phpos_clouds;
			$cl->set_id($clouds_ids[$i]['id']);
			$cl->get_cloud();	
			
			if(is_root() || $cl->is_my_cloud($clouds_ids[$i]['id']))
			{
				$item = '<a href="javascript:void(0);" onclick="'.helper_reload(array('section' => 'edit_account', 'cloud_id' => $cl->get_id(), 'cloud_type' => $cl->get_cloud_type())).'">'.$cl->get_title().'</a>';
			
			} else {
				
				$item = $cl->get_title();
			}
				
			echo $layout->row(array('<img src="'.$cl->get_cloud_icon().'"  style="height:20px"/>', $item, $cl->get_cloud_name()), $cl->get_desc());		
		}	
		echo $layout->tbl_end();		
		
	} else {
	
		echo $layout->empty_list();	
	}
	

	

echo $layout->end('column');

echo $layout->clr();




?>