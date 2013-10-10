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


if(!defined('extPlugin'))
{
	die();
}

$extPlugin = 'Media files';
$extPluginTypes = array('mov','swf','mpg','mp4','avi');

$extPluginOnOpen = "alert('movie open ".$icon['id']."');";

// $icon, %class%
$extPluginRenderRewrite = '<div title="mov'.str_replace(PHPOS_HOME_DIR,'',$icon['fullname']).'" class="easyui-tooltip phpos_icon '.$class.'"  style="display:inline-block" id="'.$icon['div'].'">
					<a href="home/szczyglis/'.str_replace(PHPOS_HOME_DIR,'',$icon['id']).'" title="home/szczyglis/'.str_replace(PHPOS_HOME_DIR,'',$icon['id']).'"  rel="prettyPhoto">
					<img src="'.$icon['icon'].'">
					<br />'.wordwrap($icon['title'], 15, " ", 1).'
					</a>
				</div>';;




$extPluginContextMenu = array('fbshare::Share on Facebook::alert("Facebook to zuo");::open');
$extPluginOpenWith = array('open_note::PluginOpenTxtNotepad::alert("PluginContextNOTEPAD='.$icon['id'].'");::open');


// == Functions to executes in explorer (add ons)
if($before_explorer_load)
{

	function unzip_me()
	{
	
	// do wykonania przez odpaleniem explorera
	// filtr na pliki i sort zrobic!!
	}



}


?>