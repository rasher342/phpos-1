<?php
/*
**********************************

	PHPOS Web Operating system
	MIT License
	(c) 2013 Marcin Szczyglinski
	szczyglis83@gmail.com
	GitHUB: https://github.com/phpos/
	File version: 1.2.6, 2013.10.16
 
**********************************
*/
if(!defined('PHPOS'))	die();	

	$html['addressbar'] = $explorer->render_address_url();
	$html['footer_address'] = $explorer->render_address_links();
	$html['footer_protocol_icon'] = $explorer->get_icon_protocol();
	$html['protocol_icon'] = $explorer->get_icon_protocol();
		 
/*
**************************
*/
 	
	// Protocol icon
	
	if(!empty($address_icon)) 
	{
		$html['protocol_icon'] = $address_icon;
		$html['footer_protocol_icon'] = $address_icon;
	}
	
	$html['protocol_bg'] = '';	
	$html['navbar'] = $explorer->render_nav_bar();
?>