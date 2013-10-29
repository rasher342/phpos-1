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
						if(!empty($item['id'])) $links[] = $item['id'];	
					}					
				}
				
				// Last item
				$item = $this->filesystem->get_file_info($this->filesystem->get_directory_id());	
				
				if($item['id'] != $this->filesystem->get_root_directory_id())
				{
					if(!empty($item['id'])) $links[] = $item['id'];	
				}	
			}	
		}	
		
		
		$c = count($links);

/*.............................................. */		
// Prefix
	
	$tmp_shared_id = $this->my_app->get_param('tmp_shared_id');	
		
		if(!empty($tmp_shared_id))
		{
			$shared = new phpos_shared;
			$shared->set_id($tmp_shared_id);
			$shared->get_shared();
			$shared_dir = $shared->get_folder_id();
		}
			
		$in_shared = $this->my_app->get_param('in_shared');
					
					
/*.............................................. */				
// If not in shared

		if(!$in_shared)
		{
			if($c!=0)
			{
				for($i = 0; $i < $c; $i++)
				{
					$item = $this->filesystem->get_file_info($links[$i]);
					
					if($item['id'] != $shared_dir)
					{
						if(is_root()) $item = $this->root_homedir_address_parse($item);
						
						$link_name = $item['basename'];
						
						
						if($this->my_app->get_param('in_library') == 1) 
						{
							$translate_lib = txt('lib'.$item['basename']);
							if($translate_lib != 'lib'.$item['basename'])	$link_name = $translate_lib;
						}
						
						$address.= '<a 
						onclick="'.helper_reload(array('dir_id' => $item['id'])).'" 
						href="javascript:void(0);">'.$link_name.'</a>'.$separator;	
					}
				}	
			}
		}
		
		$address_start = '<a onclick="'.helper_reload(
		array(
		'dir_id' => $this->filesystem->get_root_directory_id())
		).'" 
		href="javascript:void(0);"><b>'.$this->filesystem->protocol_name.'</b></a>';
			
			
/*.............................................. */				
// Shared	
		
		$in_shared = $this->my_app->get_param('in_shared');
		$tmp_shared_id = $this->my_app->get_param('tmp_shared_id');				

		
		if(defined('SHARED') || $in_shared)
		{
			$group = new phpos_groups;
			$group_id = $this->my_app->get_param('workgroup_id');
			$group->set_id($group_id);
			$group->get_group();		
			
				
			$shared_id = $this->my_app->get_param('tmp_shared_id');	
			$shared = new phpos_shared;
			$shared->set_id($shared_id);
			$shared->get_shared();
			
			$group_user = new phpos_users;
			$id_user = $shared->get_id_user();
			$group_user->set_id_user($id_user);
			$group_user->get_user_by_id();	
		
			$address_start = '<a 
			onclick="phpos.windowActionChange(\''.WIN_ID.'\', \'shared\', \'workgroup_id:'.$group_id.',workgroup_user_id:'.$id_user.',fs:local_files\')" href="javascript:void(0);"><b>'.$group_user->get_user_login().'</b></a>'.$separator.'<a onclick="phpos.windowActionChange(\''.WIN_ID.'\', \'index\', \'shared_id:'.$shared_id.',in_shared:1,fs:local_files\')" href="javascript:void(0);"><b>'.$shared->get_title().'</b></a>';
		}
		
		
		$address_bar = $address_start.$separator.$address;

?>