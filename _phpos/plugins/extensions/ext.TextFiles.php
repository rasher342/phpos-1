<?php
/*
**********************************

	PHPOS Web Operating system
	MIT License
	(c) 2013 Marcin Szczyglinski
	szczyglis83@gmail.com
	GitHUB: https://github.com/phpos/
	File version: 1.2.6, 2013.10.16
 
**********************************
*/
if(!defined('PHPOS'))	die();	


if(!defined('extPlugin'))
{
	die();
}

$extPlugin = 'Text files';
$extPluginTypes = array('html','txt','log', 'md', 'htm');

$extPluginOnOpen = apiLoad($icon['id']);

// $icon, %class%
/*
$extPluginRenderRewrite = '<div title="'.str_replace(PHPOS_HOME_DIR,'',$icon['fullname']).'" class="easyui-tooltip phpos_icon '.$class.'"  style="display:inline-block" id="'.$icon['div'].'">
					<a href="home/szczyglis/'.str_replace(PHPOS_HOME_DIR,'',$icon['id']).'" title="home/szczyglis/'.str_replace(PHPOS_HOME_DIR,'',$icon['id']).'" data-lightbox="image-1">
					<img src="'.$icon['icon'].'">
					<br />'.wordwrap($icon['title'], 15, " ", 1).'
					</a>
				</div>';;
*/



//$extPluginContextMenu = array('---','fbshare::Share on Facebook::alert("Facebook to zuo");::open');
$extPluginOpenWith = array('open_notepad::Notepad::'.apiLoad($icon['id']).'::notepad');


// == Functions to executes in explorer (add ons)
if($before_explorer_load)
{
	function unzip_me()
	{
		// to open before render
	}
}
?>