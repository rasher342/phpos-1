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
	
	if($this->my_app->get_param('ftp_id') != null) 
	{				
		$ftp = new phpos_ftp;
		$ftp->set_id($this->my_app->get_param('ftp_id'));
		$ftp->get_ftp();
		
		$ftp_address_host = '<a onclick="'.helper_reload(
		array(
		'dir_id' => '.')
		).'" 
		href="javascript:void(0);"><b>'.$ftp->get_host().'</b></a>'.$separator;			
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
						if($item['id'] != '' && $item['id'] != '.') $links[] = $item['id'];	
					}					
				}
				
				// Last item
				$item = $this->filesystem->get_file_info($this->filesystem->get_directory_id());	
				
				if($item['id'] != $this->filesystem->get_root_directory_id())
				{
					if($item['id'] != '' && $item['id'] != '.') $links[] = $item['id'];	
				}	
			}	
		}	
		
		
		$c = count($links);

/*.............................................. */		
// Prefix
					
					
/*.............................................. */				
		
			if($c!=0)
			{
				for($i = 0; $i < $c; $i++)
				{
					$item = $this->filesystem->get_file_info($links[$i]);
					
					if($item['id'] != $shared_dir)
					{
						if(is_root()) $item = $this->root_homedir_address_parse($item);
						
						$address.= '<a 
						 title="'.$item['id'].'" onclick="'.helper_reload(array('dir_id' => $item['id'])).'" 
						href="javascript:void(0);">'.$item['basename'].'</a>'.$separator;	
					}
				}	
			}
		
		
		$address_start = '<a onclick="phpos.windowActionChange(\''.WIN_ID.'\', \'ftp\', \'dir_id:.,ftp_id:0,in_shared:0,fs:local_files\')" 
		href="javascript:void(0);"><b>'.txt('ftp_folders').'</b></a>';	
		
			
		$address_bar = $address_start.$separator.$ftp_address_host.$address;	
			
/*.............................................. */			

?>