<?php

class console 
{


	public static function log($str = null, $type = null)
	{
		if(!is_array($_SESSION['console_log'])) $_SESSION['console_log'] = array();
		
		if(!empty($str))
		{
			if($type == null)
			{
				$_SESSION['console_log'][] = "<b>".date('H:i:s', time())."</b>: ".$str."' + '<br />";
				
			} elseif($type == 'ok') {
				$_SESSION['console_log'][] = "<span style=\"color:#277125\"><b>".date('H:i:s', time()).": [OK]</b> ".$str."' + '</span><br />";
				
			} elseif($type == 'error') {
				$_SESSION['console_log'][] = "<span style=\"color:#87292d\"><b>".date('H:i:s', time()).": [ERROR]</b> ".$str."' + '</span><br />";
			}
			
		} else {
			$_SESSION['console_log'][] = "<br />";
		}
	}
	
	public static function show()
	{
		if(is_array($_SESSION['console_log']))
		{
			$a = array_reverse($_SESSION['console_log']);
			$c = count($a);
			for($i=0; $i<$c; $i++)
			{
				$data.= $a[$i];
			}
			
			
			unset($_SESSION['console_log']);
		} 
		echo "<script>
		
		var html = $('#phpos_console_data').html();
		
		var new_data = '".$data."' + html;
		$('#phpos_console_data').html(new_data);
		
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
	

}
?>