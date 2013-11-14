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


	$layout->set_region('south');
	$layout->set_split('false');	
	$layout->set_fit('true');
	$layout->set_style('width:100%;height:100px;background-color:#eff5fb');

	echo $layout->custom();		

	
		$form = new phpos_forms;
		$form->onsuccess(winclose(WIN_ID));
		echo $form->form_start('explorer_api'.WIN_ID, helper_ajax(null), array('app_params' => 'api_dialog:1'));								
		
		$form->reload_after_submit(array(WIN_ID));
		
		echo $layout->column('60%');
		
		$form->condition('not_null', true, txt('name_empty'));					
		$form->input('text','explorer_save_as_filename', txt('explorer_api_file_name'), null,  null, 'width:800px');
		$form->submit('', txt('explorer_api_file_btn'));
		echo $form->render();			
		echo $form->form_end();		
		
	
		echo $layout->end('column');
		
		
		
		echo $layout->column('40%');
		$select_view['allowed'] = '';
		$select_view['all'] = '';
		$select_choosen = $my_app->get_param('view_files_types');
		$select_view[$select_choosen] = ' selected';
		echo '<div class="form_area_row input_row_mouseleave" style="border:0px;padding-top:5px">
		
		<select id="explorer_api_showfiles_'.WIN_ID.'" onchange="$(this).submit();" name="type"><option value="allowed"'.$select_view['allowed'].'>'.txt('explorer_api_window_view_allowed').'</option><option value="all"'.$select_view['all'].'>'.txt('explorer_api_window_view_all').'</option></select>
		</div>';
		
		
		echo $layout->end('column');
		echo $layout->clr();
		
		$js = "
		$('#explorer_api_showfiles_".WIN_ID."').change(function() {
			var w = $('#explorer_api_showfiles_".WIN_ID." option:selected').val();
			phpos.windowRefresh('".WIN_ID."','view_files_types:'+w);
			//alert(w);		
		});
		
		";
	$my_app->jquery_onready($js);	
	
	echo $layout->end('custom');
?>	