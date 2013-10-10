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


?><div id="phpos_startmenu_layout_apps">
<?php
	$apps = new phpos_app;
	$app_list = $apps->my_apps_list();
	$c = count($app_list);
	
	if($c != 0)
	{
		foreach ($app_list as $item)	
		{
			$apps->set_app_id($item);
			$apps->load_config();
			$is_hide = $apps->get_hidden();
			if(!$is_hide)
			{					
				echo '<div class="startmenu_app_item" title="'.$apps->get_desc().'" onclick="'.$apps->link_action().'"><img src="'.$apps->get_icon().'"><span>'.$apps->get_title().'</span></div>';
				
				/*
				echo '<div class="startmenu_app_item" title="'.$apps->get_desc().'" onclick="'.$apps->link_action().'"><img src="'.$apps->get_icon().'"><span>'.txt($item).'</span></div>';
				*/
			}		
		}	
	}

?>
</div>
<script>
$(document).ready(function() { 

	$('.startmenu_app_item').mouseenter(function()
	{
		$(this).removeClass('mouseleave').addClass('mouseenter');	
	});
	
	$('.startmenu_app_item').mouseleave(function()
	{
		$(this).removeClass('mouseenter').addClass('mouseleave');	
	});
});
</script>