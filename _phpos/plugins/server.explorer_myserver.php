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


$server_item_title = txt('local_fsystems');
$tmp_html.=	'<div ondblclick="'.link_action('index', 'fs:local_files').'" class="phpos_server_icon" title="'.txt('st_localfiles').'"><img src="'.ICONS.'server/hdd.png" /><p><b>'.txt('home_local_folder').'</b><br />'.txt('home_local_folder_desc').'<br /><span class="desc">'.PHP_OS.'</span></p></div> 
<div ondblclick="'.link_action('index', 'fs:db_mysql').'" class="phpos_server_icon" title="'.txt('st_db').'"><img src="'.ICONS.'server/db.png" /><p><b>'.txt('home_db_folder').'</b><br />'.txt('home_db_folder_desc').'<br /><span class="desc">'.$sql->get_adapter_full_name().'</span></p></div>';
?>