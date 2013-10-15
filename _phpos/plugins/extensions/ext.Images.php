<?php
/*
**********************************

	PHPOS Web Operating system
	MIT License
	(c) 2013 Marcin Szczyglinski
	szczyglis83@gmail.com
	GitHUB: https://github.com/phpos/
	File version: 1.0.0, 2013.10.09
 
**********************************
*/
if(!defined('PHPOS'))	die();	


$extPlugin = 'Images';
$extPluginTypes = array('jpg','jpeg','bmp', 'png', 'tga', 'gif', 'tiff');


$extPluginRenderRewrite = '			
				<div title="%fullname%" class="easyui-tooltip phpos_icon %class%"  style="%style%" id="%div">
					<a href="%url%" ondblclick="%action%" data-lightbox="image-1">
					<img src="%icon%" />
					<br />%shortname%
					</a>
				</div>
';	

?>