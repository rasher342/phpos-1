<?php
/*
**********************************

	PHPOS Web Operating system
	MIT License
	(c) 2013 Marcin Szczyglinski
	szczyglis83@gmail.com
	GitHUB: https://github.com/phpos/
	File version: 1.0.1, 2013.10.11
 
**********************************
*/
if(!defined('PHPOS'))	die();	


if(PHPOS_HAVE_ACCESS != $my_app->get_app_id() or !defined('PHPOS'))
{
	die();
}
	
	savelog('CP#USERS ACCESS');

	$my_app->set_param('delete_id', '');
	$my_app->set_param('toolbar_checked', 'new_user');	
	$my_app->set_param('section', 'account');
	$my_app->set_param('action', null);
	
	if(APP_ACTION == 'users_admin') $my_app->set_param('section', 'new_user');	
	
	$my_app->set_param('user_id', null);
	$my_app->set_param('wallpaper_id', null);
	$my_app->set_param('wallpaper_type', null);
	$my_app->set_param('selected_wallpaper_id', null);
	$my_app->set_param('selected_wallpaper_type', null);	
	
	$my_app->using('params');	
	$my_app->using('toolbar');		 
	winConfig('use_sections');	

	
	$my_app->jquery_onready(msg::showMessages());
	
	cache_param('user_id');
	
	$wallpaper_id = $my_app->get_param('wallpaper_id');
	if(empty($wallpaper_id)) $my_app->set_param('wallpaper_id', myconfig('wallpaper'));	
	cache_param('wallpaper_id');
	
	$wallpaper_type = $my_app->get_param('wallpaper_type');
	if(empty($wallpaper_type)) $my_app->set_param('wallpaper_type', 'global');	
	cache_param('wallpaper_type');

	$action = $my_app->get_param('action');	
	
	switch($action)
	{
		case 'delete':
		
			if(is_admin() || is_root())
			{
				$del_usr = new phpos_users;				
				$delete_id = $my_app->get_param('delete_id');
				$del_usr->set_id_user($delete_id);
				$del_usr->get_user_by_id();
				
				
				if($del_usr->delete_user())
				{
					helper_result('delete_user', 'ok', txt('deleted'));
					$my_app->set_param('action', null);
					cache_param('action');
					savelog('CP#DELETE_USER:SUCCESS');
				}
			}
			
		break;
	}
		
	
	
if(is_admin() || is_root())
{
	if(form_submit('new_user'))
	{
		if($_POST['user_action'] == 'new_user')
		{
			$tmp_login = strip_tags($_POST['user_new_login']);
			$tmp_pass1 = strip_tags($_POST['user_new_pass']);
			$tmp_pass2 = strip_tags($_POST['user_new_pass2']);
			$tmp_type = strip_tags($_POST['user_new_type']);
			$tmp_active = intval(strip_tags($_POST['user_new_active']));
			$tmp_lang = strip_tags($_POST['user_new_lang']);	
			$tmp_home = strip_tags($_POST['user_new_homedir']);
			
			if($tmp_pass1 != $tmp_pass2)
			{
				helper_result('new_user_result', 'result', 'error');
				helper_result('new_user', 'error', txt('pass_not_match'));
				
			}	else {
			
				$new_usr = new phpos_users;	
				$new_usr->set_user_login($tmp_login);
				
				if(!$new_usr->user_login_exists($tmp_login))
				{
					$new_usr->set_raw_pass($tmp_pass1);	
					$new_usr->set_user_type($tmp_type);	
					$new_usr->set_is_active($tmp_active);			
						
					if($tmp_home != 1)	$new_usr->set_nohome();			
					
					if($new_usr->new_user())
					{			
						$new_id = $new_usr->get_new_user_id();
						
						$new_cfg = new phpos_config('no_get');
						$new_cfg->set_id_user($new_id);
						$new_cfg->update_user('lang', $tmp_lang);
						$new_cfg->update_user('wallpaper', globalconfig('wallpaper'));
						$new_cfg->update_user('wallpaper_type', 'global');
						
						helper_result('new_user', 'ok', txt('created'));		
						helper_result('new_user_result', 'result', 'success');
						helper_result('new_user_id', 'var', $new_id);	
						
						savelog('CP#NEW_USER:SUCCESS');
						
					}	else {
						helper_result('new_user_result', 'result', 'error');
						helper_result('new_user', 'error', txt('error'));
						
						savelog('CP#NEW_USER:ERROR');
					}			
					
				} else {
					helper_result('new_user_result', 'result', 'error');
					helper_result('new_user', 'error', $tmp_login.': '.txt('login_exists'));
				}	
			}
			
			$_POST['user_action'] = null;
		}
	}
}


// update
if(form_submit('update_user'))
{
	if($_POST['action'] == 'update_user')
	{		
		$user_id = $my_app->get_param('user_id');
		
		$tmp_pass1 = strip_tags($_POST['user_new_pass']);
		$tmp_pass2 = strip_tags($_POST['user_new_pass2']);
		
		$tmp_type = strip_tags($_POST['user_new_type']);
		$tmp_email = strip_tags($_POST['user_new_email']);
		$tmp_active = intval(strip_tags($_POST['user_new_active']));
		$tmp_lang = strip_tags($_POST['user_new_lang']);		
		$tmp_home = strip_tags($_POST['user_new_homedir']);
		
		if($tmp_pass1 != $tmp_pass2)
		{
			helper_result('update_user_result', 'result', 'error');
			helper_result('update_user', 'error', txt('pass_not_match'));
			
		}	else {			
				
				//pass
				if(!empty($tmp_pass1) && (strlen($tmp_pass1) < 6 || strlen($tmp_pass1) > 30))
				{
					helper_result('update_user_result', 'result', 'error');
					helper_result('update_user', 'error', txt('pass_length'));					
					
				} else {			
				
						$new_usr = new phpos_users;	
						$new_usr->set_id_user($user_id);	
						$new_usr->get_user_by_id();	
						
						if(!empty($tmp_pass1))
						{
							$new_usr->set_raw_pass($tmp_pass1);
							$new_pass = $new_usr->generate_password();
							$new_usr->set_user_pass($new_pass);					
						}		
										
						$new_usr->set_user_type($tmp_type);	
						$new_usr->set_user_email($tmp_email);
						$new_usr->set_is_active($tmp_active);							
					
						
						if($new_usr->update())
						{							
							$new_cfg = new phpos_config('no_get');
							$new_cfg->set_id_user($user_id);
							$new_cfg->update_user('lang', $tmp_lang);						
							
							helper_result('update_user', 'ok', txt('updated'));		
							helper_result('update_user_result', 'result', 'success');				
							helper_result('update_user_result', 'result', 'error');
							
							savelog('CP#UPDATE_USER:SUCCESS');
							
						}	else {
						
							helper_result('update_user_result', 'result', 'error');
							helper_result('update_user', 'error', txt('error'));
							savelog('CP#UPDATE_USER:ERROR');
						}				
				
				}
			
		}
		
		$_POST['action'] = null;
	}
}



if(globalconfig('demo_mode') != 1 || is_root())
{
	if(form_submit('my_update'))
	{
		if($_POST['action'] == 'my_update')
		{		
			$user_id = logged_id();
			
			$tmp_old_pass = strip_tags($_POST['user_old_pass']);
			$tmp_pass1 = strip_tags($_POST['user_new_pass']);
			$tmp_pass2 = strip_tags($_POST['user_new_pass2']);	
			
			$tmp_email = strip_tags($_POST['user_new_email']);	
			$tmp_lang = strip_tags($_POST['user_new_lang']);			
			
			if($tmp_pass1 != $tmp_pass2)
			{
				helper_result('my_update_user_result', 'result', 'error');
				helper_result('my_update_user', 'error', txt('pass_not_match'));
				savelog('CP#UPDATE_USER_PASS:ERROR');
				
				
			}	else {			
					
					//pass
					if(!empty($tmp_pass1) && (strlen($tmp_pass1) < 6 || strlen($tmp_pass1) > 30))
					{
						helper_result('my_update_user_result', 'result', 'error');
						helper_result('my_update_user', 'error', txt('pass_length'));		
						savelog('CP#UPDATE_USER_PASS:ERROR');
						
					} else {			
					
							$new_usr = new phpos_users;	
							$new_usr->set_id_user($user_id);	
							$new_usr->get_user_by_id();	
							
							$error = 0;
							if(!empty($tmp_pass1))
							{
								// check old pass
								
								if(!empty($tmp_old_pass))
								{								
									// check pass									
									$pass_now_hash = $new_usr->get_user_pass();
									
									//check new							
									$new_usr->set_raw_pass($tmp_old_pass);
									$old_pass_hash = $new_usr->generate_password();
									
									if($pass_now_hash == $old_pass_hash)
									{							
										$new_usr->set_raw_pass($tmp_pass1);
										$new_pass = $new_usr->generate_password();							
										$new_usr->set_user_pass($new_pass);	
										
									} else {
									
										$error = 1;
										helper_result('my_update_user_result', 'result', 'error');
										helper_result('my_update_user', 'error', txt('pass_old_wrong'));
										savelog('CP#UPDATE_USER_PASS:ERROR');
									}
								
								} else {
								
									$error = 1;
									helper_result('my_update_user_result', 'result', 'error');
									helper_result('my_update_user', 'error', txt('pass_old_need'));		
									savelog('CP#UPDATE_USER_PASS:ERROR');
								
								}
									
							}	
											
						
							$new_usr->set_user_email($tmp_email);								
							
							if($error != 1)
							{
								if($new_usr->update())
								{									
									helper_result('my_update_user', 'ok', txt('updated'));		
									helper_result('my_update_user_result', 'result', 'success');				
									helper_result('my_update_user_result', 'result', 'error');
									savelog('CP#UPDATE_MY_USER:SUCCESS');
									
								}	else {
									helper_result('my_update_user_result', 'result', 'error');
									helper_result('my_update_user', 'error', txt('error'));
									savelog('CP#UPDATE_MY_USER:ERROR');
								}			
							}
					
					}
				
			}
			
			$_POST['action'] = null;
		}
	}
}

	$my_app->set_param('selected_wallpaper_id', myconfig('wallpaper'));
	cache_param('selected_wallpaper_id');
	
	$my_app->set_param('selected_wallpaper_type', myconfig('wallpaper_type'));
	cache_param('selected_wallpaper_type');
?>