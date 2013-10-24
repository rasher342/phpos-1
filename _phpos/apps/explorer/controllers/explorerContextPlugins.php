<?php
/*
**********************************

	PHPOS Web Operating system
	MIT License
	(c) 2013 Marcin Szczyglinski
	szczyglis83@gmail.com
	GitHUB: https://github.com/phpos/
	File version: 1.2.6, 2013.10.16
 
**********************************
*/
if(!defined('PHPOS'))	die();	

if(!defined("PHPOS_IN_EXPLORER"))
{
	die();
}
	if(!empty($my_plugin) && !$phposFS->is_directory($icons[$i]))
	{
		$plugin->load_plugin_data($my_plugin, $icons[$i]);
		$plugindata = $plugin->get_plugin($my_plugin);
		
		// Plugin contextmenu
		if(is_array($plugindata['context_menu']) && is_array($my_context_menu)) $plugged_context_menu = array_merge($my_context_menu, $plugindata['context_menu']);
		
		// Plugin onopen
		if(!empty($plugindata['open'])) 
		{
			$plugged_context_menu[0] = 'open_plugged::'.txt('open').'::'.$plugindata['open'].'::folder_open';
			$icons[$i]['action'] = str_replace('"', '\'', $plugindata['open']);
		}
		
		// Plugin on_open
		$context_on_open = $plugged_context_menu[3];
		$plugged_on_open = $context_on_open;
		
		if(is_array($plugindata['open_with']) && is_array($context_on_open))
		{
			$plugged_on_open = array_merge($context_on_open, $plugindata['open_with']);
			$plugged_context_menu[3] = $plugged_on_open;				
		}		
	}
	
	
	switch($my_app->get_param('view_type'))
	{
		case 'icons':
		
			if(!empty($my_plugin) && !empty($plugindata['render_rewrite']))
			{
				$html['icons'].= $explorer->get_explorer_icon_html($icons[$i], $plugindata['render_rewrite']); 
				
			} else {
			
				$html['icons'].= $explorer->get_explorer_icon_html($icons[$i]);
			}	
			
		break;
		
		case 'list':
			$html['icons'].= $explorer->get_explorer_icon_list_html($icons[$i]);
		break;
		
		case 'thumbs':
			$html['icons'].= $explorer->get_explorer_icon_html($icons[$i]);
		break;
	}	
		
		
?>