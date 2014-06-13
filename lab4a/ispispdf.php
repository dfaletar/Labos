<?php


// Inialize session
session_start();

require('fpdf.php');

class People {
    public function all() {
        try {
        	$ime1=$_POST['firstname'];
			$prezime1=$_POST['lastname'];
			$krv1=$_POST['bloodGroup'];
			$znak1=$_POST['bloodType'];

			unset($sql);

			if ($ime1) {
			    $sql[] = " ime = '$ime1' ";
			}
			if ($prezime1) {
			    $sql[] = " prezime = '$prezime1' ";
			}
			if ($krv1) {
			    $sql[] = " krvnaGrupa = '$krv1' ";
			}
			if ($znak1) {
			    $sql[] = " tipKrvi = '$znak1' ";
			}
			

			$query1 = "SELECT ime, prezime, spol, datumRodenja, mjestoRodenja, adresa, krvnaGrupa,tipKrvi, tegobe,opisTegobe, alergije, opisAlergije FROM podaci";

			if (!empty($sql)) {
			    $query1 .= ' WHERE ' . implode(' AND ', $sql);
			}

		


            $db = new PDO('mysql:host=localhost;dbname=ljekarna;charset=UTF-8', 'root', 'root');
            $query = $db->prepare("$query1");
            $query->execute();
            $people = $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            //echo "Exeption: " .$e->getMessage();
            $result = false;
        }
        $query = null;
        $db = null;
        return $people;        
    }
}

class PeoplePDF extends FPDF {
    // Create basic table
    public function CreateTable($header, $data)
    {
        // Header
        $this->SetFillColor(0);
        $this->SetTextColor(255);
        $this->SetFont('','B',10);
        foreach ($header as $col) {
            //Cell(float w [, float h [, string txt [, mixed border [, int ln [, string align [, boolean fill [, mixed link]]]]]]])
            $this->Cell($col[1], 10, $col[0], 1, 0, 'L', true);
        }
        $this->Ln();
        // Data
        $this->SetFillColor(255);
        $this->SetTextColor(0);
        $this->SetFont('','',10);
        foreach ($data as $row)
        {
            $i = 0;
            foreach ($row as $field) {
                $this->Cell($header[$i][1], 6, $field, 1, 0, 'L', true);
                $i++;
            }
            $this->Ln();
        }
    }
}

// Column headings
$header = array(
             array('Ime',  15), 
             array('Prezime', 15),
             array('Spol',10),
             array('Roden',20),
             array('Mjesto',15),
             array('Adresa',20),
             array('krvnaGrupa',10),
             array('Tip Krvi',10),
             array('Tegobe',20),
             array('opisTegobe',23),
             array('alergije',14),
             array('opis alergije',23)

             
          );
// Get data
$people = new People();
$data = $people->all();

$pdf = new PeoplePDF();
$pdf->SetFont('Arial', '', 12);
$pdf->AddPage();
$pdf->CreateTable($header,$data);
$pdf->Output();
// Retrieve username and password from database according to user's input
$username="dino";
$password="lozinka";

if(!(isset($_SESSION['usr']) && isset($_SESSION['pswd']))) {
if ($_POST['usr']==$username && $_POST['pswd'] == $password) {
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

	</div>

	<div class="sadrzaj2">

	
<h2 style="text-align: center; padding: 30px;">Upis pacijenata</h2>
			<form action="filtriranje.php" method="POST">
				<table class="unos">
					<tr>
						<td><label for="name">Ime:</label></td>
						<td><input type="text" name="firstname" id="name"></td>
					</tr>
					<tr>
						<td><label for="surname">Prezime:</label></td>
						<td><input type="text" name="lastname" id="surname"></td>
					</tr>
					<tr>
						<td></td>
						<td><input type="submit" value="Filtriraj"></td>
					</tr>
				</table>

			</form>

	
	</div>
</nav>



<footer class="site-footer">
		<h4>Copyright ZKD, 2014</h4>
	</footer>

</body>
</html>