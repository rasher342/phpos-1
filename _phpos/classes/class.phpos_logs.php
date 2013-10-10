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


class phpos_logs {
	
		private
			$logs_dir,
			$log_dir,
			$log_row,
			$log_file_data,
			$log_file,
			$logs_url;
				 
/*
**************************
*/ 		
			
		public function __construct()
		{
			if(!defined('PHPOS_KEY')) 
			{
				include PHPOS_DIR.'config/security_key.php';
				define('PHPOS_KEY', $phpos_key);
			}
			
			$logs_hash = md5('LOGS_'.PHPOS_KEY).'/';
			
			$this->logs_dir = PHPOS_DIR.'logs/'.$logs_hash;
			$this->logs_url = PHPOS_URL.'logs/'.$logs_hash;	
			$this->set_log_file();			
		}
		 
/*
**************************
*/
 	
		public function set_log_dir($year = null, $month = null, $day = null)
		{
			if($year === null && $month === null && $day ===null)
			{
				$year = date('Y');	
				$month = date('m');	
				$day = date('d');	
			}
			
			$error = 0;
			
			if(!is_dir($this->logs_dir))
			{
				if(!mkdir($this->logs_dir, 0777))
				{					
					$error = 1;
				}				
			}
			
			
			if(!is_dir($this->logs_dir.$year))
			{
				if(!mkdir($this->logs_dir.$year, 0777))
				{					
					$error = 1;
				}				
			}
			
			if(!is_dir($this->logs_dir.$year.'/'.$month))
			{
				if(!mkdir($this->logs_dir.$year.'/'.$month, 0777))
				{							
					$error = 1;
				}						
			}			
			
			if($error != 1) 
			{
				$this->log_dir = $this->logs_dir.$year.'/'.$month.'/';				
				return true;	
			}
		}
				 
/*
**************************
*/
 	
		public function set_log_file($file = null)
		{
			if($this->set_log_dir())
			{
				if($file === null)
				{
					$this->log_file = date('Y-m-d').'.log';	
					
				} else {
				
					$this->log_file = $file;	
				}
				
				$this->create_new_file();				
			}
		}
				 
/*
**************************
*/ 	
		
		public function is_log_file($file_id = null)
		{			
			if(file_exists($this->log_dir.$this->log_file)) return true;		
		}
			 
/*
**************************
*/
 	
		public function save_log_file()
		{
			if(!empty($this->log_file_data))
			{
				if(file_put_contents($this->log_dir.$this->log_file, $this->log_file_data)) return true;			
			}
		}
				 
/*
**************************
*/

		public function create_new_file()
		{
			if(!$this->is_log_file())
			{				
				file_put_contents($this->log_dir.$this->log_file, ' ');						
			}		
		}

/*
**************************
*/
 	
		public function get_log_file($file_id = null)
		{
			if(!empty($file_id)) $this->log_file = $file_id;
			
			if(!empty($this->log_file))
			{
				if($this->is_log_file())
				{
					$this->log_file_data = file_get_contents($this->log_dir.$this->log_file);
					return true;	
					
				}	else {
					
					file_put_contents($this->log_dir.$this->log_file, ' ');					
						
				}				
			}		
		}
			 
/*
**************************
*/
 	
		public function parse_log_file()
		{
			if($this->get_log_file()) 
			{
				$file_data = $this->log_file_data;
				$rows_array = array();
				$rows = explode(';;', $file_data);
				
				$c = count($rows);
				
				if($c != 0)
				{
					for($i=0; $i < $c; $i++)
					{
						$row = array();
						if(!empty($rows[$i]))
						{							
							//LOG| date: 2013.09.27 19:38:06; timestamp: 1380303486; UID: 1; ULOGIN: root; IP: 127.0.0.1; ACTION: {xxxx};;
							
							$rows[$i] = trim(str_replace(array('LOG| '), '', $rows[$i]));							
							$row_data = explode(';', $rows[$i]);							
							
							if(!empty($row_data[5]))
							{
								$row['log_id'] = $i;	
								$row['log_date'] = str_replace('date:', '', trim($row_data[0]));
								$row['log_timestamp'] = str_replace('timestamp:', '', trim($row_data[1]));
								$row['log_uid'] = str_replace('UID:', '', trim($row_data[2]));
								$row['log_ulogin'] = str_replace('ULOGIN:', '', trim($row_data[3]));
								$row['log_ip'] = str_replace('IP:', '', trim($row_data[4]));
								$row['log_action'] = str_replace(array('ACTION:', '{', '}'), '', trim($row_data[5]));
								$row['log_session'] = str_replace('IDSESSION:', '', trim($row_data[6]));

								$rows_array[] = $row;
							}
						}					
					}				
				}
				
				
				return $rows_array;
				
				//$f = 	file_get_contents($log_file_id);
			
			//echo nl2br($f);
			
			
			//$parsed_log = $logs->parse_log_file($log_file_id);	
			
			
			}		
		}
		
			 
/*
**************************
*/
 	
		public function get_log_file_data()
		{
			if($this->get_log_file())
			{
				return $this->log_file_data;			
			}		
		}
			 
/*
**************************
*/
 	
		public function create_log($row)
		{
			if(!empty($row))
			{
				$data = $this->get_log_file_data();
				$my_id = logged_id();
				$u = new phpos_users;
				$u->set_id_user($my_id);
				$u->get_user_by_id();
				$id_session = $u->get_my_session_id();
				$log = 'LOG| date: '.date('Y.m.d H:i:s').'; timestamp: '.time().'; UID: '.$my_id.'; ULOGIN: '.$u->get_user_login().'; IP: '.getIP().'; ACTION: {'.str_replace(';', ',', strip_tags($row)).'}; IDSESSION: '.$id_session;			
				
				$new_data = $log.';;'.PHP_EOL.$data;
				$this->log_file_data = $new_data;
				
				if($this->save_log_file()) return true;
			}		
		}
				 
/*
**************************
*/
 	
		public function get_logs_dir()
		{
			return $this->logs_dir;
		}
				 
/*
**************************
*/
 	
		public function get_logs_url()
		{
			return $this->logs_url;
		}
				 
/*
**************************
*/
 	
		public function get_today_log_file()
		{
			return $this->log_dir.$this->log_file;
		}
				 
/*
**************************
*/
 	
		public function is_today_date($year, $month, $day)
		{
			$this_year = date('Y');
			$this_month = date('m');
			$this_day = date('d');
			
			$s.='F_YEAR:'.$year.' , this_year: '.$this_year.'<br>';
			$s.='F_month:'.$month.' , this_month: '.$this_month.'<br>';
			$s.='F_day:'.$day.' , this_day: '.$this_day.'<br>';
			//return $s;
		
			if($year == $this_year && $month == $this_month && $day == $this_day) return true;
			//return true;
		}
	
	}

?>