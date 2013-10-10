<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
</head>
<body>

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
		return preg_replace("/[^A-Z0-9a-z_-\w ]/u", "", trim($str));
	}
	
	public static function fname($str)
	{
		$allowed = "A-Z0-9a-z_\- \^=\+@!;\{\}\&\(\)\[\]\.,";
		return preg_replace("/[^".$allowed."\w ]/u", "", trim($str));
	}

}



$a = 'sdf3!!@...  .#564---$ęęóóó{};%,,,,^&  4s=+sę//\\\ęóó11fd3';

echo filter::fname($a);






?>
</body>
</html>