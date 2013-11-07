<?php
/*
**********************************

	PHPOS Web Operating system
	MIT License
	(c) 2013 Marcin Szczyglinski
	szczyglis83@gmail.com
	GitHUB: https://github.com/phpos/
	File version: 1.3.3, 2013.11.06
 
**********************************
*/
if(!defined('PHPOS'))	die();	

class console 
{
	public static function log($str = null, $type = null)
	{
		
		$ajax = '';
		if(isset($_GET['ajax_file'])) $ajax = ' <span class="console_ajax">[AJAX]</span> ';
		if(!is_array($_SESSION['console_log'])) $_SESSION['console_log'] = array();		
		
		if(defined('WIN_ID')) $info['win_id'] = '<span class="console_winid">['.WIN_ID.']</span>';		
		if(defined('APP_ID')) $info['app_id'] = '<span class="console_appname">['.APP_ID.'</span>';
		if(defined('APP_ACTION')) $info['app_action'] = '<span class="console_appaction"> '.APP_ACTION.']</span>';
		$info['time'] = '<span class="console_time">'.date('H:i:s', time()).'</span>'.$ajax;
		
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
					$str.='<span class="console_key">'.htmlspecialchars($key).'</span> <span class="console_arrows ">&gt;&gt;</span> <span class="console_val">'.htmlspecialchars($val).'</span>';	
					if($c != $counter) $str.= '<br />';					
				}
				
				if($c > 1) $str.= '</div>';
				$str.= '<div class="console_separator"></div>';
				
			}	elseif($str != '-') {
			
				$str.= '<div class="console_separator"></div>';
			}
			
			if($str != '-')		
			{				
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
		$params = $winObject->get_appParams();
		$c = count($params);
		$params_data = '';
		
		if($c != 0)
		{
			$ajax = '';
			if(isset($_GET['ajax_file'])) $ajax = ' <span class="console_ajax">[AJAX]</span> ';
			if(!is_array($_SESSION['console_log_params'])) $_SESSION['console_log_params'] = array();		
			
			if(defined('WIN_ID')) $info['win_id'] = '<span class="console_winid">['.WIN_ID.']</span>';		
			if(defined('APP_ID')) $info['app_id'] = '<span class="console_appname">['.APP_ID.'</span>';
			if(defined('APP_ACTION')) $info['app_action'] = '<span class="console_appaction"> '.APP_ACTION.']</span>';
			$info['time'] = '<span class="console_time">'.date('H:i:s', time()).'</span>'.$ajax;
		
		
			$params_data.= $info['time']." ".$info['win_id']." ".$info['app_id'].$info['app_action'].'<div class="console_separator"></div>';
			
			foreach($params as $k => $v)
			{
				if($v == null) $v = 'null';
				$params_data.= '<span class="console_key">'.$k.'</span> <span class="console_arrows ">&gt;&gt;</span> <span class="console_val">'.htmlspecialchars($v).'</span><div class="console_separator"></div>';		
			}	
			
			$params_data.='<div class="console_line"><span class="console_arrows ">-------</span></div>';
			
			$_SESSION['console_log_params'][] = $params_data;
		}
	}
	
	
	public static function show($winObject)
	{
				
		if(is_array($_SESSION['console_log']))
		{
			$a = array_reverse($_SESSION['console_log']);
			$c_events = count($a);
			for($i=0; $i<$c_events; $i++)
			{
				if($i < 20) $data.= $a[$i];
			}	
			unset($_SESSION['console_log']);
		}
		
		if(is_array($_SESSION['console_log_params']))
		{
			$a = array_reverse($_SESSION['console_log_params']);
			$c_params = count($a);
			for($i=0; $i<$c_params; $i++)
			{
				if($i < 20) $data_params.= $a[$i];
			}	
			unset($_SESSION['console_log_params']);
		}
		
		$clipboard = new phpos_clipboard;
		$data_clipboard = $clipboard->debug_console();	
		
		
		echo "<script>
		var html_data = $('#phpos_console_data').html();
		var html_params = $('#phpos_console_params').html();
		";		
		
		if($c_params > 20)
		{
			echo "
			html_params = '';
			";
		}
		if($c_events > 20)
		{
			echo "
			html_data = '';
			";
		}
		
		echo "
		var new_data = '".$data."' + html_data;
		var new_params = '".$data_params."' + html_params;
		
		$('#phpos_console_data').html(new_data);		
		$('#phpos_console_clipboard').html('".$data_clipboard."');
		$('#phpos_console_params').html(new_params);
		
		</script>";		
	}
	
	public static function inline($str, $type = null)
	{
		$data = "<b>".date('H:i:s', time())."</b>: ".$str."' + '<br />";
		
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
			break;
			
			case 'params':
				unset($_SESSION['console_log_params']);
			break;
		
		
		}
	}

}
?>