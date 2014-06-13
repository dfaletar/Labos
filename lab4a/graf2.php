<?php

// Inialize session
session_start();

if(!(isset($_SESSION['usr']) && isset($_SESSION['pswd']))){
	header('Location: login.html');
}

if(empty($_GET["page"]))
	$page = "";
else
	$page = $_GET["page"];

function getUrl($page){
	return "?page=$page";
}

switch($page){
	case "odjava":
		session_unset();
		session_destroy();
		header("location:login.html");
		break;

	/* Ovo se izvodi ako se upise nepostojeca stranica */
	default:
	$neki_sadrzaj = "Stranica ne postoji";
		
	$link= mysql_connect("localhost", "root", "root") or die("Neuspjela konekcija");

	mysql_select_db("ljekarna") or die("Neuspjelo otvaranjebaze");
	
	$upit = "SELECT krvnaGrupa, count(id) FROM podaci GROUP BY krvnaGrupa";
	
	$i=0;
  if($result = mysql_query($upit, $link)) {
    while($row = mysql_fetch_array($result)){
      $values[] = $row[1];
    }
    mysql_free_result($result);
  }
          
  mysql_close($link);
}
?>

<!DOCTYPE html>
<html>
<head>
	<title><?php echo $title; ?></title>
	 <meta charset="UTF-8" />
	 <link rel="stylesheet" href="stil.css">
	 <script>
	function prikazi(_id) {
		var x = document.getElementById(_id);
		/*if(x.style.visibility == 'visible')
			x.style.visibility = 'hidden';
		else x.style.visibility = 'visible';*/
		if(x.style.display == 'table')
			x.style.display = 'none';
		else x.style.display = 'table';
	}
	function sakrij(_id) {
		var x = document.getElementById(_id);
		x.style.zIndex = -9999;
		x.style.visibility = 'hidden';
	}
	</script>
</head>
<header class="site-header">
	
	<div class="logo">
	<a href="<?php echo getUrl("index"); ?>"><img src="logo.png" width="200px;" alt="logo"></a>
	</div>
	
	<div class="ime">
		<h4><?php echo $_SESSION["usr"]; ?>
		<button><a href="<?php echo getUrl("odjava"); ?>">Odjavi se</a></button></h4>
	</div>


</header>
<body>
<nav class="navigation1">
	
	<div class="main-navigation">
		<a href="login.php"><li>Početna</li></a>
		<a href="zivotopis.php"><li>Životopis</li></a>
		<a href="popis_pacijenata.php"><li>Popis pacijenata</li></a>
		<a href="formular_za_pacijenta.php"><li>Formular za unos pacijenta</li></a>
		<a href="pdf.php"><li>PDF</li></a>
		<a href="graf1.php"><li>Graf omjer M/Ž</li></a>
		<a href="graf2.php"><li>Graf omjer krvne grupe</li></a>

	</div>
	<div class="sadrzaj">
		<?php
		// tell us how many columns to plot 
			$columns  = count($values); 

		  // set the height and width of the graph image 

			$width = 300; 
			$height = 200; 

		  // Set the amount of space between each column 
			$padding = 5; 

		  // Get the width of 1 column 
			$column_width = $width / $columns ; 

		  // set the graph color variables 
			$im        = imagecreate($width,$height); 
			$gray      = imagecolorallocate ($im,0xcc,0xcc,0xcc); 
			$gray_lite = imagecolorallocate ($im,0xee,0xee,0xee); 
			$gray_dark = imagecolorallocate ($im,0x7f,0x7f,0x7f); 
			$white     = imagecolorallocate ($im,0xff,0xff,0xff); 

		  // set the background color of the graph 
			imagefilledrectangle($im,0,0,$width,$height,$white); 


		  // Calculate the maximum value we are going to plot 
		  $max_value = max($values);

		  // loop over the array of columns 
			for($i=0;$i<$columns;$i++) 
				{
			// set the column hieght for each value 
				$column_height = ($height / 100) * (( $values[$i] / $max_value) *100); 
			// now the coords
				$x1 = $i*$column_width; 
				$y1 = $height-$column_height; 
				$x2 = (($i+1)*$column_width)-$padding; 
				$y2 = $height; 

				// write the columns over the background 
				imagefilledrectangle($im,$x1,$y1,$x2,$y2,$gray); 

				// This gives the columns a little 3d effect 
				imageline($im,$x1,$y1,$x1,$y2,$gray_lite); 
				imageline($im,$x1,$y2,$x2,$y2,$gray_lite); 
				imageline($im,$x2,$y1,$x2,$y2,$gray_dark); 
				} 
		   // set the correct png headers 
		  imagepng($im,"graf2.png",0);
		  echo("<img src=graf2.png>");
?>
	</div>
</nav>

<footer class="site-footer">
		<h4>Copyright ZKD, 2014</h4>
	</footer>

</body>
</html>