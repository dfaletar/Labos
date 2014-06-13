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
		$neki_sadrzaj = "<b>Dobro došli na naše stranice</b>";
		$title = "Pocetna";
	break;
	
	case "odjava":
		session_unset();
		session_destroy();
		header("location:login.html");
	break;

	/* Ovo se ozvodi ako se upise nepostojeca stranica */
	default:
		$neki_sadrzaj = "Stranica ne postoji!";
}
?>

<!DOCTYPE html>
<html>
<head>
	<title><?php echo $title; ?></title>
	 <meta charset="UTF-8" />
	 <link rel="stylesheet" href="stil.css">
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
		<?php echo $neki_sadrzaj ?>
	</div>
</nav>

<footer class="site-footer">
		<h4>Copyright ZKD, 2014</h4>
	</footer>

</body>
</html>