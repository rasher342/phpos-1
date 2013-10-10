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


	class phpos_installer {	
	
		private 
			$this_step,
			$next_step,
			$prev_step,
			$first_step,
			$last_step,
			$finished_steps,
			$chmod_dirs = array(),
			$chmod_file,
			$chmod_dir,
			$steps_titles = array(),
			$steps_headers = array(),
			$status_ok = array(),
			$status_error = array(),
			$status_warn = array(),
			$install_status,
			$install_status_ok,
			$install_status_warn,
			$install_status_error,
			$is_errors = null,
			$jquery_next,
			$jquery_start,
			$step_status;
	
	 
/*
**************************
*/
 
	
	public function __construct()
	{
			$this->first_step = 1;
			$this->last_step = 8;			
				
			
			$this->chmod_dirs[] = PHPOS_HOME_CHMOD;
			$this->chmod_dirs[] = PHPOS_DIR.'config';
			$this->chmod_dirs[] = PHPOS_DIR.'logs';
			$this->chmod_dirs[] = PHPOS_WEBROOT_DIR.'temp';
			
			
			//$this->chmod_dirs[] = PHPOS_WEBROOT_DIR.'temp2';
			
		
			
			$this->steps_titles = array(
				0 => '',
				1 => txt('installer_s1'),
				2 => txt('installer_s2'),
				3 => txt('installer_s3'),
				4 => txt('installer_s4'),				
				5 => txt('installer_s5'),
				6 => txt('installer_s6'),
				7 => txt('installer_s7'),
				8 => txt('installer_s8')
			);
				
			
	$this->steps_headers = array(
		0 => '',
		1 => txt('installer_h1'),
		
		2 => txt('installer_h2'),
		
		3 => txt('installer_h3'),
		
		4 => txt('installer_h4'),	
		
		5 => txt('installer_h5'),
		
		6 => txt('installer_h6'),
		
		7 => txt('installer_h7'),
		
		8 => txt('installer_h8')	
	);
	
		
		$this->status_ok['gen_sec_key'] = txt('installer_o1');
		$this->status_ok['gen_install_file'] = txt('installer_o2');
		$this->status_ok['gen_cfg_file'] = txt('installer_o3');	
		$this->status_ok['db_conn'] = txt('installer_o4');		
		$this->status_ok['db_install'] = txt('installer_o5');	
		$this->status_ok['db_gen_cfg'] = txt('installer_o6');
		$this->status_ok['db_update'] = txt('installer_o7');	
		$this->status_ok['reinstall'] = txt('installer_o8');
		$this->status_ok['install_ok'] = txt('installer_o9');	
		$this->status_ok['home_dir_ok'] = txt('installer_o10');

		$this->status_warn['db_pwd'] = txt('installer_w1');
		$this->status_warn['ovr_key'] = txt('installer_w2');
		$this->status_warn['ovr_db_cfg'] = txt('installer_w3');
		$this->status_warn['ovr_cfg'] = txt('installer_w4');
		$this->status_warn['ovr_install'] = txt('installer_w5');
		$this->status_warn['home_dir_warn'] = txt('installer_w6');

		$this->status_error['gen_sec_key'] = txt('installer_e1');
		$this->status_error['gen_install_file'] = txt('installer_e2');
		$this->status_error['gen_cfg_file'] = txt('installer_e3');	
		$this->status_error['db_conn'] = txt('installer_e4');			
		$this->status_error['db_install'] = txt('installer_e5');	
		$this->status_error['db_gen_cfg'] = txt('installer_e6');	
		$this->status_error['db_update'] = txt('installer_e7');	
		$this->status_error['install_errors'] = txt('installer_e8');	
		$this->status_error['reinstall'] = txt('installer_e9');
		$this->status_error['db_exists'] = txt('installer_e10');
			
			
			
			// set session
			if(!is_array($_SESSION['phpos_install_steps']))
			{
				$_SESSION['phpos_finished_steps'] = array();
				$_SESSION['phpos_finished_steps'][0] = 0;
				$_SESSION['phpos_finished_steps'][1] = 0;
				$_SESSION['phpos_finished_steps'][2] = 0;
				$_SESSION['phpos_finished_steps'][3] = 0;
				$_SESSION['phpos_finished_steps'][4] = 0;
				$_SESSION['phpos_finished_steps'][5] = 0;
				$_SESSION['phpos_finished_steps'][6] = 0;
				$_SESSION['phpos_finished_steps'][7] = 0;	
			}
			
			if(!is_array($_SESSION['phpos_install_data']))
			{
				$_SESSION['phpos_install_data'] = array();
				$_SESSION['phpos_install_data']['license'] = 0; //dac acceptd
				$_SESSION['phpos_install_data']['root_password1'] = '';
				$_SESSION['phpos_install_data']['root_password2'] = '';
				
				$_SESSION['phpos_install_data']['cfg_lang'] = $_SESSION['installer_lang'];
				$_SESSION['phpos_install_data']['cfg_title'] = 'PHP-OS Operating system';
				$_SESSION['phpos_install_data']['cfg_email'] = '';
				$_SESSION['phpos_install_data']['cfg_wallpaper'] = 'phpos_default.jpg';
				
				$_SESSION['phpos_install_data']['db_adapter'] = '';
				$_SESSION['phpos_install_data']['db_host'] = 'localhost';
				$_SESSION['phpos_install_data']['db_name'] = '';
				$_SESSION['phpos_install_data']['db_login'] = '';
				$_SESSION['phpos_install_data']['db_password'] = '';
				$_SESSION['phpos_install_data']['db_prefix'] = 'phpos_';
			}
	
	}
	
 /*
**************************
*/
	
 
 public function get_title()
 {
	return $this->steps_titles[$this->this_step];
 }
 
 /*
**************************
*/
	
 
 public function get_error_msg($id)
 {
	return $this->status_error[$id];
 }
 /*
**************************
*/
	
  public function get_ok_msg($id)
 {
	return $this->status_ok[$id];
 }
 /*
**************************
*/
	
  public function get_warn_msg($id)
 {
	return $this->status_warn[$id];
 }
/*
**************************
*/
	
	
	public function clean_session()
	{
	
	
	}
	
	
	
	public function get_steps()
	{		
		$tmp_step = $this->first_step;
		
		if(!empty($_POST['step']))
		{
			$tmp_step = intval($_POST['step']);
		} elseif(!empty($_GET['step']))
		{
			$tmp_step = intval($_GET['step']);	
		} 
		
		$step_first_min = $this->first_step - 1;
		$step_last_max = 9;
		
		if(is_integer($tmp_step) && $tmp_step > $step_first_min && 	$tmp_step < $step_last_max)
		{
			$this->this_step = $tmp_step;
		} else {
			$this->this_step = $this->first_step;
		}
			
		$this->next_step = $this->this_step + 1;	
		$this->prev_step = $this->this_step - 1;	
		
		
	}
 
/*
**************************
*/
 
	public function get_this_step()
	{
		return $this->this_step;
	}
 
/*
**************************
*/
 
	public function get_next_step()
	{
		return $this->next_step;
	}
 
/*
**************************
*/
 
	public function get_prev_step()
	{
		return $this->prev_step;
	}
 
/*
**************************
*/
 
	function get_step_title()
	{
		$title = $this->steps_titles[$this->this_step];
		return $title;
	}
 
/*
**************************
*/
 
 public function get_key_info()
 {
	if(file_exists(PHPOS_DIR.'config/security_key.php')) 
	{
		include PHPOS_DIR.'config/security_key.php';
	}
	
	//$this->PHPOS_KEY = $phpos_key
	
	$str.='<div style="width:95%; border:2px solid black; background-color:white;padding:10px;text-align:center; text-shadow:none;color:black">'.txt('installer_key_msg').'<br /><b>'.txt('installer_your_key').':</b><br /><br/><span style="color:#226721;font-weight:bold; font-size:14px">'.$phpos_key.'</span></div>';
	return $str;
 }
 
 
 
 public function get_install_status()
	{	
		
		if(!empty($this->install_status_error[0]))
		{
			$this->is_errors = 1;
			$c = count($this->install_status_error);
			for($i=0; $i<$c; $i++)
			{
				$install_status.= $this->status_info('error', $this->install_status_error[$i]);
			}	
		}
		
		if(!empty($this->install_status_warn[0]))
		{
			$c = count($this->install_status_warn);
			for($i=0; $i<$c; $i++)
			{
				$install_status.= $this->status_info('warn', $this->install_status_warn[$i]);
			}	
		}
		
		if(!empty($this->install_status_ok[0]))
		{
			$c = count($this->install_status_ok);
			for($i=0; $i<$c; $i++)
			{
				//$install_status.= $this->status_info('ok', $this->install_status_ok[$i]);
			}	
		}
		
		return $install_status;	
	}
 
/*
**************************
*/
 
	public function is_errors()
	{
		if($this->is_errors == 1) return true;
	}	
	
 
/*
**************************
*/
 
	public function render_step_titles()
	{
		$c = count($this->steps_titles);
		$str = null;
		
		for($i=0; $i < $c; $i++)
		{
			// if not 0 step
			if($i != 0)
			{
				if($i != $this->this_step)
				{
					// if not this step:
					$str.= '<span class="desc">'.$this->steps_titles[$i].'</span><br />';
					
				} else {
					
					// if this step:					
					$str.= '<span class="desc_active"><img src="'.PHPOS_WEBROOT_DIR.'_phpos/installer/arrow_step_now.png"/>'.$this->steps_titles[$i].'</span><br />';
				}
			}		
		}			
		return $str;		
	}
	 
/*
**************************
*/
 
	public function load_license()
	{
		if(file_exists(PHPOS_WEBROOT_DIR.'license_'.$_SESSION['installer_lang'].'.txt'))
		{
			$license = file_get_contents(PHPOS_WEBROOT_DIR.'license_'.$_SESSION['installer_lang'].'.txt');	
		} else {
		
			$license = file_get_contents(PHPOS_WEBROOT_DIR.'license_en.txt');	
		}
		return $license;	
	}
 
/*
**************************
*/
 
	/* ***** PRE-ACTIONS ******/
	
	public function action_set_db_session()
	{
		if(!empty($_POST['db_host']))
		{
			$_SESSION['phpos_install_data']['db_adapter'] = $_POST['db_adapter'];
			$_SESSION['phpos_install_data']['db_host'] = $_POST['db_host'];
			$_SESSION['phpos_install_data']['db_name'] = $_POST['db_name'];
			$_SESSION['phpos_install_data']['db_user'] = $_POST['db_user'];
			$_SESSION['phpos_install_data']['db_password'] = $_POST['db_password'];
			$_SESSION['phpos_install_data']['db_prefix'] = $_POST['db_prefix'];
		}	
	}
 
/*
**************************
*/
 
	public function action_set_cfg_session()
	{
		if(!empty($_POST['lang']))
		{
			$_SESSION['phpos_install_data']['cfg_title'] = $_POST['cfg_title'];	
			$_SESSION['phpos_install_data']['cfg_lang'] = $_POST['lang'];	
			$_SESSION['phpos_install_data']['cfg_email'] = $_POST['cfg_email'];	
			$_SESSION['phpos_install_data']['cfg_wallpaper'] = $_POST['cfg_wallpaper'];	
		}
	}
 
/*
**************************
*/
 
	public function action_set_accept_license_session()
	{
		$_SESSION['phpos_install_data']['license'] = 1;
	}
 
/*
**************************
*/
 
	public function action_set_root_pwd_session()
	{
		if(!empty($_POST['root_password']) && !empty($_POST['root_password_confirm']) && $_GET['step'] != 4)
		{
			if($_POST['root_password'] == $_POST['root_password_confirm'])
			{
				$_SESSION['phpos_install_data']['root_password1'] = $_POST['root_password'];
				$_SESSION['phpos_install_data']['root_password2'] = $_POST['root_password_confirm'];
				$_SESSION['phpos_finished_steps'][3] = 1;
			}
		}
	}
 
/*
**************************
*/
 
	public function action_set_chmods()
	{
		if($_SESSION['phpos_finished_steps'][6] != 1)
			{
				$c = count($this->chmod_dirs);			
				for($i=0; $i < $c; $i++)
				{
					$name = realpath($this->chmod_dirs[$i]);			
					
					if(is_dir($name))
					{					
						chmod($name, 0755);					
					} else {
					
						if(file_exists($name))
						{
							chmod($name, 0755);										
						}				
					}
				}
			}			
	}
 
/*
**************************
*/
 
	/* ****** STEPS RENDER ***** */
	
	public function step_license()
	{
		$license = $this->load_license();
		$str.='<textarea id="license" readonly>'.$license.'</textarea><br><input type="checkbox" name="license_accept" id="license_checkbox" value="true" /> '.txt('installer_i1');	
		return $str;	
	}
 
/*
**************************
*/
 
	public function step_system_check()
	{
		$str.=$this->table_check('PHP', '5.2', floatval(@phpversion()),  '');
		$str.=$this->table_check('MySQL', '4.0', floatval(@mysql_get_server_info()), txt('installer_i2'));
		return $str;
	}
 
/*
**************************
*/
 
	public function step_root_password()
	{
		$str.=$this->form_input('root_password', txt('installer_pwd'), txt('installer_i3'), 'password', '');
		$str.=$this->form_input('root_password_confirm', txt('installer_cpwd'), txt('installer_i3'), 'password', '');	
		return $str;	
	}
 
/*
**************************
*/
 
	public function step_db_config()
	{				
		$items = '<option value="mysql">MySQL</option>';
		$str.=$this->form_select('db_adapter', txt('installer_dbtype'), txt('installer_dbv'), $items, $_SESSION['phpos_install_data']['db_adapter']);
		$str.=$this->form_input('db_host', 'Host', '* '.txt('installer_req'), 'input', $_SESSION['phpos_install_data']['db_host']);
		$str.=$this->form_input('db_name', txt('installer_db'), '* '.txt('installer_req'), 'input', $_SESSION['phpos_install_data']['db_name']);
		$str.=$this->form_input('db_user', 'Login', '* '.txt('installer_req'), 'input', $_SESSION['phpos_install_data']['db_user']);
		$str.=$this->form_input('db_password', txt('installer_pwd'), txt('installer_pwdnreq'), 'password', $_SESSION['phpos_install_data']['db_password']);
		$str.=$this->form_input('db_prefix', 'Prefix', txt('installer_iprx'), 'input', $_SESSION['phpos_install_data']['db_prefix']);	
		return $str;	
	}
 
/*
**************************
*/
 
	public function step_site_config()
	{
		// lang
	
		$langs = new phpos_languages;
		$langlist = 	$langs->get_lang_list();		
		
		$wallpapers = new phpos_wallpapers;
		$wallpapers_list = 	$wallpapers->get_global_wallpapers();
		
		$items = '';
		$wallpaper_items = '';
		
		foreach($langlist as $lang)
		{					
			$langinfo = $langs->get_lang_info($lang);
			$selected = '';			
			if($lang == $_SESSION['installer_lang']) $selected = ' selected';
			$items.= '<option value="'.$lang.'"'.$selected.'>'.$langinfo['local_name'].' ('.$langinfo['eng_name'].')</option>';		
		}		
		
		foreach($wallpapers_list as $jpg)
		{				
			$selected = '';			
			if($jpg == $_SESSION['phpos_install_data']['cfg_wallpaper']) $selected = ' selected';
			$wallpaper_items.= '<option value="'.$jpg.'"'.$selected.'>'.$jpg.'</option>';		
			//echo $jpg;
		}		
		
		$str.=$this->form_input('cfg_title', txt('installer_cfg1'), '', 'input', $_SESSION['phpos_install_data']['cfg_title']);
		$str.=$this->form_select('lang', txt('installer_cfg2'), '', $items, $_SESSION['installer_lang']);
		$str.=$this->form_select('cfg_wallpaper', txt('installer_cfg3'), '', $wallpaper_items, $_SESSION['phpos_install_data']['cfg_wallpaper']);
		$str.=$this->form_input('cfg_email', 'Email', '', 'input', $_SESSION['phpos_install_data']['cfg_email']);
		return $str;
	}
 
/*
**************************
*/
 
	public function step_chmod_check()
	{
		$c = count($this->chmod_dirs);			
		for($i=0; $i < $c; $i++)
		{
			$name = realpath($chmod_dirs[$i]);
			$file_name = $this->chmod_dirs[$i];			
			
			if(is_dir($name))
			{				
				$chmod = substr(sprintf('%o', fileperms($name)), -4);
				settype($chmod, 'integer');
				$file_name = basename($file_name).'/';
				$str.=$this->chmod_check($file_name, $name, '755', $chmod, null);	
				
			} 		
		}
		
		$_SESSION['phpos_finished_steps'][6] = 1;
		return $str;
	}
 
/*
**************************
*/
 
	/* ***** INSTALLER ****** */
	
	public function set_error($id)
	{
		$this->install_status_error[] = '<b>['.txt('installer_m1').']</b> '.$this->status_error[$id];
	}
	
	public function set_sql_error($id)
	{
		$this->install_status_error[] = '<b>['.txt('installer_m2').']</b> '.$this->status_error[$id].'<br /><br/><b>SQL: '.$_SESSION['mysql_error'].'<br />';
	}
 
/*
**************************
*/
 
	public function set_ok($id)
	{
		$this->install_status_ok[] = '<b>['.txt('installer_m3').']</b> '.$this->status_ok[$id];
	}
 
/*
**************************
*/
 
 	public function set_warn($id)
	{
		$this->install_status_warn[] = '<b>['.txt('installer_m4').']</b> '.$this->status_warn[$id];
	}
 
/*
**************************
*/
	public function installer_gen_key()
	{		
		if(!file_exists(PHPOS_DIR.'config/security_key.php'))
		{
			$key = md5(time());
			$key_data = '<?php
			// Key file generated: '.time().'
			if(!defined("PHPOS"))
			{
				die();
			}
				$phpos_key = "'.$key.'";		
			?>';
			
			if(file_put_contents(PHPOS_DIR.'config/security_key.php', $key_data))
			{
				$this->set_ok('gen_sec_key');
				return true;
				
			} else {
			
				$this->set_error('gen_sec_key');				
			}
			
		} else {
			
			include PHPOS_DIR.'config/security_key.php';
			if(!empty($phpos_key))
			{
				$this->set_ok('gen_sec_key');			
				return true;
			} else {
				$this->set_error('gen_sec_key');		
			}
		}		
	}
 
/*
**************************
*/
 
	public function installer_gen_install_file()
	{		
		$t =time();
			$file_data = '<?php
			// Installer file generated: '.time().'
			if(!defined("PHPOS"))
			{
				die();
			}
				$phpos_installed_time = "'.$t.'";		
			?>';
			
		if(!file_exists(PHPOS_DIR.'config/installed.php'))
		{			
			if(file_put_contents(PHPOS_DIR.'config/installed.php', $file_data))
			{
				$this->set_ok('gen_install_file');					
				return true;
				
			}	else {
				$this->set_error('gen_install_file');
			}
			
		} else {					
				
				if(file_put_contents(PHPOS_DIR.'config/installed.php', $file_data))
				{
					$this->set_warn('ovr_install');
					$this->set_ok('gen_install_file');
					return true;
					
				} else {
					$this->set_error('gen_install_file');
				}			
			
		}		
	}
 
/*
**************************
*/
 
	public function installer_save_db_config()
	{		
		if(!empty($_SESSION['phpos_install_data']['db_host']) && !empty($_SESSION['phpos_install_data']['db_user']) && !empty($_SESSION['phpos_install_data']['db_name']))
		{
				
			$db_file = '<?php
			// DB Config file generated: '.time().'
			if(!defined("PHPOS"))
			{
				die();
			}
				$db_adapter = "'.$_SESSION['phpos_install_data']['db_adapter'].'";
				$db_host = "'.$_SESSION['phpos_install_data']['db_host'].'";
				$db_login = "'.$_SESSION['phpos_install_data']['db_user'].'";
				$db_password = "'.$_SESSION['phpos_install_data']['db_password'].'";
				$db_dbname = "'.$_SESSION['phpos_install_data']['db_name'].'";
				$db_prefix = "'.$_SESSION['phpos_install_data']['db_prefix'].'";
			?>';
			
			if(file_put_contents(PHPOS_DIR.'config/database.php', $db_file))
			{
				$this->set_ok('db_gen_cfg');					
				$_SESSION['first_login'] = 'root';
				$_SESSION['first_password'] = $_SESSION['phpos_install_data']['root_password1'];				
				return true;
			} else {
				$this->set_error('db_gen_cfg');
			}
		
		}
	}
 
/*
**************************
*/
 
	public function installer_save_config()
	{
		$cfg_file = '	<?php
		if(!defined("PHPOS"))
		{
			die();
		}			
			$PHPOS_GLOBALCONFIG["lang"] = "'.$_SESSION['installer_lang'].'";
			$PHPOS_USERCONFIG["lang"] = "'.$_SESSION['installer_lang'].'";
		?>';
		
		if(file_exists(PHPOS_DIR.'config/core.php'))
		{
			if(file_put_contents(PHPOS_DIR.'config/core.php', $cfg_file))
			{	
				//$this->set_warn('ovr_cfg');
				$this->set_ok('gen_cfg_file');	
				
				return true;
			}	else {			
				$this->set_error('gen_cfg_file');	
			}
			
		} else {
		
			if(file_put_contents(PHPOS_DIR.'config/core.php', $cfg_file))
			{
				$this->set_ok('gen_cfg_file');			
				return true;
			}	else {
			
				$this->set_error('gen_cfg_file');	
			}
		}
	}
 
/*
**************************
*/
 
	public function installer_check_connection()
	{
		$_SESSION['mysql_error'] = null;
		if(!empty($_SESSION['phpos_install_data']['db_host']) && !empty($_SESSION['phpos_install_data']['db_user']) && !empty($_SESSION['phpos_install_data']['db_name']))
		{
			global $sql;		
			if($sql->connect())
			{			
				if(empty($_SESSION['phpos_install_data']['db_password'])) $this->set_warn('db_pwd');
				$this->set_ok('db_conn');
				return true;	
				
			} else { 			
				$_SESSION['mysql_error'] = $sql->get_error('parse');
				$this->set_sql_error('db_conn');				
				return false;
			}	
		
		} else {
		
			$this->set_error('db_conn');				
			return false;
		}
	}
	
	
	public function installer_uninstall()
	{
		if($_SESSION['need_reinstall'])
		{
			global $sql;	
			$db_schema_file = PHPOS_DIR.'install/db_schema.php';
			include $db_schema_file;
		
			if(is_array($schema))		{		
		
				global $sql;
				$sql->load_schema($schema);			
				if($sql->uninstall())
				{					
					$this->set_ok('reinstall');
					unset($_SESSION['need_reinstall']);
					return true;
					
					
				} else { 	
				
					$_SESSION['mysql_error'] = $sql->get_error('parse');
					$this->set_sql_error('reinstall');		
					unset($_SESSION['need_reinstall']);
					return false;
				}
			}
		}
		unset($_SESSION['need_reinstall']);
	}
 
/*
**************************
*/
 
	public function installer_db_set_data()
	{
		$root_time = time();
		include PHPOS_DIR.'config/security_key.php';
		
		if(empty($phpos_key) || empty($_SESSION['phpos_install_data']['root_password1']))
		{
			return false;
		}		
		
		if($_SESSION['phpos_install_data']['root_password1'] != $_SESSION['phpos_install_data']['root_password2'])
		{
			// not match
		}
		
		global $sql;		
		require PHPOS_DIR.'install/db_schema.php';
		
		if(is_array($insert))
		{
			foreach($insert as $table => $record)
			{
				if(!$sql->insert_array($record, $table))
				{
					$_SESSION['mysql_error'] = $sql->get_error('parse');
					$this->set_sql_error('db_update');	
					return false;
				}			
			}	
		}
		
		
		
		$usr = new phpos_users;
		$usr->set_id_user(1);
		$usr->get_user_by_id();
		$usr->set_created_at($root_time);
		$usr->set_user_email($_SESSION['phpos_install_data']['cfg_email']);
		$usr->set_raw_pass($_SESSION['phpos_install_data']['root_password1']);		
		$root_pwd = $usr->generate_password();
		$usr->set_user_pass($root_pwd);
		
		if($usr->update())
		{
			//echo 'uuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuu'.$root_pwd;
			$this->set_ok('db_update');	
			
			// home dir
			if($usr->create_home_dir())
			{
				$this->set_ok('home_dir_ok');	
			} else {
				$this->set_warn('home_dir_warn');	
			}		
			
			$t = time();
			// Save config
			$cfg = new phpos_config('phpos_config');
			$cfg->update_global('lang', $_SESSION['phpos_install_data']['cfg_lang']);
			$cfg->update_global('wallpaper', $_SESSION['phpos_install_data']['cfg_wallpaper']);
			$cfg->update_global('site_title', $_SESSION['phpos_install_data']['cfg_title']);
			$cfg->update_global('root_email', $_SESSION['phpos_install_data']['cfg_email']);
			$cfg->update_global('version', PHPOS_VERSION);
			$cfg->update_global('versionnumber', PHPOS_VERSIONNUMBER);
			$cfg->update_global('build', PHPOS_BUILD);
			$cfg->update_global('install_time', $t);
			$cfg->update_global('update_time', $t); 
			//$cfg->update_global('key_copy', $phpos_key); 
			$cfg->set_id_user(1);		
			$cfg->update_user('lang', $_SESSION['phpos_install_data']['cfg_lang']);
			$cfg->update_user('wallpaper', $_SESSION['phpos_install_data']['cfg_wallpaper']);
			$cfg->update_user('wallpaper_type', 'global');
			
			return true;
		} else {
			$_SESSION['mysql_error'] = $sql->get_error('parse');
			$this->set_sql_error('db_update');	
		}
	}
 
/*
**************************
*/
 
	public function installer_install_db()
	{
		//$sql_file = PHPOS_DIR.'install/database.sql';
		
		global $sql;
		$db_schema_file = PHPOS_DIR.'install/db_schema.php';
		include $db_schema_file;
		
		$_SESSION['mysql_error_query'] = null;
		$sql->cond('id_user', '1');		
		
		/*$q = "SELECT id_user FROM phpos_users WHERE id_user = '1'";
		$w = @mysql_query($q);
		$r = @mysql_num_rows($w);
		*/
		
		if($sql->is_row('users'))
		{
			$this->set_error('db_exists');
			$_SESSION['need_reinstall'] = 1;
			return false;
			
		} else {
			
			unset($_SESSION['need_reinstall']);
		}
		
		
		if(is_array($schema))		{		
		
			global $sql;
			$sql->load_schema($schema);
		
					
			if($sql->install())
			{
				$_SESSION['mysql_db_installed'] = 1;
				if($this->installer_db_set_data())
				{
					$this->set_ok('db_install');						
					return true;
					
				} else {
					
					$_SESSION['mysql_error'] = $sql->get_error('parse');
					$this->set_sql_error('db_install');					
				}
			}	else {
			
				$_SESSION['mysql_error'] = $sql->get_error('parse');
				$this->set_sql_error('db_install');			
			}
		}
	}
 
/*
**************************
*/
 
/* ***** HELPERS ***** */
	
	public function info($type = 'info', $msg = null)
	{	
		switch($type)
		{
			case 'info':
				$icon = PHPOS_WEBROOT_URL.'_phpos/installer/status_info.png';
			break;
			
			case 'ok':
				$icon = PHPOS_WEBROOT_URL.'_phpos/installer/status_ok.png';
			break;
			
			case 'error':
				$icon = PHPOS_WEBROOT_URL.'_phpos/installer/status_error.png';
			break;
				
			case 'warn':
				$icon = PHPOS_WEBROOT_URL.'_phpos/installer/status_warn.png';
			break;
			
			case 'arrow':
				$icon = PHPOS_WEBROOT_URL.'_phpos/installer/status_arrow.png';
			break;
			
			case 'question':
				$icon = PHPOS_WEBROOT_URL.'_phpos/installer/status_question.png';
			break;
			
			default:
				$icon = PHPOS_WEBROOT_URL.'_phpos/installer/status_info.png';
			break;
		
		}
		if($msg == null)	$msg = $this->steps_headers[$this->this_step];
		$str = '<div class="info"><div class="img"><img src="'.$icon.'" /></div><div class="msg">'.$msg.'</div><div style="clear:both"></div></div>';
		return $str;
	}
 
/*
**************************
*/

	public function status_info($type = 'info', $msg = null)
	{	
		switch($type)
		{
			case 'info':
				$icon = PHPOS_WEBROOT_URL.'_phpos/installer/status_info.png';
			break;
			
			case 'ok':
				$icon = PHPOS_WEBROOT_URL.'_phpos/installer/status_ok.png';
			break;
			
			case 'error':
				$icon = PHPOS_WEBROOT_URL.'_phpos/installer/status_error.png';
			break;
				
			case 'warn':
				$icon = PHPOS_WEBROOT_URL.'_phpos/installer/status_warn.png';
			break;
			
			case 'arrow':
				$icon = PHPOS_WEBROOT_URL.'_phpos/installer/status_arrow.png';
			break;
			
			case 'question':
				$icon = PHPOS_WEBROOT_URL.'_phpos/installer/status_question.png';
			break;
			
			default:
				$icon = PHPOS_WEBROOT_URL.'_phpos/installer/status_info.png';
			break;
		
		}
		if($msg == null)	$msg = $this->steps_headers[$this->this_step];
		$str = '<div class="status_info"><img src="'.$icon.'" style="" />'.$msg.'</div>';
		return $str;
	}
 
/*
**************************
*/ 
	public function form_input($name, $txt, $tip = null, $type = 'input', $default_value = '')
	{			
		$str ='
		<div class="form_area_row input_row_mouseleave">
				<div class="form_area_left">'.$txt.'</div>
				<div class="form_area_right"><input title="'.$txt.'" name="'.$name.'" value="'.$default_value.'" class="input input_mouseleave" type="'.$type.'" /></div>';
				
				if($tip == null)
				{
					$str.= '<div style="clear:both"></div>';
				} else {
					$str.= '<div style="clear:both" class="form_area_tip">'.$tip.'</div>';
				}
				
		$str.= '
		</div>';		
		return $str;	
	}
	
	
			 
/*
**************************
*/
 	
	
	
	
	public function form_select($name, $txt, $tip = null, $items, $selected = '')
	{			
		$str ='
		<div class="form_area_row input_row_mouseleave">
				<div class="form_area_left">'.$txt.'</div>
				<div class="form_area_right"><select name="'.$name.'">'.$items.'</select></div>';
				
				if($tip == null)
				{
					$str.= '<div style="clear:both"></div>';
				} else {
					$str.= '<div style="clear:both" class="form_area_tip">'.$tip.'</div>';
				}
				
		$str.= '
		</div>';		
		return $str;	
	}
 
/*
**************************
*/
 
	public function table_check_header($title, $left, $right)
	{
		
	
	}
 
/*
**************************
*/
 
	public function chmod_check($title, $full_url, $left, $right, $tip = null)
	{	
		$status = 'ok';
		
		if($right < $left)
		{
			$status = 'error';
		}
		
		
		$str ='
		
		<div class="form_area_row_title">'.$title.'</div>
		<div class="form_area_row_chmod_url">'.$full_url.'</div>
		<div style="clear:both"></div>		
		
		
		<div class="form_area_row_header">
			<div class="table_area_left">'.txt('installer_req').'</div>
			<div class="table_area_right">'.txt('installer_your').'</div>
		</div>
		<div style="clear:both"></div>		
		
		<div class="form_area_row input_row_mouseleave">
				<div class="table_area_left">'.$left.'</div>
				<div class="table_area_right">'.$right.'</div>
				<div class="table_area_status"><img src="'.PHPOS_WEBROOT_URL.'_phpos/installer/status_'.$status.'.png" /></div>';
				
				if($tip == null)
				{
					$str.= '<div style="clear:both"></div>';
				} else {
					$str.= '<div style="clear:both" class="form_area_tip">'.$tip.'</div>';
				}
				
		$str.= '
		</div>';		
		return $str;	
	}
 
/*
**************************
*/
 	
	public function table_check($title, $left, $right, $tip = null)
	{	
		$status = 'ok';
		
		if($right < $left)
		{
			$status = 'error';
		}
		
		
		$str ='
		
		<div class="form_area_row_title">'.$title.'</div>
		<div style="clear:both"></div>		
		
		
		<div class="form_area_row_header">
			<div class="table_area_left">'.txt('installer_req').'</div>
			<div class="table_area_right">'.txt('installer_your').'</div>
		</div>
		<div style="clear:both"></div>		
		
		<div class="form_area_row input_row_mouseleave">
				<div class="table_area_left">'.$left.'</div>
				<div class="table_area_right">'.$right.'</div>
				<div class="table_area_status"><img src="'.PHPOS_WEBROOT_URL.'_phpos/installer/status_'.$status.'.png" /></div>';
				
				if($tip == null)
				{
					$str.= '<div style="clear:both"></div>';
				} else {
					$str.= '<div style="clear:both" class="form_area_tip">'.$tip.'</div>';
				}
				
		$str.= '
		</div>';		
		return $str;	
	}	
 
/*
**************************
*/
 
	/* jQuery for next step button */
	
	public function jquery_next_button($step)
	{
		$this->jquery_next = array();
		$this->jquery_next[0] = null;		
		$this->jquery_next[1] = null;
		
		// license			
		$this->jquery_next[1] = "	
			
			if(!$('#license_checkbox').is(':checked'))
			{
				$('#error_message').html('<img src=\"".PHPOS_WEBROOT_URL."_phpos/installer/status_error.png\" /><p>".txt('installer_er1')."</p>');
				$('#error_message').css('display', 'block');			
				return false;
			}
			";	
		
		
		$this->jquery_next[2] = null;		
		
		// root pwd
		$this->jquery_next[3] = "
		
			var pwd1=$('input[name=\"root_password\"]').val();
			var pwd2=$('input[name=\"root_password_confirm\"]').val();	
			
			
			if(pwd1=='' || pwd1==' ' || pwd2=='' || pwd2==' ')
			{
				if(pwd1=='' || pwd1==' ')
				{
					$('input[name=\"root_password\"]').addClass('input_error');				
				}
				
				if(pwd2=='' || pwd2==' ')
				{
					$('input[name=\"root_password_confirm\"]').addClass('input_error');				
				}
				
				$('#error_message').html('<img src=\"".PHPOS_WEBROOT_URL."_phpos/installer/status_error.png\" /><p>".txt('installer_er2')."</p>');
				$('#error_message').css('display', 'block');			
				return false;			
				
			} else {
				
				// not empty
				if(pwd1 != pwd2)
				{
					$('#error_message').html('<img src=\"".PHPOS_WEBROOT_URL."_phpos/installer/status_error.png\" /><p>".txt('installer_er3')."</p>');
					$('#error_message').css('display', 'block');					
					
					$('input[name=\"root_password\"]').addClass('input_error');	
					$('input[name=\"root_password_confirm\"]').addClass('input_error');				
					
					return false;	
				} else {
				
					if(pwd1.length < 6 || pwd2.length < 6 || pwd2.length > 30 || pwd2.length > 30)
					{			
						$('input[name=\"root_password\"]').addClass('input_error');	
						$('input[name=\"root_password_confirm\"]').addClass('input_error');			
						
						$('#error_message').html('<img src=\"".PHPOS_WEBROOT_URL."_phpos/installer/status_error.png\" /><p>".txt('installer_er4')."</p>');
						$('#error_message').css('display', 'block');			
						return false;						
					}		
					
				}
			
			}	
		";
		
		// db config
		$this->jquery_next[4] = "
		
			var db_host = $('input[name=\"db_host\"]').val();
			var db_name = $('input[name=\"db_name\"]').val();	
			var db_user = $('input[name=\"db_user\"]').val();	
			
			if(db_host=='' || db_host==' ')
			{
				$('input[name=\"db_host\"]').addClass('input_error');
			}
			
			if(db_name=='' || db_name==' ')
			{
				$('input[name=\"db_name\"]').addClass('input_error');
			}
			
			if(db_user=='' || db_user==' ')
			{
				$('input[name=\"db_user\"]').addClass('input_error');
			}	
			
			
			if(db_host=='' || db_host==' ' || db_name=='' || db_name==' ' || db_user=='' || db_user==' ')
			{		
				$('#error_message').html('<img src=\"".PHPOS_WEBROOT_URL."_phpos/installer/status_error.png\" /><p>".txt('installer_er5')."</p>');
				$('#error_message').css('display', 'block');			
				return false;
			}
		
		";
				
		$this->jquery_next[5] = null;
		$this->jquery_next[6] = null;
		$this->jquery_next[7] = null;
		$this->jquery_next[8] = null;
		$this->jquery_next[9] = null;
		$this->jquery_next[10] = null;
		
		return $this->jquery_next[$step];	
	}
 
/*
**************************
*/
 
	public function jquery_at_start($step)
	{
		// Fill forms when filled before		
		
		$jquery_start = array();
		$jquery_start[0] = null;	
	
		// License
		$jquery_start[1] = '';
		
		if($_SESSION['phpos_install_data']['license'] == 1)
		{
			$jquery_start[1] = "$('#license_checkbox').attr('checked', 'true')";		
		}	
	
		// System check
		$jquery_start[2] = '';
		
		
		// Root password
		$jquery_start[3] = '';	
		if(!empty($_SESSION['phpos_install_data']['root_password1']) && !empty($_SESSION['phpos_install_data']['root_password2']))	
		{
			$jquery_start[3] = "			
			$('input[name=\"root_password\"]').val('".$_SESSION['phpos_install_data']['root_password1']."');	
			$('input[name=\"root_password_confirm\"]').val('".$_SESSION['phpos_install_data']['root_password2']."');	
			";
		}		
		
		// Database configuration
		$jquery_start[4] = '';
		$jquery_start4 = null;		
		
		if(!empty($_SESSION['phpos_install_data']['db_host']))
		{
			$jquery_start4.= "$('input[name=\"db_host\"]').attr('value', '".$_SESSION['phpos_install_data']['db_host']."'); ";	
		}
		
		if(!empty($_SESSION['phpos_install_data']['db_name']))
		{
			$jquery_start4.= "$('input[name=\"db_name\"]').val('".$_SESSION['phpos_install_data']['db_name']."'); ";	
		}
		
		if(!empty($_SESSION['phpos_install_data']['db_user']))
		{
			$jquery_start4.= "$('input[name=\"db_user\"]').val('".$_SESSION['phpos_install_data']['db_user']."'); ";	
		}
		
		if(!empty($_SESSION['phpos_install_data']['db_password']))
		{
			$jquery_start4.= "$('input[name=\"db_password\"]').val('".$_SESSION['phpos_install_data']['db_password']."'); ";	
		}
		
		if(!empty($_SESSION['phpos_install_data']['db_prefix']))
		{
			$jquery_start4.= "$('input[name=\"db_prefix\"]').val('".$_SESSION['phpos_install_data']['db_prefix']."'); ";	
		}		
		$jquery_start[4] = $jquery_start4;	
		
		// No forms
		$jquery_start[5] = '';
		$jquery_start[6] = '';
		$jquery_start[7] = '';
		
		return $jquery_start[$step];	
	}	
	
}
?>