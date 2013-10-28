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


class phpos_users
{
	
	private 
		$id_user,
		$user_login,
		$user_pass,
		$user_email,
		$user_type,
		$id_group,
		$is_active,
		$created_at,
		$last_login,
		$last_activity,
		$note,
		$new_user_id,
		$db_users,
		$db_groups,
		$db_groups_records,
		$db_sessions,
		$db_clouds,
		$db_ftp,
		$db_shared,
		$db_startmenu,
		$error_id,
		$result_id,
		$raw_pass,
		$PHPOS_KEY,
		$config,
		$db_desktopfiles,
		$db_user_config,
		$home_dir_folders,
		$default_desktop,
		$no_home,
		$cfg,
		$session_sid,
		$session_id,
		$session_start,
		$session_end,
		$session_ip;

 
/*
**************************
*/
 		
	public function __construct()
	{
		$this->db_users = 'users';
		$this->db_groups = 'groups';
		$this->db_groups_records = 'groups_records';
		$this->db_clouds = 'clouds';
		$this->db_ftp = 'ftp';
		$this->db_shared = 'shared';
		$this->db_startmenu = 'startmenu';		
		$this->db_user_config = 'userconfig';
		$this->db_sessions = 'sessions';
		$this->db_desktopfiles = 'files';
		
		$this->cfg = array();
		$this->cfg['email_required'] = true;
		$this->cfg['min_login_chars'] = 5;
		$this->cfg['max_login_chars'] = 30;
		$this->cfg['min_pass_chars'] = 6;
		$this->cfg['max_pass_chars'] = 30;
		$this->cfg['available_login_chars'] = 'ABCDEFGH';
		$this->cfg['available_pass_chars'] = 'ABCDEFGH';
		$this->cfg['default_group_id'] = 0;
		$this->cfg['default_active'] = 1;
		$this->cfg['default_user_type'] = 1;		
		$this->cfg['allow_new_user_accounts'] = 1;
		$this->cfg['allow_new_groups'] = 1;		
		$this->cfg['allow_login'] = 1;	
		
		$this->home_dir_folders = array(
		'_Desktop',
		'_Download',
		'_Clipboard',
		'_Wallpapers',
		'_Pictures',
		'_Video',
		'_Log',
		'_Temp',
		'_Icons',
		'_Documents',
		'_Shared',
		'_Userdata'
		);
		
		$this->default_desktop = array(
			array('file_title' => 'my_server', 
						'plugin_id' =>'app',
						'app_id' =>'explorer',
						'app_action' =>'my_server',					
						'app_params' => 'fs:local_files',
						'multilang' => 1,
						'no_delete' => 1,
						'icon' => 'mycomp.png',
						'location' => 'desktop'
						)		
		);

		if(file_exists(PHPOS_DIR.'config/security_key.php')) include PHPOS_DIR.'config/security_key.php';
		$this->PHPOS_KEY = $phpos_key;
	}	
		
 
/*
**************************
*/
 	
	public function assign_config($config_object)
	{
		$this->config = $config_object;
	}
 
/*
**************************
*/
 		
	private function generate_session_hash()
	{
		$hash = md5($this->user_login.$this->user_pass.session_id());	
		return $hash;
	}	
 
/*
**************************
*/
 		
	public function user_is_logged()
	{
		if(!empty($_SESSION['phpos_user_id']) && !empty($_SESSION['phpos_user_session_id']) && !empty($_SESSION['phpos_user_hash']))
		{
			$tmp_id = $_SESSION['phpos_user_id'];
			$tmp_sid = $_SESSION['phpos_user_session_id'];
			$tmp_hash = $_SESSION['phpos_user_hash'];
			
			$this->id_user = $tmp_id;
			if($this->user_id_exists())
			{
				$this->get_user_by_id();
				$db_hash = $this->generate_session_hash();					
				
				if($db_hash == $tmp_hash)
				{
					return true;
				}	
				
			}	else {
			
				$this->id_user = null;
				return false;
			}			
		}
	}
 
/*
**************************
*/
 		
	public function get_logged_user()
	{
		if($this->user_is_logged())
		{			
			$this->get_user_by_id();	
			return $this->id_user;
		}	
	}
 
/*
**************************
*/
 	
	public function get_access_level()
	{
		return $this->user_type;
	}
 
/*
**************************
*/
 		
	public function generate_password()
	{
		if(!empty($this->raw_pass))
		{					
			$pwd = md5($this->id_user.$this->raw_pass.$this->PHPOS_KEY.$this->created_at);
			return $pwd;
		}	
	}
	 
/*
**************************
*/
 	
	public function set_home_dir_hash($id_user, $login, $created_at)
	{
		$dir_hash = $login.'_'.md5($this->PHPOS_KEY.$id_user.$created_at);
		return $dir_hash;	
	}
 
/*
**************************
*/
 		
	public function get_home_dir_hash()
	{
		$dir_hash = $this->user_login.'_'.md5($this->PHPOS_KEY.$this->id_user.$this->created_at);
		return $dir_hash;	
	}
 
/*
**************************
*/
 	
	private function create_default_desktop()
	{
		$error = 0;
		if(is_array($this->default_desktop))
		{
			global $sql;
			
			$c=count($this->default_desktop);			
			if($c != 0)
			{
				foreach($this->default_desktop as $record)
				{
					$record['created_at'] = time();
					$record['id_user'] = $this->id_user;
					$record['id_parent'] = 0;
					
					if(!$sql->add($this->db_desktopfiles, $record)) $error = 1;				
				}                         		
			}	
		}
		if(!$error) return true;	
	}	
	 
/*
**************************
*/
 	
	private function create_home_dir_folders($dir)
	{
		$error = 0;
		if(is_array($this->home_dir_folders))
		{
			$file = '<?php die(); ?>';
			foreach($this->home_dir_folders as $dirname)
			{				
				if(@mkdir(PHPOS_HOME_DIR.$dir.'/'.$dirname, 0777)) 
				{
					if(!@file_put_contents(PHPOS_HOME_DIR.$dir.'/'.$dirname.'/index.php', $file)) $error = 1;					
				}
			}		
		}
		
		if(!$error) return true;
	}
	
 
/*
**************************
*/
 		
	public function create_home_dir()
	{
		$dir = $this->get_home_dir_hash();
		if(!is_dir(PHPOS_WEBROOT_DIR.'home/'.$dir))
		{
			if(mkdir(PHPOS_WEBROOT_DIR.'home/'.$dir, 0777))
			{
				$file = '<?php die(); ?>';
				if(file_put_contents(PHPOS_WEBROOT_DIR.'home/'.$dir.'/index.php', $file))
				{
					if($this->create_home_dir_folders($dir))	return true;
				}
			}		
		}	
	}
	
 
/*
**************************
*/
 		
	private function login_to_system()
	{
		$_SESSION['phpos_user_id'] = $this->id_user;
		$_SESSION['phpos_user_session_id'] = session_id();
		$_SESSION['phpos_user_hash'] = $this->generate_session_hash();
		$_SESSION['logged_message'] = 1;
		
		$login_time = time();		
		$this->get_user_by_id();
		$this->set_last_login($login_time);
		$this->update();
		
		//session_regenerate_id();
		$this->create_session();
		
		header("Location: phpos_desktop.php?lang=".$_GET['lang']);
		exit;	
	}
	
 
/*
**************************
*/
 		
	public function login()
	{		
		if(!empty($this->user_login) && !empty($this->raw_pass))
		{		
			if($this->user_login_exists())
			{
				$this->get_user_by_login();		
				if($this->is_active != 1) return false;
				$pwd = $this->generate_password();
			
				if($this->user_pass == $pwd)
				{
					$this->login_to_system();
					return true;
				}			
			}		
		}	
	}
	
	 
/*
**************************
*/
 	
	
	public function user_id_exists($id_user = null)
	{
		$id = $this->id_user;
		if(!empty($id_user))
		{
			$id = $id_user;
		}		
		
		global $sql;
		if(is_object($sql))
		{
		$sql->cond('id_user', $id);
		if($sql->is_row($this->db_users)) return true;
		}
	}	
 
/*
**************************
*/
 	
	public function user_login_exists($user_login = null)
	{
		$login = $this->user_login;
		if(!empty($user_login))
		{
			$login = $user_login;			
		}
		
		global $sql;
		$sql->cond('user_login', $login);
		if($sql->is_row($this->db_users)) return true;
	}
 
/*
**************************
*/
 	
	public function get_user_by_id($id_user = null)
	{
		$id = $this->id_user;
		if(!empty($id_user))
		{
			$id = $id_user;
		}
		
		if($this->user_id_exists($id))
		{
			global $sql;
			$sql->cond('id_user', $id);
			$row = $sql->get_row($this->db_users);
			
			$this->id_user = $row['id_user'];
			$this->user_login = $row['user_login'];
			$this->user_pass = $row['user_pass'];
			$this->user_email = $row['user_email'];
			$this->user_type = $row['user_type'];
			$this->id_group = $row['id_group'];
			$this->is_active = $row['is_active'];
			$this->created_at = $row['created_at'];
			$this->last_login = $row['last_login'];
			$this->last_activity = $row['last_activity'];
			$this->note = $row['note'];
			
			return $row;		
		}	
	}
 
/*
**************************
*/
 	
	public function get_user_by_login($user_login = null)
	{
		$login = $this->user_login;
		if(!empty($user_login))
		{
			$login = $user_login;
		}
		
		if($this->user_login_exists($login))
		{
			global $sql;
			$sql->cond('user_login', $login);
			$row = $sql->get_row($this->db_users);
			
			$this->id_user = $row['id_user'];
			$this->user_login = $row['user_login'];
			$this->user_pass = $row['user_pass'];
			$this->user_email = $row['user_email'];
			$this->user_type = $row['user_type'];
			$this->id_group = $row['id_group'];
			$this->is_active = $row['is_active'];
			$this->created_at = $row['created_at'];
			$this->last_login = $row['last_login'];
			$this->last_activity = $row['last_activity'];
			$this->note = $row['note'];
			
			return $row;		
		}	
	}
   
/*
**************************
*/
 	
	public function activity()
	{
		global $sql;	
		$id = $this->get_logged_user();
		$this->update_session();
		$sql->cond('id_user', $id);
		
		$data = array(	
		'last_activity' => time()		
		);
		
		if($sql->update($this->db_users, $data)) return true;	
	}	
	   
/*
**************************
*/ 	
	
	
	public function update()
	{			
		global $sql;			
		$sql->cond('id_user', $this->id_user);
		
		$data = array(
		'user_pass' => $this->user_pass,
		'user_email' => $this->user_email,
		'user_pass' => $this->user_pass,
		'user_type' => $this->user_type,
		'id_group' => $this-> id_group,
		'is_active' => $this->is_active,
		'created_at' => $this-> created_at,
		'last_login' => $this->last_login,
		'last_activity' => $this->last_activity,
		'note' => $this->note		
		);
		
		if($sql->update($this->db_users, $data)) return true;
	}
	 
/*
**************************
*/
 	
	public function update_user()
	{			
		 return true;
	}
	
 
/*
**************************
*/
 	 
 public function set_nohome()
 {
		$this->no_home = 1;
 } 
 
/*
**************************
*/
 	
	public function new_user()
	{		
		$error = 0;
		
		if(!$this->user_login_exists($this->user_login))
		{  
			$this->created_at = time();		
			
			global $sql;		
			
			$data = array(
			'user_login' => $this->user_login,
			'user_pass' => $this->user_pass,
			'user_email' => $this->user_email,
			'user_pass' => $this->user_pass,
			'user_type' => $this->user_type,
			'id_group' => $this-> id_group,
			'is_active' => $this->is_active,
			'created_at' => $this-> created_at,
			'last_login' => $this->last_login,
			'last_activity' => $this->last_activity,
			'note' => $this->note		
			);	
			
			$id = $sql->add($this->db_users, $data);
			
			if($id != 0)
			{
				$this->new_user_id = $id;
				$this->id_user = $this->new_user_id;
				$this->user_pass = $this->generate_password();
				$this->update();
				
				if(!$this->create_default_desktop()) $error = 1;				
				
				if($this->no_home != 1)
				{					
					if(!$this->create_home_dir()) $error = 1;					
				}				
			}	
			
		} else {
		
			$error = 1;
		}
		
		if($error == 0) return true;
	}
	
 
/*
**************************
*/
 		
	public function count_users($param = 'ALL')
	{
		global $sql;	
		
		switch($param)
		{
			case 'ALL':
				
			break;
			
			case 'ACTIVE':
				$sql->cond('is_active', 1);
			break;
			
			case 'USERS':
				$sql->cond('user_type', 1);
			break;
			
			case 'ADMINS':
				$sql->cond('user_type', 2);
			break;
			
			case 'INACTIVE':
				$sql->cond('is_active', 0);
			break;				
		}	
		
		return $sql->count_rows($this->db_users);
	}
	
 
/*
**************************
*/
 		
	public function get_users($param = 'ALL')
	{
		global $sql;		
		
		if($this->count_users($param) != 0)
		{
			switch($param)
			{
				case 'ALL':
				
				break;
				
				case 'ACTIVE':
						$sql->cond('is_active', 1);
				break;				
				
				case 'USERS':
						$sql->cond('user_type', 1);
				break;
				
				case 'ADMINS':
					$sql->cond('user_type', 2);
				break;
				
				case 'INACTIVE':
					$sql->cond('is_active', 0);
				break;	
			}		
			
			
			$users = array();
			
			$records = $sql->records($this->db_users);
			foreach($records as $row)
			{
				$users[] = $row['id_user'];
			}
			
			return $users;			
		}	
	}
	
	 
/*
**************************
*/
 	
	
// GET/SET METHODS
		
		public function set_id_user($id_user)
		{
			$this->id_user = $id_user;
		}
	 
/*
**************************
*/
 		
		public function get_id_user()
		{
			return (int)$this->id_user;
		}
 
/*
**************************
*/
 			
		public function set_user_login($user_login)
		{
			$this->user_login = $user_login;
		}
 
/*
**************************
*/
 			
		public function get_user_login()
		{
			return $this->user_login;
		}
 
/*
**************************
*/
 	
		public function set_user_pass($user_pass)
		{
			$this->user_pass = $user_pass;
		}
 
/*
**************************
*/
 	
		public function set_raw_pass($raw_pass)
		{
			$this->raw_pass = $raw_pass;
		}
 
/*
**************************
*/
 			
		public function get_user_pass()
		{
			return $this->user_pass;
		}
 
/*
**************************
*/
 			
		public function set_user_email($user_email)
		{
			$this->user_email = $user_email;
		}
 
/*
**************************
*/
 			
		public function get_user_email()
		{
			return $this->user_email;
		}
 
/*
**************************
*/
 			
		public function set_user_type($user_type)
		{
			$this->user_type = $user_type;
		}
	 
/*
**************************
*/
 		
		public function get_user_type()
		{
			return $this->user_type;
		}
	 
/*
**************************
*/
 		
		public function set_id_group($id_group)
		{
			$this->id_group = $id_group;
		}
	 
/*
**************************
*/
 		
		public function get_id_group()
		{
			return $this->id_group;
		}
	 
/*
**************************
*/
 		
		public function set_is_active($is_active)
		{
			$this->is_active = $is_active;
		}
		 
/*
**************************
*/
 	
		public function get_is_active()
		{
			return $this->is_active;
		}
 
/*
**************************
*/
 		
		public function set_created_at($created_at)
		{
			$this->created_at = $created_at;
		}
 
/*
**************************
*/
 			
		public function get_created_at()
		{
			return $this->created_at;
		}
 
/*
**************************
*/
 			
		public function set_last_login($last_login)
		{
			$this->last_login = $last_login;
		}
 
/*
**************************
*/
 			
		public function get_last_login()
		{
			return $this->last_login;
		}
 
/*
**************************
*/
 	
		public function get_new_user_id()
		{
			return $this->new_user_id;
		}
 
/*
**************************
*/
 		
		public function set_last_activity($last_activity)
		{
			$this->last_activity = $last_activity;
		}
 
/*
**************************
*/
 			
		public function get_last_activity()
		{
			return $this->last_activity;
		}
 
/*
**************************
*/
 		
		public function set_note($note)
		{
			$this->note = $note;
		}
 
/*
**************************
*/
 			
		public function get_note()
		{
			return $this->note;
		}
	
// endof GET/SET METHODS	
	
	
	// sessions
	 
/*
**************************
*/
 	
	public function create_session()
	{
		global $sql;
		
		$session_id = session_id();
		
		$sql->cond('php_sessid', $session_id);
		$sql->cond('id_user', $this->id_user);
		
		if(!$sql->is_row($this->db_sessions))
		{
			//$browser = serialize(get_browser(null, true));
			
			
			$items = array(
			'id_user' => $this->id_user,
			'php_sessid' => session_id(),
			'start_time' => time(),
			'end_time' => time(),
			'user_ip' => $this->getIP(),
			'user_browser' => $_SERVER['HTTP_USER_AGENT']
			);
			
			if($sql->add($this->db_sessions, $items)) return true;
		}
	}
	 
/*
**************************
*/
 	
	public function update_session()
	{
		global $sql;
		
		$session_id = session_id();
		
		$sql->cond('php_sessid', $session_id);
		$sql->cond('id_user', $this->id_user);
		
		if($sql->is_row($this->db_sessions))
		{
			
			$sql->cond('php_sessid', $session_id);
			$sql->cond('id_user', $this->id_user);
		
		$items = array(				
			'end_time' => time()	
			);
			
			if($sql->update($this->db_sessions, $items)) return true;
		}
	}
	 
/*
**************************
*/
 	
	public function get_my_session_id()
	{
		global $sql;
		
		$session_id = session_id();
		
		$sql->cond('php_sessid', $session_id);
		$sql->cond('id_user', $this->id_user);
		
		if($sql->is_row($this->db_sessions))
		{
			
			$sql->cond('php_sessid', $session_id);
			$sql->cond('id_user', $this->id_user);
			$row = $sql->get_row($this->db_sessions);
			return $row['id_session'];		
		}
	}
	 
/*
**************************
*/
 	
	public function get_last_sessions_ids($how_many = 30)
	{
		$ids = array();
			
		global $sql;		
		$sql->sort_by('id_session', 'desc');
		$sql->limit($how_many);
		$records = $sql->records($this->db_sessions);
		
		$c = count($records);
		if($c != 0)		
		{
			foreach($records as $row)
			{
				$ids[] = $row['id_session'];
			}
			
			return $ids;	
		}	
	}
	 
/*
**************************
*/
 	
	public function get_session_id_data($id)
	{
		global $sql;		
		$sql->cond('id_session', $id);
		return $sql->get_row($this->db_sessions);	
	}
	 
/*
**************************
*/
 	
	public function is_session_id($id)
	{
		global $sql;		
		$sql->cond('id_session', $id);
		if($sql->is_row($this->db_sessions)) return true;	
	}
	 
/*
**************************
*/
 	
	public function delete_session($id)
	{
		global $sql;		
		$sql->cond('id_session', $id);
		if($sql->delete($this->db_sessions)) return true;	
	}
	
	 
/*
**************************
*/
 	
	public function getIP() { 
	 if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown")) 
			 $ip = getenv("HTTP_CLIENT_IP"); 
	 else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown")) 
			 $ip = getenv("REMOTE_ADDR"); 
	 else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown")) 
			 $ip = getenv("HTTP_X_FORWARDED_FOR"); 
	 else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] 
			 && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown")) 
			 $ip = $_SERVER['REMOTE_ADDR']; 
	 else { 
			 $ip = "unknown"; 
	 
			 } 
	 return $ip;
} 
	 
/*
**************************
*/
 	
	
	public static function deleteDir($path) 
	{
    if (!is_dir($path)) {
        return false;
    }
    if (substr($path, strlen($path) - 1, 1) != '/') {
        $path .= '/';
    }
		
    $dotfiles = glob($path . '.*', GLOB_MARK);
    $files = glob($path . '*', GLOB_MARK);
    $files = array_merge($files, $dotfiles);
    foreach ($files as $file) {
        if (basename($file) == '.' || basename($file) == '..') {
            continue;
        } else if (is_dir($file)) {
            self::deleteDir($file);
        } else {
            unlink($file);
        }
    }
    rmdir($path);
	}
	 
/*
**************************
*/
 	
	
	private function delete_user_data()
	{
		global $sql;	
		
		//$sql->cond('id_user', $this->id_user);
		//$sql->delete($this->db_user_config);
		
		$sql->cond('id_user', $this->id_user);
		$sql->delete($this->db_sessions);		
		
		//$sql->cond('id_user', $this->id_user);
		//$sql->delete($this->db_groups);
		
		$sql->cond('id_user', $this->id_user);
		$sql->delete($this->db_groups_records);
		
		$sql->cond('id_user', $this->id_user);
		$sql->delete($this->db_clouds);
		
		//$sql->cond('id_user', $this->id_user);
		//$sql->delete($this->db_ftp);
		
		$sql->cond('id_user', $this->id_user);
		$sql->delete($this->db_shared);
		
		$sql->cond('id_user', $this->id_user);
		$sql->delete($this->db_startmenu);
		
		//$sql->cond('id_user', $this->id_user);
		//$sql->delete($this->db_sessions);		
	}
	
	
	
	 
/*
**************************
*/
 	
	public function delete_user()
	{
		global $sql;	
		if(!empty($this->id_user) && $this->id_user != 1)
		{
			if($this->user_id_exists())
			{
				$dir_hash = $this->get_home_dir_hash();
				$user_dir = PHPOS_WEBROOT_DIR.'home/'.$dir_hash;
				$this->delete_user_data();
				self::deleteDir($user_dir);
				
				$sql->cond('id_user', $this->id_user);
				
				if($sql->delete($this->db_users)) return true;				
			}		
		}		
	}
	
	
	
}
?>