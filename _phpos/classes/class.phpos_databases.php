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


class phpos_databases {

	protected
		$host,
		$user,
		$password,
		$dbname,
		$adapter,
		$prefix;		
			 
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
 	
	public function set_user($user)
	{
		$this->user = $user;
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
 	
	public function set_dbname($dbname)
	{
		$this->dbname = $dbname;
	}
		 
/*
**************************
*/
 	
	public function set_adapter($adapter)
	{
		$this->adapter = $adapter;
	}
		 
/*
**************************
*/
 	
	public function set_prefix($prefix)
	{
		$this->prefix = $prefix;
	}
		 
/*
**************************
*/
 	
	public function set_type($type)
	{
		$this->type = $type;
	}

}
?>