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
	<div id="reklama">
			<h1>REKLAMA</h1>
			<form><button type="button" onclick="sakrij('reklama')">Zatvori</button></form>
		</div>
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
		<a href="#osobni_podaci">Osobni podaci</a>
      	<a href="#skolovanje">Podaci o školovanju</a>
      	<a href="#znanja_i_vjestine">Znanja i vještine</a>
      	
		<p onclick="prikazi('osobni_podaci')">Osobni podaci</p>
				<div id="osobni_podaci">
					<table class="cv">			
					<tr>
							<td><b>Ime i prezime:</td>
							<td>Dino Faletar</td>
						</tr>
						<tr>
							<td><b>Mjesto:</td>
							<td>Bjelovar</td>
						</tr>
						<tr>
							<td><b>Datum rođenja:</td>
							<td>23.04.1992</td>
						</tr>
					</table>
				</div>

				<p onclick="prikazi('skolovanje')">Podaci o školovanju</p>
				<div id="skolovanje">
					<table class="cv">
						</tr>
						<tr>
							<td><b>Osnovna škola:</td>
							<td>Osnovna škola Rovišće</td>
						</tr>
						<tr>
							<td><b>Srednja škola:</td>
							<td>Opća gimnazija Bjelovar</td>
						</tr>
						<tr>
							<td><b>Fakultet:</td>
							<td>Tehničko veleučilište u Zagrebu</td>
						</tr>
						<tr>
							<td><b>Smjer:</td>
							<td>Inženjerstvo računalnih sustava i mreža</td>
						</tr>
					</table>
				</div>
				
				<p onclick="prikazi('znanja_i_vjestine')">Znanja i vještine</p>
				<div id="znanja_i_vjestine">
					<table class="cv">
						</tr>
						<tr>
							<td><b>Programiranje:</td>
							<td>C, C#, Java</td>
						</tr>
						<tr>
							<td><b>Baze podataka:</td>
							<td>MySQL</td>
						</tr>
						<tr>
							<td><b>Dizajniranje:</td>
							<td>HTML, CSS</td>
						</tr>
					</table>
				</div>
		
      	
		
	</div>
</nav>

<footer class="site-footer">
		<h4>Copyright ZKD, 2014</h4>
	</footer>

</body>
</html>