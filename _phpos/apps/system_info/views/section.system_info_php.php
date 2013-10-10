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


echo $layout->title(txt('cp_system_info_php_title'), 'icon.png'); 
echo $layout->txtdesc(txt('cp_system_info_php_desc'));

ob_start();
phpinfo();
$phpinfo = ob_get_contents();
ob_end_clean();

echo $phpinfo;
?>