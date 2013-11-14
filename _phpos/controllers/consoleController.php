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
<a href="javascript:void(0);" onclick="phpos.console_show_content('data');" class="easyui-linkbutton"><span id="console_btn_data"><?php echo txt('console_events');?></span></a> 

<a href="javascript:void(0);" onclick="phpos.console_show_content('clipboard');" class="easyui-linkbutton"><span id="console_btn_clipboard"><?php echo txt('console_clipboard');?></span></a> 
<?php /* ?>
<a href="javascript:void(0);" onclick="phpos.console_show_content('params');" class="easyui-linkbutton"><span id="console_btn_params"><?php echo txt('console_params');?></span></a> 

<?php */ ?>
 
<a href="javascript:void(0);" onclick="phpos.console_clear();" class="easyui-linkbutton" data-options="iconCls:'icon-cancel'"><?php echo txt('console_clean');?></a>
<a href="javascript:void(0);" onclick="phpos.console_showhide();" class="easyui-linkbutton" data-options="iconCls:'icon-arrow_down'"><?php echo txt('console_hide');?></a>
<a href="javascript:void(0);" onclick="phpos.console_minmax();" class="easyui-linkbutton" data-options="iconCls:'icon-maximize'">Min/Max</a><br /> <?php echo txt('console_legend');?> : <span class="console_time"><?php echo txt('console_legend_time');?></span> | <span class="console_winid"><?php echo txt('console_legend_winid');?></span> | <span class="console_appname"><?php echo txt('console_legend_appid');?></span> | <span class="console_appaction"><?php echo txt('console_legend_appaction');?></span> | <span class="console_key"><?php echo txt('console_legend_key');?></span> | <span class="console_val"><?php echo txt('console_legend_value');?></span>
</div>
<div id="phpos_console_data"></div>
<div id="phpos_console_clipboard"></div>
<div id="phpos_console_params">

	<div id="phpos_console_params_list"></div>
	<div id="phpos_console_params_body"> <span class="console_arrows ">&lt;&lt;</span> <?php echo txt('console_click_to_show_params');?></div>
	<div style="clear:both"></div>
</div>
</div>
<script>$("#phpos_console").css("display", "none");</script>