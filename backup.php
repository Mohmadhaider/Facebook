<?php
session_start();
include_once 'src/Google_Client.php';
include_once 'src/contrib/Google_Oauth2Service.php';
require_once 'src/contrib/Google_DriveService.php';

$client = new Google_Client();
$client->setClientId('534209108294-ndcesbksb7k8rv571dcsnfnhir2bhim3.apps.googleusercontent.com');
$client->setClientSecret('hMpLy9PvCEqeHOsmYL5zJKOq');
$client->setRedirectUri('https://rtdeveloper.000webhostapp.com/backup.php');
$client->setScopes(array('https://www.googleapis.com/auth/drive.file'));


if (isset($_GET['code']) || (isset($_SESSION['access_token_google']))) {
	
	
	$service = new Google_DriveService($client);
    if (isset($_GET['code'])) {
		$client->authenticate($_GET['code']);
		$_SESSION['access_token_google'] = $client->getAccessToken();		
    } else
        $client->setAccessToken($_SESSION['access_token_google']);
	
    
    //Insert a file
    $fileName='facebook_'.$_SESSION['user_name'].'_albums.zip';
	$file = new Google_DriveFile();
    $file->setTitle($fileName);
    $file->setMimeType('application/zip');
    $file->setDescription('A User Details is uploading in json format');
	//print_r($file);
    //exit;
   
    $createdFile = $service->files->insert($file, array(
          'data' =>file_get_contents($_SESSION['zip_file2']),
          'mimeType' => 'application/zip',
		  'uploadType'=>'multipart'
        ));
		
	//unlink($fileName);
    header('location:home.php');
	//print_r($createdFile);

} else {
    $authUrl = $client->createAuthUrl();
    header('Location: ' . $authUrl);
    exit();
}

?>