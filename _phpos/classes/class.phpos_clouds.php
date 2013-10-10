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


class phpos_clouds {

	private 
		$db_clouds,
		$id,
		$cloud,
		$login,
		$password,
		$mode,		
		$title,
		$desc,
		$id_user,
		$is_public,
		$url,
		$param1,
		$param2,
		$param3,
		$param4;

			 
/*
**************************
*/
 	
	public function __construct()
	{
		$this->db_clouds = 'clouds';
	}
		 
/*
**************************
*/
 	
	public function get_all()
	{		
		global $sql;
		$records = $sql->records($this->db_clouds);
		return $records;	
	}
	 
/*
**************************
*/
 	
	public function is_my_cloud($id)
	{		
		global $sql;
		$my_id = logged_id();	
		$sql->cond('id', $id);
		$row = $sql->get_row($this->db_clouds);
		if($row['id_user'] == $my_id) return true;
	}
	 
/*
**************************
*/
 	
	public function get_cloud_icon()
	{
		$name = $this->cloud;
		return ICONS.'clouds/'.$name.'.png';	
	}
		 
/*
**************************
*/
 	public function get_cloud()
	{		
		global $sql;
		$sql->cond('id', $this->id);
		$row = $sql->get_row($this->db_clouds);
		
		$this->id = $row['id'];
		$this->cloud = $row['cloud'];
		$this->login = $row['login'];
		$this->password = $row['password'];
		$this->mode = $row['mode'];		
		$this->title = $row['title'];
		$this->desc = $row['description'];
		$this->id_user = $row['id_user'];
		$this->is_public = $row['public'];
		$this->url = $row['url'];			
		$this->param1 = $row['param1'];
		$this->param2 = $row['param2'];
		$this->param3 = $row['param3'];
		$this->param4 = $row['param4'];
	}	 
		 
	
/*
**************************
*/
	public function get_my_clouds()
	{		
		global $sql;
		$my_id = logged_id();	
		$sql->cond('id_user', $my_id);
		$sql->cond('or');		
		$sql->cond('public', 1);		
		$records = $sql->records($this->db_clouds);
		return $records;	
	}
	 
/*
**************************
*/
 	
	public function get_only_my_clouds()
	{		
		global $sql;
		$my_id = logged_id();	
		$sql->cond('id_user', $my_id);
			
		$records = $sql->records($this->db_clouds);
		return $records;	
	}
 
/*
**************************
*/
 		
	public function get_public_clouds()
	{		
		global $sql;	
		$sql->cond('public', 1);		
		$records = $sql->records($this->db_clouds);
		return $records;	
	}
 
/*
**************************
*/
 		
	public function delete_cloud($id)
	{		
		global $sql;	
		$sql->cond('id', $id);		
		if($sql->delete($this->db_clouds)) return true;	
	}
 
/*
**************************
*/
 		
	public function new_cloud($title, $desc, $cloud, $user, $pass, $public = null, $url = null, $param1 = null, $param2 = null, $param3 = null, $param4 = null)
	{
		global $sql;
		$my_id = logged_id();	
		$items = array(
		'id_user' => $my_id,
		'title' => $title,
		'cloud' => $cloud,	
		'login' => $user,
		'password' => $pass,
		'url' => $url,
		'description' => $desc,
		'public' =>	$public,
		'param1' =>	$param1,
		'param2' =>	$param2,
		'param3' =>	$param3,
		'param4' =>	$param4,
		);
		if($sql->add($this->db_clouds, $items)) return true;	
	}
	 
/*
**************************
*/
 	
	public function update_cloud($id, $title, $desc, $user, $pass, $public = null, $url = null, $param1 = null, $param2 = null, $param3 = null, $param4 = null)
	{
		global $sql;
		$my_id = logged_id();	
		$items = array(	
		'title' => $title,		
		'login' => $user,
		'password' => $pass,
		'url' => $url,
		'description' => $desc,
		'public' =>	$public,
		'param1' =>	$param1,
		'param2' =>	$param2,
		'param3' =>	$param3,
		'param4' =>	$param4,
		);
		$sql->cond('id', $id);		
		if($sql->update($this->db_clouds, $items)) return true;	
	}
	 
/*
**************************
*/
 			 
	public function set_id($id)
	{
		$this->id = $id;
	}		 
 
/*
**************************
*/
 		
	public function set_host($host)
	{
		$this->host = $host;
	}	
	 
/*
**************************
*/
 	
	public function set_login($login)
	{
		$this->login = $login;
	}	
	 
/*
**************************
*/
 	
	public function set_password($password)
	{
		$this->password = $password;
	}	
	 
/*
**************************
*/
 	
	public function set_mode($mode)
	{
		$this->mode = $mode;
	}	
	 
/*
**************************
*/
 	
	public function set_cloud($cloud)
	{
		$this->cloud = $cloud;
	}	
	 
/*
**************************
*/
 	
	public function set_title($title)
	{
		$this->title = $title;
	}	
	 
/*
**************************
*/
 	
	public function set_desc($desc)
	{
		$this->desc = $desc;
	}	
	 
/*
**************************
*/
 	
	public function set_id_user($id_user)
	{
		$this->id_user = $id_user;
	}
	 
/*
**************************
*/
 	
	public function set_is_public($is_public)
	{
		$this->is_public = $is_public;
	}
	 
/*
**************************
*/
 	
	public function set_url($url)
	{
		$this->url = $url;
	}
	 
/*
**************************
*/
 	
	public function set_param1($param1)
	{
		$this->param1 = $param1;
	}
	 
/*
**************************
*/
 	
	public function set_param2($param2)
	{
		$this->param2 = $param2;
	}
	 
/*
**************************
*/
 	
	public function set_param3($param3)
	{
		$this->param3 = $param3;
	}
	 
/*
**************************
*/
 	
	public function set_param4($param4)
	{
		$this->param4 = $param4;
	}	
	 
/*
**************************
*/ 	
	
	public function get_id()
	{
		return $this->id;
	}		 
 
/*
**************************
*/
 		
	public function get_host()
	{
		return $this->host;
	}	
	 
/*
**************************
*/
 	
	public function get_login()
	{
		return $this->login;
	}	
	 
/*
**************************
*/
 	
	public function get_password()
	{
		return $this->password;
	}	
	 
/*
**************************
*/
 	
	public function get_mode()
	{
		return $this->mode;
	}		
	 
/*
**************************
*/	
	
	
	public function get_cloud_type()
	{
		return $this->cloud;
	}		
	 
/*
**************************
*/
 	
	public function get_cloud_name()
	{
		return $this->cloud;
	}		
 
/*
**************************
*/
 		
	public function get_title()
	{
		return $this->title;
	}	
	 
/*
**************************
*/
 	
	public function get_desc()
	{
		return $this->desc;
	}	
	 
/*
**************************
*/
 	
	public function get_id_user()
	{
		return $this->id_user;
	}
	 
/*
**************************
*/
 	
	public function get_is_public()
	{
		return $this->is_public;
	}
	 
/*
**************************
*/
 	
	public function get_url()
	{
		return $this->url;
	}
	 
/*
**************************
*/
 	
	public function get_param1()
	{
		return $this->param1;
	}
	 
/*
**************************
*/
 	
	public function get_param2()
	{
		return $this->param2;
	}
	 
/*
**************************
*/
 	
	public function get_param3()
	{
		return $this->param3;
	}
	 
/*
**************************
*/
 	
	public function get_param4()
	{
		return $this->param4;
	}	
	
}
?>