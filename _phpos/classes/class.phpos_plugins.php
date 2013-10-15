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


	class phpos_plugins {
	
		private
			$plugins_data = array(),
			$plugins_extensions = array(),
			$plugins_dir;
			
			 
/*
**************************
*/
 			
		public function __construct()
		{
			$this->plugins_dir = PHPOS_DIR.'plugins/extensions/';	
		
		}	
				 
/*
**************************
*/
 	
		public function load_plugin_data($plugin, $icon = null)
		{
			$plugin_file = $this->plugins_dir.'ext.'.$plugin.'.php';
			if(file_exists($plugin_file))
			{
				define('extPlugin', true);
				include $plugin_file;
				$this->plugins_data[$plugin] = array();
				$this->plugins_data[$plugin]['name'] = $extPlugin;
				$this->plugins_data[$plugin]['extensions'] = $extPluginTypes;
				$this->plugins_data[$plugin]['open'] = $extPluginOnOpen;
				$this->plugins_data[$plugin]['open_with'] = $extPluginOpenWith;
				$this->plugins_data[$plugin]['context_menu'] = $extPluginContextMenu;
				$this->plugins_data[$plugin]['render_rewrite'] = $extPluginRenderRewrite;
				
				
				$this->plugins_extensions[$plugin] = $extPluginTypes;
			}	
		}
				 
/*
**************************
*/
 	
		public function get_my_plugin($icon)
		{
			$my_extension = $icon['extension'];
			if(is_array($icon) && is_array($this->plugins_extensions))
			{
				$c = count($this->plugins_extensions);
				if($c != 0)
				{
					foreach($this->plugins_extensions as $plugin_name => $plugin_extensions)
					{
						if(is_array($plugin_extensions))
						{
							if(in_array($my_extension, $plugin_extensions)) return $plugin_name;
						}
					}				
				}			
			}		
		}
			 
/*
**************************
*/
 		
		public function get_plugin($plugin_name)
		{
			return $this->plugins_data[$plugin_name];
		}
				 
/*
**************************
*/
 	
		public function load_plugins()
		{
			$dir = glob($this->plugins_dir.'ext.*.php');
			
			foreach($dir as $file)
			{
				$plugin_name = str_replace(array('ext.', '.php'), array('', ''), basename($file));
				$this->load_plugin_data($plugin_name);			
			}
		
		
		}		
	}

?>