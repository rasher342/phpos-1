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


if(APP_ACTION == 'my_server')
{
		$address_icon = ICONS.'server/bg.png';
		$tmp_html = '';	
		$html['icons'] = '';
		foreach($server_plugins as $plugin)
		{
			if(file_exists(PHPOS_DIR.'plugins/my_server/server.'.$plugin)) 
			{				
				$tmp_html = '';					
				include(PHPOS_DIR.'plugins/my_server/server.'.$plugin);				
				$html['icons'].= $layout->area_start($server_item_title).$tmp_html.$layout->area_end();
			}
		}
		
		$tmp_html = '';	
}

?>