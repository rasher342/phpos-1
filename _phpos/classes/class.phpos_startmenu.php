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


class phpos_startmenu {

	private 
		$db_startmenu,
		$db_files;

		 
/*
**************************
*/
 	
	public function __construct()
	{
		$this->db_startmenu = 'startmenu';
		$this->db_files = 'files';
	}
		 
/*
**************************
*/
 	
	public function get_all()
	{		
		global $sql;
		$my_id = logged_id();
		//$records = $sql->records($this->db_startmenu);		
		$sql->cond('id_user', $my_id);
		$records = $sql->records($this->db_startmenu);
		return $records;	
	}
	 
/*
**************************
*/
 	
	public function delete_item($id)
	{		
		global $sql;
		$my_id = logged_id();
		//$records = $sql->records($this->db_startmenu);
		$sql->cond('id', $id);
		$sql->cond('id_user', $my_id);
		if($sql->delete($this->db_startmenu)) return true;
	}

}
?>