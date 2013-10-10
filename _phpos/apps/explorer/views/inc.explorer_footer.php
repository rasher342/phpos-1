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


		$layout->set_id('phpos_explorer_footer');
		$footer_data = '<img src="'.$html['footer_protocol_icon'].'" style="display:block-inline;vertical-align:middle;padding-top:10px"/><span style="font-weight:bold;">'.$html['footer_address'].'</span>';
		echo $layout->footer($footer_data, true); 
		echo $layout->end('footer');
?>	