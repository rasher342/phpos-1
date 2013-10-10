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


	$langs = new phpos_languages;
	
	if(defined('INSTALLER'))
	{
		$txt = array();
		
		if(empty($_SESSION['installer_lang']))
		{
			$installer_language = 'en';	
			$_SESSION['installer_lang'] = $installer_language;
			
		} else {
			
			$reqested_lang = 	$_SESSION['installer_lang'];
		}
		
		if(!empty($_GET['lang'])) 
		{ 
			$reqested_lang = filter::alfas($_GET['lang']);
		} elseif(!empty($_POST['lang'])) 
		{ 
			$reqested_lang = filter::alfas($_POST['lang']);
		}	
		
		$lang = new phpos_languages;	
		
		if(!empty($reqested_lang))
		{
			if($lang->lang_exists($reqested_lang))
			{
				$installer_language = $reqested_lang;		
				$_SESSION['installer_lang'] = $reqested_lang;	
			}
		}
		
		$lang->lang_load($installer_language);		
		$_SESSION['login_lang'] = $_SESSION['installer_lang'];
		
		
	} elseif(defined('LOGIN_SCREEN')) {
	
		$txt = array();
		
		$config = new phpos_config;
		$login_language = $config->get_global('lang');	
			
		if(empty($_SESSION['login_lang']))
		{		
			$_SESSION['login_lang'] = $login_language;
		}
		
		if(!empty($_GET['lang'])) 
		{ 
			$reqested_lang = filter::alfas($_GET['lang']);
			
		} elseif(!empty($_POST['lang'])) 
		{ 
			$reqested_lang = filter::alfas($_POST['lang']);
		}	
		
		$lang = new phpos_languages;	
		
		if(!empty($reqested_lang))
		{
			if($lang->lang_exists($reqested_lang))
			{
				$login_language = $reqested_lang;		
				$_SESSION['login_lang'] = $reqested_lang;	
			}
		}
		
		$lang->lang_load($login_language);		
	
	
	
	} else {	
		
		$usr = new phpos_users;
		$config = new phpos_config;
		
		if($usr->user_is_logged())
		{						
			$config->set_id_user($usr->get_logged_user());
		}
		
		$usr->get_logged_user();
		$access_level = $usr->get_access_level();		
		
		
		if(!empty($_GET['lang']))
		{	
				//$PHPOS_GLOBALCONFIG['lang'] = strtolower($_GET['lang']);
				//$PHPOS_USERCONFIG['lang'] = strtolower($_GET['lang']);
				
				$requested_lang = trim(filter::alfas(strtolower($_GET['lang'])));				
			
				if($langs->lang_exists($requested_lang))
				{						
					if($config->get_global('demo_mode') != 1 || $access_level == 3)
					{
						$config->update_user('lang', $requested_lang);	
						
					} else {
						
						$demo_lang = trim($requested_lang);
						$_SESSION['demo_lang'] = $demo_lang;						
					}					
				}
		}	
		
		
		$txt = array();
		
		if($config->get_global('demo_mode') != 1 || $access_level == 3)
		{
			$langs->lang_load($config->get_user('lang'));
			
		} else {
		
			$langs->lang_load($_SESSION['demo_lang']);
		}	
	}
	
	if(!empty($lang_date_format))
	{
		define('DATE_FORMAT', 	$lang_date_format);
		
	} else {
		
		define('DATE_FORMAT', 	'H:i:s d.m.Y');
	}
	
	$_SESSION['txt'] = $txt;
?>