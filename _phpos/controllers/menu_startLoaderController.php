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
	error_reporting(E_ERROR | E_PARSE);
	
	if (!isset($_SESSION)) {
		session_start();
	}

 define('PHPOS', true);	
 
 // Define PATHS
	define('PHPOS', true);	
	define('PHPOS_DIR','../');
	define('PHPOS_URL','../_phpos/');
	define('PHPOS_WEBROOT','');	
	define('PHPOS_WEBROOT_URL','');
	define('PHPOS_WEBROOT_DIR', '../../web/');
	define('PHPOS_APPS_DIR',PHPOS_DIR.'apps/');	
	define('PHPOS_APPS_URL',PHPOS_DIR.'apps/');	
	
	define('PHPOS_HOME_DIR', PHPOS_WEBROOT_DIR.'home/');
	define('PHPOS_HOME_URL', PHPOS_WEBROOT_URL.'home/');

	include PHPOS_WEBROOT_DIR.'version.php';
	define('PHPOS_IN_LOADER', true); 
	define('ICONS',PHPOS_WEBROOT_URL.'_phpos/icons/');
 require_once(PHPOS_DIR.'common/functions.php'); 
 
 require_once(PHPOS_DIR.'classes/class.phpos_filters.php');
 require_once(PHPOS_DIR.'classes/class.phpos_console.php');
 require_once(PHPOS_DIR.'classes/class.api_wintask.php');
 require_once(PHPOS_DIR.'classes/class.api_processes.php');	
 require PHPOS_DIR.'config/database.php';	
 require_once(PHPOS_DIR.'controllers/databaseController.php');	
 require_once(PHPOS_DIR.'classes/class.phpos_config.php');	
 require_once(PHPOS_DIR.'controllers/helpersController.php');
 
 define('THEME_DIR', PHPOS_WEBROOT_DIR.'_phpos/themes/'.globalconfig('theme').'/');
 define('THEME_URL', PHPOS_WEBROOT_URL.'_phpos/themes/'.globalconfig('theme').'/');
 
 require_once(PHPOS_DIR.'classes/class.users.php');	
 require_once(PHPOS_DIR.'classes/class.helpers.php');	 
	
 require_once(PHPOS_DIR.'classes/class.phpos_startmenu.php');
 require_once(PHPOS_DIR.'classes/class.phpos_app.php');
 require_once(PHPOS_DIR.'classes/class.phpos_filesystems.php');	
 require_once(PHPOS_DIR.'classes/class.phpos_shortcuts.php');	
 require_once(PHPOS_DIR.'classes/class.phpos_clipboard.php');	
 require_once(PHPOS_DIR.'classes/class.phpos_icons.php');	
 require_once(PHPOS_DIR.'classes/class.languages.php');
 require_once(PHPOS_DIR.'controllers/languageController.php');
	
 define('PHPOS_IN_EXPLORER', true);
 require PHPOS_DIR.'plugins/filesystems/db_mysql/fs.db_mysql.php';
 //$filesystem_class = 'phpos_fs_plugin_'.$my_app->get_param('fs');	
 $phposFS = new phpos_fs_plugin_db_mysql; // start filesytem	 
	
 $config = new phpos_config;
 $config->set_id_user();
 $shortcut = new phpos_shortcuts; 
 
$startmenu = new phpos_startmenu;
$records = $startmenu->get_all();

$i = 1;
foreach($records as $item)
{
	 if($shortcut->is_shortcut($item['id_file'])) 
	 {	 
		 $row = $shortcut->get_shortcut($item['id_file']);	 
		 $icon = $shortcut->link_icon($row['plugin_id'], $row['app_id'], $row['icon'],  $row['app_action']);
		 
		 $app_action = 'app_id:'.$row['app_id'].'@'.$row['app_action'];
		 $action = winopen($row['file_title'], $row['plugin_id'], $app_action, $row['app_params']);
		 
		 $context_menu = array(				
				'delete::'.txt('del_from_start').'::delete_menustart_item("'.$item['id'].'");::delete'			
		 );	
		
		 $apiWindow = new api_wintask;
		 $apiWindow->setContextMenu( $context_menu);
		 $js.=$apiWindow->contextMenuRender('startmenu_left_item_'.$i, 'img');	 
		 $apiWindow->resetContextMenu();	
		 
		 
		 $items.= '<div id="startmenu_left_item_'.$i.'" class="startmenu_left_item" onclick="'.$action.'"><img src="'.$icon.'"><span>'.$row['file_title'].'</span></div>';
		 $i++;
	 }
}	
 
 $js.= "
 function delete_menustart_item(delete_id)
 {
		phpos.managerWindows('action=delete_start_item&item_id='+delete_id);
		phpos.menustartClose();
  }
	";
 
 
 $my_app = new phpos_app;
 jquery_function($js);
 jquery_onready($js_delete);
 
 include PHPOS_DIR.'views/startmenuView.php'; 
 echo $my_app->render_javascript_jquery(); 
?>