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


?><div style="z-index:99999999" id="phpos_console">
<div style="text-align:right">
 <span class="console_time">TIME</span> | <span class="console_winid">WIN_ID</span> | <span class="console_appname">APP_ID</span> | <span class="console_appaction">APP_ACTION</span> | <span class="console_key">KEY</span> | <span class="console_val">VALUE</span> 
<a href="javascript:void(0);" onclick="phpos.console_clear();" class="easyui-linkbutton" data-options="iconCls:'icon-cancel'"><?php echo txt('console_clean');?></a>
<a href="javascript:void(0);" onclick="phpos.console_showhide();" class="easyui-linkbutton" data-options="iconCls:'icon-arrow_down'"><?php echo txt('console_hide');?></a>
<a href="javascript:void(0);" onclick="phpos.console_minmax();" class="easyui-linkbutton" data-options="iconCls:'icon-maximize'">Min/Max</a>
</div>
<div id="phpos_console_data"></div>
</div>
<script>$("#phpos_console").css("display", "none");</script>
