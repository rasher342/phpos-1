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


if(APP_ACTION == 'cp')
	{
		$cp = new phpos_app;				
		$cp_array = $cp->cp_list();	
		$title = '<img src="'.ICONS.'server/cp.png'.'" style="width:30px; display:inline-block; vertical-align:middle" />  '.txt('control_panel');
		
		
		$html['icons'].= $layout->area_start($title);
		$html['icons'].= $layout->txtdesc(txt('control_panel_desc'));
		
		$html['right_items_title'] = txt('control_panel');
		$html['right_items_desc'] = txt('control_panel_right_desc');
		$html['right_items_img'] = 'cp.png';
		
		
		foreach($cp_array as $cp_app)
		{
			foreach($cp_app as $item)
			{			
				
				
				$cp->set_app_id($item['app_id']);
				$cp->load_config();
				$tmp_app_action = '';
			
				
				if(!empty($item['id'])) $tmp_app_action = '@'.$item['id'];
				$cp_access = $item['access_level'];
				
				if($my_app->user_check_access($cp_access))
				{			
					$html['icons'].='<div title="'.$item['title'].' - '.$item['desc'].'" class="phpos_server_icon"><a href="javascript:void(0);" ondblclick="'.winopen($item['app_title'], 'cp', 'app_id:'.$item['app_id'].$tmp_app_action.'').'"><img src="'.$cp->get_icon('cp', $item['icon']).'" /></a><p><b>'.$item['title'].'</b><br />'.$item['desc'].'<br /><span class="desc">'.$item['app_title'].'</span></p></div>';
				}
			
			
			}
		}	
		$html['icons'].= $layout->area_end();
	}

?>