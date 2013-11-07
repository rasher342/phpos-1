<?php
/*
**********************************

	PHPOS Web Operating system
	MIT License
	(c) 2013 Marcin Szczyglinski
	szczyglis83@gmail.com
	GitHUB: https://github.com/phpos/
	File version: 1.3.5, 2013.11.07
 
**********************************
*/
if(!defined('PHPOS'))	die();	


	function winConfig($helper_name, $helper_params = null)
	{
		// Get globals
		$app_name = glb::get('app_name');
		$app_action = glb::get('app_action');
		$app_param = glb::get('app_param');	
		$win_obj = glb::get('apiWindow');
		
		switch($helper_name)
		{
		
	// ----------
			case 'use_params':
				
				// If GET parameters, then parse them and apply to window object
				if(!empty($_GET['app_params']))
				{
					$win_obj->setAppParams($_GET['app_params']);
					glb::set('apiWIndow', $win_obj);
				}	
				
				// If empty params (file included by ajax, from parent main window?)
				if(!$helper_params && !is_array(glb::get('app_param')))
				{
					$app_param = $win_obj->getParam('app_params');
				}
				
				// Parse APP params
				foreach($app_param as $key => $value)
				{
					$param_name = $key;
					$param_value = $value;
					
					// If object have param data in window object
					
					
					
					
					if($win_obj->appParam($param_name))
					{
						$app_param[$param_name] = $win_obj->appParam($param_name);
					}	else {
						$win_obj->set_appParam($param_name, $param_value);
					}
				}	
				glb::set('app_param', $app_param); // Apply parameters to global
				$win_obj->updateWindow();
				glb::set('apiWindow', $win_obj);
				
				
			break;

	 // ----------
				case 'use_menu':
				
					// Default menu file = action, e.g. "indexMenu.php" (in main app folder)
					$menu_file = $app_action;
					
					// Override menu file if specified in array
					if(is_array($params))
					{				
						$menu_file = $params[$app_action];			
					}		
					
					// If menu exists, load it
					if(file_exists(PHPOS_APPS_DIR.$app_name.'/'.$menu_file.'Menu.php'))
					{
						include PHPOS_APPS_DIR.$app_name.'/'.$menu_file.'Menu.php';
						glb::set('app_menu', $app_menu); // Apply loaded menu to global
					}
					
				break;
				
				// ----------
				case 'use_toolbar':
				
					// Default toolbar file = action, e.g. "indexToolbar.php" (in main app folder)
					$toolbar_file = $app_action;
					
					// Override menu file if specified in array
					if(is_array($params))
					{				
						$toolbar_file = $params[$app_action];			
					}		
					
					// If menu exists, load it
					if(file_exists(PHPOS_APPS_DIR.$app_name.'/'.$toolbar_file.'Toolbar.php'))
					{
						include PHPOS_APPS_DIR.$app_name.'/'.$toolbar_file.'Toolbar.php';
						glb::set('app_toolbar', $app_toolbar); // Apply loaded menu to global
					}
					
				break;
				
				
				
				
				
	 // ----------			
				case 'use_action':
				
				// Override actual action
				
				break;
				
	 // ----------		
				case 'langs':		
				
					// Load app langs config to global app_langs
					if(is_array($helper_params))
					{
						$win_obj->appParam('_config_langs', $helper_params);
						glb::set('apiWindow', $win_obj);
						glb::set('app_langs', $helper_params);				
					}
					
				break;
				
				
	 // ----------		
				case 'use_lang':	
				
					// if param = choosen lang
					if(!empty($helper_params))
					{
						$lang = $helper_params;			
						
					} else {
						
						// if empty, get info from window
						$obj_lang = $win_obj->appParam('_config_lang');
						if(!empty($obj_lang))
						{
							$lang = $obj_lang;
							
						}	else {	

							// set from global OS config
							$lang = cfg::get('lang');					
						}
					}		
					
					// Set app lang
					glb::set("app_lang", $lang);
					
					// Get app available langs
					$app_langs = glb::get('app_langs');
					
					// If empty langs try load info from window params
					if(!is_array($app_langs))
					{
						$app_langs = $win_obj->appParam('_config_langs');
					}				
					
					// Get global lang file
					$txt = glb::get('txt');
					
					// Set app lang file to load
					$lang_file = $app_langs[$lang];
					
					
					// Load lang file
					if(file_exists(PHPOS_APPS_DIR.$app_name.'/lang/'.$lang_file.'Lang.php'))
					{
						include PHPOS_APPS_DIR.$app_name.'/lang/'.$lang_file.'Lang.php';
						$win_obj->appParam('_config_lang', $lang);
						$win_obj->updateWindow();
						glb::set('apiWindow', $win_obj);
						
						glb::set('txt', $txt); // add app lang to global lang					
					}
					
				break;
				
		}
	}

			 
/*
**************************
*/
 	
	function txt($str)
	{
		// Get global txt array
		
		global $txt;
		if(!is_array($txt)) $txt = $_SESSION['txt'];
		// if key is in array, translate:
		
		if(is_array($txt) && array_key_exists($str, $txt) && !empty($txt[$str]))
		{
			return $txt[$str];
		} else {
			return $str; // if not, return input string
		}
	}
				 
/*
**************************
*/
 	
// Helper for generating ajax links in app	
	function helper_ajax($file, $params = null)
	{
		// get globals
		$app_name = glb::get('app_name');
		$app_action = glb::get('app_action');	
		$win_obj = glb::get('apiWindow');
		$win_id = $win_obj->getID();
		
		
		if(is_array($params))
		{
			$p = array();
			foreach($params as $k => $v)
			{
				$p[] = $k.'='.$v;		
			}	
			
			$url_params = implode("&", $p);
			
			$params_to_link = '';
			if(!empty($url_params))
			{
				$params_to_link = '&'.$url_params;
			}		
		}	
		
		// generate and return URL
		$url = PHPOS_DIR.'_phpos/controllers/windowsLoaderController.php?id='.$win_id.'&ajax_include=1&app_id='.$app_name.'&app_action='.$app_action.'&ajax_file='.$file.$params_to_link;	
		
		return $url;
	}
				 
/*
**************************
*/
 	
	
	function helper_post($file, $params = null)
	{
		// get globals
		$app_name = glb::get('app_name');
		$app_action = glb::get('app_action');	
		$win_obj = glb::get('apiWindow');
		$win_id = $win_obj->getID();
		
		
		if(is_array($params))
		{
			$p = array();
			foreach($params as $k => $v)
			{
				$p[] = $k.'='.$v;		
			}	
			
			$url_params = implode("&", $p);
			
			$params_to_link = '';
			if(!empty($url_params))
			{
				$params_to_link = '&'.$url_params;
			}		
		}	
		
		// generate and return URL
		$url = PHPOS_DIR.'_phpos/controllers/windowsLoaderController.php?id='.WIN_ID.'&app_id='.$app_name.'&app_action='.APP_ACTION.'&ajax_file='.$file.$params_to_link;	
		
		return $url;
	}
				 
/*
**************************
*/
 	
	function helper_post_outside($file, $params = null, $win_id)
	{	
		if(is_array($params))
		{
			$p = array();
			foreach($params as $k => $v)
			{
				$p[] = $k.'='.$v;		
			}	
			
			$url_params = implode("&", $p);
			
			$params_to_link = '';
			if(!empty($url_params))
			{
				$params_to_link = '&'.$url_params;
			}		
		}	
		
		// generate and return URL
		$url = PHPOS_DIR.'_phpos/controllers/windowsLoaderController.php?id='.$win_id.'&app_id=explorer&app_action=index'.$params_to_link;	
		
		return $url;
	}
	
				 
/*
**************************
*/
 	
	
	function helper_reload($params = null)
	{		
		if(is_array($params))
		{
			foreach($params as $key => $value)
			{
				if(!empty($key))
				{
					$p[] = $key.':'.$value;
				}
			}
			
			$param_url = implode(",", $p);		
		}
		
		$str = "phpos.windowRefresh('".WIN_ID."','".$param_url."');";		
		return $str;	
	}		
				 
/*
**************************
*/
 	
// helper for declaring unique DIV's (for many instances of window)
// if arg = null, then echo(), if arg!=null, then only return without echo	

	function div($ret = null)
	{
		$win_obj = glb::get('apiWindow');
		if($ret==null)
		{
			echo '_'.$win_obj->getID(); 
		}

		return '_'.$win_obj->getID(); 
	}
				 
/*
**************************
*/
 	
	function helper_result($id = null, $type = null, $result = null)
	{
		//msg::ok('yyyyyy');		
		
		if(!empty($type) && !empty($result))
		{		
			switch($type)
			{
				case 'ok':
					$_SESSION['RESULT_STATUS'][$id] = 'ok';
					$_SESSION['RESULT'][$id] = $result;
				break;
				
				case 'error':
					$_SESSION['RESULT_STATUS'][$id] = 'error';
					$_SESSION['RESULT'][$id] = $result;				
				break;
				
				case 'var':
					$_SESSION['RESULT_STATUS'][$id] = 'var';
					$_SESSION['RESULT'][$id] = $result;				
				break;
				
				case 'result':
					$_SESSION['RESULT_STATUS'][$id] = 'result';
					$_SESSION['RESULT'][$id] = $result;				
				break;
			
				case 'info':
					$_SESSION['RESULT_STATUS'][$id] = 'info';
					$_SESSION['RESULT'][$id] = $result;				
				break;
			
			}		
		} else {
		
			
			if(!empty($_SESSION['RESULT'][$id]) && !empty($_SESSION['RESULT_STATUS'][$id]))
			{				
				switch($_SESSION['RESULT_STATUS'][$id])
				{
				
					
					case 'ok':
						msg::ok($_SESSION['RESULT'][$id]);
						return '<div class="phpos_result phpos_result_ok"><img src="'.PHPOS_WEBROOT_URL.'_phpos/icons/status_ok.png" /><p>'.$_SESSION['RESULT'][$id].'</p></div>';
					break;
					
					case 'error':
						msg::error($_SESSION['RESULT'][$id]);
						return '<div class="phpos_result phpos_result_error"><img src="'.PHPOS_WEBROOT_URL.'_phpos/icons/status_error.png" /><p>'.$_SESSION['RESULT'][$id].'</p></div>';	
					break;
					
					case 'var':
						$res = $_SESSION['RESULT'][$id];
						return $res;	
					break;
					
					case 'result':
						$res = $_SESSION['RESULT'][$id];
						return $res;	
					break;
				
					case 'info':
						msg::info($_SESSION['RESULT'][$id]);
						return '<div class="phpos_result phpos_result_info"><img src="'.PHPOS_WEBROOT_URL.'_phpos/icons/status_info.png" /><p>'.$_SESSION['RESULT'][$id].'</p></div>';	
						
					break;				
				}	
				
				unset($_SESSION['RESULT_STATUS'][$id]);
				unset($_SESSION['RESULT'][$id]);
			}		
		}			
	}	
				 
/*
**************************
*/
 	
	function logged_id()
	{	
		$my_user = new phpos_users;			
		$my_user->get_logged_user();
		$id = $my_user->get_id_user();
		return $id;
	}
				 
/*
**************************
*/
 	
	function logged_login()
	{	
		$my_user = new phpos_users;			
		$my_user->get_logged_user();
		$login = $my_user->get_user_login();
		return $login;
	}
				 
/*
**************************
*/
 	
	function is_user()
	{	
		$my_user = new phpos_users;			
		$my_user->get_logged_user();
		$access_level = $my_user->get_access_level();
		if($access_level == 1) return true;
	}
				 
/*
**************************
*/
 	
	function is_admin()
	{	
		$my_user = new phpos_users;			
		$my_user->get_logged_user();
		$access_level = $my_user->get_access_level();
		if($access_level == 2) return true;
	}
				 
/*
**************************
*/
 	
	function is_root()
	{	
		$my_user = new phpos_users;				
		$my_user->get_logged_user();
		$access_level = $my_user->get_access_level();
		if($access_level == 3) return true;
	}
	
				 
/*
**************************
*/
 	
	function cache_param($param)
	{
		global $my_app;
		$param_value = $my_app->get_param($param);
		$my_app->window->set_AppParam($param, $param_value);	
	}
				 
/*
**************************
*/
 	
	function link_action($action, $params = null)
	{
		$str = 'phpos.windowActionChange(\''.WIN_ID.'\', \''.$action.'\', \''.$params.'\');';
		return $str;	
	}
				 
/*
**************************
*/
 	
	function jquery_onready($js)
	{
		global $my_app;
		$my_app->jquery_onready($js);
	}
				 
/*
**************************
*/
 	
	function jquery_function($js)
	{
		global $my_app;
		$my_app->jquery_functions($js);
	}
				 
/*
**************************
*/
 	
	function winopen($title = 'New window', $app = 'explorer', $params = 'fs:local_files', $app_params = null)
	{		
		$str = "phpos.windowCreate('".$title."','".$app."', '".$params."', '".$app_params."')";	
		//this.controllerWindows('action=create&title=' + title_encode + '&wintype=' + type_encode + '&params=' + json_params_encode + app_params_url);
		return $str;	
	}			
				 
/*
**************************
*/
 	
	function winmodal($title = 'New window', $app = 'explorer', $params = 'fs:local_files', $app_params = null)
	{		
		$str = "phpos.windowCreateModal('".$title."','".$app."', '".$params."', '".$app_params."')";	
		//this.controllerWindows('action=create&title=' + title_encode + '&wintype=' + type_encode + '&params=' + json_params_encode + app_params_url);
		return $str;	
	}		
				 
/*
**************************
*/
 	
	function winset($name = null, $param = null)
	{				
		switch($name)
		{
			case 'title':
				$mode = 'setTitle';	
				$js_param = $param;
			break;
	
			case 'width':
				$mode = 'width';	
				$js_param = $param;				
			break;
			
			case 'height':
				$mode = 'height';	
				$js_param = $param;				
			break;		
		}
		
		if(!empty($mode))
		{		
			$jquery_code = "
				phpos.winset('".WIN_ID."', '".$mode."', '".$js_param."');
				";
				
			global $my_app;		
			$my_app->jquery_onready($jquery_code);	
		}
		
		
		/*$str = "phpos.windowCreate('".$title."','".$app."', '".$params."', '".$app_params."')";	
		return $str;	*/
	}	
				 
/*
**************************
*/
 	
	function wincenter()
	{	
		$jquery_code = "
				phpos.wincenter('".WIN_ID."');
				";				
		global $my_app;		
		$my_app->jquery_onready($jquery_code);	
	}
				 
/*
**************************
*/
 	
	function form_submit($id)
	{
		if($_POST['phpos_form_'.$id])
		{			
			$_POST['phpos_form_'.$id] = null;		
			$_SESSION['post']['phpos_form_'.$id] = null;		
			return true;
		} 	
	}
				 
/*
**************************
*/
 	
	function winreload($id = null, $params = null)
	{	
		if(is_array($params))
		{
			foreach($params as $key => $value)
			{
				if(!empty($key))
				{
					$p[] = $key.':'.$value;
				}
			}
			
			$param_url = implode(",", $p);		
		}
		
		if(empty($id)) $id = WIN_ID;
		
		$js = "phpos.windowRefresh('".$id."','".$param_url."');";		
		global $my_app;		
		$my_app->jquery_onready($js);		
		
		return $js;	
	}		
	
				 
/*
**************************
*/ 	
	
	function winclose($id, $script = null)
	{		
		if($script == 'script')
		{
			$str = "<script>phpos.windowClose(".$id.");</script>";
		} else {
			$str = "phpos.windowClose(".$id.");";
		}
		
		return $str;	
	}
				 
/*
**************************
*/
 	
	function myconfig($config_name, $config_value = null)
	{
		$usr = new phpos_users;
		$config = new phpos_config;
		if($usr->user_is_logged())
		{						
			$config->set_id_user($usr->get_logged_user());
			return $config->get_user($config_name);
		}	
	}
				 
/*
**************************
*/
 	
	function globalconfig($config_name, $config_value = null)
	{				
		$config = new phpos_config;
		if($config_value !== null)
		{
			$config->update_global($config_name, $config_value);	
		}
		return $config->get_global($config_name);		
	}
				 
/*
**************************
*/
 	
	function activity()
	{				
		$usr = new phpos_users;
		$usr->set_id_user(logged_id());
		$usr->activity();
	}
				 
/*
**************************
*/
 	
	function savelog($msg)
	{
	
		$phpos_log = new phpos_logs;		
		$phpos_log->create_log($msg);	
	}
					 
/*
**************************
*/
 	
	function param($param_name, $param_value = '--no_param--')
	{
		global $my_app;
		
		if($param_value != '--no_param--')
		{
			$my_app->set_param($param_name, $param_value);
			return $my_app->get_param($param_name);
			
		} else {
		
			return $my_app->get_param($param_name);
		}	
	}
					 
/*
**************************
*/
 	
	function apiLoad($file_id, $window_title = 'Opened file')
	{
		global $my_app;
		$str = 'phpos.windowCreate("'.$window_title.'", "app", "app_id:notepad@index","loadAPI:1,loadFS:'.$my_app->get_param('fs').',loadID:'.base64_encode($file_id).'");';
		return $str;	
	}
				 
/*
**************************
*/
 	
	function browser_url($url, $mode = '_blank')
	{
		$str = "
		var url = '".$url."';
		window.open(url, '".$mode."'); 
		";  
		return $str;	
	}
				 
/*
**************************
*/
 		
	function notify($result, $msg)
	{
		global $my_app;
			
			$my_app->set_param('action_status', $result);
			$my_app->set_param('action_status_msg', $msg);
			cache_param('action_status');	
			cache_param('action_status_msg');					
			msg::error($msg);			
	}
	
	
// == Define globals for helpers
		$phposHELPERS = array();
		$phposHELPERS['messages'] = array();
	
					 
/*
**************************
*/
 	
	function helper_waiting($msg = null, $noscript = null)
	{
		$data = '';
		if($msg != null) $data = '"'.$msg.'"';
		$js = 'phpos.waiting_show('.$data.');';
		
		if($noscript == true)
		{		
			return $js;
			
		} else {
		
			echo '<script>'.$js.'</script>';
			return $js;
		}	
	}
						 
/*
**************************
*/
 	
	function helper_stopwaiting($force = null, $noscript = null)
	{
		$js = 'phpos.waiting_hide();';
		if($force != null) $js = 'phpos.waiting_hide_execute();';		
		
		if($noscript == true)
		{		
			return $js;
			
		} else {
		
			echo '<script>'.$js.'</script>';
			return $js;
		}	
	}
/*
**************************
*/	
	function apply_status($status, $msg = null, $force = null, $noscript = null)
	{
		$js = 'phpos.applyStatus("'.$status.'", "'.$msg.'");';
		if($force != null) $js = 'phpos.showStatus();';
		
		if($noscript == true)
		{		
			return $js;
			
		} else {
		
			echo '<script>'.$js.'</script>';
			return $js;
		}	
	}
?>