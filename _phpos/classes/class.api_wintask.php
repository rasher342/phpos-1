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


class api_wintask {

	const 
		WINTASK_HOLDER = 'tasks',
		JS_FUNC_NEW_WINTASK = 'phposRenderWindow',
		DEFAULT_WINDOW_TITLE = 'New Window';
	 
/*
**************************
*/
 	
	private
		$id = 0, 
		$title = 'Null Window', 
		$wintype = 'null',
		$parent_id = 0,
		$user_id = 0,
		$process_id = 0,
		$hash = '',
		$width = 0,
		$height = 0,
		$top = 0,
		$left = 0,				
		$timestamp = 0,
		$created_at = 0,
		$updated_at = 0,
		$zindex = 5000,
		$css = 'default.css',	
		$authlevel = 1,
		$destroyed = 'false',
		$hidden = 'false',
		$minimized = 'false',
		$maximized = 'false',
		$collapsed = 'false',
		$closed = 'false',
		$app_id ='null',
		$app_params,
		$app_config,
		$modal = false,
		$menu_counter = 0,
		$contextMenu,
		$is_desktop = 0,
		
		$layout_toolbar,
		$layout_toolbar_html,
		$layout_toolbar_js,
		$layout_menu_html,
		$layout_menu_js,
		$ajax;
		
		public
			$menu_check;
		
 
/*
**************************
*/
 
	function __construct() {
		// if no tasks array create it
		if (!isset($_SESSION[self::WINTASK_HOLDER])) {
			$_SESSION[self::WINTASK_HOLDER] = Array();			
		}
		
		// create default arrays
		$this->app_params = Array();
		$this->timestamp = time();
		$this->created_at = time();
		$this->updated_at = time();
	}	
 
/*
**************************
*/
 
	public function getParam($param_name)
	{			
			if(isset($this->$param_name))
			{
				$p = $this->$param_name;
				return $p;	
				
			} else {
			
				return false;
			}		
	}
 
/*
**************************
*/
 
	public function setParam($param_name, $param_value)
	{
			$this->updated_at = time();		
			$this->$param_name = $param_value;			
	}		
 
/*
**************************
*/
 
	public function setParams($parameters_array) 
	{
		if (is_array($parameters_array)) {	
		
			foreach($parameters_array as $key => $value) 
			{
				$this->$key = $value;
			}
			
		} else {	
		
			if (!empty($parameters_array)) 
			{
				$params = explode(",", $parameters_array);
				$c = count($params);	
				
				for($i = 0; $i < $c; $i++) 
				{
					$p = explode(":", $params[$i]);
					$k = trim($p[0]); // param_name
					
					if(!empty($k) && $p[1] != ' ') 
					{
						$this->$k = trim($p[1]); // param_name = value		
					}
				}
			}
		}
	}
 
/*
**************************
*/
 
	public function getCoreConfig()
	{
		$cfg = Array();
		$cfg['session_wintask_holder'] = self::WINTASK_HOLDER;
		
		return $cfg;	
	}
 
/*
**************************
*/
 
	public function updateWindow() 
	{				
		$this->updated_at = time();
		$this->saveParams();	
		$this->loadParams();				
		return $this;
	}		
 
/*
**************************
*/
 
	public function getWindow() 
	{	
		if(isset($this->id))
		{
			$this->loadParams();	
			return $this;
		}
	}	
	
 
/*
**************************
*/
 
	public function generateJavaScript($param = null) 
	{

		$this->updated_at = time();		
		$js_func = self::JS_FUNC_NEW_WINTASK;
		
		if($this->is_desktop)
		{
			$js_func = 'phposRenderDesktop';
		}
		
		if($this->modal)
		{
			$js_func = 'phposRenderModal';
		}
		
		$tag1 = '<script>';
		$tag2 = '</script>';
		
		if($param == 'notags')
		{
			$tag1 = '';
			$tag2 = '';
		}
		
		$ajax_code = $tag1 . $js_func . '(
			\'' . $this->id . '\',
			\'' . $this->title . '\',
			\'' .$this->wintype. '\',
			' .$this->parent_id. ',
			' .$this->user_id. ',			
			\'' .$this->hash. '\',
			' .$this->width. ',
			' .$this->height. ',
			' .$this->top. ',
			' .$this->left. ',
			' .$this->timestamp. ',
			' .$this->created_at. ',
			' .$this->updated_at. ',
			' .$this->zindex. ',
			\'' .$this->css. '\',
			' .$this->authlevel. ',
			\'' .$this->destroyed. '\',
			\'' .$this->hidden. '\',			
			\'' .$this->minimized. '\',
			\'' .$this->maximized. '\',
			\'' .$this->collapsed. '\',
			\'' .$this->closed. '\',
			\'' .$this->app_id. '\'
			);'.$tag2;			
			$this->ajax = $ajax_code;
			return $this->ajax;
	}
	
 
/*
**************************
*/
 
	public function openWindow($id=null) 
	{			
		$this->ajax = '';
		$this->setID($id);	
		$this->created_at = time();
		$this->updated_at = time();		
		$this->hash = md5($this->id.$this->user_id.$this->created_at);		
		$this->saveParams();	
		
		return $this->generateJavaScript();			
	}
 
/*
**************************
*/
 
	
	private function getNextId() 
	{	
		if(!$_SESSION['next'])
		{
			$_SESSION['next'] = 2;
		} else {
			$_SESSION['next'] = $_SESSION['next'] + 1;
		}
		
		settype($_SESSION['next'], 'integer');
		return $_SESSION['next'];
	}
	
 
/*
**************************
*/
 	
	public function setID($id = null) 
	{
		if ($id == null) 
		{		
			$this->id = $this->getNextId();
			
		} else {
		
			$this->id = $id;
		}	
		
		return $this->id;
	}

/*
**************************
*/	
 
	public function countWindows($param = null)
	{		
		return count($_SESSION[self::WINTASK_HOLDER]);
	}	
  
/*
**************************
*/
 
 public function getAllWindows()
 {
	// error - dac foreach
	$c = $this->countWindows();
	if($c!=0)
	{	
		foreach($_SESSION[self::WINTASK_HOLDER] as $key => $value)
		{	
				$win_id = $_SESSION[self::WINTASK_HOLDER][$key]['id'];
				$win_obj[$j] = new api_wintask;
				$win_obj[$j]->setID($win_id);
				$win_obj[$j]->getWindow();		
		}		
		
		return $win_obj;	
	}
 } 
 
/*
**************************
*/
 
	 public function getID()
	 {
			return $this->id;
	 }	 
 
/*
**************************
*/
 	 
	 public function getType()
	 {
			return $this->wintype;
	 }
 
/*
**************************
*/
 	 
	 public function getTitle()
	 {
			return $this->title;
	 }
	 
 
/*
**************************
*/
 	 
	 
	 public function getJavaScript()
	 {
			return $this->ajax;
	 }
 
/*
**************************
*/
 	 
	 public function setPID($pid)
	 {
			$this->process_id = $pid;
	 }
 
/*
**************************
*/
 	 
	 public function getPID()
	 {
			return $this->process_id;
	 }
 
/*
**************************
*/
 	 
	 public function setUID($uid)
	 {
			$this->user_id = $uid;
	 }
 
/*
**************************
*/
 	 
	 public function getUID()
	 {
			return $this->user_id;
	 }
 
/*
**************************
*/
 	 
	 public function getAPPID()
	 {
			return $this->app_id;
	 }
 
/*
**************************
*/
 	 
	 public function setAPPID($app_id)
	 {
			$this->app_id = $app_id;
	 }
 
/*
**************************
*/
 	 
	 public function setAppConfig($app_config)
	 {
			$this->app_config = $app_config;
			$this->updateWindow();
	 }
	 
 
/*
**************************
*/
 
	public function closeWindow() 
	{	
		// Remove from Process
		//$proc = new api_winproces;
		//$proc->removeWindowFromProcess($this->id, $this->process_id);
		
		$proc = new api_winprocess;
		$proc->removeWindow($this->getID(), $this->getPID());			
		unset($_SESSION['tasks'][$this->id]);	
	}
	 
/*
**************************
*/
 
	public function loadParams() 
	{
		if(is_array($_SESSION[self::WINTASK_HOLDER][$this->id])) 
		{
			foreach($_SESSION[self::WINTASK_HOLDER][$this->id] as $key => $value) 
			{
				if(!empty($value)) 
				{
					$this->$key = $value;		
				}
			}		
		}
	}
	 
/*
**************************
*/
 
	public function saveParams() 
	{
	
	// ! posusuwac niepotrzebne parametry
		$window_session = Array(		
			'id' => (int)$this->id, 
			'title' => $this->title, 
			'wintype' => $this->wintype,
			'parent_id' => (int)$this->parent_id,
			'user_id' => (int)$this->user_id,
			'process_id' => (int)$this->process_id,
			'hash' => $this->hash,
			'width' => (int)$this->width,
			'height' => (int)$this->height,
			'top' => (int)$this->top,
			'left' => (int)$this->left,				
			'timestamp' => (int)$this->timestamp,
			'created_at' => (int)$this->created_at,
			'updated_at' => (int)$this->updated_at,
			'zindex' => (int)$this->zindex,
			'css' => $this->css,	
			'authlevel' => (int)$this->authlevel,
			'destroyed' => $this->destroyed,
			'hidden' => $this->hidden,
			'minimized' => $this->minimized,
			'maximized' => $this->maximized,
			'collapsed' => $this->collapsed,
			'closed' => $this->closed,
			'app_id' => $this->app_id,
			'app_params' => $this->app_params,
			'app_config' => $this->app_config
		);	
		
		if($this->id != -1) $_SESSION[self::WINTASK_HOLDER][$this->id] = $window_session;
	}
 
/*
**************************
*/
 
	private function saveParam($param_name, $param_value)
	{
			if(!empty($param_name) && $this->id != -1) 
			{
				$_SESSION[self::WINTASK_HOLDER][$this->id][$param_name] = $param_value;
				return true;
			}
	}
 
/*
**************************
*/
 
	public function setAppParams($params_json)
	{
		if(!empty($params_json))
		{
			// save cache in session
			$_SESSION['win_params'][$this->id] = $params_json;
			
			// explode to array
			$arr = explode(",", $params_json);
			$c = count($arr);
			for($i=0; $i<$c; $i++)
			{
				$p = explode(":", $arr[$i]);
				$param_name = $p[0];
				$param_value = $p[1];
				
				// zrobic na metodzie appparam
				$this->app_params[$param_name] = "$param_value";			
			}	
		
		// save
			$this->updateWindow();
		}			
	}
 
/*
**************************
*/
 
	public function appParam($param_name, $param_value = null)
	{
		// if !argument
		if(!isset($param_value))
		{
			if(isset($this->app_params[$param_name]))
			{			
				return $this->app_params[$param_name];	// return param value
			} 
			
		} else {
		
			// set new param value
			$this->app_params[$param_name] = $param_value;
			$this->updateWindow();
			return $this->app_params[$param_name];
		}
	}
	 
/*
**************************
*/
 	
	public function get_appParams()
	{		
		return $this->app_params;	
	}

 
/*
**************************
*/
 	
	public function set_appParam($param_name, $param_value = null)
	{	
			// set new param value
			$this->app_params[$param_name] = $param_value;
			$this->updateWindow();
			return $this->app_params[$param_name];		
	}
 
/*
**************************
*/
 
		public function debugObjectParams()
	{
		$a = Array();
		
		foreach($this as $key => $value)
		{
			$a[$key] = $value;		
		}
		
		return $a;
	}
	
 
/*
**************************
*/
 	
	public function debugSessionParams()
	{
		$a = Array();
		
		foreach($_SESSION[self::WINTASK_HOLDER][$this->id] as $key => $value)
		{
			$a[$key] = $value;		
		}
		
		return $a;
	}
 
/*
**************************
*/
 	
	// Helper for reloading windows with parameters
	public function reload($params = null)
	{
		if(is_array($params))
		{
			foreach($params as $key => $value)
			{
				$p[] = $key.':'.$value;			
			}
			
			$param_url = implode(",", $p);		
		}
		
		$str = "window_refresh('".$this->getID()."','".$param_url."');";
		return $str;	
	}	
	


 
/*
**************************
*/
 



// == MENU

	private function parseMenuParams($item_json, $to_check = null)
	{
		// create array from params of item
		if(!empty($item_json) && !is_array($item_json))
		{
			
			$params = explode(",", $item_json);
			$c = count($params);
			
			for($i=0; $i<$c; $i++)
			{
				$p = explode(":", $params[$i]);
				$key = $p[0];
				$value = $p[1];
				$param[$key] = trim($value);				
			}	
			
			// if separator
			if($item_json == 'separator')
			{
				$param['separator'] = true;
			}						
				
								
			
			return $param;
		}		
	}
	
 
/*
**************************
*/
 	
	private function menuAction($menu_item, $action = null)
	{					
		if(!empty($menu_item['action']))
		{
			$action = $menu_item['action'];
		}
		
		if(function_exists($action))
		{
			$this->ajax.= '$(\'#'.$menu_item['id'].'\').click(function(item) 
			{
			//alert(item.id);
			'.$action($menu_item).' 
			});';						
		}		
		
		return $action;					
	}
 
/*
**************************
*/
 	
	private function renderItem($menu_item)
	{
		if($menu_item['separator'])
		{
			$menu_render='<div class="menu-sep"></div>  ';
			
		} else {
		
			if($menu_item['checked'])
			{
				$menu_render='<div id="'.$menu_item['id'].'" data-options="name:\''.$menu_item['id'].'\',iconCls:\'icon-ok\'">'.$menu_item['title'].'</div>';
				
			} else {		
			
				$menu_render='<div id="'.$menu_item['id'].'" data-options="name:\''.$menu_item['id'].'\'">'.$menu_item['title'].'</div>';
			}										
		}
		
		return $menu_render;
	}		
 
/*
**************************
*/

	private function menuCheck($menu_item)
	{			
			$menu_item['checked'] = false;
			
			if(!empty($menu_item['check']))
			{
				$key = $menu_item['check'];
				$this->menu_check[$key] = $menu_item['if'];				
			}
			
			foreach($menu_item as $k => $v)
			{
				if(isset($this->menu_check[$k]))
				{
					settype($k, 'string');
					settype($v, 'string');
					settype($this->menu_check[$k], 'string');
					
					if($this->menu_check[$k] == $v)
					{
						$menu_item['checked'] = true;
					}				
				}		
			}

			return $menu_item;					
	}						
				
		
 
/*
**************************
*/
 
	
	private	function renderItems($items, $level = 0)
	{
		$level++;
		if($level == 1)
		{
			$this->ajax = '';
			$this->menu_check = array();
		}
		
		$this->menu_counter++;
		$str='';	
		
		if(is_array($items))
		{				
			$c = count($items);
			for($i=0; $i<$c; $i++)
			{
					// get check param
												
						$menu_item = $this->parseMenuParams($items[$i]);
						$menu_item['id'] = 'menuitem'.$this->getID().'_'.$level.'_'.$i.'_'.$this->menu_counter;
						$menu_item = $this->menuCheck($menu_item);
						
						if(empty($menu_id))
						{
							$menu_id = 'mm'.$this->getID().$level.$i.$this->menu_counter;
						}
						$menu_item['menu_id'] =	$menu_id;
					
						$action = $this->menuAction($menu_item, $action);												
					
					
						
					if(!is_array($items[$i]))
					{		
								
						if($level == 1) 
						{							
							
							$menu_id = 'mm'.$this->getID().$level.$i.$this->menu_counter;
							$menu_item['menu_id'] =	$menu_id;
							
							$icon = '';
							
							if(!empty($menu_item['icon']))
							{
								$icon = "iconCls:'".$menu_item['icon']."',";
							}
							
							
							//$tmp = array();
							
							
							
							if(!is_array($items[$i+1]))
							{
									$str.='<a href="javascript:void(0)" id="'.$menu_item['id'].'" class="easyui-menubutton" 
							data-options="'.$icon.'menu:\'#'.$menu_id.'\'">'.$menu_item['title'].'</a>  ';
							} else {
								$str.='
							<a href="javascript:void(0)" id="mb'.$menu_id.'" class="easyui-menubutton" 
							data-options="'.$icon.'menu:\'#'.$menu_id.'\'">'.$menu_item['title'].'</a><div id="'.$menu_id.'" style="width:150px;">  ';					
							}		
							
							
						}	else {
						
							$next_index = $i + 1;
							if(is_array($items[$next_index]))
							{
								$title = $menu_item['title'];
							} else {			
						
								$str.=$this->renderItem($menu_item);	

							}
						}										
						
						
					} else {
					
						if($level != 1) 
						{									
							$str.='<div><span>'.$title.'</span><div>';			
						}						
										
						$str.=$this->renderItems($items[$i], $level); // recursive
						
						if($level != 1) 
						{									
							$str.='</div></div>';			
						}	
						
						
						//$str.='</div>';
											
					if($level == 1) 
					{
							$str.='</div>';
					}
						
					
					}
					
					if(!is_array($items[$i]) && $level==1)
					{
						
					}
				
			}		

					
		}
		
		
		return $str;			
	}
				
 
/*
**************************
*/
 		
	public function renderMenu($app_menu)
	{			
		$menu_render='';
		$jquery='';		
		
		if(is_array($app_menu))
		{
			$c = count($app_menu);			
			for($i=0; $i<$c; $i++)
			{		
				// main
				$menu_item = $this->parseMenuParams($app_menu[$i]['header']);		
				$checker = $app_menu[$i]['to_check_if'];
				$menu_render.='<a href="javascript:void(0)" id="mb" class="easyui-menubutton" 
				data-options="menu:\'#api_window_'.$this->getParam('id').'_menu_'.$i.'\',iconCls:\''.$menu_item['icon'].'\'">'.$menu_item['title'].'</a>
				<div id="api_window_'.$this->getParam('id').'_menu_'.$i.'" style="width:150px;">  ';				
				
				// items
				if(is_array($app_menu[$i]['items']))
				{
					$d = count($app_menu[$i]['items']);
					for($j=0; $j<$d; $j++)
					{
						// parse
						$menu_item = $this->parseMenuParams($app_menu[$i]['items'][$j], $checker);						
						$menu_item['id'] = 'api_window_'.$this->getParam('id').'_menu_'.$i.'_'.$j;						
						
						// if separator
						if($menu_item['separator'])
						{
							$menu_render.='<div class="menu-sep"></div>  ';
							
						} else {
						
							// if check this				
							if($menu_item['checked'])
							{
								$menu_render.='<div id="'.$menu_item['id'].'" data-options="iconCls:\'icon-edit\'">'.$menu_item['title'].'</div>';
								
							} else {			
							
								$menu_render.='<div id="'.$menu_item['id'].'">'.$menu_item['title'].'</div>';
							}
							
							$action = $this->menuAction($menu_item, $action);					
							
						}
					}							
				}
				
				// end root
				$menu_render.='</div>';		
			}		
		
			// end if is menu
		
			$ret = Array();
			$ret['rendered_menu'] = $this->renderItems($app_menu);
			//$ret['rendered_menu'] = $menu_render;
			$ret['rendered_jquery'] = $this->ajax.'';
			$this->ajax = '';
			
			$this->layout_menu_html = $ret['rendered_menu'];
			$this->layout_menu_js = $ret['rendered_jquery'];			
			
			return $ret;
		}
 }
	
	
 
/*
**************************
*/
 	
	
	public function contextMenuParseItem($item)
	{
		if(!empty($item))
		{
			$separator = "::";
			
			if($item != '---')
			{			
				$expl = explode($separator, $item);		
				$item_data['id'] = $expl[0];
				$item_data['title'] = $expl[1];
				$item_data['action'] = $expl[2];
				$item_data['icon'] = $expl[3];
				$item_data['disabled'] = $expl[4];
				$item_data['items'] = null;
				
			} else {
			
				$item_data['id'] = '---';
				$item_data['title'] = '---';
				$item_data['icon'] = '---';
			}
			//echo '<pre>';
			//var_dump($item_data);
			//echo '</pre>';
			return $item_data;		
		}		
	}
	
 
/*
**************************
*/
 	
	public function contextMenuParseItems($items_array)
	{
		if(is_array($items_array))
		{
			$item_data = array();
			$c = count($items_array);
			
			for($i=0; $i<$c; $i++)
			{
				// if not array with sub items
				if(!is_array($items_array[$i]))
				{
					// if only item, parse:
					$item_data[$i] = $this->contextMenuParseItem($items_array[$i]);
					
				} else {
					// if array					
					$item_data[$i]['items'] = $items_array[$i];
				}
							
			}	
			
			return $item_data;			
		}	
	}
 
/*
**************************
*/
 	
	public function contextMenuMakeItems($items_array, $level=0)
	{
		// next submenu
		$level++;		
		
		// parse items from array
		$items = $this->contextMenuParseItems($items_array);
		$implode_glue = ",
		";
		
		// if level1 - no quotes
		if($level == 1)
		{		
			$js_code = 'items: {
			';
			
		} else {
		
			$js_code = '"items": {
				';
		}
		
		$c = count($items);
		$j=0;		
		
		for($i=0;$i<$c; $i++)
		{	
			// If not have subitems
			if(!is_array($items[$i]['items']) && !is_array($items[$i+1]['items']))
			{					
					if(!empty($items[$i]['action']))
					{
					
						if(!empty($items[$i]['icon']))
						{
							$icon = '
							icon: "'.$items[$i]['icon'].'",
							';
						} else {
							$icon = '';
						}						
						
						
						// if disabled
						$disabled = '';
						if($items[$i]['disabled'] == 'true')
						{
							$disabled = 'disabled: true,
							';
						}					
					
						$js_code_items[$j]='"'.$items[$i]['id'].'": {
										name: "'.$items[$i]['title'].'",'.$icon.$disabled.'
										callback: function(key, options) {
												 '.$items[$i]['action'].' 
										}
									}';
					
					} else {		

							if(!empty($items[$i]['icon']))
							{
								$icon = ', icon: "'.$items[$i]['icon'].'"';							
							} else {
								$icon = '';
							}	
							
						// if not separator
						if($items[$i]['id'] != '---')
						{
							$js_code_items[$j]='"'.$items[$i]['id'].'": {name: "'.$items[$i]['title'].'"'.$icon.'}';	
							
						} else {
						
							$js_code_items[$j]='"sep'.$j.'": "---------"';
							
						}
					}	

				$j++;
			} else {
			
				if($items[$i-1]['id'] != '---') 
				{
					if(!empty($items[$i-1]['icon']))
					{
						$icon = ', icon: "'.$items[$i-1]['icon'].'"';							
					} else {
						$icon = '';
					}	
							
					if($i !=0)
					{
						if(!empty($items[$i-1]['title']))
						{
							$js_code_items[$j] = '"'.$items[$i-1]['id'].'":  { 
							name: "'.$items[$i-1]['title'].'"'.$icon.',
							'.$this->contextMenuMakeItems($items[$i]['items'], $level).'
							}';
							
							$j++;
						}
					}
				}
			}			
		}
		
		if(is_array($js_code_items))
		{	
			$js_code.= implode($implode_glue, $js_code_items); 
		}
		
		$js_code.= "
		}";	
		
		return $js_code;
	}
	
 
/*
**************************
*/
 	
	public function contextMenuRender($div_id, $selector, $trigger = null)
	{
		$trigger_mode = 'delay: 5000,
		autoHide: false,
		';
		
		if($trigger != null)
		{
			switch($trigger)
			{
				case 'hover':
					$trigger_mode="trigger: 'hover',
					delay: 100,
					autoHide: true,
					";
				break;			
				
				case 'left':
					$trigger_mode="trigger: 'left',
					delay: 100,
					autoHide: true,
					";
				break;			
			}		
		}
		
		
		$items = $this->contextMenuMakeItems($this->contextMenu);
		$jquery = '$(\'#'.$div_id.'\').contextMenu({
        selector: \''.$selector.'\',			  
        '.$trigger_mode.$items.'
    });
		';
			return $jquery;
	}	
	
 
/*
**************************
*/
 	
	public function setContextMenu($items_array)
	{
		$this->contextMenu = $items_array;	
	}
 
/*
**************************
*/
 	
	public function resetContextMenu()
	{
		$this->contextMenu = array();	
	}
 
/*
**************************
*/
 	
	public function appendToContextMenu($items, $id = null)
	{
		if($id == null)
		{
			$this->contextMenu[] = $items;
			
		} else {
		
			$this->contextMenu[$id][] = $items;
		}
	}
 
/*
**************************
*/
 	
	public function replaceToContextMenu($id, $items)
	{
		$this->contextMenu[$id] = $items;
	}
 
/*
**************************
*/
 	
	public function removeFromContextMenu($index)
	{
		if(isset($this->contextMenu[$index]) || is_array($this->contextMenu[$index]))
		{
			unset($this->contextMenu[$index]);
			return true;			
		}
	}
 
/*
**************************
*/
 	
	public function getContextMenu()
	{
		return $this->contextMenu;
	}
		
	
/*
**************************
*/

	public function render_toolbar($toolbar_array, $checked_id = null)
	{
		if(is_array($toolbar_array))
		{			
			
			$js = "
			$('.phpos_toolbar_item').mouseenter(function() {
				$(this).removeClass('phpos_toolbar_mouseleave').addClass('phpos_toolbar_mouseenter');			
			});
			
			$('.phpos_toolbar_item').mouseleave(function() {
				if($(this).attr('id') != 'phpos_toolbar_".$this->getID()."_".$checked_id."')
				{
					$(this).removeClass('phpos_toolbar_mouseenter').addClass('phpos_toolbar_mouseleave');	
				}
			});	
			
			$('#phpos_toolbar_".$this->getID()."_".$checked_id."').addClass('phpos_toolbar_checked');
			";
		
		
		
			$c = count($toolbar_array);
			
			global $my_app;
			
			//print_r($my_app);
			for($i=0; $i < $c; $i++)
			{				
				if($my_app->user_have_access_section($toolbar_array[$i]['id']))
				{				
					$img = null;
					
					if(file_exists(MY_RESOURCES_DIR.$toolbar_array[$i]['icon']))
					{
						$img = '<img src="'.MY_RESOURCES_URL.$toolbar_array[$i]['icon'].'" />';
						
					} elseif(file_exists(PHPOS_WEBROOT_DIR.'_phpos/icons/'.$toolbar_array[$i]['icon']))
					{
						$img = '<img src="'.PHPOS_WEBROOT_URL.'_phpos/icons/'.$toolbar_array[$i]['icon'].'" />';
					}	
					
					
					$str.= '<div id="phpos_toolbar_'.$this->getID().'_'.$toolbar_array[$i]['id'].'" class="phpos_toolbar_item easyui-tooltip" title="'.$toolbar_array[$i]['tip'].'">'.$img.$toolbar_array[$i]['title'].'</div>';
					
					$js.= '
					$("#phpos_toolbar_'.$this->getID().'_'.$toolbar_array[$i]['id'].'").click(function() {
					'.$toolbar_array[$i]['link'].'			
					});
					';
			
				}
			
			}	
			$ret = array();
			$ret['html'] = $str;
			$ret['js'] = $js;
			
			$this->layout_toolbar = $ret;		
			
			$this->layout_toolbar_html = $ret['html'];				
			$this->layout_toolbar_js = $ret['js'];	
		
		}	
	}
		 
/*
**************************
*/
 	
	public function get_layout_toolbar()
	{
		return $this->layout_toolbar;
	}
		 
/*
**************************
*/
 	
	public function get_layout_toolbar_html()
	{
		return $this->layout_toolbar_html;
	}
		 
/*
**************************
*/
 		
	public function get_layout_toolbar_js()
	{
		return $this->layout_toolbar_js;
	}
		 
/*
**************************
*/
 	
	public function get_layout_menu_html()
	{
		return $this->layout_menu_html;
	}
		 
/*
**************************
*/
 	
	public function get_layout_menu_js()
	{
		return $this->layout_menu_js;
	}
	 
/*
**************************
*/
 	
	
	
	public function get_app_name()
	{		
		if(strstr($this->app_id, '@') != false)
		{
			$app_data = explode('@', $this->app_id);
			$app_name = $app_data[0];
			$app_action = $app_data[1];
			
		} else {
		
			$app_name = $this->app_id;
			$app_action = 'index';
		}
		return $app_name;
	}
	 
/*
**************************
*/
 		
	public function get_app_action()
	{
		if(strstr($this->app_id, '@') != false)
		{
			$app_data = explode('@', $this->app_id);
			$app_name = $app_data[0];
			$app_action = $app_data[1];
			
		} else {
		
			$app_name = $this->app_id;
			$app_action = 'index';
		}
		return $app_action;
	}	
	
}
?>