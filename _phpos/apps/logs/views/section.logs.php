<?php
/*
**********************************

	PHPOS Web Operating system
	MIT License
	(c) 2013 Marcin Szczyglinski
	szczyglis83@gmail.com
	GitHUB: https://github.com/phpos/
	File version: 1.0.1, 2013.10.11
 
**********************************
*/
if(!defined('PHPOS'))	die();	


echo $layout->title(txt('logs_app_title'), 'icon.png'); 
echo $layout->txtdesc(txt('logs_app_title_desc'));
	
	
$logs = new phpos_logs;
$logs_dir = $logs->get_logs_dir();
	
	echo $layout->column('70%');	
	
	$log_file_id = $my_app->get_param('log_id');
	
	if(!empty($log_file_id))
	{		
		$today = '';
		if($logs->is_today_date($my_app->get_param('year_id'), $my_app->get_param('month_id'), $my_app->get_param('day_id'))) $today = ' <span style="font-weight:bold; color: #1d791e">('.txt('today').')</span>';
						
		$log_title = txt('logs_log_from_title').$my_app->get_param('year_id').' - '.$my_app->get_param('month_id').' - '.$my_app->get_param('day_id').$today;
		echo $layout->subtitle($log_title, ICONS.'logs/section_logs.png');
		echo $layout->txtdesc($txt['logs_list']);
		
			$download_action = browser_url(PHPOS_WEBROOT_URL."phpos_downloader.php?hash=".md5(PHPOS_KEY)."&download_type=".base64_encode('log')."&file=".base64_encode($log_file_id));
			$download_btn = $layout->button(txt('logs_section_btn_download'), $download_action, 'download1');			
			
			$view_action = browser_url('../_phpos/'.str_replace('../','', $log_file_id));
			
			$view_btn = $layout->button(txt('logs_section_btn_see_raw'), $view_action, 'edit');
			
		
		echo $download_btn. '  '.$view_btn;
		
		//echo 'Download raw log file here: <a href="'.$logs->get_logs_url().$log_file_id.'" target="_blank"><b>'.basename($log_file_id).'</b></a>';		
		
		
		//echo nl2br($f);	
		$logs->set_log_dir($my_app->get_param('year_id'), $my_app->get_param('month_id'), $my_app->get_param('day_id'));
		$logs->set_log_file(basename($log_file_id));
		
		$parsed_log = $logs->parse_log_file($log_file_id);		
		echo $layout->tbl_start();
		$layout->td_classes(array(''));
		echo $layout->head(array(txt('logs_section_tbl_id') => '10%', txt('logs_section_tbl_time') => '20%', txt('logs_section_tbl_user') => '25%', txt('logs_section_tbl_ip') => '15%', txt('logs_section_tbl_action') => '20%', txt('logs_section_tbl_session') => '10%'));	
		
		foreach($parsed_log as $log_data)
		{			
			$btn = txt('logs_section_btn_see_session_empty');
			$sessions = new phpos_users;
			if($sessions->is_session_id($log_data['log_session']))
			{
				$action = helper_reload(array('section' => 'sessions', 'id_session' => $log_data['log_session']));	
				$btn = $layout->button(txt('logs_section_btn_see_session'), $action, 'login');
			}			
				
			$tip = '<b>UID:</b> '.$log_data['log_uid'].'<br /><b>'.txt('logs_section_tbl_fulltime').':</b> '.date('Y.m.d H:i:s', intval($log_data['log_timestamp']));
		
			echo $layout->row(array(
				$log_data['log_id'] + 1,
				date('H:i', intval($log_data['log_timestamp'])),
				$log_data['log_ulogin'],
				$log_data['log_ip'],
				$log_data['log_action'],
				$btn
			
			), $tip);			
		}
		
		
		echo $layout->tbl_end();	
	
	}
	
	echo $layout->end('column');	
	
	
echo $layout->column('30%');		
echo $layout->subtitle(txt('logs_log_folders_title'), ICONS.'logs/logfiles.png');
echo $layout->txtdesc(txt('logs_folders'));

$dir = glob($logs_dir.'*');
$years = array();
foreach($dir as $year)
{
	if(is_dir($year))
	{
		$years[] = basename($year);		
	}	
}

if(count($years) != 0)
{
	echo '<ul id="tt" class="easyui-tree">'; 
	
	rsort($years);
	
	foreach($years as $year_number)
	{
		$year_closed = '';
		if($year_number != $my_app->get_param('year_id')) $year_closed = ',state:\'closed\'';		
		
		echo '<li data-options="iconCls:\'icon-folder\''.$year_closed.'">
									
					<span><a href="javascript:void(0);" onclick="'.helper_reload(array('year_id' => $year_number, 'month_id' => null, 'day_id' => null, 'log_id' => null)).'"><span style="color:black"><b>'.$year_number.'</b></span></a></span>';
		
		
		
		
		//echo $year_number.'<br />';
		
		$dir_months = glob($logs_dir.$year_number.'/*');
		$months = array();
		foreach($dir_months as $month)
		{
			if(is_dir($month))
			{
				$months[] = basename($month);				
			}	
		}	
		
		
		if(count($months) != 0)
		{
			echo '<ul>';
			rsort($months);
			foreach($months as $month_number)
			{
				$month_closed = '';
				if($month_number != $my_app->get_param('month_id')) $month_closed = ',state:\'closed\'';						
				
				$month_translated = txt('month_'.intval($month_number));
				echo '<li data-options="iconCls:\'icon-folder\''.$month_closed.'">
				<span><a href="javascript:void(0);" onclick="'.helper_reload(array('year_id' => $year_number, 'month_id' => $month_number, 'day_id' => null, 'log_id' => null)).'"><span style="color:black">'.$month_translated .'</span></a></span>';
				
				
				$dir_days = glob($logs_dir.$year_number.'/'.$month_number.'/*.*');
				
				
				echo '<ul>';
				foreach($dir_days as $day)
				{
					if(!is_dir($day) && basename($day) != 'index.php')
					{
						$days[] = basename($day);
						$log_ext = '.log';
						$day_id = str_replace(array('-', $year_number, $month_number, $log_ext), '', basename($day));
						
						$today = '';
						if($logs->is_today_date($year_number, $month_number, $day_id)) $today = ' <span style="font-weight:bold; color: #1d791e">('.txt('today').')</span>';						
											
						if($my_app->get_param('log_id') != null && $my_app->get_param('log_id') == $day) $day_id = '<b>'.$day_id.'</b>';
						$name = $day_id.$today;				
										
						if(file_exists($day) && !empty($name))
						{
							echo '<li data-options="iconCls:\'icon-file\'">
							<span>
								<a href="javascript:void(0);" onclick="'.helper_reload(array('year_id' => $year_number, 'month_id' => $month_number, 'day_id' => $day_id, 'log_id' => $day)).'"><span style="color:black">'.$name.'</span></a>
							</span></li>';
						}
					}	
				}
				
				echo '</ul>';
		
			echo '</li>';
			
			}
		
				echo '</ul>';
		}

	
	echo '</li>';
	}	

	echo '</ul>';
}

	echo $layout->end('column');	
	
	
	echo $layout->clr();
	
?>