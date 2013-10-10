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


$group_id = $my_app->get_param('group_id');

if(!empty($group_id))
{
		// get group
		$group = new phpos_groups;
		$group->set_id($group_id);
		$group->get_group();
	

		echo helper_result('update_group');
		echo $layout->title(txt('group_edit'), 'icon.png'); 

		$form = new phpos_forms;

		echo $form->form_start('update_group', helper_ajax('section.edit_group.php'), array('app_params' => ''));
		$form->reload_after_submit(array('nowy'));
		$form->input('hidden','action', '', '',  'update_group');


		echo $layout->column('50%');	

		$form->title(txt('group_edit'), null, ICONS.'accounts/toolbar_edit.png');


		$form->condition('not_null', true, txt('form_empty_field').txt('name'));
		$form->input('text','group_new_name', txt('name'), txt('dsc_cp_newgroup_name'),  $group->get_title());

		
		$form->input('text','group_new_desc', txt('desc'), txt('dsc_cp_newgroup_desc')            ,  $group->get_desc());


		echo $form->render();


		echo $layout->end('column');
		echo $layout->column('50%');	

		$form->title(txt('group_msg'), '', ICONS.'email.png');


		$form->textarea('group_new_msg', txt('group_msg'), txt('dsc_cp_newgroup_msg'),  $group->get_msg());
		$form->status();
			$delete_action = "
			$.messager.confirm('".txt('delete')."', '".txt('delete_confirm')."?', function(r){
			if (r){
				phpos.windowRefresh('".WIN_ID."', 'section:list,action:delete,delete_id:".$group->get_id()."');	
			}
			});	";
			
			
			$form->button(txt('delete'), $delete_action, 'cancel');
		$form->submit('', txt('btn_update'), 'edit_add');


		//$form->button('', 'button', 'edit_add');


		echo $form->render();

		echo $layout->end('column');
		echo $layout->clr();
		echo $form->form_end();

} else {
		
	winreload(WIN_ID, array('section' => 'list')); 
	
}
?>