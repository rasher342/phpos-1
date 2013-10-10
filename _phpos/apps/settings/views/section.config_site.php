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


// if section access
$new_id = helper_result('new_config_id');
if(empty($new_id))
{

echo helper_result('config_update');
echo $layout->title(txt('cp_settings_section_site'), 'icon.png'); 
echo $layout->txtdesc(txt('cp_settings_section_site_desc'));
$form = new phpos_forms;

echo $form->form_start('config_site', helper_ajax('section.config_site.php'), array('app_params' => ''));
$form->reload_after_submit(array('nowy'));
$form->input('hidden','action', '', '',  'config_site');


echo $layout->column('50%');	

$form->title(txt('cp_settings_section_site_meta'), null, ICONS.'tags.png');


$form->condition('not_null', true, txt('form_empty_field').txt('title'));
$form->input('text','site_title', txt('title'), txt('dsc_ftp_name'),  globalconfig('site_title'));


$form->input('text','site_desc', txt('desc'), txt('dsc_ftp_desc'),  globalconfig('site_desc'));


echo $form->render();


echo $layout->end('column');
echo $layout->column('50%');	

$form->title(txt('cp_settings_section_site_language'), '', ICONS.'lang.png');

	$languages = new phpos_languages;
	$langs_array = $languages->get_lang_list();
	$lang_items = array();

	foreach($langs_array as $lang_id)
	{
		$lang_data =  $languages->get_lang_info($lang_id);	
		$lang_name = $lang_data['eng_name'].' ('.$lang_data['local_name'].')';
		$lang_items[$lang_id] = $lang_name;
	}

	$form->select('site_lang', txt('language'), txt('cp_settings_section_site_language_desc'),  $lang_items, globalconfig('lang'));

	
$form->title('Server root email', '', ICONS.'email.png');
$form->input('text','root_email', 'Email', txt('dsc_ftp_desc'),  globalconfig('root_email'));	
	
$form->status();
$form->submit('', txt('btn_update'), 'edit_add', 'right');


//$form->button('', 'button', 'edit_add');


echo $form->render();

echo $layout->end('column');
echo $layout->clr();
echo $form->form_end();



} else {

	echo $layout->title('Adding new workgroup', 'icon.png'); 	
	
	echo $layout->column('50%');	
	
	echo helper_result('new_ftp');	
	
	//echo '<script>'.winreload(WIN_ID, array('section' => 'list')).'</script>';
		//echo '<img src="'.MY_RESOURCES_URL.'user_added_img.png" style="width:100px;padding-left:50px"/>';
	
	echo $layout->end('column');	
	echo $layout->column('50%');
	

	
	echo $layout->end('column');	
	echo $layout->clr();
	



	
}
?>