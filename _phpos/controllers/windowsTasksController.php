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

	if(!isset($_SESSION)) 
	{
		session_start();
	}
	
error_reporting(E_ERROR | E_PARSE);

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
	define('PHPOS_IN_LOADER', true); 
	
	define('PHPOS_HOME_DIR', PHPOS_WEBROOT_DIR.'home/');
	define('PHPOS_HOME_URL', PHPOS_WEBROOT_URL.'home/'); 
 
 	require_once(PHPOS_DIR.'config/core.php');	
	require_once(PHPOS_DIR.'config/database.php');
	
// Load all classes and functions
	require_once(PHPOS_DIR.'controllers/databaseController.php');	
	require_once(PHPOS_DIR.'classes/class.phpos_filters.php');
	require_once(PHPOS_DIR.'classes/class.phpos_console.php');
	require_once(PHPOS_DIR.'classes/class.users.php');
	
	require_once(PHPOS_DIR.'classes/class.phpos_config.php');
	
	$config = new phpos_config;
	$config->set_id_user();
	
	require_once(PHPOS_DIR.'classes/class.helpers.php');	

	define("PHPOS_SYSTEM_LANG", cfg::get('lang'));	
	define("PHPOS_USER_LANG", cfg::uget('lang'));	
	
	
 require_once(PHPOS_DIR.'classes/class.api_wintask.php');
 require_once(PHPOS_DIR.'classes/class.api_processes.php');
 require_once(PHPOS_DIR.'classes/class.languages.php');
 require_once(PHPOS_DIR.'controllers/helpersController.php');	
 require_once(PHPOS_DIR.'classes/class.phpos_console.php'); 
 
 define('THEME_DIR', PHPOS_WEBROOT_DIR.'_phpos/themes/'.globalconfig('theme').'/');
 define('THEME_URL', PHPOS_WEBROOT_URL.'_phpos/themes/'.globalconfig('theme').'/');
 
 require_once(PHPOS_DIR.'controllers/languageController.php');
 require_once(PHPOS_DIR.'classes/class.phpos_tasks.php'); 
 require_once(PHPOS_DIR.'classes/class.phpos_startmenu.php'); 


	if(!empty($_GET['action'])) 
	{
		switch(filter::alfas($_GET['action'])) 
		{
			case 'delete_start_item':
			
				if(globalconfig('demo_mode') != 1 || is_root())
				{
					$id = filter::num($_GET['item_id']);
					$startmenu = new phpos_startmenu;
					$startmenu->delete_item($id);
				}
				
			break;		
			
			
			case 'create':
			
				if(!empty($_GET['title'])) 
				{
					$win_task = new api_wintask; 
					
					$id = null;
					if($_GET['desktop'])
					{
						$win_task->setID(1);
						$win_task->setParam('is_desktop', 1); 
						$id = 1;						
					}
					
					if($_GET['modal']) $win_task->setParam('modal', true);
					$win_task->setParam('title', filter::utf($_GET['title'])); // set title
					$win_task->setParam('wintype', filter::alfas($_GET['wintype'])); // set wintype
					$win_task->setParams($_GET['params']); // parse params					
					$win_task->openWindow($id); // create window
					$win_task->setAppParams($_GET['app_params']);
					echo $win_task->getJavaScript(); // get JS code		

					$apiProcess = new api_winprocess;
					$apiProcess->assignWindow($win_task);
					$pid = $apiProcess->newProcess();					
				}
				
			break;

			case 'destroy':
			
				if(!empty($_GET['id'])) 
				{
					$win_task = new api_wintask; 
					$win_task->setID(filter::num($_GET['id']));
					$win_task->getWindow();					
					//echo '<script>alert("'.$win_task->getParam('process_id').'");</script>';							
					$win_task->closeWindow();				
				}
				
			break;
				
				
			case 'sessiondestroy':
				session_destroy();
			break;	
			
			case 'clear_console_events':
				console::clear('events');
			break;	
			
			case 'clear_console_clipboard':
				console::clear('clipboard');
			break;	
			
			case 'clear_console_params':
				console::clear('params');
			break;	
				
				
			case 'restore':				
				$c = count($_SESSION['tasks']);			
				$js_code='';
				
				$win_tasks = new api_wintask; 				
				$c = $win_tasks->countWindows();	
				
				if($c!=0) 
				{
					foreach($_SESSION['tasks'] as $key => $value)
					{	
						if($key != 1)
						{						
							$win_task = new api_wintask; 
							$win_task->setID($_SESSION['tasks'][$key]['id']);
							$win_task->getWindow();							
							$win_task->generateJavaScript('notags');	
							$js_code.=$win_task->getJavaScript();													
							
						}
						unset($win_task);		
					}					
				}		
			
				break;
				
				case 'update':
				
					if(isset($_GET['id']))
					{
						$win_task = new api_wintask; 
						$win_task->setID(filter::num($_GET['id']));
						$win_task->getWindow();				
						$win_task->setParams($_GET['parameters_parsed']);					
						$win_task->updateWindow();							
						unset($win_task);
					}
				break;

				default:
				break;
		} 
	} // if !action
	
	
if($_GET['action']!='update')
{
	$t = new phpos_tasks;
	echo $t->render_tasks();
	$js_context_menu = $t->get_jquery();
	$styles = $t->get_styles();	
}
?>

<style><?php echo $styles; ?></style>
<script>
$(document).ready(function() { 

	$('.phpos-menustart_TaskItem').mouseenter(function()
	{
		$(this).removeClass('phpos-menustart_TaskItem_mouseout').addClass('phpos-menustart_TaskItem_mouseover');		
	});
	
	$('.phpos-menustart_TaskItem').mouseleave(function()
	{
		$(this).removeClass('phpos-menustart_TaskItem_mouseover').addClass('phpos-menustart_TaskItem_mouseout');		
	});	
	
	
	var restore = setTimeout(function()
	{
		
		<?php echo $js_code; ?>

	}	, 1000);
	
	
	//alert('<?php echo txt('copy'); ?>');
	
	
	// document click i czy nie hover !!!!!!!!!!!! na all!!!
	
	
});
$(function(){
		
		<?php  echo $js_context_menu; ?>		
});
</script>