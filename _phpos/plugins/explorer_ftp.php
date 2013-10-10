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


	if(!defined('PHPOS_EXPLORER_PLUGIN')) die();

	$items = null;
		
	$ftp = new phpos_ftp;
	$records = $ftp->get_my_ftp();

		 
/*
**************************
*/
 	

	if(count($records) != 0)
	{
		foreach($records as $row)
		{
			$items.= '<li data-options="iconCls:\'icon-ftpfolder\'"><span><a title="'.$row['title'].' '.$row['host'].'"href="javascript:void(0);" onclick="'.link_action('index', 'dir_id:.,ftp_id:'.$row['id'].',fs:ftp').'"><span style="color: black">'.$row['title'].'</span></a></span></li>';
		} 

	} else {
		
		$items.= '<li data-options="iconCls:\'icon-blank\'"><span>'.$txt['ftp_no_accounts'].'</span></li>';
	}

		 
/*
**************************
*/
 	
	$html['left_tree'].= '<br/><br/>
	<ul id="tt2" class="easyui-tree">
		<li data-options="iconCls:\'icon-network\'">
					 <span><a title="'.$txt['ftp_folders'].'" href="javascript:void(0);" onclick="'.link_action('ftp', 'shared_id:0,workgroup_id:0,fs:ftp').'"><span style="color: black;"><b>'.$txt['ftp_folders'].'</b></span></a></span>
					<ul>
					'.$items.'
					</ul>
		</li>
	</ul>';

	$items = null;
?>