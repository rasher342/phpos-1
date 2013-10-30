<?php
/*
**********************************

	PHPOS Web Operating system
	MIT License
	(c) 2013 Marcin Szczyglinski
	szczyglis83@gmail.com
	GitHUB: https://github.com/phpos/
	File version: 1.3.1, 2013.10.30
 
**********************************
*/
if(!defined('PHPOS'))	die();	


?><div style="z-index:99999999" id="phpos_console"><input type="button" value="<?php echo txt('console_clean');?>" onclick="$('#phpos_console_data').html('');"><input type="button" value="<?php echo txt('console_hide');?>" onclick="$('#phpos_console').css('display', 'none');"><div id="phpos_console_data"></div></div>
<script>$("#phpos_console").css("display", "none");</script>
