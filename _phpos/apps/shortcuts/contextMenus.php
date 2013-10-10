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


if(!defined("PHPOS_IN_EXPLORER"))
{
	die();
}

	$contextMenus['FILE'] = array(		
			'debug::'.txt('debug').'::alert("'.$icon['div'].':'.$icon['id'].'");::open',
			'open::'.txt('open').'::delete_file("'.$item.'");::open',
			'open_with::'.txt('open_with').'::alert();::icon',
				array('openwith1::Notatnik::alert();', 'openwith2::Word2::alert();'),	
			'---',
			'rename::'.txt('rename').'::rename_file("'.$icon['id'].'", "'.$icon['name'].'");::rename',		
			'chmod::'.txt('privilleges').' (chmod)::chmod_file("'.$icon['id'].'", "'.$icon['name'].'");::rename',					
			'download::'.txt('download').'::download_file("'.base64_encode($icon['id']).'");::download',			
			'delete::'.txt('delete').'::delete_file("'.$icon['id'].'");::delete'	
	);			


	$contextMenus['DIR'] = array(		
			//'open::Otwórz folder::phpos.windowRefresh("'.$apiWindow->getID().'","dir_id:'.$phposFS->addLastSlash($icons[$i]['id']).'");::open',			
			'rename::'.txt('rename').'::rename_file("'.$icon['id'].'", "'.$icon['title'].'");::rename',			
			'delete::'.txt('delete').'::delete_file("'.$icon['id'].'");::delete'
	);	

	$contextMenus['WINDOW'] = array(		
			'newdir::'.txt('new_folder').'::newfolder();::add'	
	);
	

?>