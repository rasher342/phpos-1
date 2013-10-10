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


class dbg {

	
	static function shows($data, $win=null)
	{
		if(empty($win))
		{
			$win = 1;
		}
		echo '<script>
		$("#phpos_debugger").css("display", "block");
		var debug = $("#phpos_debugger_data .win'.$win.'").html();
		var new_debug = debug + "'.str_replace('"','\'',urlencode(htmlspecialchars($data))).'<br />";
		$("#phpos_debugger_data .win'.$win.'").html(new_debug);
		$("#phpos_debugger_data .win'.$win.'").html(str_replace("+", " ",decodeURIComponent($("#phpos_debugger_data .win'.$win.'").html())));
		$("#phpos_debugger_data .win'.$win.'").wrapInner("<pre />");	
		</script>';	
	}
		 
/*
**************************
*/
 	
	static function show($data, $win=null)
	{
	
		if(empty($win))
		{
			$win = 1;
		}
		echo '<script>	
		$("#phpos_debugger").css("display", "block");
		var new_debug = "'.str_replace('"','\'',urlencode(htmlspecialchars($data))).'<br />";
		$("#phpos_debugger_data .win'.$win.'").html(new_debug);
		$("#phpos_debugger_data .win'.$win.'").html(str_replace("+", " ",decodeURIComponent($("#phpos_debugger_data .win'.$win.'").html())));
		$("#phpos_debugger_data .win'.$win.'").wrapInner("<pre />");	
		</script>';	
	}
		 
/*
**************************
*/
 	
	static function dumps($var, $win=null)
	{
		if(empty($win))
		{
			$win = 1;
		}
		ob_start();
		var_dump($var);
		$dumped_var = ob_get_clean();		
		
		
		echo '<script>
		$("#phpos_debugger").css("display", "block");
		var debug = $("#phpos_debugger_data .win'.$win.'").html();
		//var new_debug = ;
		$("#phpos_debugger_data .win'.$win.'").html(debug + "'.str_replace('"','\'',urlencode(htmlspecialchars($dumped_var))).'<br />");		
		$("#phpos_debugger_data .win'.$win.'").html(str_replace("+", " ",decodeURIComponent($("#phpos_debugger_data .win'.$win.'").html())));
		$("#phpos_debugger_data .win'.$win.'").wrapInner("<pre />");	
		
		</script>';			
	}
		 
/*
**************************
*/
 	
	static function dump($var, $win=null)
	{
		if(empty($win))
		{
			$win = 1;
		}
		ob_start();
		var_dump($var);
		$dumped_var = ob_get_clean();		
		
		
		echo '<script>		
		$("#phpos_debugger").css("display", "block");
		$("#phpos_debugger_data .win'.$win.'").html("'.str_replace('"','\'',urlencode(htmlspecialchars($dumped_var))).'<br />");		
		$("#phpos_debugger_data .win'.$win.'").html(str_replace("+", " ",decodeURIComponent($("#phpos_debugger_data .win'.$win.'").html())));		
		$("#phpos_debugger_data .win'.$win.'").wrapInner("<pre />");		
		</script>';			
	}
}



?>