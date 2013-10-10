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


$app_toolbar = array();
$app_toolbar[] = array('id' => 'logs', 'title' => txt('logs_section_logs_title'), 'link' => helper_reload(array('section' => 'logs')), 'icon' => 'logs/section_logs.png', 'tip' => txt('logs_section_logs_title_desc'));

$app_toolbar[] = array('id' => 'sessions', 'title' => txt('logs_section_sessions_title'), 'link' => helper_reload(array('section' => 'sessions', 'id_session' => null)), 'icon' => 'logs/section_sessions.png', 'tip' => txt('logs_section_sessions_desc'));
?>