<?php
/*
**********************************

	PHPOS Web Operating system
	MIT License
	(c) 2013 Marcin Szczyglinski
	szczyglis83@gmail.com
	GitHUB: https://github.com/phpos/
	File version: 1.2.5, 2013.10.15
 
**********************************
*/
if(!defined('PHPOS'))	die();	


$tray_icons = glob(PHPOS_DIR.'plugins/tray/tray.*.php');
$tray_data = array();

if(is_root() || is_admin())
{
echo '<div id="phpos_tray_icon_console" title="'.txt('console_tray_title').'" class="phpos_tray_item phpos_tray_item_mouseleave"><img src="'.ICONS.'tray/console.png" /></div>';
}


foreach($tray_icons as $tray_plugin)
{
	$tray = array();
	include $tray_plugin;	
	$tray_data[] = $tray;
}

$c = count($tray_data);
if($c != 0)
{
	for($i=0; $i<$c; $i++)
	{
		$this_tray = $tray_data[$i];
		
		if($this_tray['access_level'] < 2 || ($this_tray['access_level'] == 2 && is_admin()) || is_root())
		{		
			$wintask = new api_wintask;
			$wintask->setContextMenu($this_tray['context_menu']);
			$js_context_menu.= $wintask->contextMenuRender('phpos_tray_icon_'.$this_tray['id'], 'img', 'left');			
			$txt = '';
			
			if(!empty($this_tray['txt']))
			{
				$txt = '<span>'.$this_tray['txt'].'</span>';
			}			
			
			if($this_tray['use_custom_icons'])
			{
				echo '<div id="phpos_tray_icon_'.$this_tray['id'].'" title="'.$this_tray['title'].'" class="phpos_tray_item phpos_tray_item_mouseleave"><img src="'.$this_tray['icons'][0].'" />'.$txt.'</div>';	
				
			} else {
			
				echo '<div id="phpos_tray_icon_'.$this_tray['id'].'" title="'.$this_tray['title'].'" class="phpos_tray_item phpos_tray_item_mouseleave"><img  src="'.PHPOS_WEBROOT_URL.'_phpos/icons_tray/'.$this_tray['icons'][0].'" />'.$txt.'</div>';	
			}		
		}
	}
}

?>
<script>
$(document).ready(function() { 

	$('.phpos_tray_item').mouseenter(function()
	{
		$(this).removeClass('phpos_tray_item_mouseleave').addClass('phpos_tray_item_mouseenter');	
	});
	
	$('.phpos_tray_item').mouseleave(function()
	{
		$(this).removeClass('phpos_tray_item_mouseenter').addClass('phpos_tray_item_mouseleave');	
	});
	
	$('#phpos_tray_icon_console').click(function()
	{
		phpos.console_showhide();
	});
	
});

$(function(){
		
		<?php  echo $js_context_menu; ?>		
});
</script>