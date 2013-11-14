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


class phpos_forms {

	private
		$form_data,
		$form_items,
		$form_required,
		$form_required_msg,
		$jquery_required,
		$jquery_reload,
		$focus,
		$onsuccess,
		$onerror,
		$noecho = false,
		$form_jquery;
		
			 
/*
**************************
*/
 	
	
	public function __construct()
	{
		$this->form_items = array();
		$this->form_data = array();
		$this->form_jquery = null;	
		$this->jquery_reload = array();
		$this->form_required = array();
		$this->form_required_msg = array();
		$this->jquery_required = null;
	}
	 
/*
**************************
*/
 	
	public function reset_required()
	{
		$this->form_required = array();
	}
		
/*
**************************
*/
 	
	public function noecho()
	{
		$this->noecho = true;
	}		
/*
**************************
*/

	public function focus($input_name)
	{
		$this->focus = $input_name;
	}		
	
		 
/*
**************************
*/ 		
 	
	public function condition($type, $param = null, $msg = null)
	{
		$this->form_required[$type] = $param;	
		$this->form_required_msg[$type] = $msg;
	}
		 
/*
**************************
*/
 	
	public function generate_conditions_code($item)
	{
		$conditions = array();
		$c = 0;
		
		if($this->form_required['not_null']) 
		{
			$cond_data['code'] = "$('#".$this->form_data['id']." input[name=\"".$item['input_name']."\"]').val() == '' || $('#".$this->form_data['id']." input[name=\"".$item['input_name']."\"]').val() == ' '";
			$cond_data['msg'] = $this->form_required_msg['not_null'];
			$condition[] = $cond_data;
			$c = 1;
		}
		
		if($this->form_required['match'] != null) 
		{
			$cond_data['code'] = "$('#".$this->form_data['id']." input[name=\"".$item['input_name']."\"]').val() != $('#".$this->form_data['id']." input[name=\"".$this->form_required['match']."\"]').val()";
			$cond_data['msg'] = $this->form_required_msg['match'];
			$condition[] = $cond_data;
			$c = 1;
		}
		
		
		if($this->form_required['min'] != null)
		{
			$cond_data['code'] = "$('#".$this->form_data['id']." input[name=\"".$item['input_name']."\"]').val().length < ".$this->form_required['min'];
			$cond_data['msg'] = $this->form_required_msg['min'];
			$condition[] = $cond_data;
			$c = 1;
		}
		
		if($this->form_required['max'] != null)
		{
			$cond_data['code'] = "$('#".$this->form_data['id']." input[name=\"".$item['input_name']."\"]').val().length > ".$this->form_required['max'];
			$cond_data['msg'] = $this->form_required_msg['max'];
			$condition[] = $cond_data;
			$c = 1;			
		}
		
		if($c)
		{
			$code = "var valid_error = 0; 
			";
			
			foreach($condition as $cond)
			{
				$code.="if(".$cond['code'].") { valid_error = 1; var errors = $('.form_error_message p').html(); $('.form_error_message p').html(errors + '<br />".$cond['msg']."'); } 
				";	
			}
			
			$code.=" if(valid_error == 1) {
				form_error = 1;	
				$('#".$this->form_data['id']." input[name=\"".$item['input_name']."\"]').addClass('phpos_form_input_error');
				$('.form_error_message').removeClass('phpos_form_input_field_error_hidden').addClass('phpos_form_input_field_error'); 	
				} else {
				$('#".$this->form_data['id']." input[name=\"".$item['input_name']."\"]').removeClass('phpos_form_input_error');		
			} 
			";
			
			$this->jquery_required.=$code;			
		}	
	}
		
		 
/*
**************************
*/
 	
	
	public function required($min = null, $max = null, $type = null)
	{
		$this->form_required['required'] = true;
		$this->form_required['check_min'] = $min;
		$this->form_required['check_max'] = $max;
	}
	
		 
/*
**************************
*/
 	
	public function input($type = 'text', $name, $title, $tip = null,  $value = null, $styles = '')
	{
		$item = array();
		$item['type'] = $type;
		$item['title'] = $title;
		$item['tip'] = $tip;
		$item['input_name'] = $name;		
		$item['input_value'] = $value;		
		$item['styles'] = $styles;	
		
		if($this->form_required['required'] == true)
		{		
			
			$this->jquery_required.= "
				if($('#".$this->form_data['id']." input[name=\"".$item['input_name']."\"]').val() == '' || $('#".$this->form_data['id']." input[name=\"".$item['input_name']."\"]').val() == ' ') {	
					
					form_error = 1;	
					$('#".$this->form_data['id']." input[name=\"".$item['input_name']."\"]').addClass('phpos_form_input_error');
					$('.form_error_message').removeClass('phpos_form_input_field_error_hidden').addClass('phpos_form_input_field_error'); 	
				} else {
					$('#".$this->form_data['id']." input[name=\"".$item['input_name']."\"]').removeClass('phpos_form_input_error');
									
				}
			";
			
			$item['required'] = true;		
		}
		$this->generate_conditions_code($item);
		$this->form_items[] = $item;	
		
		$this->reset_required();
	}
	
		 
/*
**************************
*/
 	
	public function textarea($name, $title, $tip = null,  $value = null)
	{
		$item = array();
		$item['type'] = 'textarea';
		$item['title'] = $title;
		$item['tip'] = $tip;
		$item['input_name'] = $name;		
		$item['input_value'] = $value;		
		
		if($this->form_required['required'] == true)
		{			
			$this->jquery_required.= "
				if($('#".$this->form_data['id']." textarea[name=\"".$item['input_name']."\"]').val() == '' || $('#".$this->form_data['id']." textarea[name=\"".$item['input_name']."\"]').val() == ' ') {	
					
					form_error = 1;	
					$('#".$this->form_data['id']." textarea[name=\"".$item['input_name']."\"]').addClass('phpos_form_input_error');
					$('.form_error_message').removeClass('phpos_form_input_field_error_hidden').addClass('phpos_form_input_field_error'); 	
				} else {
					$('#".$this->form_data['id']." textarea[name=\"".$item['input_name']."\"]').removeClass('phpos_form_input_error');
									
				}
			";
			
			$item['required'] = true;		
		}
		
		$this->form_items[] = $item;	
		
		$this->reset_required();
	}
			 
/*
**************************
*/
 	
	public function texteditor($name, $title, $tip = null,  $value = null)
	{
		$item = array();
		$item['type'] = 'texteditor';
		$item['title'] = $title;
		$item['tip'] = $tip;
		$item['input_name'] = $name;		
		$item['input_value'] = $value;		
		
		if($this->form_required['required'] == true)
		{			
			$this->jquery_required.= "
				if($('#".$this->form_data['id']." textarea[name=\"".$item['input_name']."\"]').val() == '' || $('#".$this->form_data['id']." textarea[name=\"".$item['input_name']."\"]').val() == ' ') {	
					
					form_error = 1;	
					$('#".$this->form_data['id']." textarea[name=\"".$item['input_name']."\"]').addClass('phpos_form_input_error');
					$('.form_error_message').removeClass('phpos_form_input_field_error_hidden').addClass('phpos_form_input_field_error'); 	
				} else {
					$('#".$this->form_data['id']." textarea[name=\"".$item['input_name']."\"]').removeClass('phpos_form_input_error');
									
				}
			";
			
			$item['required'] = true;		
		}
		
		$this->form_items[] = $item;	
		
		$this->reset_required();
	}
		 
/*
**************************
*/
 	
	public function select($name, $title, $tip = null, $items = null,  $selected = null)
	{
		$item = array();
		$item['type'] = 'select';
		$item['title'] = $title;
		$item['tip'] = $tip;
		$item['select_name'] = $name;		
		$item['selected'] = $selected;	
		$item['items'] = $items;		
		
		if($this->form_required['required'] == true)
		{			
			$this->jquery_required.= "
				if($('#".$this->form_data['id']." input[name=\"".$item['input_name']."\"]').val() == '' || $('#".$this->form_data['id']." input[name=\"".$item['input_name']."\"]').val() == ' ') {	
					
					form_error = 1;	
					$('#".$this->form_data['id']." input[name=\"".$item['input_name']."\"]').addClass('phpos_form_input_error');
					$('.form_error_message').removeClass('phpos_form_input_field_error_hidden').addClass('phpos_form_input_field_error'); 	
				} else {
					$('#".$this->form_data['id']." input[name=\"".$item['input_name']."\"]').removeClass('phpos_form_input_error');
									
				}
			";
			
			$item['required'] = true;		
		}
		
		$this->form_items[] = $item;	
		
		$this->reset_required();
	}
	
		 
/*
**************************
*/
 	
	public function title($title, $tip = null, $icon = null)
	{
		$item = array();
		$item['type'] = 'title';
		$item['title'] = $title;
		$item['tip'] = $tip;		
		$item['icon'] = $icon;
		$this->form_items[] = $item;			
		$this->reset_required();
	}
		 
/*
**************************
*/
 	
	
	public function render_title($title, $tip, $icon)
	{			
		if(!empty($icon)) $img = '<img src="'.$icon.'" style="height:30px;display:inline-block; vertical-align:middle; padding-right:5px" />';
		
		$str ='
		<div class="form_area_row_header input_row_mouseleave" style="margin-bottom:10px">'.$img.$title.'</div>';			
		$str.= $this->render_header_tip($tip);	
		return $str;	
	}
	
		 
/*
**************************
*/
 	
	
	public function render_select($name, $txt, $tip = null, $items = null,  $selected = null, $style = null)
	{			
		if(is_array($items))
		{
			foreach($items as $key => $value)
			{
				$s = '';
				if($key == $selected) $s = ' selected';
				$options.='<option value="'.$key.'"'.$s.'>'.$value.'</option>';			
			}	
		}	
		
		if(!empty($tip)) $tip_class =  ' easyui-tooltip" title="'.$tip.'"';
		$str ='
		<div class="form_area_row input_row_mouseleave'.$tip_class.'">
				<div class="form_area_left">'.$txt.'</div>
				<div class="form_area_right"><select title="'.$txt.'" name="'.$name.'" value="'.$default_value.'" class="select">'.$options.'</select></div>';				
				
		$str.= $this->render_tip($tip);			
		
		$str.= '
		</div>';		
		return $str;	
	}
	
		 
/*
**************************
*/
 	
	
	public function radio($name, $title, $tip = null, $items = null,  $checked = null)
	{
		$item = array();
		$item['type'] = 'radio';
		$item['title'] = $title;
		$item['tip'] = $tip;
		$item['select_name'] = $name;		
		$item['checked'] = $checked;	
		$item['items'] = $items;		
		
		if($this->form_required['required'] == true)
		{			
			$this->jquery_required.= "
				if($('#".$this->form_data['id']." input[name=\"".$item['input_name']."\"]').val() == '' || $('#".$this->form_data['id']." input[name=\"".$item['input_name']."\"]').val() == ' ') {	
					
					form_error = 1;	
					$('#".$this->form_data['id']." input[name=\"".$item['input_name']."\"]').addClass('phpos_form_input_error');
					$('.form_error_message').removeClass('phpos_form_input_field_error_hidden').addClass('phpos_form_input_field_error'); 	
				} else {
					$('#".$this->form_data['id']." input[name=\"".$item['input_name']."\"]').removeClass('phpos_form_input_error');
									
				}
			";
			
			$item['required'] = true;		
		}
		
		$this->form_items[] = $item;	
		
		$this->reset_required();
	}
	
		 
/*
**************************
*/
 		
	public function render_radio($name, $txt, $tip = null, $items = null,  $checked = null)
	{			
		if(is_array($items))
		{
			foreach($items as $key => $value)
			{
				$s = '';
				if($key == $checked) $s = ' checked';
				$radios.='<input type="radio" name="'.$name.'" value="'.$key.'"'.$s.'>'.$value;			
			}	
		}	
		
		if(!empty($tip)) $tip_class =  ' easyui-tooltip" title="'.$tip.'"';
		$str ='
		<div class="form_area_row input_row_mouseleave'.$tip_class.'">
				<div class="form_area_left">'.$txt.'</div>
				<div class="form_area_right">'.$radios.'</div>';				
				
		$str.= $this->render_tip($tip);			
		
		$str.= '
		</div>';		
		return $str;	
	}
		 
/*
**************************
*/
 	
	public function render_checkbox($name, $txt, $tip = null, $items = null,  $checked = null)
	{			
		if(is_array($items))
		{
			foreach($items as $key => $value)
			{
				$s = '';
				if($key == $checked) $s = ' checked="checked"';
				$checkbox.='<input type="checkbox" name="'.$name.'" value="'.$key.'"'.$s.' style="vertical-align:middle">'.$value;			
			}	
		}	
		
		if(!empty($tip)) $tip_class =  ' easyui-tooltip" title="'.$tip.'"';
		$str ='
		<div class="form_area_row input_row_mouseleave'.$tip_class.'">
				<div class="form_area_left">'.$txt.'</div>
				<div class="form_area_right">'.$checkbox.'</div>';				
				
		$str.= $this->render_tip($tip);			
		
		$str.= '
		</div>';		
		return $str;	
	}
		 
/*
**************************
*/
 	
	public function checkbox($name, $title, $tip = null, $items = null,  $checked = null)
	{
		$item = array();
		$item['type'] = 'checkbox';
		$item['title'] = $title;
		$item['tip'] = $tip;
		$item['checkbox_name'] = $name;		
		$item['checked'] = $checked;	
		$item['items'] = $items;		
		
		if($this->form_required['required'] == true)
		{			
			$this->jquery_required.= "
				if($('#".$this->form_data['id']." input[name=\"".$item['input_name']."\"]').val() == '' || $('#".$this->form_data['id']." input[name=\"".$item['input_name']."\"]').val() == ' ') {	
					
					form_error = 1;	
					$('#".$this->form_data['id']." input[name=\"".$item['input_name']."\"]').addClass('phpos_form_input_error');
					$('.form_error_message').removeClass('phpos_form_input_field_error_hidden').addClass('phpos_form_input_field_error'); 	
				} else {
					$('#".$this->form_data['id']." input[name=\"".$item['input_name']."\"]').removeClass('phpos_form_input_error');
									
				}
			";
			
			$item['required'] = true;		
		}
		
		$this->form_items[] = $item;	
		
		$this->reset_required();
	}
		
		 
/*
**************************
*/
 	
	
	public function render_tip($tip = null)
	{
		if($tip == null)
		{
			$str= '<div style="clear:both"></div>';
		} else {
			$str= '<div style="clear:both" class="phpos_layout_txtdesc">'.$tip.'</div>';
		}
		//$str= '<div style="clear:both"></div>';
		return $str;
	}
		 
/*
**************************
*/
 	
	public function render_header_tip($tip = null)
	{
		if($tip == null)
		{
			$str= '<div style="clear:both"></div>';
			
		} else {
		
			$str= '<div style="clear:both" class="form_area_tip"><img src="'.PHPOS_WEBROOT_URL.'_phpos/themes/default/menuicons/icons/tip.png" style="display:inline-block; vertical-align:middle" />'.$tip.'</div>';
		}
		
		return $str;
	}
	
		 
/*
**************************
*/
 	
	public function render_input($name, $txt, $tip = null,  $default_value = '', $type = 'text', $styles = null)
	{		
		if(!empty($tip)) $tip_class =  ' easyui-tooltip" title="'.$tip.'"';
		$class = 'input ';
		if(!empty($styles)) $class = '';
		$str ='
		<div class="form_area_row input_row_mouseleave'.$tip_class.'">
				<div class="form_area_left">'.$txt.'</div>
				<div class="form_area_right"><input title="'.$txt.'" name="'.$name.'" value="'.$default_value.'" class="'.$class.'input_mouseleave" type="'.$type.'" /></div>';				
				
		$str.= $this->render_tip($tip);			
		
		$str.= '
		</div>';		
		return $str;	
	}
		 
/*
**************************
*/
 	
	public function render_textarea($name, $txt, $tip = null,  $default_value = '')
	{		
		if(!empty($tip)) $tip_class =  ' easyui-tooltip" title="'.$tip.'"';
		$str ='
		<div class="form_area_row input_row_mouseleave'.$tip_class.'">
				<div class="form_area_left">'.$txt.'</div>
				<div class="form_area_right"><textarea title="'.$txt.'" name="'.$name.'" class="input input_mouseleave" style="height:200px">'.$default_value.'</textarea></div>';				
				
		$str.= $this->render_tip($tip);			
		
		$str.= '
		</div>';		
		return $str;	
	}
			 
/*
**************************
*/
 	
	public function render_texteditor($name, $txt, $tip = null,  $default_value = '')
	{		
		if(!empty($tip)) $tip_class =  ' easyui-tooltip" title="'.$tip.'"';
		$str ='
		
		
			<textarea id="editor_'.WIN_ID.'" title="'.$txt.'" name="'.$name.'" class="input input_mouseleave" style="height:400px; width:95%; background-color: white; padding:5px">'.$default_value.'</textarea>';				
				
		$str.= $this->render_tip($tip);			
		
		$str.= '
		';		
		return $str;	
	}
	
		 
/*
**************************
*/
 	
	
	public function render_label($txt, $tip = null,  $default_value = '')
	{			
		$str ='
		<div class="form_area_row input_row_mouseleave">
				<div class="form_area_left">'.$txt.'</div>
				<div class="form_area_right">'.$default_value.'</div>';				
				
		$str.= $this->render_tip($tip);			
		
		$str.= '
		</div>';		
		return $str;	
	}
		 
/*
**************************
*/
 	
	public function render_status()
	{
		$str.= '<div class="form_error_message phpos_form_input_field_error_hidden"><img src="'.PHPOS_WEBROOT_URL.'_phpos/installer/status_error.png" /><p>Incorrect data. Please correct informations in form.</p></div>';		
		return $str;	
	}
		 
/*
**************************
*/
 	
	
	public function render($method = 'post')
	{
		if(is_array($this->form_items))
		{
			$c = count($this->form_items);		
			
			for($i=0; $i < $c; $i++)
			{
				switch($this->form_items[$i]['type'])
				{
					case 'text':
						$str.= $this->render_input($this->form_items[$i]['input_name'], $this->form_items[$i]['title'], $this->form_items[$i]['tip'], $this->form_items[$i]['input_value'], $this->form_items[$i]['styles']);
					break;	
					
					case 'textarea':
						$str.= $this->render_textarea($this->form_items[$i]['input_name'], $this->form_items[$i]['title'], $this->form_items[$i]['tip'], $this->form_items[$i]['input_value']);
					break;
					
					case 'texteditor':
						$str.= $this->render_texteditor($this->form_items[$i]['input_name'], $this->form_items[$i]['title'], $this->form_items[$i]['tip'], $this->form_items[$i]['input_value']);
					break;
					
					case 'password':
						$str.= $this->render_input($this->form_items[$i]['input_name'], $this->form_items[$i]['title'], $this->form_items[$i]['tip'], $this->form_items[$i]['input_value'], 'password', $this->form_items[$i]['style']);
					break;	
					
					case 'file':
						$str.= $this->render_input($this->form_items[$i]['input_name'], $this->form_items[$i]['title'], $this->form_items[$i]['tip'], $this->form_items[$i]['input_value'], 'file', $this->form_items[$i]['style']);
					break;
					
					case 'select':					
						$str.= $this->render_select($this->form_items[$i]['select_name'], $this->form_items[$i]['title'], $this->form_items[$i]['tip'], $this->form_items[$i]['items'], $this->form_items[$i]['selected'], $this->form_items[$i]['style']);
					break;	
					
					case 'radio':					
						$str.= $this->render_radio($this->form_items[$i]['select_name'], $this->form_items[$i]['title'], $this->form_items[$i]['tip'], $this->form_items[$i]['items'], $this->form_items[$i]['checked']);
					break;	
					
					case 'checkbox':					
						$str.= $this->render_checkbox($this->form_items[$i]['checkbox_name'], $this->form_items[$i]['title'], $this->form_items[$i]['tip'], $this->form_items[$i]['items'], $this->form_items[$i]['checked']);
					break;	
					
					case 'label':
						$str.= $this->render_label($this->form_items[$i]['title'], $this->form_items[$i]['tip'], $this->form_items[$i]['input_value']);
					break;			
					
					case 'title':
						$str.= $this->render_title($this->form_items[$i]['title'], $this->form_items[$i]['tip'], $this->form_items[$i]['icon']);
					break;
					
					case 'hidden':
						$str.= $this->render_hidden($this->form_items[$i]['input_name'], $this->form_items[$i]['input_value']);
					break;
					
					case 'status':
						$str.= $this->render_status();
					break;
					
					case 'button':
						$str.= $this->render_button($this->form_items[$i]['input_value'], $this->form_items[$i]['action'], $this->form_items[$i]['icon']);
					break;
					
					case 'submit':
						$str.= $this->render_submit('', $this->form_items[$i]['input_value'], $this->form_items[$i]['icon'], $this->form_items[$i]['align']);
					break;
					
					case 'submit_btn':
						$str.= $this->render_submit_btn('', $this->form_items[$i]['input_value'], $this->form_items[$i]['icon'], $this->form_items[$i]['align']);
					break;
				}			
			}			
		
		$this->form_items = array();
		return $str;
		}	
	}
		 
/*
**************************
*/
 	
	public function form_start($id, $action = null, $params) 
	{		
		$this->form_data['id'] = $id;
		$this->form_data['params'] = $params;		
		$this->form_data['action'] = helper_post('', $params);		
		if(!empty($action)) $this->form_data['action'] = $action;	
		$str= '<form method="POST" action="'.$this->form_data['action'].'" id="'.$this->form_data['id'].'" enctype="multipart/form-data">
			<input type="hidden" name="phpos_keep_result" value="1" />';
			
		return $str;		
	}
		 
/*
**************************
*/
 	
	public function form_end() 
	{
		$this->jquery();
		$str = '<input type="hidden" name="phpos_form_'.$this->form_data['id'].'" value="1" />
		</form>';
		
		//echo 'phpos_form_'.$this->form_data['id'];
		return $str;
	}
		 
/*
**************************
*/
 	
	
	public function render_hidden($name, $value)
	{
		$str = '<input type="hidden" name="'.$name.'" value="'.$value.'" />';
		return $str;
	}
	 
/*
**************************
*/
 	
	public function form_button($type, $value, $icon = 'edit_add')
	{
		$str.='<a style="margin-top:10px" id="btn" href="#" class="easyui-linkbutton" data-options="iconCls:\'icon-'.$icon.'\'">'.$value.'</a>';
		
		return $str;
	}
		 
/*
**************************
*/
 	
	public function button($value, $action = "alert('button');", $icon = 'edit_add')
	{
		$item = array();
		$item['type'] = 'button';		
		$item['action'] = $action;	
		$item['icon'] = $icon;			
		$item['input_value'] = $value;		
		$this->form_items[] = $item;	
		
		$this->reset_required();
	}
		 
/*
**************************
*/
 	
	public function status()
	{
		$item = array();
		$item['type'] = 'status';	
		$this->form_items[] = $item;	
		
		$this->reset_required();
	}
		 
/*
**************************
*/
 	
	public function submit($type = null, $value, $icon = 'edit_add', $align = null)
	{
		$item = array();
		$item['type'] = 'submit';		
		$item['icon'] = $icon;	
		$item['align'] = $align;			
		$item['input_value'] = $value;		
		$this->form_items[] = $item;		
		
		$this->reset_required();
	}
		 
		 /*
**************************
*/
 	
	public function submit_btn($value = null, $icon = 'edit_add', $align = null)
	{
		$item = array();
		$item['type'] = 'submit_btn';		
		$item['icon'] = $icon;	
		$item['align'] = $align;			
		$item['input_value'] = $value;		
		$this->form_items[] = $item;		
		
		$this->reset_required();
	}
/*
**************************
*/
 	
	public function label($title, $value, $icon = 'edit_add')
	{
		$item = array();
		$item['type'] = 'label';		
		$item['icon'] = $icon;		
		$item['title'] = $title;	
		$item['input_value'] = $value;		
		$this->form_items[] = $item;		
		
		$this->reset_required();
	}
	 
/*
**************************
*/
 	
	public function render_button($value, $action, $icon)
	{
		$str.='<a style="margin-top:10px" id="btn" href="javascript:void(0);" onclick="'.$action.'" class="easyui-linkbutton" data-options="iconCls:\'icon-'.$icon.'\'">'.$value.'</a>';		
		return $str;	
	}
		 
/*
**************************
*/
 	
	public function render_submit($type = null, $value, $icon, $align = null)
	{
		if(!empty($align)) $str.='<div style="width:90%;text-align:'.$align.'">';
		$str.='<a style="margin-top:10px" id="phpos_form_submit'.$this->form_data['id'].'" href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:\'icon-'.$icon.'\'">'.$value.'</a>';	
		if(!empty($align)) $str.='</div>';
		$this->form_jquery.= "
		$('#phpos_form_submit".$this->form_data['id']."').click(function() {			
			$('#".$this->form_data['id']."').submit();
		});
		
		$('#".$this->form_data['id']." input').click(function() {			
			$(this).removeClass('phpos_form_input_error');				
		});
		
		";
		return $str;	
	}

		 
/*
**************************
*/
 	
	public function render_submit_btn($type = null, $value, $icon, $align = null)
	{		
		global $layout;
		$str.= $layout->next_button($value, null, null, null, $this->form_data['id']);		
		
		$this->form_jquery.= "
		$('#phpos_form_submit_btn_".$this->form_data['id']."').click(function() {
			//alert('".htmlspecialchars($this->form_data['action'])."');
			$('#".$this->form_data['id']."').submit();
		});
		
		$('#".$this->form_data['id']." input').click(function() {			
			$(this).removeClass('phpos_form_input_error');				
		});
		
		";
		return $str;	
	}
		 
/*
**************************
*/
 	
	public function reload_after_submit($panels)
	{
		if(is_array($panels))
		{
			$c = count($panels);
			
			for($i=0; $i < $c; $i++)
			{
				$this->jquery_reload[] = $panels[$i];			
			}		
		}
	}
		 
/*
**************************
*/
 	
	
	private function render_jquery_reload()
	{
		$c = count($this->jquery_reload);
		$a = array();
		for($i=0; $i<$c; $i++)
		{
			//$a[] = "$('#".$this->jquery_reload[$i]."').panel('refresh');";	
			//$a[] = "$('#".$this->jquery_reload[$i]."').panel('refresh');";	
			//$a[] = "alert('".$i."');";	
		//$a[] = "phpos.windowRefresh('".$this->jquery_reload[$i]."','action_id:0');";					
			$a[] = "$('#".$this->jquery_reload[$i]."').panel('refresh');";
		}
		
		$j = implode(", ", $a);
		if(!empty($j))
		{
			$j.="; ";
		}
		return $j;
	}
	
		 
/*
**************************
*/
 	
	public function jquery_helper()
	{
		$str = "
		$('.input').mouseleave(function() {
		if(!$(this).is(':focus'))
		{
			$(this).removeClass('input_mouseclick').removeClass('input_mouseenter').addClass('input_mouseleave');	
		}
	});
	
	$('.input').click(function() {
		$('.input').not(this).removeClass('input_mouseclick').removeClass('input_mouseenter').addClass('input_mouseleave');	
		$(this).removeClass('input_error').removeClass('input_mouseenter').addClass('input_mouseclick');	
	});
	
	$('.input').focusin(function() {
		$('.input').not(this).removeClass('input_mouseclick').removeClass('input_mouseenter').addClass('input_mouseleave');	
		$(this).removeClass('input_error').removeClass('input_mouseenter').addClass('input_mouseclick');	
	});	
	
	
	// click on window
	
	$('*').click(function() {
		if(!$('.input').is(':focus'))
		{
			$('.input').removeClass('input_mouseclick').removeClass('input_mouseenter').addClass('input_mouseleave');	
		}		
	});	
			
	// form row
	$('.form_area_row').mouseover(function() {		
			$(this).removeClass('input_row_mouseleave').addClass('input_row_mouseenter');	
	});	
	
	$('.form_area_row').mouseleave(function() {		
			$(this).removeClass('input_row_mouseenter').addClass('input_row_mouseleave');			
	});	
	";
	
	return $str;	
	}
	
/*
**************************
*/

	public function onsuccess($js_code)
	{
		$this->onsuccess = $js_code;
	}
		 
/*
**************************
*/
 	
	public function jquery()
	{
		$onsuccess = '';
		if(!empty($this->onsuccess)) 
		{
			$onsuccess = ' '.
			$this->onsuccess
			.'';
		}
		
		
		$this->form_jquery.= "
		$('#".$this->form_data['id']."').form({  					
				onSubmit: function(){
				
				";
				
		if(!empty($this->jquery_required))
		{
			$this->form_jquery.="
			var form_error = 0;
			$('.form_error_message p').html('');
			";
			
			$this->form_jquery.= $this->jquery_required;
			$this->form_jquery.="
			if(form_error == 1)
			{
				//alert('wymagane');
				return false;
			}
			";		
		
		}		
		
				
		$this->form_jquery.= "		
				
		},  
		success:function(data){					
				//".helper_reload()."
				".$onsuccess."
				".$this->render_jquery_reload()."				
					return false; 				
		}				
		});
		";	
		
		$this->form_jquery.= $this->jquery_helper();
		
		global $my_app;		
		$my_app->jquery_onready($this->form_jquery);
		
		//return $this->form_jquery;
	}

}
?>