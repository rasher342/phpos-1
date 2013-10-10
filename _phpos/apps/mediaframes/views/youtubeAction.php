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


function parse_yturl($url) 
{
    $pattern = '#^(?:https?://)?(?:www\.)?(?:youtu\.be/|youtube\.com(?:/embed/|/v/|/watch\?v=|/watch\?.+&v=))([\w-]{11})(?:.+)?$#x';
    preg_match($pattern, $url, $matches);
    return (isset($matches[1])) ? $matches[1] : false;
}

$u = parse_yturl($url); 

$jquery = "
		
		var media_width = 600;
		var media_height = 400;
		
		var url = '".$u."';
		var media_left = ($(window).width()/2)-(media_width/2);
    var media_top = ($(window).height()/2)-(media_height/2);
		
		var w = window.open('http://www.youtube.com/embed/".$u."?autoplay=1', 'PHPOS: yt'+Math.random(),'top='+media_top+',left='+media_left+',resizable=no, height='+media_height+',width='+media_width);
		w.focus();
		".winclose(WIN_ID)."
		";
		
		$my_app->jquery_onready($jquery);

?>