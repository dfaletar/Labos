<?php

// Inialize session
session_start();
	
if(!(isset($_SESSION['usr']) && isset($_SESSION['pswd']))) {
	$link= mysql_connect("localhost", "root", "root") or die("Neuspjela konekcija");

	mysql_select_db("ljekarna") or die("Neuspjelo otvaranje baze");
	
	$upit = "SELECT * FROM korisnici WHERE username='".$_POST['usr']."' AND password='".md5($_POST['pswd'])."';";
	
	
	$result = mysql_query($upit, $link) or die ("Neuspjelo");
	
	$korisnik = mysql_num_rows($result);
	
		if ($korisnik ==1) {
		// Set username session variable
		$_SESSION['usr'] = $_POST['usr'];
		$_SESSION['pswd'] = $_POST['pswd'];
		}else
		header('Location: login.html');
		}

if(empty($_GET["page"]))
	$page = "index";
else
	$page = $_GET["page"];

function getUrl($page){
	return "?page=$page";
}

$neki_sadrzaj = "";
$title = "";

switch($page){
	case "index":
		$neki_sadrzaj = "<b>Dobro došlo ".$username."</b>. <br /><br />
						Korisničko ime : ".$username." <br />
						Lozinka : ".$password.""  ;
		$title = "Pocetna";
	break;


	case "cv":
		$neki_sadrzaj = "<p>skdjhfskdjhfkjdfh</p>";


	case "odjava":
		session_unset();
		session_destroy();
		header("location:login.html");
	break;


	/* Ovo se ozvodi ako se upise nepostojeca stranica */
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
	 <script type="text/javascript" src="js/search.js"></script>
</head>
<header class="site-header">
	
	<div class="logo">
	<a href="<?php echo getUrl("index"); ?>"><img src="logo.png" width="200px;" alt="logo"></a>
	</div>
	
	<div class="ime">
		<h4> <?php echo $_SESSION['ime']; ?>
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
		<a href="jsonPacijenti.php"><li>Pacijenti ispis JSON</li></a>
		<a href="doktori.php"><li>Ispis doktori</li></a>
	</div>
</nav>
	<div class="ispis">

	
<h2 style="text-align: center; padding: 30px;">Doktori</h2>

	
	
	<?php
	$json = json_decode(file_get_contents("http://stajp.vtszg.hr/~spredanic/DWA2/lab5/podaci.php"), true);
	$doktori = array();
	for($i=0; $i<count($json);$i++){
		if($json[$i]["ime"]==strtoupper($_GET["ime"]) or $json[$i]["prezime"]==strtoupper($_GET["prezime"])){
			array_push($doktori , $json[$i]);

		}
	}
	//print_r($doktor);

	for($i=0; $i< count($doktori); $i++){
		$doktor=$doktori[$i];

	echo "ID: ".$doktor["id"];
	echo "<br/>";
	echo "Ime: ".$doktor["ime"];
	echo "<br/>";
	echo "Prezime: ".$doktor["prezime"];
	echo "<br/>";
	echo "Podrucni ured: ".$doktor["podrucni_ured"];
	echo "<br/>";
	echo "Sifra ustanove: ".$doktor["sifra_ustanove"];
	echo "<br/>";
	echo "Naziv ustanove: ".$doktor["naziv_ustanove"];
	echo "<br/>";
	echo "Id broj: ".$doktor["id_broj"];
	echo "<br/>";
	echo "Broj osiguranika: ".$doktor["broj_osiguranika"];
	echo "<br/>";
	echo "Broj poste: ".$doktor["broj_poste"];
	echo "<br/>";
	echo "Naziv poste: ".$doktor["naziv_poste"];
	echo "<br/>";
	echo "Ulica: ".$doktor["ulica"];
	echo "<br/>";
	echo "Kucni broj: ".$doktor["kucni_broj"];
	echo "<br/>";
	echo "Grad: ".$doktor["grad"];
	echo "<br />";
	echo "<br />";
	}

		
	?>


	</div>



<footer class="site-footer">
		<h4>Copyright ZKD, 2014</h4>
	</footer>

</body>
</html>