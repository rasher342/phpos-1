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



function form_input($name, $txt, $tip = null, $type = 'input', $default_value = '')
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

function form_title($name, $tip)
{			
	$str ='
	<div class="form_area_row_header input_row_mouseleave">
			'.$name.'</div>';
			
			if($tip == null)
			{
				$str.= '<div style="clear:both"></div>';
			} else {
				$str.= '<div style="clear:both" class="form_area_tip">'.$tip.'</div>';
			}
			
		
	return $str;	
}

function form_start_ajax($id, $params) 
{
	$str.= '<form method="post" action="'.helper_post('', $params).'" id="'.$id.'">';
	return $str;
}

function form_hidden($name, $value)
{
	return '<input type="hidden" name="'.$name.'" value="'.$value.'" />';
}


function form_button($type, $value)
{
	return '<input class="phpos_form_button" type="'.$type.'" value="'.$value.'"><br />';
}



if(!empty($app_param['delete_id']))
{


}

if($_POST['user_action_new'])
{
	$tmp_login = $_POST['user_new_login'];
	$tmp_pass1 = $_POST['user_new_pass'];
	$tmp_pass2 = $_POST['user_new_pass2'];
	$tmp_type = $_POST['user_new_type'];
	
	$new_usr = new phpos_users;
	
	$new_usr->set_user_login($tmp_login);
	$new_usr->set_user_pass($tmp_pass1);
	$new_usr->set_user_type($tmp_type);
	
	if($new_usr->new_user())
	{
		echo 'nowy user';
	}	else {
		echo 'eeror';
	}
	


$_POST['user_action_new'] = 0;
}




?>










<div style="background-color:white; height:100% auto">
nnnnnn

<a href="javascript:void" onclick="<?php echo helper_reload(array('action' => 'new')); ?>">
<img src="_phpos/resources/task_manager/icons/header_users.png" class="easyui-tooltip" 
title="<?php  echo txt('users');?>">
</a>




<?php echo $app_param['delete_id']; ?>
<table width="100%"><tr>
<td width="50%" valign=top>




<?php
$users = new phpos_users;

$how_many = $users->count_users();

echo 'users:'.$how_many.'<br>';

$t = time();
$id = 2;
// admin //id1
// admin


// szczyglis //id2
// haslo
/*
echo 'time:'.$t.'<br>md5_demo:'.md5(md5($id.$t.'haslo'));
*/

if($how_many != 0)
{
	$users_ids = $users->get_users();
	
	echo '<table class="phpos_table">';
	$c=count($users_ids);
	
	
	echo '<tr class="phpos_table_row_header">
	<td><b>id</b></td>
		<td><b>id_user</b></td>
		<td><b>user_login</b></td>
		<td><b>user_pass</b></td>
		<td><b>user_email</b></td>
		<td><b>user_type</b></td>
		<td><b>id_group</b></td>
		<td><b>is_active</b></td>
		<td><b>created_at</b></td>
		<td><b>last_login</b></td>
		<td><b>last_activity</b></td>
		<td><b>note</b></td>
		<td><b>X</b></td>
		</tr>';
		
	
	
	
	
	
	
	
	for($i=0; $i<$c; $i++)
	{
		$u = new phpos_users();
		$u->set_id_user($users_ids[$i]);
		$u->get_user_by_id();
		
		$id = $u->get_id_user();
		
		$class = 'phpos_table_row1';
		if($i%2 == 0)
		{
			$class = 'phpos_table_row2';
		}
		
		echo '<tr class="'.$class.'">
		<td>'.$users_ids[$i].'</td>
		<td>'.$u->get_id_user().'</td>
		<td>'.$u->get_user_login().'</td>
		<td>'.$u->get_user_pass().'</td>
		<td>'.$u->get_user_email().'</td>
		<td>'.$u->get_user_type().'</td>
		<td>'.$u->get_id_group().'</td>
		<td>'.$u->get_is_active().'</td>
		<td>'.$u->get_created_at().'</td>
		<td>'.$u->get_last_login().'</td>
		<td>'.$u->get_last_activity().'</td>
		<td>'.$u->get_note().'</td>
		<td><a href="javascript:void(0);" onclick="'.helper_reload(array('delete_id' => $id)).'"><span style="color:red">(x)</span></a></td>
		</tr>';
		
		unset($u);
	}
	
	

	echo '</table>';


}




?>



</td>
<td width="50%" valign=top>
xxxx-
<?php echo $_POST['test']; ?>











</td>

</tr>
</table>



<?php echo form_start_ajax('test', array('fs' => $app_param['fs'])); ?>
<?php echo form_hidden('user_action_new', '1'); ?>
<?php echo form_title('To create new user, fill data below', ''); ?>
<?php echo form_input('user_new_login', 'Login', 'tip', 'input', ''); ?>
<?php echo form_input('user_new_pass', 'Password1', '', 'input', ''); ?>
<?php echo form_input('user_new_pass2', 'Password2', '', 'input', ''); ?>
<?php echo form_input('user_new_type', 'Typ', '', 'input', ''); ?>
<?php echo form_button('submit', 'Dodaj usera'); ?>
<?php //echo form_end('id', 'action_params'); ?>
</form>



</div>


<script>
$(document).ready(function() { 

			$('#test').form({  					
				onSubmit: function(){
								
				},  
				success:function(data){					
					<?php echo helper_reload(); ?>
					return false; 
					
				}				
			});
			
			
			/* input */
	$('.input').mouseleave(function() {
		if(!$(this).is(":focus"))
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
		if(!$('.input').is(":focus"))
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
	
	
	
	
	$('.phpos_table tr').mouseenter(function() {		
			$(this).addClass('phpos_table_tr_mouseenter');	
	});
	
	$('.phpos_table tr').mouseleave(function() {		
			$(this).removeClass('phpos_table_tr_mouseenter');	
	});
	
			
});



</script>