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


class phpos_database extends phpos_databases {

	private
		$schema,
		$errors = array(),
		$db_type,
		$adapter_full_name,
		$db_prefix,
		$condition = array(),
		$sort_by = null,
		$limit = null,
		$debug = array();			
	 
/*
**************************
*/
 		
	public function __construct()
	{
		$this->adapter_full_name = 'MySQL';
		$this->db_type = 'mysql';	
		$this->db_prefix = 'phpos_';
	}
	 
/*
**************************
*/
 	
	public function connect()
	{
		$connection = @mysql_connect($this->host, $this->user, $this->password) or $this->set_error(mysql_error(), 'mysql_connect');
		$db = @mysql_select_db($this->dbname, $connection) or $this->set_error(mysql_error(), 'mysql_select_db');
		if(empty($this->errors[0])) return true;	
	}
		
	 
/*
**************************
*/
 	
	public function load_schema($schema)
	{
		$this->schema = $schema;	
	}
 
/*
**************************
*/
 	
	public function get_adapter_full_name()
	{
		return $this->adapter_full_name;
	}
	 
/*
**************************
*/
 	
	private function set_error($error = null, $query = null)
	{
		$this->errors[] = $query.': '.$error;
	}
	 
/*
**************************
*/
 	
	public function get_error($parse = null)
	{
		if($parse == null)
		{
			$err = $this->errors;	
			
		} else {
		
			$err = implode('<br />', $this->errors);			
		}
		
		$this->errors = array();
		return $err;
	}
	 
/*
**************************
*/
 	
	public function get_debug($parse = null)
	{
		if($parse == null)
		{
			$dbg = $this->debug;	
			
		} else {
		
			$dbg = implode('<br />', $this->debug);
		}		
		
		$this->debug = array();
		return $dbg;
	}	
	 
/*
**************************
*/
 	
	private function set_debug($query)
	{
		$this->debug[] = $query;
	}	
	 
/*
**************************
*/
 	
	private function parse_fields($fields, $primary_key)
	{	
		$field = array();
		foreach($fields as $field_data)
		{
			$field_name = $field_data[0];
			$field_type = $field_data[1];
			$field_length = $field_data[2];
			$field_params = $field_data[3];	
			
			$auto_increment = '';
			if($primary_key == $field_name) $auto_increment = ' AUTO_INCREMENT';		
			$field[] = ''.$field_name.' '.$field_type.' '.$field_params.$auto_increment;		
		}	
		
		$parsed = implode(',', $field);
		return $parsed;	
	}
	 
/*
**************************
*/
 	
	public function parse_schema()
	{
		if(is_array($this->schema))
		{
			$queries = array();
			foreach($this->schema as $table_name => $table_data)
			{
				$tbl = '';				
				$tbl.= 'CREATE TABLE IF NOT EXISTS '.$this->db_prefix.$table_name.' ( ';
				$tbl.= $this->parse_fields($table_data['fields'], $table_data['id_key']);		
				$tbl.= ', PRIMARY KEY ('.$table_data['id_key'].') )';		
				$queries[] = $tbl;
			}	
			
			return $queries;	
		}
	}
 
/*
**************************
*/
 		
	public function install()
	{
		if(is_array($this->schema))
		{			
			$queries = $this->parse_schema();			
			foreach($queries as $query)
			{
				@mysql_query($query) or $this->set_error(mysql_error(), $query);
				$this->set_debug($query);
			}				
			if(empty($this->errors[0])) return true;	
		}	
	}
	 
/*
**************************
*/
 	
	private function parse_row($row, $table)
	{
		if(is_array($row))
		{		
			$fields = array();
			$values = array();
			foreach($row as $key => $value)
			{
				$fields[] = $key;
				$values[] = "'".$value."'";		
			}			
			
			$query_fields = implode(',', $fields);
			$query_values = implode(',', $values);
			
			$query = "INSERT INTO ".$this->db_prefix.$table." (".$query_fields.") VALUES(".$query_values.")";
			return $query;
		}	
	}
	
 
/*
**************************
*/
 		
	public function insert_array($arr, $table)
	{
		if(is_array($arr))
		{				
			foreach($arr as $q)
			{
				$query =  $this->parse_row($q, $table);
				@mysql_query($query) or $this->set_error(mysql_error(), $query);
				$this->set_debug($query);				
			}
			
			if(empty($this->errors[0])) return true;	
		}
	}	
 
/*
**************************
*/
 		
	public function parse_drop()
	{
		if(is_array($this->schema))
		{
			$queries = array();
			foreach($this->schema as $table_name => $table_data)
			{					
				$queries[] =  'DROP TABLE '.$this->db_prefix.$table_name;
			}	
			return $queries;	
		}
	}	
	 
/*
**************************
*/
 	
	public function uninstall()
	{
		if(is_array($this->schema))
		{			
			$queries = $this->parse_drop();			
			foreach($queries as $query)
			{
				@mysql_query($query) or $this->set_error(mysql_error());
				$this->set_debug($query);
			}		
			
			if(empty($this->errors[0])) return true;	
		}	
	}

	 
/*
**************************
*/
 	
	function sort_by($order_by, $order = 'asc')
	{
		if(!empty($order_by))
		{
			$this->sort_by = $this->filter_var($order_by).' '.$this->filter_var($order);
		}	
	}
	 
/*
**************************
*/
 	
	function limit($num)
	{
		if(!empty($num))
		{
			$this->limit = $this->filter_var($num);
		}	
	}
	 
/*
**************************
*/
 	
	function op($value)
	{
		$this->condition[] = $value;
	}	
 
/*
**************************
*/
 		
	function cond($field, $value = null, $operator = null)
	{
		
		if($field != 'or' && $field != 'and')		
		{
			$sql[0] = $field;
			$sql[1] = $value;
			$sql[2] = $operator;
			$this->condition[] = $sql;
			
		} else {
		
			$this->condition[] = $field;
		}
	}
 
/*
**************************
*/
 		
	function parse_cond()
	{
		//$sql = array();
		if(!empty($this->condition[0]))
		{
			$c = count($this->condition);		
			
			for($i=0; $i < $c; $i++)
			{			
				
				if(is_array($this->condition[$i]))
				{
					$field = $this->filter_var(trim($this->condition[$i][0]));
					$value = $this->filter_var(trim($this->condition[$i][1]));
					$operator = '=';
					
					if(!empty($this->condition[$i][2])) $operator = trim($this->condition[$i][2]); 					
					$sql[] = $field." ".$operator." '".$value."'";
					$index = $i+1;
					if(is_array($this->condition[$index])) $sql[] = '&&';
					
				} elseif(!empty($this->condition[$i])) {
				
					$sql[] = $this->condition[$i];				
				}				
			}			
			$query = implode(" ", $sql);
			return $query;
		}		
	}
 
/*
**************************
*/
 		
	function reset_cond()
	{
		$this->condition = array();
		$this->sort_by = null;
		$this->limit = null;
	}
 
/*
**************************
*/
 		
	function parse_query_cond()
	{		
		$cond = $this->parse_cond();
		$sort = $this->sort_by;		
		$q = null;
		if(!empty($cond)) $q.=' WHERE '.$cond;
		if(!empty($this->sort_by)) $q.=' order by '.$this->sort_by;
		if(!empty($this->limit)) $q.=' limit '.$this->limit;		
		return $q;
	}
	 
/*
**************************
*/
 	
	function count_rows($table, $select = '*')
	{
		if(!empty($table))
		{
			$query = "SELECT count(*) as total from ".$this->db_prefix.$table.$this->parse_query_cond();
			//echo $query;
			$result=mysql_query($query);
			$data=mysql_fetch_assoc($result);
			$this->reset_cond();
			return $data['total'];
		}	
	}
	 
/*
**************************
*/
 	
	function is_row($table, $select = '*')
	{
		if(!empty($table))
		{
			//$this->limit = 1;
			$query = "SELECT count(*) as total from ".$this->db_prefix.$table.$this->parse_query_cond();		
			$result=@mysql_query($query);
			//echo $query;
			$data=@mysql_fetch_assoc($result);
			$this->reset_cond();
			//return $query;
			if($data['total'] !=0) return true;
		}	
	}
	 
/*
**************************
*/
 	
	function get_row($table, $select = '*')
	{
		if(!empty($table))
		{			
			$query = "SELECT ".$select." from ".$this->db_prefix.$table.$this->parse_query_cond();
			$result=@mysql_query($query);
			$this->reset_cond();
			if(@mysql_num_rows($result)!=0)
			{				
				return mysql_fetch_array($result);
			}
		}	
	}
	 
/*
**************************
*/
 	
	function records($table, $select = '*')
	{
		if(!empty($table))
		{			
			$query = "SELECT ".$select." from ".$this->db_prefix.$table.$this->parse_query_cond();
			$result=@mysql_query($query);
			
			$record = array();
			while($row = @mysql_fetch_array($result))
			{
				$record[] = $row;
			}		
			
			$this->reset_cond();
			return $record;
		}	
	}
	 
/*
**************************
*/
 	
	function add($table, $array)
	{
		if(!empty($table) && is_array($array))
		{		
			$fields = array();
			$values = array();
			foreach($array as $key => $value)
			{
				$fields[] = $this->filter_var($key);
				$values[] = "'".$this->filter_var($value)."'";		
			}			
			
			$query_fields = implode(',', $fields);
			$query_values = implode(',', $values);
			
			$query = "INSERT INTO ".$this->db_prefix.$table." (".$query_fields.") VALUES(".$query_values.")";
			$SESSION['query'] = $query;
			if(@mysql_query($query))
			{
				$this->reset_cond();			
				return mysql_insert_id();
			}
		}	
	}
	
	 
/*
**************************
*/
 	
	function update($table, $array)
	{
		if(!empty($table) && is_array($array))
		{				
			$column = array();
			foreach($array as $key => $value)
			{
				$column[] = $this->filter_var($key)." = '".$this->filter_var($value)."'";
			}			
			
			$q = implode(',', $column);			
			
			$query = "UPDATE ".$this->db_prefix.$table." SET ".$q.$this->parse_query_cond();
			$this->reset_cond();
			//echo $query;
			if(@mysql_query($query)) return true;
			
		}	
	}
 
/*
**************************
*/
 	
	function delete($table)
	{
		if(!empty($table))
		{				
			$query = "DELETE FROM ".$this->db_prefix.$table.$this->parse_query_cond();
			$this->reset_cond();			
			if(@mysql_query($query)) return true;
		}	
	}
	 
/*
**************************
*/
 	
	function filter_var($var)
	{
		return mysql_real_escape_string($var);
	}
}
?>