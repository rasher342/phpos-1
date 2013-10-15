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
if(!defined('PHPOS'))	die();	


class phpos_app
{
	private
		$app_id,
		$app_action,
		
		$window_id,
		$process_id,		
		$config,
		$params,
		$param = array(),
		$available_params = array(),
		$sections = array(),
		
		$jquery_functions = array(),
		$jquery_onready = array(),
		
		$multilanguage = 0,
		
		$access_level,	
		$access_level_cp,
		$access_level_sections,
		$control_panels,
		$hidden,
		$version,
		$author,
		$website,
		$email,
		$desc,
		$title,
		$icon,
		$default_action,
		$default_section,
		$multiple_windows,
		$db_schema,
		$installer,	
		$css,
		$js,
		$plugin,		
		
		$actions = array();
			 
/*
**************************
*/
 	
		public
			$window,
			$user;
		
		 
/*
**************************
*/
 		
		
		public function __construct()
		{
			
		
		
		
		}
	 
/*
**************************
*/
 	
		public function set_window($win_object)
		{
			$this->window = $win_object;
		}
			 
/*
**************************
*/
 	
		public function set_user($user_object)
		{
			$this->user = $user_object;
		}
			 
/*
**************************
*/
 	
		public function set_app_id($app_id)
		{
			$this->app_id = $app_id;
		}
			 
/*
**************************
*/
 	
		public function get_app_id()
		{
			return $this->app_id;
		}
			 
/*
**************************
*/
 	
		public function set_app_action($app_action)
		{
			$this->app_action = $app_action;
		}
		
		
		
			 
/*
**************************
*/
 	
		public function get_app_action()
		{
			return $this->app_action;
		}
		
		public function get_multilanguage()
		{
			return $this->multilanguage;
		}
		
		public function is_multilanguage()
		{
			if($this->multilanguage == 1) return true;
		}
			 
/*
**************************
*/
 	
		public function config_exists()
		{
			if(file_exists(PHPOS_APPS_DIR.$this->app_id.'/config.php'))
			{
				return true;
			}		
		}
		
			 
/*
**************************
*/
 		

 	
		public function get_access_level_section($section_id)
		{		
			//return $this->access_level_sections[$section_id];
			if(is_array($this->sections) && array_key_exists($section_id, $this->sections))
			{
				return $this->sections[$section_id]['access_level'];
			}			
		}

			 
/*
**************************
*/
 	
		public function user_have_access()
		{
			$access_app = $this->get_access_level();
			$user = new phpos_users;
			$user->get_logged_user();					
			$access_user = $user->get_access_level();			
			if($access_user >= $access_app)
			{
				return true;
			}
		}
			 
/*
**************************
*/
 			public function user_have_action_access($action)
		{
			$access_action = intval($this->action_access($action));
			$user = new phpos_users;
			$user->get_logged_user();					
			$access_user = intval($user->get_access_level());	
		
			if($access_user >= $access_action)
			{
				return true;
			}
			
		}
		
/*
**************************
*/
 			public function user_check_access($access_level)
		{
			$access_to_check = intval($access_level);
			$user = new phpos_users;
			$user->get_logged_user();					
			$access_user = intval($user->get_access_level());	
		
			if($access_user >= $access_to_check)
			{
				return true;
			}
			
		}			
/*
**************************
*/
		public function user_have_access_cp()
		{
			$access_app = $this->get_access_level_cp();
			
			$user = new phpos_users;
			$user->get_logged_user();					
			$access_user = $user->get_access_level();
			
			
			if($access_user >= $access_app)
			{
				return true;
			}
		}
			 
/*
**************************
*/
 	
		public function user_have_access_section($section_id)
		{
			$access_section = $this->get_access_level_section($section_id);			
			$user = new phpos_users;
			$user->get_logged_user();					
			$access_user = $user->get_access_level();		
			
			if(empty($access_section))
			{
				return false;
			}
			
			if($access_user >= $access_section)
			{
				return true;
			} 
		}
			 
/*
**************************
*/
 	
		public function is_hidden()
		{
			if($this->hidden) return true;
		}
		
			 
/*
**************************
*/
 	
		public function get_icon($type = 'app', $cp_icon = null)
		{			
			$icon = $this->icon;
			$default = 'default_icon_app.png';
			
			if($type == 'cp') {
				$icon = $cp_icon;
				$default = 'default_icon_cp.png';
			}
			
		
			if(!empty($icon))
			{
				if(file_exists($icon))
				{
					return $icon;
				} else {				
					
					if(file_exists(PHPOS_DIR.'apps/'.$this->app_id.'/resources/'.$icon))
					{
						return PHPOS_URL.'apps/'.$this->app_id.'/resources/'.$icon;
						
					} else {
					
						if(file_exists(PHPOS_WEBROOT_DIR.'_phpos/icons/'.$icon))
						{
							return ICONS.$icon;
							
						} else {
						
							if($type == 'cp') return $this->get_icon();
							return PHPOS_WEBROOT_DIR.'_phpos/icons/'.$default;
						}					
					}				
				}			
			} else {
				//echo 	$this->app_id.':ikona: '.$icon.'<br>';
					
				if($type == 'cp') return $this->get_icon();
				return PHPOS_WEBROOT_DIR.'_phpos/icons/'.$default;
			}		
		}
			 
/*
**************************
*/
 	
		
		public function load_config()
		{
			if($this->config_exists())
			{
				include PHPOS_APPS_DIR.$this->app_id.'/config.php';
								
				$this->app_id = $app_id;
				$this->access_level =	$access_level;
				$this->access_level_cp =	$cp_access_level;			
				$this->hidden = $hidden;
				$this->version = $version;
				$this->author = $author;
				$this->website = $website;
				$this->desc = $desc;
				$this->email = $email;
				$this->actions = $actions;
				$this->sections = $section;
				$this->title = $title;
				$this->icon = $icon;
				$this->multilanguage = $multilanguage;
				$this->default_action = $default_action;
				$this->default_section =$default_section;
				$this->control_panels =	$control_panels;
				$this->multiple_windows = $multiple_windows;
				$this->db_schema = $db_schema;
				$this->installer = $installer;
				$this->css = $css;
				$this->js = $js;	
				$this->plugin = $plugin;
				$this->available_params = $app_param;
			}
		}

		 
/*
**************************
*/
 	
	public function set_param($param_name, $param_value)
	{
		$this->param[$param_name] = $param_value;		
		//$this->window->updateWindow();
	}
		
		 
/*
**************************
*/


public function app_required_params()
{
	if(is_array($this->available_params))
	{
		$params_array = array();
		$c = count($this->available_params);
		if($c!=0)
		{
			foreach($this->available_params as $name => $data)
			{
				if($this->param_is_required($name))
				{
					$value = $this->default_param_value($name);
					$params_array[] = $name.':'.$value;				
				}			
			}		
		}	
		
		return $params_array;
	}
}


		
/*
**************************
*/
	
	public function link_action()
	{		
		$link_params = $this->app_required_params();	
		if(!is_array($link_params)) $link_params = array();
		
		$app_action = $this->default_app_action();
		$app_plugin = $this->app_used_plugin();
		
		if(!empty($this->default_section))
		{
			$link_params[] = 'section:'.$this->default_section;		
		}		
		
		$parse_params = implode(',', $link_params);
		
		$link = winopen($this->get_title(), $app_plugin, 'app_id:'.$this->app_id.'@'.$app_action, $parse_params);
		//echo htmlspecialchars($link);
		return $link;
		//function winopen($title = 'New window', $app = 'explorer2', $win_params = 'app_id', $app_params = 'fs:')
	}
		 
/*
**************************
*/
	
	public function app_param_info($id)
	{
		return $this->available_params[$id];	
	}	
			 
/*
**************************
*/
		
	public function default_param_value($id)
	{
		$p = $this->available_params[$id];
		return $p['default'];	
	}
		
/*
**************************
*/
	
	public function param_is_required($id)
	{
		$p = $this->available_params[$id];
		if($p['required']) return true;
	}
		
/*
**************************
*/
		
	public function get_param_name($id)
	{
		$p = $this->available_params[$id];
		return $p['name'];
	}
		
/*
**************************
*/
	
	public function app_param_values($id)
	{
		$params = $this->available_params;
		$p = $params[$id];
		$items = $p['values'];
		if(!empty($items)) 
		{
			$a = explode(',', $items);
			return $a;
		}
	}
		 
/*
**************************
*/
		
	public function action_name($id)
	{
		if(is_array($this->actions) && array_key_exists($id, $this->actions))
		{		
			return $this->actions[$id]['name'];
		}	
	}
			 
/*
**************************
*/
	
	public function action_access($id)
	{
		if(is_array($this->actions) && array_key_exists($id, $this->actions))
		{		
			return $this->actions[$id]['access_level'];
		}	
	}
		 
/*
**************************
*/
	
	public function default_app_action()
	{
		if(empty($this->default_action)) $this->default_action = 'index';
		return $this->default_action;		
	}
		 
/*
**************************
*/
	
	public function app_used_plugin()
	{
		if(empty($this->plugin)) $this->plugin = 'app';
		return $this->plugin;		
	}

 			 
/*
**************************
*/
	
	public function get_param($param_name)
	{
		return $this->param[$param_name];
	}
		 
/*
**************************
*/
 	
	public function get_params()
	{
		return $this->param;
	}
	
	
		 
/*
**************************
*/
 	
	
	public function using($helper_name, $helper_params = null)
	{
	// Get globals
	$app_name = glb::get('app_name');
	$app_action = glb::get('app_action');
	$app_param = glb::get('app_param');	
	$win_obj = glb::get('apiWindow');
	
	switch($helper_name)
	{
	
// ----------
		case 'params':
			
			// If GET parameters, then parse them and apply to window object
			if(!empty($_GET['app_params']))
			{
				$this->window->setAppParams($_GET['app_params']);				
			}	
			
			// If empty params (file included by ajax, from parent main window?)
			if(!$helper_params && !is_array($this->param))
			{
				$this->param = $this->window->getParam('app_params');
			}
			
			// Parse APP params
			foreach($this->param as $key => $value)
			{
				$param_name = $key;
				$param_value = $value;
				
				// If object have param data in window object
				
				
				
				
				if($this->window->appParam($param_name))
				{
					$this->param[$param_name] = $this->window->appParam($param_name);
				}	else {
					$this->window->set_appParam($param_name, $param_value);
				}
			}	
			
			$this->window->updateWindow();			
			
		break;

 // ----------
			case 'menu':
			
				// Default menu file = action, e.g. "indexMenu.php" (in main app folder)
				$menu_file = $this->app_action;
				
				// Override menu file if specified in array
				if(is_array($params))
				{				
					$menu_file = $params[$this->app_action];			
				}		
				
				// If menu exists, load it
				if(file_exists(PHPOS_APPS_DIR.$this->app_id.'/'.$menu_file.'Menu.php'))
				{
					include PHPOS_APPS_DIR.$this->app_id.'/'.$menu_file.'Menu.php';
					$this->window->renderMenu($app_menu);
					
					$js = $this->window->get_layout_menu_js();
					$this->jquery_onready($js);
				}
				
			break;
			
			// ----------
			case 'toolbar':
			
				// Default toolbar file = action, e.g. "indexToolbar.php" (in main app folder)
				$toolbar_file = $this->app_action;
				
				// Override menu file if specified in array
				if(is_array($params))
				{				
					$toolbar_file = $params[$this->app_action];			
				}		
				
				// If menu exists, load it
				if(file_exists(PHPOS_APPS_DIR.$this->app_id.'/'.$toolbar_file.'Toolbar.php'))
				{
					include PHPOS_APPS_DIR.$this->app_id.'/'.$toolbar_file.'Toolbar.php';
					$this->window->render_toolbar($app_toolbar, $this->get_param('section'));
					
					$js = $this->window->get_layout_toolbar_js();
					$this->jquery_onready($js);
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
 	
	public function jquery_onready($js = null)
	{
		if(!empty($js))
		{
			$this->jquery_onready[] = $js;
			
		} else {			
		
			$sep = " 
			";
			
			$c = count($this->jquery_onready);
			
			if($c != 0)
			{
				$render_jquery = implode($sep, $this->jquery_onready);
				
				$full_code = '$(document).ready(function() { 	
				'.$render_jquery.'
				});
				';
				
				return $full_code;
			}
		}		
	}
	
	 
/*
**************************
*/
 		
	public function jquery_functions($js = null)
	{
		if(!empty($js))
		{
			$this->jquery_functions[] = $js;
			
		} else {			
		
			$sep = " 
			";
			
			$c = count($this->jquery_functions);
			
			if($c != 0)
			{
				$render_jquery = implode($sep, $this->jquery_functions);
				
				$full_code = '$(function(){ 	
				'.$render_jquery.'
				});
				';
				
				return $full_code;
			}
		}		
	}
		 
/*
**************************
*/
 	
	public function render_javascript_jquery()
	{
		$jquery_onready = $this->jquery_onready();
		$jquery_functions = $this->jquery_functions();
		
			$js_render = '<script type="text/javascript">
			'.$jquery_onready.'
			'.$jquery_functions.'			
			</script>';
	
			
		return $js_render;
	}
	
		 
/*
**************************
*/
 	
	
	public function section($section_id)
	{		
		if($this->user_have_access_section($section_id))
		{		
			if(file_exists(MY_APP_DIR.'views/section.'.$section_id.'.php'))
			{	
				define('PHPOS_SECTION_ACCESS', true);
				global $layout;				
				$my_app = $this;
				require MY_APP_DIR.'views/section.'.$section_id.'.php';				
			}
			
		} else {
			
			echo '<div class="form_error_message phpos_form_input_field_error"><img src="'.PHPOS_WEBROOT_URL.'_phpos/installer/status_error.png" /><p>Error. Access to this section is blocked for your account type.</p></div>';
			
		}
	}
		 
/*
**************************
*/
 	
	public function have_cp()
		{
			if(is_array($this->control_panels) && !empty($this->control_panels[0])) return true;		
		}
		 
/*
**************************
*/
 		
	public function get_cp_list()
	{
			
			if($this->have_cp())
			{				
				$cp_array = array();
				foreach($this->control_panels as $cp_data)
				{					
					if(is_array($cp_data))
					{						
						$cp_info = array();
						$cp_info['id'] = $cp_data[0];
						$cp_info['access_level'] = $cp_data[4];
						$cp_info['title'] = $cp_data[1];
						$cp_info['app_title'] = $this->title;
						$cp_info['app_id'] = $this->app_id;
						$cp_info['icon'] = $cp_data[2];
						$cp_info['desc'] = $cp_data[3];
						$cp_array[] = $cp_info;					
					}				
				}
			return $cp_array;
			}		
		}
		
	 
/*
**************************
*/
 	

		public function apps_list()
		{
			$dir = glob(PHPOS_APPS_DIR.'*');
			$apps = array();
			foreach($dir as $app_dir)
			{
				if(is_dir($app_dir))
				{
					$apps[] = basename($app_dir);				
				}			
			}
			
			return $apps;		
		}
	 
/*
**************************
*/
 	public function my_apps_list()
		{
			$dir = glob(PHPOS_APPS_DIR.'*');
			$apps = array();
			foreach($dir as $app_id)
			{
				if(is_dir($app_id))
				{
					$app_name = basename($app_id);
					
					$app = new phpos_app;
					$app->set_app_id($app_name);
					$app->load_config();
					
					if($app->user_have_access()) $apps[] = $app_name;								
				}			
			}
			
			return $apps;		
		}
	 
/*
**************************
*/
		public function cp_list()
		{
			$all_apps = $this->apps_list();			
			foreach($all_apps as $app_name)
			{
				$app = new phpos_app;
				$app->set_app_id($app_name);
				$app->load_config();
				
				if($app->have_cp())
				{				
					$cp_array[] = $app->get_cp_list();							
				}			
			}			
			return $cp_array;
		}
	 
/*
**************************
*/
 	

	public function get_access_level()
{
  return $this->access_level;
}


/*
**************************
*/


public function set_access_level($access_level)
{
  $this->access_level = $access_level;
}


/*
**************************
*/



public function get_access_level_cp()
{
  return $this->access_level_cp;
}


/*
**************************
*/


public function set_access_level_cp($access_level_cp)
{
  $this->access_level_cp = $access_level_cp;
}


/*
**************************
*/



public function get_access_level_sections()
{
  return $this->access_level_sections;
}


/*
**************************
*/


public function set_access_level_sections($access_level_sections)
{
  $this->access_level_sections = $access_level_sections;
}


/*
**************************
*/



public function get_control_panels()
{
  return $this->control_panels;
}


/*
**************************
*/


public function set_control_panels($control_panels)
{
  $this->control_panels = $control_panels;
}


/*
**************************
*/



public function get_hidden()
{
  return $this->hidden;
}


/*
**************************
*/


public function set_hidden($hidden)
{
  $this->hidden = $hidden;
}


/*
**************************
*/



public function get_version()
{
  return $this->version;
}


/*
**************************
*/


public function set_version($version)
{
  $this->version = $version;
}


/*
**************************
*/



public function get_author()
{
  return $this->author;
}


/*
**************************
*/


public function set_author($author)
{
  $this->author = $author;
}


/*
**************************
*/



public function get_website()
{
  return $this->website;
}


/*
**************************
*/


public function set_website($website)
{
  $this->website = $website;
}


/*
**************************
*/



public function get_email()
{
  return $this->email;
}


/*
**************************
*/


public function set_email($email)
{
  $this->email = $email;
}


/*
**************************
*/



public function get_raw_desc()
{
  return $this->desc;
}


/*
**************************
*/


public function set_desc($desc)
{
  $this->desc = $desc;
}


/*
**************************
*/
public function get_raw_title()
{
  
  if(!empty($this->title))
	{
		return $this->title;
	} else {
		return $this->app_id;
	}
}

 
/*
**************************
*/
 	

public function get_desc()
{
  if($this->is_multilanguage())
	{
			return txt($this->desc);
			
	} else {
		
			return $this->desc;
	}
}

 
/*
**************************
*/
 	

public function get_title()
{
  
  if(!empty($this->title))
	{
		if($this->is_multilanguage())
		{
			return txt($this->title);
		} else {
		
			return $this->title;
		}
			
	} else {
		return $this->app_id;
	}
}


/*
**************************
*/


public function set_title($title)
{
  $this->title = $title;
}


/*
**************************
*/



public function set_icon($icon)
{
  $this->icon = $icon;
}


/*
**************************
*/



public function get_default_action()
{
  return $this->default_action;
}


/*
**************************
*/


public function set_default_action($default_action)
{
  $this->default_action = $default_action;
}


/*
**************************
*/



public function get_multiple_windows()
{
  return $this->multiple_windows;
}


/*
**************************
*/


public function set_multiple_windows($multiple_windows)
{
  $this->multiple_windows = $multiple_windows;
}


/*
**************************
*/



public function get_db_schema()
{
  return $this->db_schema;
}


/*
**************************
*/


public function set_db_schema($db_schema)
{
  $this->db_schema = $db_schema;
}


/*
**************************
*/



public function get_installer()
{
  return $this->installer;
}


/*
**************************
*/


public function set_installer($installer)
{
  $this->installer = $installer;
}


/*
**************************
*/



public function get_css()
{
  return $this->css;
}


/*
**************************
*/


public function set_css($css)
{
  $this->css = $css;
}


/*
**************************
*/

public function get_plugin()
{
  return $this->plugin;
}


/*
**************************
*/


public function set_plugin($plugin)
{
  $this->plugin = $plugin;
}

/*
**************************
*/


public function get_js()
{
  return $this->js;
}


/*
**************************
*/

public function get_actions()
{
  return $this->actions;
}


/*
**************************
*/
public function set_js($js)
{
  $this->js = $js;
}


/*
**************************
*/



public function get_section_acces_level()
{
  return $this->section_acces_level;
}


/*
**************************
*/


public function set_section_acces_level($section_acces_level)
{
  $this->section_acces_level  = $section_acces_level;
}

/*
**************************
*/



public function get_available_params()
{
  return $this->available_params;
}


/*
**************************
*/


public function set_available_params($available_params)
{
  $this->available_params  = $available_params;
}
/*
**************************
*/


public function get_default_section()
{
  return $this->default_section;
}


/*
**************************
*/


public function set_default_section($default_section)
{
  $this->default_section  = $default_section;
}
/*
**************************
*/

	
	
}
?>