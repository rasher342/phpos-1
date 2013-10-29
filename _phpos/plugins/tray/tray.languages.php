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


$tray['id'] = 'languages_switcher';
$tray['version'] = 1.0;
$tray['load_only_with_app'] = false;
$tray['app_id'] = null;
$tray['use_custom_icons'] = true;
$tray['use_lang'] = false;
$tray['title'] = txt('langs_tray_title');

$languages = new phpos_languages;
$langs_array = $languages->get_lang_list();

if(!defined('INSTALLER'))
{
	if(globalconfig('demo_mode') != 1 || is_root())
	{
		$config_lang = $config->get_user('lang');
		
	} else {
		
		if(!empty($_SESSION['demo_lang']))
		{
			$config_lang = $_SESSION['demo_lang'];
			
		} else {
			
			$config_lang = $config->get_user('lang');
		}	
	}
	
} else {
	$config_lang = $_SESSION['installer_lang'];
}

if(defined('LOGIN_SCREEN'))
{
	$config_lang = $_SESSION['login_lang'];
}

$selected_lang = strtolower($config_lang);

$tmp_context_menu = array();
$tmp_flags = array();
$context_menu_style=array();

$k = count($langs_array);

for($j = 0; $j < $k; $j++)
{
	$lang_data =  $languages->get_lang_info($langs_array[$j]);	
	$lang_name = $lang_data['eng_name'].' ('.$lang_data['local_name'].')';
	
	if($langs_array[$j] == $selected_lang)
	{
		$lang_name = '<b>'.$lang_data['eng_name'].' ('.$lang_data['local_name'].')</b>';
	}
	
	$step_url ='';
	if(defined('INSTALLER')) $step_url = '&step='.$step;
	
	$tmp_context_menu[] = 'lng'.$j.'::'.$lang_name.'::window.location="?lang='.$langs_array[$j].$step_url.'";::lang_'.$langs_array[$j];
	$tmp_flags[$langs_array[$j]] = $languages->get_lang_flag_image('30', $langs_array[$j]);
	
	if(!$in_login)
	{	
	$styles.='.context-menu-item.icon-lang_'.$langs_array[$j].' { background-image: url("'.$tmp_flags[$langs_array[$j]].'"); } ';	
	}
}

$tray['context_menu'] = $tmp_context_menu;



$url = $tmp_flags[$selected_lang];

$tray['icons'] = array($url);

echo '<style>'.$styles.'</style>';

?>