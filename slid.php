<!DOCTYPE html>
<html>
<title>W3.CSS</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<style>
.mySlides {display:none}
.w3-left, .w3-right, .w3-badge {cursor:pointer}
.w3-badge {height:13px;width:13px;padding:0}
</style>
<body>

<div class="w3-content w3-display-container" style="max-width:800px">
  <?php

	session_start();
	$number=$_GET["no"]+1;
	$imgs=explode(";",$_SESSION["img_data"]);
	$cnt=0;
	foreach($imgs as $img)
	{
		if($img=="Next albums")
		{
			$cnt++;
			continue;
		}
		if($cnt==$number)
		{
			echo "<img class='mySlides' src=$img  height='640px' width='800px'>";//$img."<br><br>";
		}
	}

?>
  
  <div class="w3-center w3-container w3-section w3-large w3-text-white w3-display-bottommiddle" style="width:100%">
    <div class="w3-left w3-hover-text-khaki" onclick="plusDivs(-1)" style="color:black">&#10094;</div>
    <div class="w3-right w3-hover-text-khaki" onclick="plusDivs(1)" style="color:black">&#10095;</div>
  </div>
</div>

<script>
var slideIndex = 1;
showDivs(slideIndex);

function plusDivs(n) {
  showDivs(slideIndex += n);
}

function currentDiv(n) {
  showDivs(slideIndex = n);
}

function showDivs(n) {
  var i;
  var x = document.getElementsByClassName("mySlides");
  var dots = document.getElementsByClassName("demo");
  if (n > x.length) {slideIndex = 1}    
  if (n < 1) {slideIndex = x.length}
  for (i = 0; i < x.length; i++) {
     x[i].style.display = "none";  
  }
  for (i = 0; i < dots.length; i++) {
     dots[i].className = dots[i].className.replace(" w3-white", "");
  }
  x[slideIndex-1].style.display = "block";  
  dots[slideIndex-1].className += " w3-white";
}
</script>

</body>
</html> 