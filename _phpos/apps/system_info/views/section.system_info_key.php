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


echo $layout->title(txt('cp_system_info_key_title'), 'icon.png'); 
echo $layout->txtdesc(txt('cp_system_info_key_desc'));

echo '<div style="text-align:center"><img src="'.ICONS.'system_info/key_icon.png" /><br />'.txt('cp_system_info_key_show_dsc').'<br /><textarea readonly class="cp_key">'.$phpos_key. '</textarea><br />'.txt('cp_system_info_key_show_dsc2').'</div>';

?>