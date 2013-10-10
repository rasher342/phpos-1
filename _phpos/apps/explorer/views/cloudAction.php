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
?>			

<?php	
$layout = new phpos_layout;

$layout->set_fit('true');
$layout->set_style('background:transparent');
$layout->set_id('phpos_explorer_window');
?>

<?php echo $layout->start(); ?>	

			<?php include MY_APP_DIR.'views/inc.layout_header.php'; ?>		
			<?php include MY_APP_DIR.'views/inc.explorer_left_tree.php'; ?>			
				
				
			<?php				
			$layout->set_region('center');
			$layout->set_classes('phpos_explorer_files_body');			
			$layout->set_id('phpos_explorer_div'.div(1));
			$layout->set_style('background-image:url('.$html['protocol_bg'].'); background-repeat:no-repeat; background-position:top right');	
			?>
			
			<?php echo $layout->custom(); ?>
			<?php 
			if($readonly) 
			{ 
				echo '<div class="explorer_readonly_info">'.txt('folder_readonly_msg').'</div>'; 
			} 
			?>
			<table width="100%" id="phpos_explorer_files_table_main">
				<tr>

				<td width="100%" valign="top" class="td_icons" id="phpos_explorer_td<?php div();?>">	
					<div id="<?php echo $explorer->config('div_contener');?>" class="icons_contener">
					
					<?php
					
					echo 'NETURL:'.$_SESSION['PHPOS_NETURL'].'<BR>';
require_once PHPOS_DIR.'classes/google-api-php-client/src/Google_Client.php';
require_once PHPOS_DIR.'classes/google-api-php-client/src/contrib/Google_DriveService.php';

$client = new Google_Client();
// Get your credentials from the APIs Console
$client->setClientId('893916972523-dj3h0r941dopsch168dkg74qfdjrl9db.apps.googleusercontent.com');
$client->setClientSecret('4WQAgVdPcXHl2CIcQ7o-LCZ9');
$client->setRedirectUri($_SESSION['PHPOS_NETURL']);
$client->setScopes(array('https://www.googleapis.com/auth/drive'));

$service = new Google_DriveService($client);

// Exchange authorization code for access token


//$plus = new Google_PlusService($client);

if(isset($_SESSION['google_token'])) {
	$_GET['code'] = $_SESSION['google_token'];
  $client->authenticate();
  $_SESSION['token'] = $client->getAccessToken();
  $redirect = $_SESSION['PHPOS_NETURL'];
	unset($_SESSION['google_token']);
  header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
}

if (isset($_SESSION['token'])) {
  $client->setAccessToken($_SESSION['token']);
}

if ($client->getAccessToken()) {
	
	echo 'Connected to your google account.<br />';
  //$activities = $plus->activities->listActivities('me', 'public');
  //print 'Your Activities: <pre>' . print_r($activities, true) . '</pre>';

  // We're not done yet. Remember to update the cached access token.
  // Remember to replace $_SESSION with a real database or memcached.
  $_SESSION['token'] = $client->getAccessToken();
} else {
  $authUrl = $client->createAuthUrl();
  echo "<a href='$authUrl'>Connect Me!</a>";
}


$lista = @$service->files->list();
echo '<pre>';
print_r($lista);
echo '</pre>';

$c = count($lista['items']);
if($c != 0)
{
	foreach($lista['items'] as $f)
	{
		if($f['mimeType'] == 'application/vnd.google-apps.folder')
		{
			echo 'FOLDER: <a href="'.$f['webContentLink'].'" target="_blank">'.$f['title'].'</a><br>';
		} else {
			echo '<a href="'.$f['webContentLink'].'" target="_blank">'.$f['title'].'</a><br>';
		}
	
	}

}
echo $c;


?>					
					
					
					
					
					
					
					
					
					
					
			goooogle
 					<?php	//echo $html_RenderIcons; ?>
					</div>
				</td>

				</tr>
			</table>	
				
		<?php echo $layout->end('custom'); ?>	
		
<?php include MY_APP_DIR.'views/inc.explorer_footer.php'; ?>
		
<?php echo $layout->end('layout'); ?>		


<?php //dbg::show('msg:'.msg::showMessages()); ?>
<?php include MY_APP_DIR.'views/jquery.php'; ?>