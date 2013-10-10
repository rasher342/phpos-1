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


if(!defined("PHPOS_IN_DEBUG") && !defined('DEBUG'))
{
	die();
}
?><div data-options="border:true,region:'north',split:true, Height:250, cache:false" id="phpos_debugger" style="z-index:99999; height:250px;background-color: white; background:solid"><input type="button" value="kasuj" onclick="$('#phpos_debugger_data .win1').html('');$('#phpos_debugger_data .win2').html('');$('#phpos_debugger_data .win3').html('');$('#phpos_debugger_data .win4').html('');"><div id="phpos_debugger_data">
<div class="win1" style="padding:3px;border-left:1px solid black;float:left"></div><div class="win2" style="padding:3px;border-left:1px solid black;float:left"></div><div class="win3" style="padding:3px;border-left:1px solid black;float:left"></div><div class="win4" style="padding:3px;border-left:1px solid black;float:left"></div><div style="clear:both"></div>


</div></div>
<script>$("#phpos_debugger").css("display", "none");</script>
