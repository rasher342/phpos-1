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


class app_explorer {

	private
		$my_app,
		$fs,
		$filesystem,
		$js_code,
		$hidden_icons = array(),
		$config = array(),
		$window;
		
				 
/*
**************************
*/
 	
	public function __construct()
	{		
		$this->hidden_icons = array(
		'_Desktop',
		'_Documents',
		'_Download',
		'_Clipboard',
		'_Log',
		'_Icons',
		'_Pictures',
		'_Shared',
		'_Temp',
		'_Userdata',
		'_Video',	
		'_Wallpapers',	
		'index.php',
		'index.htm',
		'index.html',
		'index.php5'
		);		
	}
				 
/*
**************************
*/
 	
	public function set_fs($fs)
	{
		$this->fs = $fs;
	}
				 
/*
**************************
*/

 	public function get_hidden_icons()
	{
		return $this->hidden_icons;
	}
	
/*
**************************
*/	
	public function addJs($js_code)
	{
		$this->js_code.= $js_code;
	}
	
/*
**************************
*/	
	public function renderJs()
	{
		return $this->js_code;
	}
	
/*
**************************
*/

	public function config($name, $value = null)
	{
		if(!empty($value))
		{
			$this->config[$name] = $value;
			return $this->config[$name];
			
		} else {
		
			return $this->config[$name];			
		}	
	}	
				 
/*
**************************
*/
 	
	public function assign_filesystem(phpos_filesystems $fs_object)
	{
		$this->filesystem = $fs_object;
	}
				 
/*
**************************
*/
 	
	public function assign_my_app(phpos_app $app_object)
	{
		$this->my_app = $app_object;
	}
				 
/*
**************************
*/
 	
	public function assign_window(api_wintask $window_object)
	{
		$this->window = $window_object;
	}
					 
/*
**************************
*/
 	
	public function get_tree($root, $level = 0)
	{
		$ret = '';	
		$level++;
		
		$dir_id = $this->my_app->get_param('dir_id');
		$global_fs = $this->my_app->get_param('fs');
		
		$class_name = 'phpos_fs_plugin_'.$this->fs;		
		$fs = new $class_name;
		$root_id = $fs->get_root_directory_id();			
		
		$fs->set_directory_id($root);
		
		$files = $fs->get_files_list();
		$c = count($files);
		
		$item_parents_array = $fs->get_parents($dir_id);		
					
/*.............................................. */		
	
		for($i=0; $i<$c; $i++)
		{	
			if($fs->is_directory($files[$i]))
			{				
				if(!in_array($files[$i]['basename'], $this->hidden_icons))
				{					
					if(is_root()) $files[$i] = $this->root_homedir_address_parse($files[$i]);
						
					if($files[$i]['id'] == $dir_id && $this->fs == $global_fs)
					{
						$span = '<span style="color:black"><b>'.$files[$i]['basename'].'</b></span>';		
						
					} else {
					
						$span = '<span style="color:black">'.$files[$i]['basename'].'</span>';				
					}					
					
					// if item is parent of actual dir_id
					
					$closed = '';
				
					if(in_array($files[$i]['id'], $item_parents_array) && $this->fs == $global_fs)
					{					
						$ret.='<li data-options="iconCls:\'tree_user_root_icon\'"><span><a title="'.$files[$i]['id'].'" href="javascript:void(0);" onclick="phpos.windowActionChange(\''.$this->window->getID().'\', \'index\' , \'reset_shared:1,root_id:'.$root_id.',in_shared:0,tmp_shared_id:0,shared_id:0,dir_id:'.$files[$i]['id'].',app_id:index,fs:'.$this->fs.'\')">'.$span.'</a></span>';					
						$ret.='<ul>'.$this->get_tree($files[$i]['id'], $level).'</ul>'; // get childs
						
					} else {					
						
						$ret.='<li data-options="iconCls:\'tree_user_root_icon\',state:\'closed\'"><span><a href="javascript:void(0);" onclick="phpos.windowActionChange(\''.$this->window->getID().'\', \'index\' , \'reset_shared:1,app_id:index,root_id:'.$root_id.',in_shared:0,tmp_shared_id:0,shared_id:0,dir_id:'.$files[$i]['id'].',fs:'.$this->fs.'\')">'.$span.'</a></span>';
						$ret.='<ul>'.$this->get_tree($files[$i]['id'], $level).'</ul>'; // get childs
					}			
					
					$ret.='</li>';						
				}
			}		
		}	
		
	return $ret;	
	}	
					 
/*
**************************
*/
 	
	public function get_address_links()
	{	
		
	}
	
					 
/*
**************************
*/
 	
	
	public function render_address_links()
	{
		
		$separator = '<img class="arrow" 
		src="'.THEME_URL.'icons/arrow_small_right.png">';		
		
		
		if(APP_ACTION == 'my_server')
		{
			$address_start = '<a onclick="'.helper_reload(
			array(
			'dir_id' => $this->filesystem->get_root_directory_id())
			).'" 
			href="javascript:void(0);"><b>'.txt('my_server').'</b></a>';
		}
		
		if(APP_ACTION == 'clouds')
		{
			$address_start = '<a onclick="'.helper_reload(
			array(
			'cloud_id' => 0)
			).'" 
			href="javascript:void(0);"><b>'.txt('clouds_title').'</b></a>';
		}
		
		if(APP_ACTION == 'ftp')
		{
			$address_start = '<a onclick="'.helper_reload(
			array(
			'ftp_id' => 0)
			).'" 
			href="javascript:void(0);"><b>'.txt('ftp_folders').'</b></a>';
		}
						
/*.............................................. */		
	
		if(APP_ACTION == 'cp')
		{
			$address_start = '<a onclick="'.helper_reload(
			array(
			'dir_id' => $this->filesystem->get_root_directory_id())
			).'" 
			href="javascript:void(0);"><b>'.txt('control_panel').'</b></a>';
		}
					
/*.............................................. */		
		
		if(APP_ACTION == 'shared')
		{
			
			$group = new phpos_groups;
			$group_id = $this->my_app->get_param('workgroup_id');			
				
			if(!empty($group_id))
			{
				$group->set_id($group_id);
				$group->get_group();
				
				$group_user = new phpos_users;
				$id_user = $this->my_app->get_param('workgroup_user_id');
				$group_user->set_id_user($id_user);
				$group_user->get_user_by_id();				
			
				$address_start = '<a onclick="phpos.windowActionChange(\''.WIN_ID.'\', \'workgroup\', \'workgroup_id:'.$group_id.',fs:local_files\')" href="javascript:void(0);"><b>'.$group->get_title().'</b></a>'.$separator.'<a onclick="phpos.windowActionChange(\''.WIN_ID.'\', \'shared\', \'workgroup_id:'.$group_id.',workgroup_user_id:'.$id_user.',fs:local_files\')" href="javascript:void(0);"><b>'.$group_user->get_user_login().'</b></a>';
				
			} else {		
			
				$id_user = logged_id();
				$group_user = new phpos_users;				
				$group_user->set_id_user($id_user);
				$group_user->get_user_by_id();				
			
				$address_start = '<a onclick="phpos.windowActionChange(\''.WIN_ID.'\', \'shared\', \'workgroup_id:0,fs:local_files\')" href="javascript:void(0);"><b>'.$group_user->get_user_login().'</b></a>';
			}
		}
						
/*.............................................. */		
	
		if(APP_ACTION == 'workgroup')
		{		
			$group = new phpos_groups;
			$group_id = $this->my_app->get_param('workgroup_id');
			
			if(!empty($group_id))
			{			
				$group->set_id($group_id);
				$group->get_group();
				
				$address_start = '<a onclick="phpos.windowActionChange(\''.WIN_ID.'\', \'workgroup\', \'workgroup_id:'.$group_id.',fs:local_files\')" href="javascript:void(0);"><b>'.$group->get_title().'</b></a>';
				
			} else {
			
				$address_start = '<a onclick="phpos.windowActionChange(\''.WIN_ID.'\', \'workgroup\', \'workgroup_id:0,fs:local_files\')" href="javascript:void(0);"><b>Workgroups</b></a>';
			}
		}
		
		
		$address_bar = $address_start.$separator.$address;
		
/*.............................................. */		
				
			
		if(APP_ACTION == 'index')
		{
			// Load filesystem plugin address
			if(file_exists(PHPOS_DIR.'plugins/filesystems/'.$this->fs.'/explorer.address.php'))
			{
				include PHPOS_DIR.'plugins/filesystems/'.$this->fs.'/explorer.address.php';	
			}				
		}			

				
/*.............................................. */				
		
		return $address_bar;
	}
					 
/*
**************************
*/
 	
	public function root_homedir_parse($icon)
	{		
			$home_dir = $this->my_app->get_param('dir_id').'/';
			
			if(PHPOS_HOME_DIR == $home_dir)
			{
				$e = explode('_', $icon['filename']);				
				$icon['filename'] = $e[0];
			}
			
			return $icon;
	}
					 
/*
**************************
*/
 	
	public function root_homedir_address_parse($icon)
	{		
			$home_dir = dirname($icon['id']).'/';
			
			if(PHPOS_HOME_DIR == $home_dir)
			{
				$e = explode('_', $icon['filename']);				
				$icon['filename'] = $e[0];
				$icon['basename'] = $e[0];
			}
			
			return $icon;
	}
					 
/*
**************************
*/
 	
	public function get_address_url()
	{
		$address = $this->filesystem->get_address();
		
		if(!empty($_POST['address_bar']))	{
			//msg::dbg('DATA FROM ADDRESS BAR');
			//$address = $this->filesystem->api_parseAddress($_POST['address_bar']);
		}
		
		return $address;		
	}
					 
/*
**************************
*/
 	
	public function render_address_url()
	{			
		global $address_icon;
		
		if(!empty($address_icon)) 
		{
			$up_icon = $address_icon;
			
		} else {
		
			$up_icon = $this->get_icon_protocol();
		}
		
		$str.='<form class="explorer_address_form" enctype="multipart/form-data" method="post" action="'.helper_post('null', array('fs' => $this->fs)).'" id="addressbar_'.$this->window->getID().'">	
		
		<div id="explorer_address_list" 
		class="inline_show explorer_bar_mouseleave"><img 
		class="protocol_icon" 
		src="'.$up_icon.'" />
		'.$this->render_address_links().'
		</div>	
		
		
		<a href="javascript:void(0);"><img style="display:inline-block;vertical-align:top;height:25px" 
		src="'.THEME_URL.'windows/explorer_header_go.png"></a>	
		</form>';
		
		return $str;		
	}
				 
/*
**************************
*/
 	
	public function get_icon_protocol()
	{
		if(file_exists(PHPOS_DIR.'plugins/filesystems/'.$this->my_app->get_param('fs').'/resources/address_icon.png'))
		{
			return PHPOS_URL.'plugins/filesystems/'.$this->my_app->get_param('fs').'/resources/address_icon.png';
		}
		
		global $address_icon;
		$icon = MY_RESOURCES_URL.'fs_icons/default.png';
		
		if(file_exists(MY_RESOURCES_DIR.'fs_icons/'.$this->fs.'.png')) $icon = MY_RESOURCES_URL.'fs_icons/'.$this->fs.'.png';
		if(!empty($address_icon)) $icon = $address_icon;
		return $icon;
	}
					 
/*
**************************
*/
 	
	public function icons()
	{
		$footer_protocol_icon = MY_RESOURCES_URL.'protocol_default_footer.png';	
				
/*.............................................. */		
			
		if(file_exists(MY_RESOURCES_DIR.'protocol_'.strtolower($fs).'_footer.png'))
		{
			$footer_protocol_icon = MY_RESOURCES_URL.'protocol_'.strtolower($fs).'_footer.png';
		}
		
		$protocol_icon = '';	
						
/*.............................................. */		
	
		if(file_exists(MY_RESOURCES_DIR.'protocol_'.strtolower($fs).'_addressbar.png'))
		{
			$protocol_icon = MY_RESOURCES_URL.'protocol_'.strtolower($fs).'_addressbar.png';	
			
		} else {
		
			$protocol_icon = MY_RESOURCES_URL.'protocol_default_addressbar.png';	
		}
						
/*.............................................. */		
	
		
		if(file_exists(MY_RESOURCES_DIR.'bg_'.strtolower($fs).'.png'))
		{
			$fs_background = MY_RESOURCES_URL.'bg_'.strtolower($fs).'.png';	
			
		} else {
		
			$fs_background = MY_RESOURCES_URL.'bg_default.png';	
		}
	}
	
					 
/*
**************************
*/
 	
	public function render_nav_bar()
	{		
		global $my_app;
		$dir_id = $this->my_app->get_param('dir_id');	
		
		$nav = new phpos_navigation;	
		
		if($this->my_app->get_param('action_id') == null)
		{
			if(!$my_app->get_param('minus_index'))
			{
				$nav->next_index();
				$nav->add_item();
				$_SESSION['phpos_navigation_stopindex'][WIN_ID] = true;
				
			} else {
			
				$nav->set_index($my_app->get_param('set_index'));			
				$nav->add_item();
				$my_app->set_param('minus_index', null);
				$my_app->set_param('set_index', null);
				cache_param('minus_index');
				cache_param('set_index');
			}
		}
		//$nav->debug();
		
	//link_action($action, $params = null)
		
			
			//$navBar.='<img src="'.PHPOS_WEBROOT_URL.'_phpos/themes/default/windows/explorer_header_nav_back_transparent.png">';	

				
/*.............................................. */		
	
	
		if($nav->is_prev_index()) // if next
		{                            
			global $my_app;
			$index = 	$nav->get_index();
			$link_index = $index - 1;			
			
			$go_to_index = $nav->get_prev_index();
			$action = 'phpos.windowActionChange(\''.WIN_ID.'\', \''.$nav->get_action($go_to_index).'\', \''.$nav->parse_params($go_to_index).',minus_index:1,set_index:'.$link_index.'\');';			
			
			$navBar.='<a 			
			title="'.txt('navi_prev').'" 
			href="javascript:void(0);" 
			onclick="'.$action.'"><img 
			class="nav_back" 
			src="'.THEME_URL.'windows/explorer_header_nav_back.png"></a>';	
			
		} else {
			
			$navBar.='<img 
			src="'.THEME_URL.'windows/explorer_header_nav_back_transparent.png">';	
		}		
		
/*.............................................. */

		if($nav->is_next_index()) // if next
		{                            
			global $my_app;
			$index = 	$nav->get_index();
			$link_index = $index + 1;
			
			$go_to_index = $nav->get_next_index();
			$action = 'phpos.windowActionChange(\''.WIN_ID.'\', \''.$nav->get_action($go_to_index).'\', \''.$nav->parse_params($go_to_index).',minus_index:0,set_index:'.$link_index.'\');';			
			
			
			$navBar.='<a 		
			title="'.txt('navi_next').'" 
			href="javascript:void(0);" 
			onclick="'.$action.'"><img 
			class="nav_next" 
			src="'.THEME_URL.'windows/explorer_header_nav_next.png"></a>';	
			
		} else {
			
			$navBar.='<img src="'.THEME_URL.'windows/explorer_header_nav_next_transparent.png">';				
		}
		
/*.............................................. */
		
		// Navigation Level Up
		
		
		if(APP_ACTION =='index')
		{
			if($this->filesystem->have_parent($dir_id))
			{			
				$parent_dir = $this->filesystem->get_parent_dir($dir_id);		
				
				$in_shared = $this->my_app->get_param('in_shared');
				
				if(!$in_shared)
				{
					// not shared
					$navBar.='<a 					
					title="'.txt('navi_up').'" 
					href="javascript:void(0);" 
					onclick="'.helper_reload(
					array(
					'dir_id' => $parent_dir, 
					'dir_navigation_index' => $navigation['next']['index_id'])
					)
					.'"><img class="nav_top"  
					src="'.THEME_URL.'windows/explorer_header_nav_top.png"></a>';	
					
	/*.............................................. */		
		
				} else {
				
					// shared, if(not) parent shared
					$shared = new phpos_shared;			
					
					$check_dir_id = $dir_id;
					
					if(substr($check_dir_id, -1) == '/')		
					{
						$check_dir_id = substr($check_dir_id, 0, -1);
					}
							
					$check = $shared->find_shared($check_dir_id);
						
	/*.............................................. */		
					
					if($check == 0)
					{
						// can up, parent is not outside shared
						$navBar.='<a 					
						title="'.txt('tip_nav_go_to').': '.$parent_dir.'" 
						href="javascript:void(0);" 
						onclick="'.helper_reload(
						array(
						'dir_id' => $parent_dir, 
						'dir_navigation_index' => $navigation['next']['index_id'])
						)
						.'"><img 
						class="nav_top" 
						src="'.THEME_URL.'windows/explorer_header_nav_top.png" /></a>';	
					
					} else {
					
						$navBar.='<img 
						class="nav_top_inactive" 
						src="'.THEME_URL.'windows/explorer_header_nav_top_transparent.png /">';					
					}			
				}
				
			} else {
			
				switch($this->my_app->get_param('fs'))
				{
					case 'ftp':
					
						$navBar.='<a 					
							title="'.txt('tip_nav_go_to').': '.txt('ftp_folders').'" 
							href="javascript:void(0);" 
							onclick="'.link_action('ftp', 'fs:local_files, ftp_id:0').'"><img 
							class="nav_top" 
							src="'.THEME_URL.'windows/explorer_header_nav_top.png" /></a>';	
					break;
					
					case 'local_files':
					
						$navBar.='<a 					
							title="'.txt('tip_nav_go_to').': '.txt('my_server').'" 
							href="javascript:void(0);" 
							onclick="'.link_action('my_server').'"><img 
							class="nav_top" 
							src="'.THEME_URL.'windows/explorer_header_nav_top.png" /></a>';
					break;
					
					case 'db_mysql':
					
						$navBar.='<a 					
							title="'.txt('tip_nav_go_to').': '.txt('my_server').'" 
							href="javascript:void(0);" 
							onclick="'.link_action('my_server').'"><img 
							class="nav_top" 
							src="'.THEME_URL.'windows/explorer_header_nav_top.png" /></a>';
					break;
							
					default:
					
						$navBar.='<a 					
							title="'.txt('tip_nav_go_to').': '.txt('clouds_title').'" 
							href="javascript:void(0);" 
							onclick="'.link_action('clouds', 'fs:local_files, cloud_id:0').'"><img 
							class="nav_top" 
							src="'.THEME_URL.'windows/explorer_header_nav_top.png" /></a>';					
					
				}				
			}
			
		} else {
		
			// Not index
			switch(APP_ACTION)
			{
				case 'clouds':
				
						if($this->my_app->get_param('cloud_id') == null)
						{
							$navBar.='<a 					
							title="'.txt('tip_nav_go_to').': '.txt('my_server').'" 
							href="javascript:void(0);" 
							onclick="'.link_action('my_server').'"><img 
							class="nav_top" 
							src="'.THEME_URL.'windows/explorer_header_nav_top.png" /></a>';
						}
						
				break;
				
				case 'ftp':
				
						if($this->my_app->get_param('ftp_id') == null)
						{
							$navBar.='<a 					
							title="'.txt('tip_nav_go_to').': '.txt('my_server').'" 
							href="javascript:void(0);" 
							onclick="'.link_action('my_server').'"><img 
							class="nav_top" 
							src="'.THEME_URL.'windows/explorer_header_nav_top.png" /></a>';							
						} 
						
				break;
			
				case 'workgroup':
				
						if($this->my_app->get_param('workgroup_id') == null)
						{
							$navBar.='<a 					
							title="'.txt('tip_nav_go_to').': '.txt('my_server').'" 
							href="javascript:void(0);" 
							onclick="'.link_action('my_server').'"><img 
							class="nav_top" 
							src="'.THEME_URL.'windows/explorer_header_nav_top.png" /></a>';
							
						} else {							
							
							$navBar.='<a 					
								title="'.txt('tip_nav_go_to').': '.txt('workgroups').'" 
								href="javascript:void(0);" 
								onclick="'.link_action('workgroup', 'workgroup_id:0,workgroup_user_id:0').'"><img 
								class="nav_top" 
								src="'.THEME_URL.'windows/explorer_header_nav_top.png" /></a>';												
						}
						
				break;
				
				case 'shared':
				
						if($this->my_app->get_param('shared_id') == null && $this->my_app->get_param('tmp_shared_id') == null)
						{
							if($this->my_app->get_param('workgroup_user_id') == null)
							{
								$navBar.='<a 					
								title="'.txt('tip_nav_go_to').': '.txt('my_server').'" 
								href="javascript:void(0);" 
								onclick="'.link_action('my_server').'"><img 
								class="nav_top" 
								src="'.THEME_URL.'windows/explorer_header_nav_top.png" /></a>';
						
							} else {
								
								$group = new phpos_groups;
								$group->set_id($this->my_app->get_param('workgroup_id'));
								$group->get_group();
								$navBar.='<a 					
									title="'.txt('tip_nav_go_to').': '.$group->get_title().'" 
									href="javascript:void(0);" 
									onclick="'.link_action('workgroup', 'workgroup_id:'.$this->my_app->get_param('workgroup_id').',workgroup_user_id:0').'"><img 
									class="nav_top" 
									src="'.THEME_URL.'windows/explorer_header_nav_top.png" /></a>';							
							}								
						}
						
				break;

				default:
				 $navBar.='<img class="nav_top_inactive" src="'.THEME_URL.'windows/explorer_header_nav_top_transparent.png">';	
				
			}		
		}
	
		return $navBar;
	}

					 
/*
**************************
*/
 	
	public function generate_to_start_context($filesystem, $plugin_id, $link_param, $id = null)
	{
		switch($filesystem)
		{
			case 'local_files':		
			
			break;			

				
/*.............................................. */		
	
				
			case 'db_mysql':
			
				switch($plugin_id)
				{
					case 'app':					
					case 'link':
					
						$param_id = null;
						if(!empty($id)) $param_id = ',link_id:'.$id;
						$str = 'to_menustart::'.txt('to_mstart').'::'.winmodal(txt('to_mstart'), 'app', 'app_id:shortcuts@menustart,width:300,height:350','desktop:1,location:menustart,after_reload:'.WIN_ID.',link_type:app,to_menustart:1,link_param:'.$link_param.$param_id).'::myserver';			
						
					break;				
				}
				
			break;		
		}
	
		return $str;	
	}
					 
/*
**************************
*/
 	
	public function generate_to_edit_context($filesystem, $plugin_id, $link_param, $id = null)
	{
		switch($filesystem)
		{
			case 'local_files':		
			
			break;
			

				
/*.............................................. */		
	
				
			case 'db_mysql':
			
				switch($plugin_id)
				{
					case 'app':
					case 'link':
						$shortcut_action = 'app';
						if($link_param == 'webframes') $shortcut_action = 'iframe';
						if($link_param == 'mediaframes') $shortcut_action = 'medialink';
						if($plugin_id == 'link') $shortcut_action = 'link';
						
						$param_id = null;
						if(!empty($id)) $param_id = ',link_id:'.$id;
						$str = 'edit_link::'.txt('edit_shortcut').'::'.winmodal(txt('edit_shortcut'), 'app', 'app_id:shortcuts@'.$shortcut_action.',width:300,height:350','desktop:1,back:null,location:edit,after_reload:'.WIN_ID.',link_type:app,link_param:'.$link_param.$param_id).'::edit';
					
					break;				
				}
				
			break;		
		}
	
		return $str;	
	}
					 
/*
**************************
*/
 	
	public function get_explorer_icon_html($icon, $rewrite = null)
		{		
			$class = ' phpos_icon_mouseout';			
			global $my_app, $phposFS;
			/*
			if($icon['title'] == $mark_file)
			{
				$class = ' phpos_icon_mouseover';			
			}	
			*/			
			
			$icon['icon'] = $this->filesystem->get_icon($icon);
			
			if($my_app->get_param('fs') == 'db_mysql')
			{
				if($icon['content'])
				{		
					if(file_exists(PHPOS_WEBROOT_DIR.'_phpos/resources/'.$icon['app_id'].'/db_file.png')) $icon['icon'] = PHPOS_WEBROOT_URL.'_phpos/resources/'.$icon['app_id'].'/db_file.png';	
				}			
			}
				
/*.............................................. */		
				
			if(empty($icon['action'])) $icon['action'] = $this->filesystem->get_action_dblclick($icon);	

			if($my_app->get_param('api_dialog'))
			{
				if($my_app->get_param('api_dialog_type') == 'open_file')
				{				
					if(!$phposFS->is_directory($icon)) $icon['action'] = helper_reload(array('opened_file_id' => $icon['id'], 'opened_file_name' => $icon['basename'], 'opened_file_extension' => $icon['extension'], 'opened_file_app_id' => $icon['app_id']));	
					
				} else {
				
					if(!$phposFS->is_directory($icon)) $icon['action'] = "$('#explorer_api".WIN_ID." input[name=explorer_save_as_filename]').val('".$icon['filename']."');";
				}
			}
					
/*.............................................. */		
			
			$display = 'display:inline-block';
			
			if(defined('IN_DESKTOP'))
			{
				$display = '';
			}
			
			$shared = '';
			if($icon['is_shared']) $shared = '<br/><span style="color:white; font-size: 9px; padding:2px; background-color:#2e1953">'.txt('shortcuts_icon_explorer_shared').'</span>';
			
				
/*.............................................. */		
		
			$ext = '';
			if($my_app->get_param('show_extensions') == '1' && ($my_app->get_param('fs') == 'local_files' || $my_app->get_param('fs') == 'ftp')) $ext = '.'.$icon['extension'];
			
			if($rewrite === null)
			{			
				// $icon_data = '<div title="'.$icon['id'].', file_id:'.$icon['file_id'].'" class="easyui-tooltip phpos_icon '.$class.'"  
			$icon_data = '<div title="'.$icon['filename'].'" class="phpos_icon '.$class.'"    style="'.$display.'" id="'.$icon['div'].'">
					<a href="javascript:void(0)" ondblclick="'.$icon['action'].'">
					<img src="'.$icon['icon'].'" />
					<br />'.wordwrap(string_cut($icon['filename'],25), 15, " ", 1).$ext.$shared.'
					</a><br>'.$icon['file_id'].'
				</div>';		
				
			} else {
				$url = $icon['id'];
				if($my_app->get_param('fs') == 'local_files') $url = str_replace(PHPOS_WEBROOT_DIR, '', $icon['id']);
				$shortname = wordwrap($icon['filename'], 15, " ", 1).$ext;
				$icon_data = str_replace(array('%url%', '%id%', '%div%', '%class%', '%style%', '%action%', '%icon%', '%fullname%', '%shortname%'), array($url, $icon['id'], $icon['div'], $class, $display, $icon['action'], $icon['icon'], $icon['filename'], $shortname), $rewrite);
				
			}
				
				/*
				$icon_data = '<div title="basename:'.$icon['basename'].' dirname: '.$icon['dirname'].'" class="easyui-tooltip phpos_icon '.$class.'"  style="'.$display.'" id="'.$icon['div'].'">
					<a href="javascript:void(0)" ondblclick="'.$icon['action'].'">
					<img src="'.$icon['icon'].'" title="'.$icon['id'].'">
					<br />'.$shared.wordwrap($icon['filename'], 15, " ", 1).'
					</a>
				</div>';			
			*/

				
/*.............................................. */		
	
				
			// Generate HTML code to render icon			
			$html_RenderIcons='
			<div id="m'.$icon['div'].'" style="display:inline-block" class="'.$this->config['icon_size_class'].'">
				'.$icon_data.'
			</div>';	
			
			if(defined('IN_DESKTOP'))
			{
				$html_RenderIcons=$icon_data;
			}		
			
			return $html_RenderIcons;
		}
				 
/*
**************************
*/
 	
		public function get_explorer_icon_list_html($icon, $rewrite = null)
		{		
			$class = ' phpos_icon_mouseout';			
			global $my_app, $phposFS;
			/*
			if($icon['title'] == $mark_file)
			{
				$class = ' phpos_icon_mouseover';			
			}	
			*/			
			
			$ext = '';
			if($my_app->get_param('show_extensions') == '1' && ($my_app->get_param('fs') == 'local_files' || $my_app->get_param('fs') == 'ftp')) $ext = '.'.$icon['extension'];
			
			$icon['icon'] = $this->filesystem->get_icon($icon);
			
			if($my_app->get_param('fs') == 'db_mysql')
			{
				if($icon['content'])
				{		
					if(file_exists(PHPOS_WEBROOT_DIR.'_phpos/resources/'.$icon['app_id'].'/db_file.png')) $icon['icon'] = PHPOS_WEBROOT_URL.'_phpos/resources/'.$icon['app_id'].'/db_file.png';	
				}			
			}
				
/*.............................................. */		
				
			if(empty($icon['action'])) $icon['action'] = $this->filesystem->get_action_dblclick($icon);	

			if($my_app->get_param('api_dialog'))
			{
				if($my_app->get_param('api_dialog_type') == 'open_file')
				{				
					if(!$phposFS->is_directory($icon)) $icon['action'] = helper_reload(array('opened_file_id' => $icon['id'], 'opened_file_name' => $icon['basename'], 'opened_file_extension' => $icon['extension'], 'opened_file_app_id' => $icon['app_id']));	
					
				} else {
				
					if(!$phposFS->is_directory($icon)) $icon['action'] = "$('#explorer_api".WIN_ID." input[name=explorer_save_as_filename]').val('".$icon['filename']."');";
				}
			}
					
/*.............................................. */		
			
			$display = 'display:inline-block';
			
			if(defined('IN_DESKTOP'))
			{
				$display = '';
			}
			
			$shared = '';
			if($icon['is_shared']) $shared = '<br/><span style="color:white; font-size: 9px; padding:2px; background-color:#2e1953">'.txt('shortcuts_icon_explorer_shared').'</span>';
			
				
/*.............................................. */		
		
			
			if($rewrite === null)
			{			
				// $icon_data = '<div title="'.$icon['id'].', file_id:'.$icon['file_id'].'" class="easyui-tooltip phpos_icon '.$class.'"  
			/*
			$icon_data = '<div title="'.$icon['id'].', file_id:'.$icon['file_id'].'" class="phpos_icon '.$class.'"  style="'.$display.'" id="'.$icon['div'].'">
					<a href="javascript:void(0)" ondblclick="'.$icon['action'].'">
					<img src="'.$icon['icon'].'" />
					<br />'.wordwrap(string_cut($icon['filename'],25), 15, " ", 1).$shared.'
					</a>
				</div>';	
			*/
			
						
			
			$icon_data = '
			<td style="width:10px"><input value="'.base64_encode($icon['id']).'" type="checkbox" id="phpos_list_checkbox_'.WIN_ID.'_'.$icon['index'].'"></td>
			<td style="width:10px"><img src="'.$icon['icon'].'" style="width:20px"/></td>
			<td style="width:60%"><div id="'.$icon['div'].'"><a href="javascript:void(0)" onclick="'.$icon['action'].'">'.wordwrap(string_cut($icon['filename'],25), 15, " ", 1).$ext.'</a></div></td>
			<td style="width:10%">'.$icon['extension'].'</td>
			<td style="width:10%">'.filesizes($icon['size']).'</td>
			<td style="width:20%">'.$icon['modified_at'].'</td>';
		
					
				
			} else {
				$url = $icon['id'];
				if($my_app->get_param('fs') == 'local_files') $url = str_replace(PHPOS_WEBROOT_DIR, '', $icon['id']);
				$shortname = wordwrap($icon['filename'], 15, " ", 1);
				$icon_data = str_replace(array('%url%', '%id%', '%div%', '%class%', '%style%', '%action%', '%icon%', '%fullname%', '%shortname%'), array($url, $icon['id'], $icon['div'], $class, $display, $icon['action'], $icon['icon'], $icon['filename'], $shortname), $rewrite);
				
			}
				
				/*
				$icon_data = '<div title="basename:'.$icon['basename'].' dirname: '.$icon['dirname'].'" class="easyui-tooltip phpos_icon '.$class.'"  style="'.$display.'" id="'.$icon['div'].'">
					<a href="javascript:void(0)" ondblclick="'.$icon['action'].'">
					<img src="'.$icon['icon'].'" title="'.$icon['id'].'">
					<br />'.$shared.wordwrap($icon['filename'], 15, " ", 1).'
					</a>
				</div>';			
			*/

				
/*.............................................. */		
			$tr_class = 'tr1';
			if($icon['index']%2 == 0) $tr_class = 'tr2';
				
			// Generate HTML code to render icon			
			$html_RenderIcons='<tr phpos_index="'.$icon['index'].'" class="'.$tr_class.'">			
				'.$icon_data.'			
			</tr>';	
			
			if(defined('IN_DESKTOP'))
			{
				$html_RenderIcons=$icon_data;
			}		
			
			return $html_RenderIcons;
		}
				 
/*
**************************
*/

	public function get_explorer_icon_jquery($icon)
		{		
			$attr=".attr('myID','".$icon['id']."')"; // set id attribute for drag&drop actions
			$middle_click='';
			$droppable='';
			$draggable='';
			
			$phposFS = glb::get('phposFS');
			$apiWindow = glb::get('apiWindow');
			
				
/*.............................................. */		
	
				
			// If it's dir:
			if($phposFS->api_isDir($icon))
			{
				$middle_click=".mousedown(function(event) {	if(event.which==2) { phpos.windowCreate('".$icon['name']."', 'explorer', 'app_id:explorer@index, parent_id:".$apiWindow->getID()."', 'fs:LocalFiles,dir_id:".$phposFS->addLastSlash($icon['id'])."'); }	})";
						
				// Droppable action for dir	
				$droppable=".droppable({
					onDragEnter:function(e,source){
							$(source).draggable('options').cursor='auto';
							$(this).addClass('phpos_icon_mouseclick');	// check class
					},
					onDragLeave:function(e,source){
							$(source).draggable('options').cursor='not-allowed';
							$(this).removeClass('phpos_icon_mouseclick');	
					},
					onDrop:function(e,source){						
							$(this).addClass('phpos_icon_mouseclick');							
							phpos.windowRefresh('".$apiWindow->getID()."','action_MoveFile_ID:'+$(source).attr('myid')+',action_MoveFile_ToDirID:'+$(this).attr('myID'));
					}
				})
				";		
			
			} 	
		

				
/*.............................................. */		
	
				
			// Draggable action for all
				$draggable=".draggable({
					revert:true,	
					proxy: 'clone',		
					onStartDrag:function(){					
							$(this).draggable('options').cursor = 'not-allowed';
							$(this).draggable('proxy').css('z-index',10);
					},
					onStopDrag:function(){					
							$(this).draggable('options').cursor='move';					
					}
				})
				";	
			

				
/*.............................................. */		
	
				
			// Generate jQuery code to assign CSS classes to icon and assign actions
			if(defined('IN_DESKTOP'))
			{
					// okaddClass('icon_out').addClass('icon_size_desktop');
					$jquery_GenerateIconsActions= "$('#".$icon['div']."').addClass('icon_out').addClass('icon_size_desktop')".$middle_click.$droppable.$attr.$draggable.";
			";	
			
			} else {
				$jquery_GenerateIconsActions= "$('#".$icon['div']."').addClass('phpos_icon_mouseout').addClass('".$this->config['icon_size_class']."')".$middle_click.$droppable.$attr.$draggable.";
			";	
			
			}
		
			
			return $jquery_GenerateIconsActions;
			
		}	

}
?>