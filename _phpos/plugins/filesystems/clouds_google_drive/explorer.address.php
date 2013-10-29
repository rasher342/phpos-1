<?php
/*
**********************************

	PHPOS Web Operating system
	MIT License
	(c) 2013 Marcin Szczyglinski
	szczyglis83@gmail.com
	GitHUB: https://github.com/phpos/
	File version: 1.2.9, 2013.10.28
 
**********************************
*/
if(!defined('PHPOS'))	die();	

if(!defined("PHPOS_IN_EXPLORER"))
{
	die();
}

	if($this->my_app->get_param('cloud_id') != null) 
	{				
		$cloud = new phpos_clouds;
		$cloud->set_id($this->my_app->get_param('cloud_id'));
		$cloud->get_cloud();
		
		$cloud_address_name = '<a onclick="'.helper_reload(
		array(
		'dir_id' => ($this->my_app->get_param('root_id')))
		).'" 
		href="javascript:void(0);"><b>'.$cloud->get_title().'</b></a>';			
	}




// Address links	

		$dir_id = $this->my_app->get_param('dir_id');		
		
		if($dir_id != '.')
		{
			$links = array();		
			$address_items = $this->filesystem->get_parents($dir_id);	

			if(is_array($address_items))
			{
				$c = count($address_items);
				asort($address_items);			
				
				for($i=0; $i< $c; $i++)
				{
					if($address_items[$i] != $this->filesystem->get_root_directory_id())
					{
						$item = $this->filesystem->get_file_info($address_items[$i]);
						$links[] = $item['id'];	
					}					
				}
				
				// Last item
				$item = $this->filesystem->get_file_info($this->filesystem->get_directory_id());	
				
				if($item['id'] != $this->filesystem->get_root_directory_id())
				{
					$links[] = $item['id'];	
				}	
			}	
		}	
		
		
		$c = count($links);

					
/*.............................................. */				
		
			if($c!=0)
			{
				for($i = 0; $i < $c; $i++)
				{
					$item = $this->filesystem->get_file_info($links[$i]);
					
					if($item['id'] != $shared_dir)
					{						
						$address.= '<a 
						onclick="'.helper_reload(array('dir_id' => $item['id'])).'" 
						href="javascript:void(0);">'.$item['basename'].'</a>'.$separator;	
					}
				}	
			}
		
		
		$address_start = '<a onclick="phpos.windowActionChange(\''.WIN_ID.'\', \'clouds\', \'dir_id:.,ftp_id:0,in_shared:0,fs:local_files\')" 
		href="javascript:void(0);"><b>'.txt('clouds_title').'</b></a>'.$separator.$cloud_address_name;
			
			
/*.............................................. */				
// Shared	
		

		
		$address_bar = $address_start.$separator.$address;

?>