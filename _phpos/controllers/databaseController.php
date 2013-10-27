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


	require_once(PHPOS_DIR.'classes/class.phpos_databases.php');
	
	$database_adapter = "mysql";
	if(!empty($db_adapter)) $database_adapter = $db_adapter;
	
	$adapter_class = PHPOS_DIR.'classes/class.database.'.$database_adapter.'.php';
	if(file_exists($adapter_class))
	{
		require $adapter_class;
	} else {
		die();
	}	
	
	$sql = new phpos_database;
	$sql->set_host($db_host);
	$sql->set_user($db_login);
	$sql->set_password($db_password);
	$sql->set_dbname($db_dbname);
	$sql->set_prefix($db_prefix);
	
	unset($db_host, $db_login, $db_password, $db_dbname, $db_prefix);
	
	$sql->connect() or die();
?>