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


class phpos_updater {

	private
		$last_version,
		$my_version,
		$type,
		$build,
		$name,
		$zip_file,	
		$msg,	
		$json_file,
		$json_data,
		$server_url,	
		$conn_status = null,	
		$conn_log = null,
		$changes;
			 
/*
**************************
*/
 	
	public function __construct()
	{
		$this->server_url = PHPOS_ONLINE;		
		$this->json_file = 'updates_server.php';
		$this->my_version = PHPOS_VERSION;
		
		/*
		--file struct--
		last_version:00512;  when 005 = 0.05, .12
		type:critical; critical|bugs|features
		date:time();
		title:v.1.1.1;
		url:download/file.zip;
		msg:msg;
		changes:
		item1,
		item2,
		item3		
		*/
	}	
		 
/*
**************************
*/
 	
	public function is_actual()
	{
		$my_version = floatval($this->my_version);
		$newest_version = floatval($this->last_version);	
		if($my_version >= $newest_version) return true;	
	}	
		 
/*
**************************
*/
 	
	private function parse()
	{
		if(!empty($this->json_data))
		{
			$data = explode(';', $this->json_data);
			
			$tmp_last_version = $data[0];
			$tmp_my_version;
			$tmp_type = $data[1];
			$tmp_timestamp = $data[2];
			$tmp_name = $data[3];
			$tmp_zip_file = $data[4];	
			$tmp_msg = $data[5];					
			$tmp_changes = $data[6];			
			
			$data_last_version = explode(':', $tmp_last_version);			
			$data_type = explode(':', $tmp_type);
			$data_timestamp = explode(':', $tmp_timestamp);
			$data_name = explode(':', $tmp_name);
			$data_zip_file = explode(':', $tmp_zip_file);
			$data_msg = explode(':', $tmp_msg);		
			$data_changes = explode(':', $tmp_changes);			
			
			$this->last_version = trim($data_last_version[1]);
			$this->type = trim($data_type[1]);
			$this->build = trim($data_timestamp[1]);
			$this->name = trim($data_name[1]);
			$this->zip_file = trim($data_zip_file[1]);
			$this->msg = trim($data_msg[1]);
			$this->changes = trim($data_changes[1]);
			
			if(is_array($data_last_version) && count($data_last_version) == 2) return true;		
		}	
	}
		 
/*
**************************
*/
 		
	public function check_online($timeout = 5)
	{
		try {
		
		 // @set_time_limit(10);
			$ctx = stream_context_create(array( 
					'http' => array( 
							'timeout' => $timeout 
							) 
					) 
			); 
			
			if(false === ($this->json_data = @file_get_contents(PHPOS_UPDATER.'?version='.$this->my_version, 0, $ctx))) $this->conn_status = false;
			
			
		} catch (Exception $e) {
		
        $this->conn_status = false;
				$this->conn_log = 'Failed to connect server'; 
				
    }
		//@set_time_limit(30);
		if($this->conn_status !== false)
		{
				$this->conn_status = true;
				
				if($this->parse()) 
				{
					return true;	
					
				} else {
				
					$this->conn_status = false;
					$this->conn_log = 'Failed to load update data from server'; 
				}
				
		} else {
		
			$this->conn_log = 'Failed to load update data from server'; 
			return false;			
		}		
	}
		 
	 
/*
**************************
*/
 		 
	public function get_conn_error()
	{
		return $this->conn_log;
	}
/*
**************************
*/
 	
	public function get_version()
	{
		return $this->last_version;
	}
		 
/*
**************************
*/
 	
	public function get_type()
	{
		return $this->type;
	}
		 
/*
**************************
*/
 	
	public function get_build()
	{
		return $this->build;
	}
		 
/*
**************************
*/
 	
	public function get_name()
	{
		return $this->name;
	}
		 
/*
**************************
*/
 	
	public function get_zip()
	{
		return $this->zip_file;
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
 	
	public function get_changes()
	{
		return $this->changes;
	}
	

}
?>