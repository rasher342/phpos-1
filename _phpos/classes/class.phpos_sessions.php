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


class phpos_sessions {

	private 
		$db_ftp,
		$id,
		$host,
		$login,
		$password,
		$mode,
		$port,
		$title,
		$desc,
		$id_user,
		$is_public,
		$remote_dir;
	
			 
/*
**************************
*/
 	
	public function __construct()
	{
		$this->db_ftp = 'ftp';
	}
		 
/*
**************************
*/
 	
	public function get_all()
	{		
		global $sql;
		$records = $sql->records($this->db_ftp);
		return $records;	
	}
			 
/*
**************************
*/
 	
	public function is_my_ftp($id)
	{		
		global $sql;
		$my_id = logged_id();	
		$sql->cond('id', $id);
		$row = $sql->get_row($this->db_ftp);
		if($row['id_user'] == $my_id) return true;
	}
		 
/*
**************************
*/
 	public function get_ftp()
	{		
		global $sql;
		$sql->cond('id', $this->id);
		$row = $sql->get_row($this->db_ftp);
		
		$this->id = $row['id'];
		$this->host = $row['host'];
		$this->login = $row['login'];
		$this->password = $row['password'];
		$this->mode = $row['mode'];
		$this->port = $row['port'];
		$this->title = $row['title'];
		$this->desc = $row['description'];
		$this->id_user = $row['id_user'];
		$this->is_public = $row['public'];
		$this->remote_dir = $row['remote_dir'];			
	}
		 
		 
	
/*
**************************
*/
	public function get_my_ftp()
	{		
		global $sql;
		$my_id = logged_id();	
		$sql->cond('id_user', $my_id);
		$sql->cond('or');		
		$sql->cond('public', 1);		
		$records = $sql->records($this->db_ftp);
		return $records;	
	}
		 
/*
**************************
*/
 		
	public function get_public_ftp()
	{		
		global $sql;	
		$sql->cond('public', 1);		
		$records = $sql->records($this->db_ftp);
		return $records;	
	}
			 
/*
**************************
*/
 	
	public function delete_ftp($id)
	{		
		global $sql;	
		$sql->cond('id', $id);		
		if($sql->delete($this->db_ftp)) return true;	
	}

			 
/*
**************************
*/
 	
	public function new_ftp($title, $desc, $host, $user, $pass, $port, $public = null, $remote_dir = null)
	{
		global $sql;
		$my_id = logged_id();	
		$items = array(
		'id_user' => $my_id,
		'title' => $title,
		'host' => $host,
		'port' => $port,
		'login' => $user,
		'password' => $pass,
		'remote_dir' => $remote_dir,
		'description' => $desc,
		'public' =>	$public
		);
		if($sql->add($this->db_ftp, $items)) return true;	
	}
			 
/*
**************************
*/
 	
	public function update_ftp($id, $title, $desc, $host, $user, $pass, $port, $public = null, $remote_dir = null)
	{
		global $sql;
		$my_id = logged_id();	
		$items = array(		
		'title' => $title,
		'host' => $host,
		'port' => $port,
		'login' => $user,
		'password' => $pass,
		'remote_dir' => $remote_dir,
		'description' => $desc,
		'public' =>	$public
		);
		$sql->cond('id', $id);		
		if($sql->update($this->db_ftp, $items)) return true;	
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
 	
	public function set_port($port)
	{
		$this->port = $port;
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
 	
	public function set_remote_dir($remote_dir)
	{
		$this->remote_dir = $remote_dir;
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
 	
	public function get_port()
	{
		return $this->port;
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
 	
	public function get_remote_dir()
	{
		return $this->remote_dir;
	}
	
}
?>