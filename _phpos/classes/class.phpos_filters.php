<?php

class filter {


	public static function num($str)
	{
		$num = preg_replace("/[^0-9]/","", trim($str)); 	
		settype($num, 'integer');
		return $num;
	}
	
	public static function alfanum($str)
	{
		return preg_replace("/[^a-zA-Z0-9]/", "", trim($str));
	}
	
	public static function alfa($str)
	{
		return preg_replace("/[^a-zA-Z]/", "", trim($str));
	}
	
	public static function alfas($str)
	{
		return preg_replace("/[^a-zA-Z-_]/", "", trim($str));
	}
	
	public static function utf($str)
	{
		return preg_replace("/[^A-Z0-9a-z_ -\w ]/u", "", trim($str));
	}	
	
	public static function fname($str)
	{
		$replace_array = array('\\','/','^','*','<','>','|');		
		return trim(str_replace($replace_array,'_',$str));
	}

}
?>