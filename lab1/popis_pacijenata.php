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
		$neki_sadrzaj = "Stranica ne postoji!";
}
?>

<!DOCTYPE html>
<html>
<head>
	<title><?php echo $title; ?></title>

	 <link rel="stylesheet" href="stil.css">
	 
	 <script type="text/javascript" src="js/search.js"></script>
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
		<a href="login.php"><li>Poèetna</li></a>
		<a href="zivotopis.php"><li>Životopis</li></a>
		<a href="popis_pacijenata.php"><li>Popis pacijenata</li></a>

	</div>
	<div class="sadrzaj">
	

	
			
			
<?php
$row = 1;
$count=0;
if (($handle = fopen("citat.csv", "r")) !== FALSE) {
  echo '<table id="dataTable">';
    while ($count <=5) {
    	$data = fgetcsv($handle, 1000, ",");
        $row++;
        $splitdata=explode(';', $data[0]);
        echo '<tr>';
        for ($c=0; $c <= 6; $c++) {
            echo '<td>';
            echo $splitdata[$c] . "\n";
            echo '</td>';
        }
        echo '</tr>';
        $count++;
    }
    echo '</table>';
    fclose($handle);
}
?>
		
	</div>
</nav>

<footer class="site-footer">
		<h4>Copyright ZKD, 2014</h4>
	</footer>

</body>
</html>