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

 
?>
<style>
<?php
$menuicons_dir = THEME_DIR.'menuicons/*.png';
$glob_dir = glob($menuicons_dir);

foreach($glob_dir as $png)
{
	echo '.icon-'.str_replace('.png', '', basename($png)).' { background: url(\''.THEME_URL.'menuicons/'.basename($png).'\')  no-repeat center center; }';
	echo '.context-menu-item.icon-'.str_replace('.png', '', basename($png)).' { background-image: url(\''.THEME_URL.'menuicons/'.basename($png).'\'); }';
}

?>
</style>