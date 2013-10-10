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


class glb
{
    static public function set($name, $value)
    {
        $GLOBALS[$name] = $value;
    }

    static public function get($name)
    {
        return $GLOBALS[$name];
    }

}

	 
/*
**************************
*/
 	

class msg
{

	static public function ok($message = null)
	{
		if(empty($message))
		{
			$message = txt('msg_success');
		}
		
		$phposHELPERS = glb::get('phposHELPERS');
		$phposHELPERS['messages'][] = array('text' => $message, 'type' => 'success');
		glb::set('phposHELPERS', $phposHELPERS);
	}
		 
/*
**************************
*/
 	
	static public function error($message = null)
	{
		if(empty($message))
		{
			$message = txt('msg_error');
		}
		
		$phposHELPERS = glb::get('phposHELPERS');
		$phposHELPERS['messages'][] = array('text' => $message, 'type' => 'error');
		glb::set('phposHELPERS', $phposHELPERS);
	}
		 
/*
**************************
*/
 	
	static public function info($message)
	{
		$phposHELPERS = glb::get('phposHELPERS');
		$phposHELPERS['messages'][] = array('text' => $message, 'type' => 'info');
		glb::set('phposHELPERS', $phposHELPERS);
	}
		 
/*
**************************
*/
 	
	static public function updater($message)
	{
		$phposHELPERS = glb::get('phposHELPERS');
		$phposHELPERS['messages'][] = array('text' => $message, 'type' => 'updater');
		glb::set('phposHELPERS', $phposHELPERS);
	}
	
	
	static public function messenger($message)
	{
		$phposHELPERS = glb::get('phposHELPERS');
		$phposHELPERS['messages'][] = array('text' => $message, 'type' => 'msg');
		glb::set('phposHELPERS', $phposHELPERS);
	}
			 
/*
**************************
*/
 	
	static public function dbg($message)
	{
		$phposHELPERS = glb::get('phposHELPERS');
		$phposHELPERS['messages'][] = array('text' => $message, 'type' => 'dbg');
		glb::set('phposHELPERS', $phposHELPERS);
	}
		 
/*
**************************
*/
 	
	static public function showMessages($nohide=null)
	{
		$phposHELPERS = glb::get('phposHELPERS');
		$messages = $phposHELPERS['messages'];
		$c = count($messages);
		
		$j['dbg'] = 1;
		$j['ok'] = 1;
		$j['error'] = 1;
		$j['info'] = 1;
			
		for($i=0; $i < $c; $i++)
		{			
			switch($messages[$i]['type'])
			{				
				case 'dbg':
					$messages_dbg[] = $j['dbg'].') '.$messages[$i]['text'];	
					$j['dbg']++;
				break;			
				
				
				case 'success':
					$messages_ok[] = $j['ok'].') '.$messages[$i]['text'];	
					$j['ok']++;
				break;
				
				
				case 'error':
					$messages_error[] = $j['error'].') '.$messages[$i]['text'];	
					$j['error']++;
				break;
				
				case 'msg':
					$messages_msg[] = $messages[$i]['text'];	
					$j['msg']++;
				break;
				
				case 'updater':
					$messages_updater[] = $messages[$i]['text'];	
					$j['updater']++;
				break;
				
				
				case 'info':
					$messages_info[] = $j['info'].') '.$messages[$i]['text'];	
					$j['info']++;					
				break;		
			}	
		}
		$msg = '';
		$timeout = 4000;	
		$timeout_counter = 0;
		$overlay = 'false';
		$showtime = 4000;
		$width = 300;
		
		if($_SESSION['DEBUG'])
		{
			if(is_array($messages_dbg))
			{
				$show_dbg = '9000';
				$autohide = 'false';
				if($nohide)
				{
					$autohide = 'false';
				}
				
				$msg.= " var msg = setTimeout(function() { jError(
				'<b>PHPOS DEBUGGER:</b><br />".implode(".<br />", $messages_dbg)."',
				{
					autoHide : ".$autohide.", 
					clickOverlay : false,
					MinWidth : ".$width.",
					TimeShown : ".$show_dbg.",
					ShowTimeEffect : 1000,
					HideTimeEffect : 600,
					LongTrip :20,
					HorizontalPosition : 'right',
					VerticalPosition : 'bottom',
					ShowOverlay : ".$overlay."
				}); }, ".$timeout_counter.");
				";
			
				$timeout_counter+=$timeout;
			}	
		}
		
		
		if(is_array($messages_error))
		{
			$msg.= "   var msg = setTimeout(function() { jError(
			'<b>".txt('msg_error').":</b><br />".implode(".<br />", $messages_error)."',
			{
				autoHide : true, 
				clickOverlay : false,
				MinWidth : ".$width.",
				TimeShown : ".$showtime.",
				ShowTimeEffect : 1000,
				HideTimeEffect : 600,
				LongTrip :20,
				HorizontalPosition : 'right',
				VerticalPosition : 'bottom',
				ShowOverlay : ".$overlay."
			}); }, ".$timeout_counter.");
			";
		
			$timeout_counter+=$timeout;
		}
		
		
		if(is_array($messages_ok))
		{
			$msg.= "   var msg = setTimeout(function() { jSuccess(
			'<b>".txt('msg_success').":</b><br />".implode(".<br />", $messages_ok)."',
			{
				autoHide : true, 
				clickOverlay : false,
				MinWidth : ".$width.",
				TimeShown : ".$showtime.",
				ShowTimeEffect : 1000,
				HideTimeEffect : 600,
				LongTrip :20,
				HorizontalPosition : 'right',
				VerticalPosition : 'bottom',
				ShowOverlay : ".$overlay."
			}); }, ".$timeout_counter.");
			";
		
			$timeout_counter+=$timeout;
		}
		
		if(is_array($messages_updater))
		{
			$msg.= "   var msg = setTimeout(function() { jNotify(
			'<b>Online update:</b><br />".implode(".<br />", $messages_updater)."',
			{
				autoHide : false, 
				clickOverlay : false,
				MinWidth : ".$width.",
				TimeShown : ".$showtime.",
				ShowTimeEffect : 1000,
				HideTimeEffect : 600,
				LongTrip :20,
				HorizontalPosition : 'right',
				VerticalPosition : 'bottom',
				ShowOverlay : ".$overlay."
			}); }, ".$timeout_counter.");
			";
		
			$timeout_counter+=$timeout;
		}
		
		
		if(is_array($messages_msg))
		{
			$msg.= "   var msg = setTimeout(function() { jNotify(
			'<b>Messenger:</b><br />".implode(".<br />", $messages_msg)."',
			{
				autoHide : true, 
				clickOverlay : false,
				MinWidth : ".$width.",
				TimeShown : 3000,
				ShowTimeEffect : 1000,
				HideTimeEffect : 600,
				LongTrip :20,
				HorizontalPosition : 'right',
				VerticalPosition : 'bottom',
				ShowOverlay : ".$overlay."
			}); }, ".$timeout_counter.");
			";
		
			$timeout_counter+=$timeout;
		}
		
		
		
		if(is_array($messages_info))
		{
			$msg.= "   var msg = setTimeout(function() { jNotify(
			'<b>".txt('msg_info').":</b><br />".implode(".<br />", $messages_info)."',
			{
				autoHide : true, 
				clickOverlay : false,
				MinWidth : ".$width.",
				TimeShown : ".$showtime.",
				ShowTimeEffect : 1000,
				HideTimeEffect : 600,
				LongTrip :20,
				HorizontalPosition : 'right',
				VerticalPosition : 'bottom',
				ShowOverlay : ".$overlay."
			}); }, ".$timeout_counter.");
			";
		
			$timeout_counter+=$timeout;
		}		
			
		return $msg;	
	}

}
	 
/*
**************************
*/
 	
class cfg {

	static function get($option=null)
	{
		if($option)
		{
			$cfg = glb::get('PHPOS_GLOBALCONFIG');			
			return $cfg[$option];			
		}	
	}
		 
/*
**************************
*/
 	
	static function uget($option=null)
	{
		if($option)
		{
			$cfg = glb::get('PHPOS_USERCONFIG');			
			return $cfg[$option];			
		}	
	}
}
	 
/*
**************************
*/
 	
class helper {

	static function window($mode, $id = null, $noecho = null)
	{		
		if($id == null)
		{
			$win = glb::get('apiWindow');
			$id = $win->getID();
		}
		
		switch($mode)
		{			
			case 'close':
				$str = "<script>phpos.windowClose(".$id.");</script>";
			break;
		}		
		
		if($noecho == null)	echo $str;
		return $str;	
	}
			 
/*
**************************
*/
 	
	static function win($title = 'New window', $app = 'explorer2', $params = 'fs:local_files', $app_params = null)
	{		
		$str = "phpos.windowCreate('".$title."','".$app."', '".$params."', '".$app_params."')";	
		return $str;	
	}			
		
			 
/*
**************************
*/
 	
	static function alert($mode, $msg, $noecho = null)
	{			
		switch($mode)
		{			
			case 'error':
				$str = "<script>$.messager.alert('PHPOS Windows API', '".$msg."', 'error');</script>";
			break;
			
			case 'info':
				$str = "<script>$.messager.alert('PHPOS Windows API', '".$msg."', 'info');</script>";
			break;
		}		
		
		if($noecho == null)	echo $str;
		return $str;	
	}	
	
}
?>