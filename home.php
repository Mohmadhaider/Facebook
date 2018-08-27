<?php 	@session_start();

	
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>User Profile</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
	<style>#myProgress {
  width: 100%;
  background-color: #ddd;
}

#myBar {
  width: 10%;
  height: 30px;
  background-color: #4CAF50;
  text-align: center;
  line-height: 30px;
  color: white;
}</style>
</head>
<body style='background-color:royalblue'><center><div style='margin-right:25%; margin-left:25%; margin-top:10%;margin-bottom:15%; background-color:white;'><br><br><form action='#'>
	<ul>
		<?php
			
			$arr=explode(";",$_SESSION["userData"]);
			$i=0;
			for($i=0;$i<count($arr)-1;$i++)
			{
				echo "<li><input type='checkbox' value=$i name='checkbox$i'/> - <a href='slide.php?no=$i'>".$arr[$i]."</a><button name='download' value=$i>Download</button></li><br>";
			}
			?></ul>
			<?php echo "<button name='download_select' >Download Selected</button><button name='download_all' value=".($i-1).">Download All</button><br><button name='upload_select' >Upload Selected</button><button name='upload_all' value=".($i-1).">Upload All</button>";
			
			if(isset($_REQUEST["upload"]))
			{
				$number=$_REQUEST["upload"]+1;
				$_SESSION['alb_name']=$arr[$number-1];
				if(!is_dir('upload_img/Albums/facebook_'.$_SESSION['user_name'].'_album/'.$number.'/'.$arr[$number-1]))
					mkdir('upload_img/Albums/facebook_'.$_SESSION['user_name'].'_album/'.$number.'/'.$arr[$number-1],0777,true);
				$imgs=explode(";",$_SESSION["img_data"]);
				$cnt=0;
				set_error_handler("customError");
				foreach($imgs as $img)
				{
					if($img=="Next albums")
					{ 
						$cnt++;
						continue;
					}
					if($cnt==$number)
					{
						$url=$img;
						$image='upload_img/Albums/facebook_'.$_SESSION['user_name'].'_album/'.$number.'/'.$arr[$number-1].'/'.getDate()[0].microtime().'.jpg';
						file_put_contents($image, file_get_contents($url));
					}
				}
				set_error_handler("customError");
				create_zip_for_upload('upload_img/Albums');
				delete_files('upload_img/Albums');

			}
			if(isset($_REQUEST["upload_all"]))
			{
				$number=$_REQUEST["upload_all"];
	echo $number;
				$imgs=explode(";",$_SESSION["img_data"]);
				$cnt=-1;
				foreach($imgs as $img)
				{
					if($img=="Next albums")
					{ 
						$cnt++;
						continue;
					}
					if($cnt==$number)
					{
						if(!is_dir('upload_img/Albums/facebook_'.$_SESSION['user_name'].'_album/'.$arr[$cnt]))
							mkdir('upload_img/Albums/facebook_'.$_SESSION['user_name'].'_album/'.$arr[$cnt],0777,true);
						$url=$img;
						$image='upload_img/Albums/facebook_'.$_SESSION['user_name'].'_album/'.$arr[$cnt].'/'.getDate()[0].microtime().'.jpg';
						file_put_contents($image, file_get_contents($url));
					}
				}
				

set_error_handler("customError");
create_zip_for_upload('upload_img/Albums');
delete_files('upload_img/Albums');

			}
			if(isset($_REQUEST["upload_select"]))
			{
				for($j=0;$j<$i;$j++)
				{
					if(isset($_REQUEST['checkbox'.$j]))
					{
						$number=$j;
				$_SESSION['alb_name']=$arr[$number];
				if(!is_dir('upload_img/Albums/Selected/facebook_'.$_SESSION['user_name'].'_album/'.$arr[$number]))
					mkdir('upload_img/Albums/Selected/facebook_'.$_SESSION['user_name'].'_album/'.$arr[$number],0777,true);
				$imgs=explode(";",$_SESSION["img_data"]);
				$cnt=0;
				foreach($imgs as $img)
				{
					if($img=="Next albums")
					{ 
						$cnt++;
						continue;
					}
					if($cnt==$number+1)
					{
						$url=$img;
						$image='upload_img/Albums/Selected/facebook_'.$_SESSION['user_name'].'_album/'.$arr[$number].'/'.getDate()[0].microtime().'.jpg';
						file_put_contents($image, file_get_contents($url));
					}
				}
					}
				
				}
				set_error_handler("customError");
				create_zip_for_upload('upload_img/Albums/Selected');
				delete_files('upload_img/Albums/Selected');
			
			}
			
			if(isset($_REQUEST["download_select"]))
			{
			     
			     progress();
				for($j=0;$j<$i;$j++)
				{
					if(isset($_REQUEST['checkbox'.$j]))
					{
						$number=$j;
				$_SESSION['alb_name']=$arr[$number];
				if(!is_dir('New Folder/Albums/Selected/'.$_SESSION['user_name'].'/'.$arr[$number]))
					mkdir('New Folder/Albums/Selected/'.$_SESSION['user_name'].'/'.$arr[$number],0777,true);
				$imgs=explode(";",$_SESSION["img_data"]);
				$cnt=0;
				foreach($imgs as $img)
				{
					if($img=="Next albums")
					{ 
						$cnt++;
						echo "Aulbm no ".$cnt;
						continue;
					}
					if($cnt==$number+1)
					{
						$url=$img;
						$image='New Folder/Albums/Selected/'.$_SESSION['user_name'].'/'.$arr[$number].'/'.getDate()[0].microtime().'.jpg';
						file_put_contents($image, file_get_contents($url));
					}
				}
					}
				
				}
				set_error_handler("customError");
				create_zip('New Folder/Albums/Selected');
				delete_files('New Folder/Albums/Selected/');
			}
			if(isset($_REQUEST["download"]))
			{
				progress();
				$number=$_REQUEST["download"]+1;
				$_SESSION['alb_name']=$arr[$number-1];
				if(!is_dir('New Folder/Albums/'.$_SESSION['user_name'].'/'.$number.'/'.$arr[$number-1]))
					mkdir('New Folder/Albums/'.$_SESSION['user_name'].'/'.$number.'/'.$arr[$number-1],0777,true);
				$imgs=explode(";",$_SESSION["img_data"]);
				$cnt=0;
				set_error_handler("customError");
				foreach($imgs as $img)
				{
					if($img=="Next albums")
					{ 
						$cnt++;
						continue;
					}
					if($cnt==$number)
					{
						$url=$img;
						$image='New Folder/Albums/'.$_SESSION['user_name'].'/'.$number.'/'.$arr[$number-1].'/'.getDate()[0].microtime().'.jpg';
						file_put_contents($image, file_get_contents($url));
					}
				}
				set_error_handler("customError");
				create_zip('New Folder/Albums/'.$_SESSION['user_name'].'/'.$number);
				delete_files('New Folder/Albums/'.$_SESSION['user_name']);
}
function create_zip($url)
				{
				if(!is_dir('Zips/users/'.$_SESSION['user_name']))
					mkdir('Zips/users/'.$_SESSION['user_name'],0777,true);
				$_SESSION['zips']='Zips/users/'.$_SESSION['user_name'].'/';
				delete_files($_SESSION['zips']);
				$rootPath = realpath($url);
				$zip = new ZipArchive();
				if(!is_dir('Zips/users/'.$_SESSION['user_name']))
					mkdir('Zips/users/'.$_SESSION['user_name'],0777,true);
				$name='Zips/users/'.$_SESSION['user_name'].'/'.$_SESSION['user_name']."_".getDate()[0].'.zip';
				$_SESSION['zip_file']='Zips/users/'.$_SESSION['user_name'].'/'.$_SESSION['user_name']."_".getDate()[0].'.zip';
				$zip->open($name, ZipArchive::CREATE | ZipArchive::OVERWRITE);
				$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($rootPath),RecursiveIteratorIterator::LEAVES_ONLY);
				foreach ($files as $name => $file)
				{
					if (!$file->isDir())
					{
						$filePath = $file->getRealPath();
						$relativePath = substr($filePath, strlen($rootPath) + 1);
						$zip->addFile($filePath, $relativePath);
					}
				}
				$zip->close();
				
				echo "Click <a href='download.php?zip_file=".$_SESSION["zip_file"]."' name='download_link'>here</a> to download<br>";
				}


/* 
 * php delete function that deals with directories recursively
 */
 function create_zip_for_upload($url)
				{
				if(!is_dir('Zips_upload/users'))
					mkdir('Zips_upload/users',0777,true);
				$_SESSION['zips']='Zips_upload/users/';
				//delete_files($_SESSION['zips']);
				$rootPath = realpath($url);
				$zip = new ZipArchive();
				if(!is_dir('Zips_upload/users'))
					mkdir('Zips_upload/users',0777,true);
				$name='Zips_upload/users/facebook_'.$_SESSION['user_name'].'_album.zip';
				$_SESSION['zip_file2']='Zips_upload/users';
				$zip->open($name, ZipArchive::CREATE | ZipArchive::OVERWRITE);
				$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($rootPath),RecursiveIteratorIterator::LEAVES_ONLY);
				foreach ($files as $name => $file)
				{
					if (!$file->isDir())
					{
						$filePath = $file->getRealPath();
						$relativePath = substr($filePath, strlen($rootPath) + 1);
						$zip->addFile($filePath, $relativePath);
					}
				}
				$zip->close();
				
				echo "Click <a href='backup.php' name='download_link'>here</a> to Upload<br>";
				}


function delete_files($target) {
try{
    if(is_dir($target)){
        $files = glob( $target . '*', GLOB_MARK ); //GLOB_MARK adds a slash to directories returned

        foreach( $files as $file ){
            delete_files( $file );      
        }

        rmdir( $target );
set_error_handler("customError");
    } elseif(is_file($target)) {
        unlink( $target );  
    }
set_error_handler("customError");
}
catch(Exception $e)
{
 echo "Success";
}
}
				
if(isset($_REQUEST["download_all"]))
{
    progress();
	$number=$_REQUEST["download_all"];
	echo $number;
	$imgs=explode(";",$_SESSION["img_data"]);
				$cnt=-1;
				foreach($imgs as $img)
				{
					if($img=="Next albums")
					{ 
						$cnt++;
						continue;
					}
					if(true)
					{
						if(!is_dir('New Folder/Albums/'.$_SESSION['user_name'].'/'.$arr[$cnt]))
							mkdir('New Folder/Albums/'.$_SESSION['user_name'].'/'.$arr[$cnt],0777,true);
						$url=$img;
						$image='New Folder/Albums/'.$_SESSION['user_name'].'/'.$arr[$cnt].'/'.getDate()[0].microtime().'.jpg';
						file_put_contents($image, file_get_contents($url));
					}
				}
		
set_error_handler("customError");
create_zip('New Folder');
delete_files('New Folder/Albums/'.$_SESSION['user_name']);
}
function customError($errno, $errstr) {
   echo "";
}

//set error handler
set_error_handler("customError");

		
function progress()
{?>
    <div id="myProgress">
  <div id="myBar">10%</div>
</div>

<br>

<script>
  var elem = document.getElementById("myBar");   
  var width = 10;
  var id = setInterval(frame, 100);
  function frame() {
    if (width >= 50) {
      clearInterval(id);
    } else {
      width++; 
      elem.style.width = width + '%'; 
      elem.innerHTML = width * 1  + '%';
    }
  }
</script>
<?php }
		?>
	</form><br><br></div>
	</center>
</body>
</html>