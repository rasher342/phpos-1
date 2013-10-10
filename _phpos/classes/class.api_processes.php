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


class api_winprocess
{
	private 
		$uid = 0,
		$windowID,
		$app_id,
		$pid,
		$hash,
		$processList,
		$timestamp,
		$silent = 0,
		$hide = 0,
		$window_object;
	
	 
/*
**************************
*/
 	
	public function getWinProceses()
	{
		$window = new api_wintask;
		$win_object = $window->getAllWindows();		
		$c = count($win_object);
		
		$process_counter = array();
		$process_owners = array("root" => "root");
		
		for($i=0; $i<$c; $i++)
		{
			$p = explode("@", $win_object[$i]->getParam('app_id'));		
			$app_id = $p[0];
			$process[$i] = $app_id;				
			
			$process_owners[$app_id][] =$win_object[$i]->getID();
			
			if(!in_array($process[$i], $process_counter))
			{
				$process_counter[] = $process[$i];
			}
		}		
		
		return $process_owners;		
	}

	 
/*
**************************
*/
 		
	public function getPIDof($app_id)
	{
		$c = count($_SESSION['pid']);
		
		$i=0;
		foreach($_SESSION['pid'] as $key => $value)
		{
			if($key == $app_id)
			{
				return $i;
			}
			
			$i++;
		}
	}
	 
/*
**************************
*/
 	
	public function assignWindow($window_object)
	{
		$this->window_object = $window_object;	
	}		
	 
/*
**************************
*/
 	
	public function removeWindows($pid)
	{
		if(!empty($pid))
		{
			$this->loadPID($pid);
			$c = $this->countWindows();
			if($c != 0)
			{
				// remove process id from windows
				$winID = $this->getProcessWindows();
				for($i=0; $i<$c; $i++)
				{
					$w = new api_wintask;
					$w->setID($winID);
					$w->getWindow();
					$w->closeWindow();				
				}			
				
				// reset array
				if(is_array($_SESSION['pid'][$this->app_id]['WIN_ID']))
				{
					$_SESSION['pid'][$this->app_id]['WIN_ID'] = array();
					return true;
				}	
			}
		}	
	}	
	
	 
/*
**************************
*/
 	
	public function removeWindow($windowID, $pid)
	{
		settype($pid, 'integer');
		settype($windowID, 'integer');		
		
		// Create process object
		$check_process = new api_winprocess;
		$check_process->loadPID($pid); // load process data
		
		$app_id = $check_process->getAPP_ID(); // get app_id from process	
			
		// check for app_id in processes
		if(is_array($_SESSION['pid'][$app_id]['WIN_ID']))
		{
			// if app_id exists in session
			foreach($_SESSION['pid'][$app_id]['WIN_ID'] as $key => $value)
			{								
				settype($key, 'integer'); // key = array index
				settype($value, 'integer'); // value = windowID
				
				// if this is my ID
				if($value == $windowID)
				{
					unset($_SESSION['pid'][$app_id]['WIN_ID'][$key]); // remove from array
					
					// check for other windows, if empty then remove process
					$this->emptyProcess($pid);					
					return true;
				}			
			}			
		}
	}	
	 
/*
**************************
*/
 	
		public function getPID_of_APPID($app_id)
		{
			if(!empty($app_id))
			{
				if(is_array($_SESSION['pid'][$app_id]))
				{
					return $_SESSION['pid'][$app_id]['PID'];		
					
				}	else {		
				
					return false;
					
				}
			}	
		}	
		
	 
/*
**************************
*/
 	
		public function getAPPID_of_PID($pid)
		{		
			settype($pid, 'integer');
			
			if(!empty($pid))
			{		
				if(is_array($_SESSION['pid']))
				{
					foreach($_SESSION['pid'] as $key => $value)
					{
						$my_pid = $_SESSION['pid'][$key]['PID'];
						if($my_pid == $pid)
						{							
							return $key;
							
						}					
					}			
				}
			}	
		}	

	 
/*
**************************
*/
 	
		public function countWindows()
		{
			if(!empty($this->app_id))
			{
				return count($_SESSION['pid'][$this->app_id]['WIN_ID']);				
			}		
		}
	
	 
/*
**************************
*/
 	
		public function killProcess($pid)
		{
			if(!empty($pid))
			{
				$this->loadPID($pid);
				unset($_SESSION['pid'][$this->app_id]);
				
				// remove all windows
				$this->removeWindows($pid);				
				return true;	
			}		
		}	
		
	 
/*
**************************
*/
 	
		private function emptyProcess($pid)
		{
			if(!empty($pid))
			{
				$this->loadPID($pid);
				
				// if no windows				
				if($this->countWindows() == 0)
				{
					// if not hide and not silent
					if(!$this->getHide() && !$this->getSilent())
					{
						$this->killProcess($pid);	
						
					}				
				}			
			}	
		}	
	
	 
/*
**************************
*/
 	
	public function newProcess()
	{
		
		// if no PID session array, create it:
		if(!is_array($_SESSION['pid']))
		{
			$_SESSION['pid'] = array();	

			// Create ROOT process
			$_SESSION['pid']['root'] = array();	
			$_SESSION['pid']['root']['PID'] = 0;		
			$_SESSION['pid']['root']['UID'] = 0;	
			$_SESSION['pid']['root']['silent'] = 1;	
			$_SESSION['pid']['root']['hide'] = 0;	
			$_SESSION['pid']['root']['timestamp'] = time();	
			$_SESSION['pid']['root']['WIN_ID'] = array();	// array for windows IDs
		}				
		
			// if assigned Window
			if(is_object($this->window_object))
			{
					// get app_id from window
					$tmp_app_id = $this->window_object->getAPPID();
					
					// Explode for app_id @ action
					$app_data = explode("@", $tmp_app_id);
					$app_id = $app_data[0];
								
					// Generate new PID				
					
										
					// If there is no session for this app_id, create it:
					if(!is_array($_SESSION['pid'][$app_id]))
					{
							$pid = $this->newPID();
							settype($pid, 'integer');
							
							$_SESSION['pid'][$app_id] = array();	

							// Create PID								
							$_SESSION['pid'][$app_id]['PID'] = $pid;
							$_SESSION['pid'][$app_id]['UID'] = 999;
							$_SESSION['pid'][$app_id]['timestamp'] = time();
							$_SESSION['pid'][$app_id]['silent'] = 0;
							$_SESSION['pid'][$app_id]['hide'] = 0;
							
							// Create session for window IDs
							if(!is_array($_SESSION['pid'][$app_id]['WIN_ID']))
							{
								$_SESSION['pid'][$app_id]['WIN_ID'] = array();			
							}			
					}	else {
					
						$pid = $this->getPID_of_APPID($app_id); // else assign to existsing process					
					}
					
					// get Window ID
					$windowID = $this->window_object->getID();					
					settype($windowID, 'integer');
					
										
					// If Window already not in the session
					if(!in_array($windowID, $_SESSION['pid'][$app_id]['WIN_ID']))
					{								
						$_SESSION['pid'][$app_id]['WIN_ID'][] =  $windowID;	// Add Window ID to process
					}		
		
					// Load process to class
					$this->loadPID($pid);
					
					// Assign PID to window
					$this->window_object->setPID($pid);	// send PID to Window
					$this->window_object->updateWindow();				
					
					return $pid; // returns generated pid
			} 
	}		
	
	 
/*
**************************
*/
 	
		public function loadPID($pid)
		{				
			settype($pid, 'integer');
			
			// Foreach on all APP_IDs
			foreach($_SESSION['pid'] as $key => $value)
			{
				// if this is my PID:
				if($_SESSION['pid'][$key]['PID'] == $pid)
				{
					// Load PID data to class
					$this->app_id = $key;
					$this->pid = $_SESSION['pid'][$key]['PID'];	
					$this->uid = $_SESSION['pid'][$key]['UID'];
					$this->timestamp = $_SESSION['pid'][$key]['timestamp'];
					$this->silent = $_SESSION['pid'][$key]['silent'];
					$this->hide = $_SESSION['pid'][$key]['hide'];
					
					// Load PID WIndows
					$this->getProcessWindows();					
					return true;
					
				}				
			}	
		}
		
	 
/*
**************************
*/
 	
	public function getProcessWindows()
	{		
		$this->windowID = array();
		
		if(!empty($this->pid) && !empty($this->app_id))
		{
				// Foreach on PID windows array
				foreach($_SESSION['pid'][$this->app_id]['WIN_ID'] as $key => $value)
				{
					
					settype($value, 'integer');					
					$this->windowID[] = $value; // add to array						
									
				}					
				return $this->windowID; // returns array with windowIDs
		}		
	}		
	 
/*
**************************
*/
 	
		private function newPID()
		{					
			$pids = array(); // tmp array for PIDs				
			
			// check for all PIDs in session
			foreach($_SESSION['pid'] as $key => $value)
			{
				$pids[] = $_SESSION['pid'][$key]['PID'];
			}
			
			// All PIDs loaded. 
			// Now get the PID with max ID:		
			
			$last_pid = max($pids); // max PID
			
			// Start numering from 1000:
			if($last_pid == 0)
			{
				$last_pid = 1000;
			}
			
			// Increase ++
			$last_pid++;	// so, we start from 1001
			
			return $last_pid;			
		}
	 
/*
**************************
*/
 	

	public function procesy()
	{
		return $_SESSION['pid'];	
	}
	 
/*
**************************
*/
 		
	public function getPID()
	{
		return $this->pid;
	}
		 
/*
**************************
*/
 	
	public function getUID()
	{
		return $this->uid;
	}	
		 
/*
**************************
*/
 	
	public function getTime()
	{
		return $this->timestamp;
	}
		 
/*
**************************
*/
 	
	public function getSilent()
	{
		return $this->silent;
	}
		 
/*
**************************
*/
 	
	public function getHide()
	{
		return $this->hide;
	}
		 
/*
**************************
*/
 	
	public function getAPP_ID()
	{
		return $this->app_id;
	}	

	 
/*
**************************
*/
 	
	public function refresh()
	{		
		$i=0;
		$this->processList = array();
		foreach($_SESSION['pid'] as $key => $value)
		{
			$pid = $_SESSION['pid'][$key]['PID'];
			$app_id = $key;
			
			$this->processList[$i] = new api_winprocess;
			$this->processList[$i]->loadPID($pid);	
			
			$i++;		
		}			
		return $this->processList;
	}	
	
}
?>