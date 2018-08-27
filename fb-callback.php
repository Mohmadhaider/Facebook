<?php
	require_once "config.php";

	try {
		$accessToken = $helper->getAccessToken();
	} catch (\Facebook\Exceptions\FacebookResponseException $e) {
		echo "Response Exception: " . $e->getMessage();
		exit();
	} catch (\Facebook\Exceptions\FacebookSDKException $e) {
		echo "SDK Exception: " . $e->getMessage();
		exit();
	}

	
    $_SESSION["demo"]="Data to display";
	$oAuth2Client = $FB->getOAuth2Client();
	if (!$accessToken->isLongLived())
		$accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
	$user_name = $FB->get("/me?fields=name", $accessToken);
	$userData = $user_name->getGraphNode()->asArray();
	$_SESSION['user_name']=$userData["name"];
	$get_name = $FB->get("/me?fields=albums{name}", $accessToken);
	$userData = $get_name->getGraphNode()->asArray();
	$_SESSION['userData']="";
	$get_images=$FB->get("/me?fields=albums{photos{images}}", $accessToken);
	$image_data=$get_images->getGraphNode()->asArray();
	$_SESSION["img_data"]="";
	$_SESSION['access_token'] = (string) $accessToken;
	$_SESSION["flag"]=1;
	$_SESSION["flag2"]=1;
	display($userData);
	display($image_data);
	function display($data)
	{
		foreach($data as $k=>$v)
		{
			if($k==="photos" and $_SESSION["flag"]==1)
			{
				$_SESSION["img_data"]=$_SESSION["img_data"]."Next albums;";
				$_SESSION["flag"]=0;
			}
			if($k=="images")
				{
					$_SESSION["flag2"]=0;
				}
			if(is_array($v))
			{
				display($v);
			}
			else
			{
				
				
				if($k=="name" || $_SESSION["flag2"]==0)
				{
					if($k=="name")
						$_SESSION["userData"]=$_SESSION["userData"].$v.";";
					if($k=="source"){
						$_SESSION["img_data"]=$_SESSION["img_data"].$v.";";
						$_SESSION["flag"]=1;
						$_SESSION["flag2"]=1;
					}
				}
			}
		}
		
		
	}
	header("location:home.php");
	exit();
?>