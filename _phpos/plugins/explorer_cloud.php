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


/*
if(!defined('PHPOS_EXPLORER_PLUGIN')) die();

	// local_files
	$global_fs = $my_app->get_param('fs');
	$dir_id = $my_app->get_param('dir_id');
	
	
	$closed = '';
	
	$my_fs = 'local_files';
	$filesystem_class = 'phpos_fs_plugin_'.$my_fs;	
	
	$treeFS = new $filesystem_class; // start filesytem		
	$tree_explorer = new app_explorer;
	$tree_explorer->set_fs($my_fs);
	
	$tree_explorer->assign_filesystem($treeFS);
	$tree_explorer->assign_window($apiWindow);
	$tree_explorer->assign_my_app($my_app);		
	
	$root_id = $treeFS->get_root_directory_id();
	
	if($dir_id == $root_id || $global_fs != $my_fs)
	{
		$closed = ',state:\'closed\'';
	}

	
	$tree_local_files = '
	<li data-options="iconCls:\'icon-disk\''.$closed.'">
	<span><a title="" href="javascript:void(0);" onclick="phpos.windowActionChange(\''.$apiWindow->getID().'\', \'cloud\', \'reset_google_token:1\')"><span style="color: black; font-weight:bold">Google Drive</span></a></span>			
	
	</li>
	';
	
	
	
	$html['left_tree'].= '<br/><br/>
	<ul id="tt" class="easyui-tree">	
	
		<li data-options="iconCls:\'icon-myserver\'">
									
					<span><a href="javascript:void(0);" onclick="phpos.windowActionChange(\''.$apiWindow->getID().'\', \'cloud\')"><span style="color:black"><b>Cloud</b></span></a></span>
					
					<ul>
					
							'.$tree_local_files.'			
						
					</ul>
		</li>	
	
	</ul>';


	
	*/
	
	
	
	
	
	
	
	
	
	
	
	
	

if(!defined('PHPOS_EXPLORER_PLUGIN')) die();

$items = null;
	
$clouds = new phpos_clouds;
$records = $clouds->get_my_clouds();



if(count($records) != 0)
{
	foreach($records as $row)
	{
		/*
		$items.= '<li data-options="iconCls:\'icon-ftpfolder\'"><span><a title="'.$row['title'].' '.$row['host'].'"href="javascript:void(0);" onclick="phpos.windowActionChange(\''.WIN_ID.'\', \'cloud\', \'reset_google_token:1, cloud_type:'.$row['cloud'].'\')"><span style="color: black; font-weight:bold"><b>'.$row['title'].'</b></span></a></span></li>';
		*/
		
		/*
		$items.= '<li data-options="iconCls:\'icon-ftpfolder\'"><span><a title="'.$row['title'].' '.$row['host'].'"href="javascript:void(0);" onclick="'.link_action('index', 'dir_id:.,ftp_id:'.$row['id'].',fs:clouds_google_drive').'"><span style="color: black; font-weight:bold"><b>'.$row['title'].'</b></span></a></span></li>';
		*/
		
		$items.= '<li data-options="iconCls:\'icon-ftpfolder\'"><span><a title="'.$row['title'].'" href="javascript:void(0);" onclick="alert(\'Sorry, this feature will be available in next updates.\')"><span style="color: black;">'.$row['title'].'</span></a></span></li>';
	} 

} else {
	
	$items.= '<li data-options="iconCls:\'icon-blank\'"><span>'.$txt['cloud_no_accounts'].'</span></li>';
}



/*
$html['left_tree'].= '<br/><br/>
<ul id="tt2" class="easyui-tree">
	<li data-options="iconCls:\'icon-network\'">
         <span><a title="'.$txt['cloud_folders'].'" href="javascript:void(0);" onclick="phpos.windowActionChange(\''.WIN_ID.'\', \'cloud\')"><span style="color: black; font-weight:bold"><b>'.$txt['cloud_folders'].'</b></span></a></span>
				<ul>
				'.$items.'
				</ul>
	</li>
</ul>';
*/

$html['left_tree'].= '<br/><br/>
<ul id="tt2" class="easyui-tree">
	<li data-options="iconCls:\'icon-network\'">
         <span><a title="'.$txt['cloud_folders'].'" href="javascript:void(0);" onclick="alert(\'Sorry, this feature will be available in next updates.\')"><span style="color: black;"><b>'.$txt['cloud_folders'].'</b></span></a></span>
				<ul>
				'.$items.'
				</ul>
	</li>
</ul>';
$items = null;

?>