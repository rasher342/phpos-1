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
$new_id = helper_result('new_ftp_id');
$cloud_type = $my_app->get_param('cloud_type');


if(empty($cloud_type))
{
	echo '<div class="layout_clouds_select">'.txt('cloud_select_new').'<br /><br /><img src="'.ICONS.'clouds/google_drive.png" onclick="'.link_action('index', 'cloud_type:google_drive').'"/></div>';
	
	$js = "
	$('.layout_clouds_select img').mouseenter(function()
	{
		$(this).addClass('layout_clouds_select_over');
	});
	
	$('.layout_clouds_select img').mouseleave(function()
	{
		$(this).removeClass('layout_clouds_select_over');
	});
	
	";
	
	
	
	$my_app->jquery_onready($js);
	
	
	
} else {

if(empty($new_id))
{
	$cloud = new phpos_clouds;			
	$cloud->set_cloud($cloud_type);			
			
			
echo helper_result('new_cloud');
echo $layout->title(txt('add_new_cloud'), null); 
echo $layout->txtdesc(txt('dsc_cloud_title'));
$form = new phpos_forms;

echo $form->form_start('new_cloud', helper_ajax('section.new_account.php'), array('app_params' => ''));
$form->reload_after_submit(array('nowy'));
$form->input('hidden','action', '', '',  'new_cloud');
$form->input('hidden','cloud_new_type', '', '',  $cloud_type);

echo $layout->column('50%');	

$form->title(txt('dsc_cloud_desc_new').': '.$cloud->get_cloud_name(), null, $cloud->get_cloud_icon());


$form->condition('not_null', true, txt('form_empty_field').txt('title'));
$form->input('text','cloud_new_title', txt('title'), txt('dsc_cloud_name'),  '');


$form->input('text','cloud_new_desc', txt('desc'), txt('dsc_cloud_desc'),  '');

if(is_root() || is_admin())
{
	$items = array('1' => txt('yes'), '0' => txt('no'));
	$form->radio('cloud_new_public', txt('public'), txt('dsc_cloud_public'),  $items, '0');
} else {
	$form->input('hidden','cloud_new_public', '', '',  0);
}
include MY_APP_DIR.'views/cloud_help_google.php';

echo $layout->end('column');
echo $layout->column('50%');	



switch($cloud_type)
{
	case 'google_drive':
	
		echo $layout->txtdesc(txt('dsc_cloud_google_info'));
	
		$form->title(txt('cloud_authentication'), '', ICONS.'auth_key.png');


		$form->condition('not_null', true, txt('form_empty_field').'ClientID');
		$form->input('text','cloud_new_login', 'Client ID', txt('dsc_cloud_login'),  '');

		$form->condition('not_null', true, txt('form_empty_field').'Secret');
		$form->input('password','cloud_new_pass', 'Client Secret', txt('dsc_cloud_pass'),  '');

		$form->input('text','cloud_new_url', 'Redirect URL', txt('dsc_cloud_port'),  $_SESSION['PHPOS_NETURL']);
	
	break;
}



$form->status();
$form->submit('', txt('btn_create'), 'edit_add', 'right');


//$form->button('', 'button', 'edit_add');




echo $form->render();

echo $layout->end('column');
echo $layout->clr();
echo $form->form_end();



} else {

	echo $layout->title('Adding new workgroup', 'icon.png'); 	
	
	echo $layout->column('50%');	
	
	echo helper_result('new_ftp');	
	
	echo '<script>'.winreload(WIN_ID, array('section' => 'list')).'</script>';
		//echo '<img src="'.MY_RESOURCES_URL.'user_added_img.png" style="width:100px;padding-left:50px"/>';
	
	echo $layout->end('column');	
	echo $layout->column('50%');
	

	
	echo $layout->end('column');	
	echo $layout->clr();
	
}






} // isset cloud type
?>