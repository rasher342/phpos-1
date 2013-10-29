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


	class phpos_tasks {
	
		private
			$tasks,
			$windows,
			$styles,
			$jquery;
			
			
			 
/*
**************************
*/
 	
		public function __construct()
		{
			$this->windows = $_SESSION['tasks'];		
			$this->tasks = array();
		}		
			 
/*
**************************
*/
 	
		
		public function count_windows()
		{
			return count($this->windows) - 1;
		}
			 
/*
**************************
*/
 	
		public function is_desktop($id)
		{
			if($id == 1) return true;
		}
	 
/*
**************************
*/
 	
		public function get_opened_windows()
		{
			if($this->count_windows() != 0)
			{
				$windows = array();
				foreach($this->windows as $key => $value)
				{
					if(!$this->is_desktop($key)) $windows[] = $key;			
				}	
				
			return $windows;
			}	
		}
		
	 
/*
**************************
*/
 			
		public function count_windows_in_task($process_id)
		{
			return count($this->tasks[$process_id]);		
		}
			 
/*
**************************
*/
 	
		public function get_windows_in_task($process_id)
		{
			return $this->tasks[$process_id];		
		}
			 
/*
**************************
*/
 	
		public function get_window_data($win_id)
		{
			$win = new api_wintask; 
			$win->setID($win_id);
			$win->getWindow();				
			return $win;		
		}
		
			 
/*
**************************
*/
 	
		public function get_window_process($win_id)
		{	
			$win = $this->get_window_data($win_id);
			return $win->getParam('process_id');		
		}
			 
/*
**************************
*/
 	
		public function create_task($process_id)
		{
			if(!is_array($this->tasks[$process_id]))
			{
				$this->tasks[$process_id] = array();
			}
		}
		 
/*
**************************
*/
 		
		public function assign_to_task($win_id)
		{
			$process_id = $this->get_window_process($win_id);			
			$this->create_task($process_id);
			$this->tasks[$process_id][] = $win_id;		
		}
			 
/*
**************************
*/
 	
		public function task_exists($task_id)
		{
			if(array_key_exists($task_id, $this->tasks)) return true;		
		}
		
			 
/*
**************************
*/
 	
		public function get_tasks()
		{
			return array_keys($this->tasks);	
		}
		
			 
/*
**************************
*/
 	
		public function set_tasks()
		{
			$c = $this->count_windows();
			if($c > 0)
			{
				 $windows = $this->get_opened_windows();			 
				 for($i=0; $i < $c; $i++)
				 {
						$this->assign_to_task($windows[$i]);				 
				 }		
			}	
		}
		 
/*
**************************
*/
 		
		public function get_task_icon_class($task_id)
		{
			return $this->tasks[$task_id][0];
		}
			 
/*
**************************
*/
 	
		public function get_app_id($win_id)
		{			
			$win = $this->get_window_data($win_id);
			$app = $win->getAPPID();
	
			if(strstr($app, '@') != false)
			{
				$app_data = explode('@', $app);
				$app_name = $app_data[0];
				$app_action = $app_data[1];
			} else {
				$app_name = $app;
				$app_action = 'index';
			}
			return $app_name;
		}
			 
/*
**************************
*/
 		
		
		public function get_icon_style($win_id)
		{
			$str = ' .context-menu-item.icon-win { background-image: url("'.PHPOS_URL.'apps/'.$this->get_app_id($win_id).'/resources/windowlist_icon.png"); } ';	
			return $str;		
		}
			 
/*
**************************
*/
 	
		public function get_styles()
		{
			return $this->styles;
		}
		
			 
/*
**************************
*/
 	
		public function create_context_menu($task_id)
		{
			$windows = $this->get_windows_in_task($task_id);
			
			
			$c = count($windows);			
			//$context_menu = array();
			//$context_menu[] = 'debug::'.txt('debug').'::alert("'.$icon['div'].':'.$icon['id'].'");::open';
			$action_close_all = null;
			for($i=0; $i<$c; $i++)
			{
				if(!$this->is_desktop($windows[$i]))
				{
					$win = $this->get_window_data($windows[$i]);
					$title = $win->getParam('title');				
					$action_showhide = 'phpos.windowShowHide("'.$windows[$i].'"); ';	
					$action_maximize = 'phpos.windowMaximize("'.$windows[$i].'"); ';
					$action_center = 'phpos.windowCenter("'.$windows[$i].'"); ';
					$action_close = 'phpos.windowClose("'.$windows[$i].'"); ';
					$action_close_all.=	$action_close;
					$this->styles.= $this->get_icon_style($windows[$i]);				
					
					$context_menu[] = 'win'.$i.'::<b>'.$title.'</b>::alert();::win';
					$context_menu[] = array(
					'close'.$i.'::'.txt('close_win').'::'.$action_close.'::cancel',
					'---', 
					'mix'.$i.'::'.txt('showhide_win').'::'.$action_showhide.'::minimize',  					 
					'center'.$i.'::'.txt('center_win').'::'.$action_center.'::maximize'									
					);
				}
			}
			$context_menu[] = '---';
			$context_menu[] = 'closeall'.$i.'::'.txt('closeall_win').'::'.$action_close_all.'::cancel';			
			
			return $context_menu;		
		}
		
		
			 
/*
**************************
*/
 	
		
		public function assign_context_menu($task_id)
		{
			$context_menu = $this->create_context_menu($task_id);
			
			$wintask = new api_wintask;
			$wintask->setContextMenu($context_menu);			
			$this->jquery.= $wintask->contextMenuRender('phpos_task_'.$task_id, 'div', 'left');				
		}
			 
/*
**************************
*/
 	
		public function get_jquery()
		{			
			return $this->jquery;
		}
			 
/*
**************************
*/
 	
		public function render_task($task_id)
		{
			if($this->task_exists($task_id))
			{
				$str = '
					<div id="phpos_task_'.$task_id.'" class="phpos-menustart_TaskItem phpos-menustart_TaskItem_mouseout" 
					title="'.txt('opened_windows').': '. $this->count_windows_in_task($task_id).'">
					
						<div class="phpos_window_icon'.$this->get_task_icon_class($task_id).'" style="display:inline-block; width:30px;	height:30px; vertical-align: middle">
							<img src="'.PHPOS_WEBROOT_URL.'_phpos/icons/menustart_blank.png" class="tasks_windowIcon" />
						</div>					
					
					</div>
				';
			$this->assign_context_menu($task_id);				
				
			return $str;			
			}		
		}
			 
/*
**************************
*/
 	
		public function render_tasks()
		{
			
			
			$this->set_tasks();			
			$tasks = $this->get_tasks();
			$c = count($tasks);
			
			if($c != 0)
			{
				for($i=0; $i < $c; $i++)
				{
					$str.= $this->render_task($tasks[$i]);
				}
			}	
			
			return $str;
		}
	
	
	}
?>