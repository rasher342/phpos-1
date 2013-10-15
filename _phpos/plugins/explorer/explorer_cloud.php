<?php
/*
**********************************

	PHPOS Web Operating system
	MIT License
	(c) 2013 Marcin Szczyglinski
	szczyglis83@gmail.com
	GitHUB: https://github.com/phpos/
	File version: 1.2.5, 2013.10.15
 
**********************************
*/
if(!defined('PHPOS'))	die();	

if(!defined('PHPOS_EXPLORER_PLUGIN')) die();

$items = null;	
$clouds = new phpos_clouds;
$records = $clouds->get_my_clouds();

	if(count($records) != 0)
	{
		foreach($records as $row)
		{			
			$items.= '<li data-options="iconCls:\'icon-ftpfolder\'"><span><a title="'.$row['title'].' '.$row['host'].'"href="javascript:void(0);" onclick="'.link_action('index', 'dir_id:.,cloud_id:'.$row['id'].',reset_google_token:1,root_id:.,fs:clouds_google_drive').'"><span style="color: black;">'.$row['title'].'</span></a></span></li>';		
		} 

	} else {
		
		$items.= '<li data-options="iconCls:\'icon-blank\'"><span>'.txt('cloud_no_accounts').'</span></li>';
	}

$html['left_tree'].= '<br/><br/>
<ul id="tt2" class="easyui-tree">
	<li data-options="iconCls:\'icon-network\'">
         <span><a title="'.$txt['cloud_folders'].'" href="javascript:void(0);" onclick="'.link_action('clouds', 'shared_id:0,workgroup_id:0,fs:clouds_google_drive').'"><span style="color: black;"><b>'.$txt['cloud_folders'].'</b></span></a></span>
				<ul>
				'.$items.'
				</ul>
	</li>
</ul>';
$items = null;
?>