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


$msg_id = $my_app->get_param('msg_id');

if($msg_id === null)
{
	$msg = new phpos_messages;
	$c = $msg->count_sended();	

	echo $layout->subtitle(txt('messager_sended_title'), MY_RESOURCES_URL.'msg_sended.png');	
	echo $layout->txtdesc(txt('messager_sended_desc'));	
	
	echo $layout->tbl_start();
	echo $layout->head(array(
	'' => '5%',
	txt('messager_tbl_message') => '40%', 
	'<img style="display:inline-block; vertical-align:middle" src="'.MY_RESOURCES_URL.'time_icon.png" /> '.txt('messager_tbl_sended') => '15%',
	'<img style="display:inline-block; vertical-align:middle" src="'.MY_RESOURCES_URL.'time_icon.png" /> '.txt('messager_tbl_readed') => '15%',
	'<img style="display:inline-block; vertical-align:middle" src="'.MY_RESOURCES_URL.'user_icon.png" />'.txt('messager_tbl_to') => '15%', 
	txt('messager_tbl_actions') => '15%'));
	
	
	if($c != 0)
	{
		$records = $msg->get_sended();		
		foreach($records as $row)
		{
			$icon = MY_RESOURCES_URL.'readed_icon.png';
			
			$readed = date('Y.m.d H:i', $row['readed_at']);
			$title = $row['title'];
			if(!$msg->is_readed($row['id'])) 
			{
				$icon = MY_RESOURCES_URL.'unreaded_icon.png';
				$title = '<b>'.$row['title'].'</b>';
				$readed = txt('messager_tbl_not_yet');
			}
			
			$delete_action = "
			$.messager.confirm('".txt('delete')."', '".txt('delete_confirm')."?', function(r){
			if (r){
				".helper_reload(array('delete_sended_id' => $row['id']))."
			}
			});	";
			
			
			
			
			//helper_reload(array('delete_sended_id' => $row['id']));
			
			$u = new phpos_users;
			$u->set_id_user($row['id_user_to']);
			$u->get_user_by_id();	

				
			
			
			$row_items = array(
			'<img src="'.$icon.'" />',
			'<a href="javascript:void(0);" onclick="'.helper_reload(array('msg_id' => $row['id'])).'">'.$title.'</a>', 
			date('Y.m.d H:i', $row['sended_at']), 
			$readed,
			$u->get_user_login(), 
			$layout->button(txt('delete'), $delete_action, 'cancel'));			
		
			echo $layout->row($row_items, string_cut(strip_tags($row['msg'], '<br>'), 100));
		}
		
		
		
	}	else {
		
		echo $layout->empty_list();		
	}
	
	echo $layout->tbl_end();	
	
} else {
	
	include MY_APP_DIR.'views/view_message.php';

}
?>