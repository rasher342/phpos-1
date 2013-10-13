<?php
session_start();

$_SESSION['PHPOS_NETURL'] = 'http://localhost/google.php';
echo 'NETURL:'.$_SESSION['PHPOS_NETURL'].'<BR>';
require_once '_phpos/classes/google-api-php-client/src/Google_Client.php';
require_once '_phpos/classes/google-api-php-client/src/contrib/Google_DriveService.php';

$client = new Google_Client();
// Get your credentials from the APIs Console
$client->setClientId('893916972523.apps.googleusercontent.com');
$client->setClientSecret('S_VgFbW1Ycax8sWJOjcVznZd');
$client->setRedirectUri($_SESSION['PHPOS_NETURL']);
$client->setScopes(array('https://www.googleapis.com/auth/drive'));

$service = new Google_DriveService($client);

// Exchange authorization code for access token


//$plus = new Google_PlusService($client);

if(isset($_GET['code'])) {
	$_SESSION['google_token'] = $_GET['code'];
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