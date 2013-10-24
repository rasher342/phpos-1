<?php 
/*
**********************************

	PHPOS Web Operating system
	MIT License
	(c) 2013 Marcin Szczyglinski
	szczyglis83@gmail.com
	GitHUB: https://github.com/phpos/
	File version: 1.2.7, 2013.10.24
 
**********************************
*/
if(!defined('PHPOS'))	die();	

	function secondsToTime($inputSeconds) {

			$secondsInAMinute = 60;
			$secondsInAnHour  = 60 * $secondsInAMinute;
			$secondsInADay    = 24 * $secondsInAnHour;

			// extract days
			$days = floor($inputSeconds / $secondsInADay);

			// extract hours
			$hourSeconds = $inputSeconds % $secondsInADay;
			$hours = floor($hourSeconds / $secondsInAnHour);

			// extract minutes
			$minuteSeconds = $hourSeconds % $secondsInAnHour;
			$minutes = floor($minuteSeconds / $secondsInAMinute);

			// extract the remaining seconds
			$remainingSeconds = $minuteSeconds % $secondsInAMinute;
			$seconds = ceil($remainingSeconds);

			// return the final array
			$obj = array(
					'd' => (int) $days,
					'h' => (int) $hours,
					'm' => (int) $minutes,
					's' => (int) $seconds,
			);
			return $obj;
	}


	function getIP() { 
		 if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown")) 
				 $ip = getenv("HTTP_CLIENT_IP"); 
		 else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown")) 
				 $ip = getenv("REMOTE_ADDR"); 
		 else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown")) 
				 $ip = getenv("HTTP_X_FORWARDED_FOR"); 
		 else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] 
				 && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown")) 
				 $ip = $_SERVER['REMOTE_ADDR']; 
		 else { 
				 $ip = "unknown"; 
		 
				 } 
		 return $ip;
	} 


	function textcut($str, $max, $zost)
	{
		if(strlen($str) > $max)
		{
			$max .=strlen($zost);
			$str = strrev(strstr(strrev(substr($$str, 0, $max)), ' '));
			$str .= $zost;
		}
		return $str;
	}

	function string_cut($String, $Length, $Title = 0, $Dots = 1) {
		if (!$Length) return ($String);
		if (!function_exists ('mb_substr')) return ((strlen ($String) > ($Length + 3) || !$Dots)?($Title?'<span title="'.htmlspecialchars ($String).'">'.htmlspecialchars (substr_replace ($String, ($Dots?'...':''), $Length)).'</span>':htmlspecialchars (substr_replace ($String, ($Dots?'...':''), $Length))):htmlspecialchars ($String));
		else return ((mb_strwidth ($String, 'UTF-8') > ($Length + 3) || !$Dots)?($Title?'<span title="'.htmlspecialchars ($String).'">'.htmlspecialchars (mb_substr ($String, 0, $Length, 'UTF-8')).($Dots?'...':'').'</span>':htmlspecialchars (mb_substr ($String, 0, $Length, 'UTF-8')).($Dots?'...':'')):htmlspecialchars ($String));
	}



	function array_sort_func($a,$b=NULL) { 
		 static $keys; 
		 if($b===NULL) return $keys=$a; 
		 foreach($keys as $k) { 
				if(@$k[0]=='!') { 
					 $k=substr($k,1); 
					 if(@$a[$k]!==@$b[$k]) { 
							return strcmp(@$b[$k],@$a[$k]); 
					 } 
				} 
				else if(@$a[$k]!==@$b[$k]) { 
					 return strcmp(@$a[$k],@$b[$k]); 
				} 
		 } 
		 return 0; 
	} 

	function array_sort(&$array) { 
		 if(!$array) return $keys; 
		 $keys=func_get_args(); 
		 array_shift($keys); 
		 array_sort_func($keys); 
		 usort($array,"array_sort_func");        
	} 

	function file_chmod($perms)
	{
		//$perms = fileperms('/etc/passwd');

		if (($perms & 0xC000) == 0xC000) {
				// Socket
				$info = 's';
		} elseif (($perms & 0xA000) == 0xA000) {
				// Symbolic Link
				$info = 'l';
		} elseif (($perms & 0x8000) == 0x8000) {
				// Regular
				$info = '-';
		} elseif (($perms & 0x6000) == 0x6000) {
				// Block special
				$info = 'b';
		} elseif (($perms & 0x4000) == 0x4000) {
				// Directory
				$info = 'd';
		} elseif (($perms & 0x2000) == 0x2000) {
				// Character special
				$info = 'c';
		} elseif (($perms & 0x1000) == 0x1000) {
				// FIFO pipe
				$info = 'p';
		} else {
				// Unknown
				$info = 'u';
		}

		// Owner
		$info .= (($perms & 0x0100) ? 'r' : '-');
		$info .= (($perms & 0x0080) ? 'w' : '-');
		$info .= (($perms & 0x0040) ?
								(($perms & 0x0800) ? 's' : 'x' ) :
								(($perms & 0x0800) ? 'S' : '-'));

		// Group
		$info .= (($perms & 0x0020) ? 'r' : '-');
		$info .= (($perms & 0x0010) ? 'w' : '-');
		$info .= (($perms & 0x0008) ?
								(($perms & 0x0400) ? 's' : 'x' ) :
								(($perms & 0x0400) ? 'S' : '-'));

		// World
		$info .= (($perms & 0x0004) ? 'r' : '-');
		$info .= (($perms & 0x0002) ? 'w' : '-');
		$info .= (($perms & 0x0001) ?
								(($perms & 0x0200) ? 't' : 'x' ) :
								(($perms & 0x0200) ? 'T' : '-'));

		return $info;
	}
	
	function filesizes($bytes)
  {
        if ($bytes >= 1073741824)
        {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        }
        elseif ($bytes >= 1048576)
        {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        }
        elseif ($bytes >= 1024)
        {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        }
        elseif ($bytes > 1)
        {
            $bytes = $bytes . ' b';
        }
        elseif ($bytes == 1)
        {
            $bytes = $bytes . ' b';
        }
        else
        {
            $bytes = '';
        }

        return $bytes;
	}
	
	
function infomonit($msg, $noscript = null)
 {
 	 if($noscript === null) 	$monit.= "<script>";
	
	 $monit.= "
				jNotify(
					'".$msg."',
					{
						autoHide : true, 
						clickOverlay : false,
						MinWidth : 200,
						TimeShown : 3000,
						ShowTimeEffect : 1000,
						HideTimeEffect : 600,
						LongTrip :20,
						HorizontalPosition : 'right',
						VerticalPosition : 'bottom',
						ShowOverlay : false
					}
				);
				";		
		if($noscript === null) $monit.= "</script>";
		return $monit;
 } 
 
 function hide_conn()
 {
 	 if($noscript === null) 	$monit.= "<script>";
	
	 $monit.= "
				$('.c2').hide();
				";		
		if($noscript === null) $monit.= "</script>";
		return $monit;
 } 
?>