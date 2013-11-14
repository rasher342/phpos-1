<?php
/*
**********************************

	PHPOS Web Operating system
	MIT License
	(c) 2013 Marcin Szczyglinski
	szczyglis83@gmail.com
	GitHUB: https://github.com/phpos/
	File version: 1.3.5, 2013.11.07
 
**********************************
*/
if(!defined('PHPOS'))	die();	

class console 
{
	public static function cut_tags($str)
	{
		return str_replace(array("<", ">"), array("&lt;", "&gt;"), $str);
	}
	
	
	
	public static function log($str = null, $type = null)
	{
		$demo = null;
		if(globalconfig('demo_mode') == 1 && !is_root() && !is_admin())	$demo = 1;
		
		
		$ajax = '';
		if(isset($_GET['ajax_file'])) $ajax = ' <span class="console_ajax">[AJAX]</span> ';
		if(!is_array($_SESSION['console_log'])) $_SESSION['console_log'] = array();		
		
		if(!$demo)
		{
			if(defined('WIN_ID')) $info['win_id'] = '<span class="console_winid">['.WIN_ID.']</span>';		
			if(defined('APP_ID')) $info['app_id'] = '<span class="console_appname">['.APP_ID.'</span>';
			if(defined('APP_ACTION')) $info['app_action'] = '<span class="console_appaction"> '.APP_ACTION.']</span>';
			$info['time'] = '<span class="console_time">'.date('H:i:s', time()).'</span>'.$ajax;
			
		} else {
		
			if(defined('WIN_ID')) $info['win_id'] = '<span class="console_winid">[demo]</span>';		
			if(defined('APP_ID')) $info['app_id'] = '<span class="console_appname">[demo</span>';
			if(defined('APP_ACTION')) $info['app_action'] = '<span class="console_appaction"> demo]</span>';
			$info['time'] = '<span class="console_time">'.date('H:i:s', time()).'</span>'.$ajax;
		}
		
		if(!empty($str))
		{
			if(is_array($str))
			{
				$tmp_str = $str;
				$c = count($tmp_str);
				
				$str = '';
			
				if($c > 1) $str = '<div class="console_block">';	
				
				$counter = 0;
				foreach($tmp_str as $key => $val)
				{
					$counter++;
					
					if($demo) 
					{
						$key = 'demo';
						$val = 'demo';
					}
					
					$str.='<span class="console_key">'.self::cut_tags($key).'</span> <span class="console_arrows">&gt;&gt;</span> <span class="console_val">'.self::cut_tags($val).'</span>';	
					if($c != $counter) $str.= '<br />';					
				}
				
				if($c > 1) $str.= '</div>';
				$str.= '<div class="console_separator"></div>';
				
			}	elseif($str != '-') {
			
				$str.= '<div class="console_separator"></div>';
			}
			
			if($str != '-')		
			{				
				//$str = self::cut_tags($str);
				if($type == null)
				{
					$_SESSION['console_log'][] = $info['time']." ".$info['win_id']." ".$info['app_id'].$info['app_action']." ".$str;
					
				} elseif($type == 'ok') {
				
					$_SESSION['console_log'][] = $info['time']." ".$info['win_id']." ".$info['app_id'].$info['app_action']." <span class=\"console_status_ok\"> <b>[OK]</b> ".$str."</span>";
					
				} elseif($type == 'error') {
				
					$_SESSION['console_log'][] = $info['time']." ".$info['win_id']." ".$info['app_id'].$info['app_action']." <span class=\"console_status_err\">  <b>[ERROR]</b> ".$str."</span>";				
				}
				
			} else {
			
				$_SESSION['console_log'][] = '<br />';
			}
			
		} else {
			$_SESSION['console_log'][] = '<div class="console_line"><span class="console_arrows ">@window.render</span></div>';
		}
	}
	
	public static function log_params($winObject)
	{
		/*
		
		$demo = null;
		if(globalconfig('demo_mode') == 1 && !is_root() && !is_admin())	$demo = 1;
		
		$params = $winObject->get_appParams();
		$c = count($params);
		$params_data = '';
		
		if($c != 0)
		{
			$ajax = '';
			if(isset($_GET['ajax_file'])) $ajax = ' <span class="console_ajax">[AJAX]</span> ';
			if(!is_array($_SESSION['console_log_params'])) $_SESSION['console_log_params'] = array();		
			
			if(!$demo)
			{
				if(defined('WIN_ID')) $info['win_id'] = '<span class="console_winid">['.WIN_ID.']</span>';		
				if(defined('APP_ID')) $info['app_id'] = '<span class="console_appname">['.APP_ID.'</span>';
				if(defined('APP_ACTION')) $info['app_action'] = '<span class="console_appaction"> '.APP_ACTION.']</span>';
				$info['time'] = '<span class="console_time">'.date('H:i:s', time()).'</span>'.$ajax;
				
			} else {
			
				if(defined('WIN_ID')) $info['win_id'] = '<span class="console_winid">[demo]</span>';		
				if(defined('APP_ID')) $info['app_id'] = '<span class="console_appname">[demo</span>';
				if(defined('APP_ACTION')) $info['app_action'] = '<span class="console_appaction"> demo]</span>';
				$info['time'] = '<span class="console_time">'.date('H:i:s', time()).'</span>'.$ajax;
			}
		
			$this_index = count($_SESSION['console_log_params']);
		
			$params_data.= '<a href="javascript:void(0)" onclick="phpos.console_show_params_body('.$this_index.')">'.$info['time'].' '.$info['win_id'].' '.$info['app_id'].$info['app_action'].'</a><div class="console_separator"></div><div id="console_params_'.$this_index.'" class="console_params_items"> '.$info['time'].' '.$info['win_id'].' '.$info['app_id'].$info['app_action'].'<div class="console_separator"></div>';
			
			foreach($params as $k => $v)
			{
				if($v == null) $v = 'null';
				
				if($demo) 
				{
					$k = 'demo';
					$v = 'demo';
				}
				
				$params_data.= '<span class="console_key">'.self::cut_tags($k).'</span> <span class="console_arrows ">&gt;&gt;</span> <span class="console_val">'.self::cut_tags($v).'</span><div class="console_separator"></div>';		
			}	
			
			$params_data.='</div>';
			
			$_SESSION['console_log_params'][] = $params_data;
		}
		
		*/
	}
	
	
	
	
	public static function show($winObject)
	{
		global $my_app;
		//return false;
		$demo = null;
		if(globalconfig('demo_mode') == 1 && !is_root() && !is_admin())	$demo = 1;
		
		$max_events = 100;
		$max_params = 10;
		
		$counter_events_this = 0;
		$counter_params_this = 0;
		
		
		if(is_array($_SESSION['console_log']))
		{
			$a = array_reverse($_SESSION['console_log']);
			$c_events = count($a);
			$b = array();
			for($i=0; $i<$c_events; $i++)
			{				
				if($i == 0) $counter_events_this++;			
				if($i < $max_events) 
				{
					$prefix = '';
					if($a[$i] != '<br />' && $a[$i] != '<div class="console_line"><span class="console_arrows ">@window.render</span></div>')
					{
						$prefix = '<span class="console_index"># '.$counter_events_this.'</span> ';
						$counter_events_this++;
						
					} else {
						
						$max_events++;
					}
					
					$data.= $prefix.$a[$i];
					$b[$i] = $a[$i];
				}
			}	
			
			$r = array_reverse($b);
			$_SESSION['console_log'] = $r;			
			
		}
		
		if(is_array($_SESSION['console_log_params']))
		{
			$a = array_reverse($_SESSION['console_log_params']);
			$c_params = count($a);
			$b = array();
			for($i=0; $i<$c_params; $i++)
			{				 
				if($i == 0) $counter_params_this++;	
				if($i < $max_params) 
				{
					$prefix = '';
					if($a[$i] != '<br />' && $a[$i] != '<div class="console_line"><span class="console_arrows">-------</span></div>')
					{
						$prefix = '<span class="console_index"># '.$counter_params_this.'</span> ';
						$counter_params_this++;
						
					} else {
						
						$max_params++;
					}
					
					$data_params.= $prefix.$a[$i];
					$b[$i] = $a[$i];
				}
			}
			
			$r = array_reverse($b);
			$_SESSION['console_log_params'] = $r;			
		}	
		
		
		$clipboard = new phpos_clipboard;
		$data_clipboard = $clipboard->debug_console();			
		
		if($demo) $data_clipboard = 'This feature is hidden in demo mode';
		
		if($my_app->get_param('api_dialog') != 1 && !defined('IN_AJAX'))
		{
			echo "<script>	
		
			
			new_events = '".$data."';
			/*
		new_params = '".strip_tags($data_params)."';			
			*/
			
			$(\"#phpos_console_data\").html(new_events);		
			$(\"#phpos_console_clipboard\").html('".$data_clipboard."');
			//$(\"#phpos_console_params_list\").html(new_params);		
			
			
			</script>";	
		}		
	}
	
	public static function inline($str, $type = null)
	{
		$data = "<b>".date('H:i:s', time())."</b>: ".self::cut_tags($str)."' + '<br />";
		
		echo "<script>
		$(document).ready(function() {
		var html = $('#phpos_console_data').html();
		//alert(html);
		var new_data = '".$data."' + html;
		$('#phpos_console_data').html(new_data);
		});
		</script>";		
	}
	
	public static function clear($witch)
	{		
		switch($witch)
		{
			case 'events':
				unset($_SESSION['console_log']);
				$_SESSION['console_log_counter'] = 0;
			break;
			
			case 'params':
				unset($_SESSION['console_log_params']);
				$_SESSION['console_log_params_counter'] = 0;
			break;
		
		
		}
	}

}
?>