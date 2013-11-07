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


class phpos_messages {

	private
		$db_msg;
			 
/*
**************************
*/ 		
		
	public function __construct()
	{
		$this->db_msg = 'messages';	
	}	
			 
/*
**************************
*/
 	
	public function count_unreaded()
	{
		global $sql;
		$my_id = logged_id();
		$sql->cond('id_user_to', $my_id);
		$sql->cond('receiver_deleted', '0');
		$sql->cond('readed_at', '0');
		$c = $sql->count_rows($this->db_msg);	
		return $c;
	}
			 
/*
**************************
*/
 	
	public function get_unreaded()
	{
		global $sql;
		$my_id = logged_id();
		$sql->cond('id_user_to', $my_id);
		$sql->cond('is_readed', null);		
		$sql->cond('receiver_deleted', null);
		$sql->sort_by('id', 'desc');
		return $sql->records($this->db_msg);	
	}
			 
/*
**************************
*/
 	
	public function count_received()
	{
		global $sql;
		$my_id = logged_id();
		$sql->cond('id_user_to', $my_id);
		$sql->cond('receiver_deleted', null);
		return $sql->count_rows($this->db_msg);		
	}
			 
/*
**************************
*/
 	
	public function have_unreaded()
	{
		if($this->count_unreaded() != 0) return true;
	}
			 
/*
**************************
*/
 	
	public function get_received()
	{
		global $sql;
		$my_id = logged_id();
		$sql->cond('id_user_to', $my_id);
		$sql->sort_by('id', 'desc');
		$sql->cond('receiver_deleted', null);
		return $sql->records($this->db_msg);	
	}
			 
/*
**************************
*/	
	
	public function count_sended()
	{
		global $sql;
		$my_id = logged_id();
		$sql->cond('id_user_from', $my_id);
		$sql->cond('sender_deleted', null);
		return $sql->count_rows($this->db_msg);		
	}
			 
/*
**************************
*/
 	
	public function get_sended()
	{
		global $sql;
		$my_id = logged_id();
		$sql->cond('id_user_from', $my_id);
		$sql->cond('sender_deleted', null);
		$sql->sort_by('id', 'desc');
		return $sql->records($this->db_msg);	
	}
			 
/*
**************************
*/
 	
	public function get_msg($id)
	{
		global $sql;
		$my_id = logged_id();
		$sql->cond('id', $id);
		return $sql->get_row($this->db_msg);	
	}
			 
/*
**************************
*/
 	
	public function is_to_me($id)
	{
		global $sql;
		$my_id = logged_id();
		$sql->cond('id', $id);
		$row = $sql->get_row($this->db_msg);	
		
		if(intval($row['id_user_to']) == intval($my_id))
		{
			return true;
		}
	}
			 
/*
**************************
*/
 	
	public function is_readed($id)
	{
		global $sql;
		
		$sql->cond('id', $id);
		$row = $sql->get_row($this->db_msg);
		if($row['is_readed']) return true;
	}
			 
/*
**************************
*/
 	
	public function set_as_readed($id)
	{
		global $sql;
		$my_id = logged_id();
		$sql->cond('id', $id);
		
		$items = array(
			'is_readed' => 1,
			'readed_at' => time()
		);
		
		if($sql->update($this->db_msg, $items)) return true;
	}
			 
/*
**************************
*/
 	
	public function send($to = null, $title, $msg)
	{
		$my_id = logged_id();
		
		global $sql;
		$items = array(
		'id_user_from' => $my_id,
		'id_user_to' => $to,
		'title' => $title,
		'sended_at' => time(),
		'msg' => $msg,
		'sender_deleted' => 0,
		'receiver_deleted' => 0,
		'is_readed' => 0,
		'readed_at' => 0
		);
		
		if($sql->add($this->db_msg, $items)) return true;	
	}
			 
/*
**************************
*/
 	
	public function delete_sended($id)
	{
		global $sql;
		$sql->cond('id', $id);
		$items = array(
		'sender_deleted' => 1
		);
		
		if($sql->update($this->db_msg, $items)) return true;	
	}
			 
/*
**************************
*/
 	
	public function delete_received($id)
	{
		global $sql;
		$sql->cond('id', $id);
		$items = array(
		'receiver_deleted' => 1
		);
		
		if($sql->update($this->db_msg, $items)) return true;	
	}

}
?>