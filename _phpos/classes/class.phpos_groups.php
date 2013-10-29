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


class phpos_groups {

	private 
		$id,
		$title,
		$desc,
		$msg,
		$id_owner,
		$db_groups,
		$db_users,
		$db_groups_records;

	 
/*
**************************
*/
 		
	public function __construct()
	{
		$this->db_users = 'users';
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
 	
	public function get_desc()
	{
		return $this->desc;
	}
		 
/*
**************************
*/
 	
	public function get_id_owner()
	{
		return $this->id_owner;
	}
		 
/*
**************************
*/
 	
	public function get_msg()
	{
		return $this->msg;
	}
		 
/*
**************************
*/
 	
	public function get_all()
	{		
		global $sql;
		$records = $sql->records($this->db_groups);
		return $records;	
	}
		 
/*
**************************
*/
 	
	public function get_my_groups()
	{		
		global $sql;
		$my_id = logged_id();	
		$sql->cond('id_user', $my_id);		
		$records = $sql->records($this->db_groups_records);
		
		if(count($records) != 0)
		{
			$group_data = array();
			foreach($records as $row)
			{
				$sql->cond('id', $row['id_group']);
				if($sql->is_row($this->db_groups))
				{
					$sql->cond('id', $row['id_group']);
					$group_data[] = $sql->get_row($this->db_groups);
				}
				
			}
		}			
		
		return $group_data;	
	}
			 
/*
**************************
*/
 	
	public function get_my_own_groups()
	{		
		global $sql;
		$my_id = logged_id();	
		$sql->cond('id_owner', $my_id);		
		return $sql->records($this->db_groups);
	} 
/*
**************************
*/
 	public function delete_group($id)
	{		
		global $sql;	
		$sql->cond('id', $id);		
		if($sql->delete($this->db_groups)) return true;	
	}	
		 
/*
**************************
*/
 	
	public function group_exists()
	{
		global $sql;
		$sql->cond('id', $this->id);
		if($sql->is_row($this->db_groups)) return true;	
	}
		 
/*
**************************
*/
 	
	public function count_users()
	{
		global $sql;
		$sql->cond('id_group', $this->id);
		return $sql->count_rows($this->db_groups_records);	
	}
		 
/*
**************************
*/
 	
	public function get_group()
	{
		global $sql;
		$sql->cond('id', $this->id);
		$row = $sql->get_row($this->db_groups);	
		$this->title = $row['title'];
		$this->desc = $row['description'];
		$this->msg = $row['msg'];
		$this->id_owner = $row['id_owner'];
		
		return $row;	
	}
	
			 
/*
**************************
*/
 	
	public function new_group($title, $desc, $msg)
	{
		global $sql;
		$my_id = logged_id();
		$items = array(
		'title' => $title,
		'description' => $desc,
		'msg' => $msg,
		'id_owner' => $my_id	
		);
		if($sql->add($this->db_groups, $items)) return true;	
	}
			 
/*
**************************
*/
 	
	public function update_group($title, $desc, $msg)
	{
		global $sql;		
		$items = array(
		'title' => $title,
		'description' => $desc,
		'msg' => $msg,			
		);
		$sql->cond('id', $this->id);
		if($sql->update($this->db_groups, $items)) return true;	
	}
	
			 
/*
**************************
*/
 	
	public function remove_user($id_user, $id_group)
	{
		global $sql;
		$sql->cond('id_user', $id_user);
		$sql->cond('id_group', $id_group);	
		if($sql->delete($this->db_groups_records)) return true;	
	}
			 
/*
**************************
*/
 	
	public function add_user($id_user, $id_group)
	{
		global $sql;
		$items = array(
		'id_group' => $id_group,
		'id_user' => $id_user		
		);
		if($sql->add($this->db_groups_records, $items)) return true;	
	}
		 
/*
**************************
*/
 	
	public function im_in_group()
	{
		$users_in_group = $this->get_users_in_group();
		
		$my_id = logged_id();		
		global $sql;
		$sql->cond('id_group', $this->id);
		$sql->cond('id_user', $my_id);
		
		if($sql->is_row($this->db_groups_records)) return true;	
	}
			 
/*
**************************
*/
 	
	public function im_owner($group)
	{		
		$my_id = logged_id();		
		global $sql;
		$sql->cond('id', $group);
		$sql->cond('id_owner', $my_id);
		
		if($sql->is_row($this->db_groups)) return true;	
	}
	
		 
/*
**************************
*/
 	
	public function get_users_in_group()
	{
		global $sql;
		if(!empty($this->id) && $this->group_exists())
		{
			$sql->cond('id_group', $this->id);
			return $sql->records($this->db_groups_records);				
		}	
	}
			 
/*
**************************
*/
 	
	public function get_users_out_group()
	{
		global $sql;
		if(!empty($this->id) && $this->group_exists())
		{
			$all_users = $sql->records($this->db_users);
			
			$user = array();
			foreach($all_users as $row)
			{
				$sql->cond('id_user', $row['id_user']);
				$sql->cond('id_group', $this->id);
				if(!$sql->is_row($this->db_groups_records)) $user[] = $row;
			}
			
			return $user;			
		}	
	}
	
	
}
?>