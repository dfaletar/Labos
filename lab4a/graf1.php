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
}

	$link= mysql_connect("localhost", "root", "root") or die("Neuspjela konekcija");

	mysql_select_db("ljekarna") or die("Neuspjelo otvaran je baze");
	
	$upit = "SELECT * FROM podaci WHERE spol = 'M'";
	
	$result = mysql_query($upit, $link) or die("Neuspješno");
	
	$muskih=mysql_num_rows($result);
	
	$upit = "SELECT * FROM podaci WHERE spol <> 'M'";
	
	$result = mysql_query($upit, $link) or die("Neuspješno");
	
	$zenskih=mysql_num_rows($result);
	
	 

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
		  // create an array of values for the chart. These values 
		  // could come from anywhere, POST, GET, database etc. 
		  $values = array($muskih,$zenskih); 

		  // now we get the number of values in the array. this will 
		  // tell us how many columns to plot 
			$columns  = count($values); 

		  // set the height and width of the graph imag
		  $width = 300; 
		  $height = 200; 


		  $ukupno = $muskih + $zenskih;
		  $postoM = $muskih / $ukupno * 360;
		  $postoZ = $zenskih / $ukupno * 360;

		  $image = imagecreate(250, 250); 
		  $background = imagecolorallocate($image, 255, 255, 255); 

		  $navy = imagecolorallocate($image, 0x00, 0x00, 0x80);
		  $darknavy = imagecolorallocate($image, 0x00, 0x00, 0x50);
		  $red = imagecolorallocate($image, 0xFF, 0x00, 0x00);
		  $darkred = imagecolorallocate($image, 0x90, 0x00, 0x00);

		  for ($i = 170; $i > 150; $i--) {
			imagefilledarc($image, 150, $i, 200, 100, 0, $postoM, $darkred, IMG_ARC_PIE);
			imagefilledarc($image, 150, $i, 200, 100, $postoM, 360 , $darknavy, IMG_ARC_PIE);
		  }

		  imagefilledarc($image, 150, 150, 200, 100, 0, $postoM, $red, IMG_ARC_PIE);
		  imagefilledarc($image, 150, 150, 200, 100, $postoM, 360 , $navy, IMG_ARC_PIE);

		  imagepng($image,"graf1.png",0);
		  echo("<img src=graf1.png>");
?>
	</div>
</nav>

<footer class="site-footer">
		<h4>Copyright ZKD, 2014</h4>
	</footer>

</body>
</html>