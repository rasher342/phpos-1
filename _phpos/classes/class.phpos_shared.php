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


class phpos_shared {

	private 
		$id_user,
		$title,
		$folder_type,
		$folder_id,
		$readonly,		
		$db_shared;

		 
/*
**************************
*/
 	
	public function __construct()
	{
		$this->db_shared = 'shared';
		$this->db_groups = 'groups';
		$this->db_groups_records = 'groups_records';
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
 	
	public function get_id()
	{
		return $this->id;
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
 	
	public function get_id_user()
	{
		return $this->id_user;
	}
		 
/*
**************************
*/
 	
	public function get_folder_type()
	{
		return $this->folder_type;
	}
		 
/*
**************************
*/
 	
	public function get_folder_id()
	{
		return $this->folder_id;
	}
		 
/*
**************************
*/
 	
	public function get_readonly()
	{
		return $this->readonly;
	}
		 
/*
**************************
*/
 	
	public function get_shared()
	{
		global $sql;
		$sql->cond('id', $this->id);
		$row = $sql->get_row($this->db_shared);	
		$this->title = $row['title'];
		$this->folder_type = $row['folder_type'];
		$this->folder_id = $row['folder_id'];
		$this->readonly = $row['readonly'];
		$this->id_user = $row['id_user'];
		
		return $row;
	}
		 
/*
**************************
*/
 	
	public function is_shared_to_me()
	{
		global $sql;	
		$my_id = logged_id();	
		if($this->id_user == $my_id) return true;
		
		$sql->cond('id_user', $this->id_user);			
		$records = $sql->records($this->db_groups_records);	
		
		foreach($records as $row)
		{
			$sql->cond('id_user', $my_id);		
			$sql->cond('id_group', $row['id_group']);
			if($sql->is_row($this->db_groups_records)) return true;		
		}
	}
	
		 
/*
**************************
*/
 	
	public function get_all()
	{		
		global $sql;
		$records = $sql->records($this->db_shared);
		return $records;	
	}
		 
/*
**************************
*/
 	
	public function get_my_shared()
	{		
		global $sql;
		$my_id = logged_id();
		$sql->cond('id_user', $my_id);
		$records = $sql->records($this->db_shared);
		return $records;	
	}
			 
/*
**************************
*/
 	
	public function is_folder_shared($id)
	{
		$records = $this->get_my_shared();
		$c = count($records);
		
		if($c != 0)
		{
			$shared = array();
			foreach($records as $row)
			{
				$shared[] = $row['folder_id'];			
			}
			
			if(in_array(base64_encode($id), $shared)) return true;
		}	
	}
	
			 
/*
**************************
*/
 	
	public function find_shared($id)
	{
		global $sql;
		$sql->cond('folder_id', base64_encode($id));
		$row = $sql->get_row($this->db_shared);		
		return $row['id'];
	}
			 
/*
**************************
*/
 		 
	public function is_my($id)
	{
		$my_id = logged_id();		
		global $sql;
		$sql->cond('id', $id);
		$row = $sql->get_row($this->db_shared);	
		if($row['id_user'] == $my_id) return true;
	}	
/*
**************************
*/
 	
	public function set_id_user($id)
	{
		$this->id_user = $id;
	}
		 
/*
**************************
*/
 	
	public function get_user_shared()
	{
		if(!empty($this->id_user))
		{
			global $sql;
			$sql->cond('id_user', $this->id_user);
			return $sql->records($this->db_shared);		
		}
	}
		 
/*
**************************
*/
 		
		public function count_user_shared()
	{
		if(!empty($this->id_user))
		{
			global $sql;
			$sql->cond('id_user', $this->id_user);
			return $sql->count_rows($this->db_shared);		
		}
	}
			 
/*
**************************
*/
 	
	
	public function share_folder($title, $desc, $type, $id, $readonly)
	{
		global $sql;
		$my_id = logged_id();
		
		$items = array(
		'id_user' => $my_id,
		'title' => $title,
		'description' => $desc,
		'folder_type' => $type,
		'folder_id' => $id,
		'readonly' => $readonly		
		);
		
		if($sql->add($this->db_shared, $items)) return true;	
	}
			 
/*
**************************
*/
 	
	public function unshare_folder($id)
	{
		global $sql;
		$my_id = logged_id();
		
		$sql->cond('id_user', $my_id);
		$sql->cond('folder_id', $id);
		echo $id;
		
		if($sql->delete($this->db_shared)) return true;	
	}

}
?>