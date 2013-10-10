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


$schema = array(
	
	'files' => array(						
						'id_key' => 'id_file',						
						'fields' => array(
							array('id_file', 'int'),
							array('file_title', 'text'),
							array('plugin_id', 'text'),
							array('location', 'text'),
							array('app_id', 'text'),		
							array('app_action', 'text'),								
							array('win_params', 'text'),
							array('app_params', 'text'),
							array('id_parent', 'int'),
							array('id_user', 'int'),
							array('created_at', 'int'),
							array('modified_at', 'int'),
							array('content', 'text'),
							array('chmod', 'int'),
							array('is_dir', 'bool'),
							array('no_delete', 'bool'),						
							array('shared', 'int'),
							array('icon', 'text'),
							array('deleted', 'bool'),
							array('multilang', 'bool')
						)
	),
		'ftp' => array(						
						'id_key' => 'id',						
						'fields' => array(
							array('id', 'int'),
							array('id_user', 'int'),
							array('title', 'text'),
							array('host', 'text'),
							array('port', 'int'),
							array('login', 'text'),
							array('password', 'text'),
							array('remote_dir', 'text'),
							array('description', 'text'),
							array('public', 'bool')
						)
	),
	
		'messages' => array(						
						'id_key' => 'id',						
						'fields' => array(
							array('id', 'int'),
							array('id_user_from', 'int'),
							array('id_user_to', 'int'),
							array('sended_at', 'int'),
							array('readed_at', 'int'),
							array('is_readed', 'bool'),
							array('title', 'text'),
							array('msg', 'text'),
							array('receiver_deleted', 'bool'),
							array('sender_deleted', 'bool')
						)
	),
	
		'clouds' => array(						
						'id_key' => 'id',						
						'fields' => array(
							array('id', 'int'),
							array('id_user', 'int'),
							array('title', 'text'),
							array('cloud', 'text'),							
							array('login', 'text'),
							array('password', 'text'),
							array('url', 'text'),
							array('description', 'text'),
							array('public', 'bool'),
							array('param1', 'text'),
							array('param2', 'text'),
							array('param3', 'text'),
							array('param4', 'text')
						)
	),
		'globalconfig' => array(						
						'id_key' => 'id_config',						
						'fields' => array(
							array('id_config', 'int'),
							array('config_name', 'text'),
							array('config_value', 'text'),
							array('config_param', 'text')
						)
	),
		'groups' => array(						
						'id_key' => 'id',						
						'fields' => array(
							array('id', 'int'),
							array('id_owner', 'int'),
							array('title', 'text'),
							array('description', 'text'),
							array('msg', 'text')
						)
	),	
	'groups_records' => array(						
						'id_key' => 'id',						
						'fields' => array(
							array('id', 'int'),
							array('id_group', 'int'),
							array('id_user', 'int')
						)
	),	
		'startmenu' => array(						
						'id_key' => 'id',						
						'fields' => array(
							array('id', 'int'),
							array('id_user', 'int'),							
							array('id_file', 'int')							
						)
	),
		'sessions' => array(						
						'id_key' => 'id_session',						
						'fields' => array(
							array('id_session', 'int'),							
							array('id_user', 'int'),
							array('php_sessid', 'text'),
							array('start_time', 'int'),
							array('end_time', 'int'),
							array('user_ip', 'text'),
							array('user_browser', 'text'),      
							array('user_param', 'text')
						)
	),
	'shared' => array(						
						'id_key' => 'id',						
						'fields' => array(
							array('id', 'int'),
							array('id_user', 'int'),
							array('title', 'text'),
							array('description', 'text'),
							array('folder_type', 'text'),
							array('folder_id', 'text'),
							array('readonly', 'bool')
						)
	),
		'userconfig' => array(						
						'id_key' => 'id_config',						
						'fields' => array(
							array('id_config', 'int'),
							array('id_user', 'int'),
							array('config_name', 'text'),
							array('config_value', 'text'),
							array('config_param', 'text')
						)
	),
		'users' => array(						
						'id_key' => 'id_user',						
						'fields' => array(
							array('id_user', 'int'),
							array('user_login', 'text'),
							array('user_pass', 'text'),
							array('user_email', 'text'),
							array('user_type', 'int'),
							array('id_group', 'int'),
							array('is_active', 'bool'),
							array('created_at', 'int'),
							array('last_login', 'int'),
							array('last_activity', 'int'),
							array('note', 'text')
						)
	),
	
	
);

$insert['users'] = array(
  array('id_user' => '1','user_login' => 'root','user_pass' => '','user_email' => '','user_type' => '3','id_group' => '1','is_active' => '1','created_at' => '0','last_login' => '0','last_activity' => '0','note' => 'root')
);

$insert['files'] = array(
  array('id_file' => '1','file_title' => 'my_server','plugin_id' => 'app', 'location' => 'desktop', 'id_parent' => '0','id_user' => '1','created_at' => time(),'modified_at' => time(),'content' => '','chmod' => '0','is_dir' => '0','no_delete' => '1','app_id' => 'explorer', 'app_action' => 'my_server', 'app_params' => 'fs:local_files','shared' => '0','icon' => 'mycomp.png','deleted' => '0','multilang' => '1'),
	
	array('id_file' => '2','file_title' => 'updater_app_title','plugin_id' => 'app', 'location' => 'desktop', 'id_parent' => '0','id_user' => '1','created_at' => time(),'modified_at' => time(),'content' => '','chmod' => '0','is_dir' => '0','no_delete' => '0','app_id' => 'updater', 'app_action' => 'index', 'shared' => '0', 'deleted' => '0','multilang' => '1'),
	
	array('id_file' => '3','file_title' => 'notepad_app_title','plugin_id' => 'app', 'location' => 'desktop', 'id_parent' => '0','id_user' => '1','created_at' => time(),'modified_at' => time(),'content' => '','chmod' => '0','is_dir' => '0','no_delete' => '0','app_id' => 'notepad', 'app_action' => 'index', 'shared' => '0', 'deleted' => '0','multilang' => '1'),
	
	array('id_file' => '4','file_title' => 'app_messager','plugin_id' => 'app', 'location' => 'desktop', 'id_parent' => '0','id_user' => '1','created_at' => time(),'modified_at' => time(),'content' => '','chmod' => '0','is_dir' => '0','no_delete' => '0','app_id' => 'messenger', 'app_action' => 'index', 'shared' => '0', 'deleted' => '0','multilang' => '1'),
	
	array('id_file' => '5','file_title' => 'logs_app_title','plugin_id' => 'app', 'location' => 'desktop', 'id_parent' => '0','id_user' => '1','created_at' => time(),'modified_at' => time(),'content' => '','chmod' => '0','is_dir' => '0','no_delete' => '0','app_id' => 'logs', 'app_action' => 'index', 'shared' => '0', 'deleted' => '0','multilang' => '1'),
	
	array('id_file' => '6','file_title' => txt('after_install_readme_title'),'plugin_id' => 'app', 'location' => 'db', 'id_parent' => '0','id_user' => '1','created_at' => time(),'modified_at' => time(),'content' => txt('after_install_readme_file'),'chmod' => '0','is_dir' => '0','no_delete' => '0',	
	'app_id' => 'notepad', 'app_action' => 'index', 'app_params' => 'content:1', 'shared' => '0', 'deleted' => '0','multilang' => '0'),
	
	array('id_file' => '7','file_title' => txt('after_install_folder_links'),'plugin_id' => 'folder', 'location' => 'desktop', 'id_parent' => '0','id_user' => '1','created_at' => time(),'modified_at' => time(),'content' => '','chmod' => '0','is_dir' => '1','no_delete' => '0','app_id' => '', 'app_action' => 'index', 'app_params' => '', 'shared' => '0', 'deleted' => '0','multilang' => '0'),
	
	array('id_file' => '8','file_title' => txt('after_install_shortcut_yt_militia'),'plugin_id' => 'app', 'location' => 'db', 'id_parent' => '7','id_user' => '1','created_at' => time(),'modified_at' => time(),'content' => '','chmod' => '0','is_dir' => '0','no_delete' => '0','app_id' => 'mediaframes', 'app_action' => 'youtube', 'app_params' => 'url:aHR0cDovL3d3dy55b3V0dWJlLmNvbS93YXRjaD92PVV4ZXg0Ry1Nd3hJ', 'shared' => '0', 'deleted' => '0','multilang' => '0'),

	array('id_file' => '9','file_title' => txt('after_install_shortcut_link_barok'),'plugin_id' => 'link', 'location' => 'db', 'id_parent' => '7','id_user' => '1','created_at' => time(),'modified_at' => time(),'content' => '','chmod' => '0','is_dir' => '0','no_delete' => '0','app_id' => 'links', 'app_action' => 'index', 'app_params' => 'url:aHR0cDovL2Jhcm9rZW5naW5lLmNvbS8=', 'shared' => '0', 'deleted' => '0','multilang' => '0'),
	
	array('id_file' => '10','file_title' => txt('after_install_shortcut_phpos_www'),'plugin_id' => 'link', 'location' => 'db', 'id_parent' => '7','id_user' => '1','created_at' => time(),'modified_at' => time(),'content' => '','chmod' => '0','is_dir' => '0','no_delete' => '0','app_id' => 'links', 'app_action' => 'index', 'app_params' => 'url:aHR0cDovL3d3dy5waHBvcy5yb3gucGw=', 'shared' => '0', 'deleted' => '0','multilang' => '0'),
	
	array('id_file' => '11','file_title' => txt('after_install_shortcut_frame_wiki'),'plugin_id' => 'link', 'location' => 'db', 'id_parent' => '7','id_user' => '1','created_at' => time(),'modified_at' => time(),'content' => '','chmod' => '0','is_dir' => '0','no_delete' => '0','app_id' => 'webframes', 'app_action' => 'index', 'app_params' => 'url:aHR0cDovL3dpa2lwZWRpYS5vcmc=', 'shared' => '0', 'deleted' => '0','multilang' => '0'),
	
);

$insert['groups'] = array(
  array('id' => '1', 'id_owner' => '1', 'title' => txt('after_install_group_name'), 'description' => txt('after_install_group_desc'), 'msg' => '')
);

$insert['groups_records'] = array(
  array('id' => '1', 'id_group' => '1', 'id_user' => '1')
);


$insert['startmenu'] = array(
  array('id' => '1','id_user' => '1', 'id_file' => '10')
);

$insert['startmenu'] = array(
  array('id' => '1','id_user' => '1', 'id_file' => '10')
);

$insert['messages'] = array(
  array('id' => '1','id_user_from' => '1', 'id_user_to' => '1', 'sended_at' => time(), 'readed_at' => '0', 'is_readed' => '0', 'title' => txt('after_install_msg_title'), 'msg' => txt('after_install_msg_body'), 'sender_deleted' => '1', 'receiver_deleted' => '0')
);

$insert['userconfig'] = array(
  array('id_config' => '1','id_user' => '1','config_name' => 'lang','config_value' => 'en','config_param' => '')
);

$insert['globalconfig'] = array(
  array('config_name' => 'lang','config_value' => 'en'),
	array('config_name' => 'theme','config_value' => 'default'),
	array('config_name' => 'upload_blacklist','config_value' => 'php,php5,php4,php3,html,htm,js,cgi,exe,bin,bat,sh')
);





?>