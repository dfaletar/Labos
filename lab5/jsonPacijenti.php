<?php


// Inialize session
session_start();



$link = mysqli_connect('localhost','root','root','ljekarna');

	if(mysqli_connect_errno()) {
		printf("Connect faild: %s\n", mysqli_connect_error());
		exit();
	}




$result = mysqli_query($link,"SELECT * FROM korisnici");
$a=mysqli_num_rows($result);


$i=0;
while($row = mysqli_fetch_array($result))
  {
  $korisnik[$i]=$row['username'];	
  $lozinka[$i]=$row['password'];
  $ime[$i]=$row['name'];	
  $i++;
  }
 
 


 



// Retrieve username and password from database according to user's input
if(!(isset($_SESSION['usr']) && isset($_SESSION['pswd']))) {
for ($j=0; $j < $a; $j++) { 
	if($_POST['usr']==$korisnik[$j] && $_POST['pswd'] == $lozinka[$j]){
		$username=$korisnik[$j];
		$password=$lozinka[$j];
		$ime2=$ime[$j];
	}
}


if ($_POST['usr']==$username && $_POST['pswd'] == $password) {
// Set username session variable
$_SESSION['usr'] = $_POST['usr'];
$_SESSION['pswd'] = $_POST['pswd'];
$_SESSION['ime'] = $ime2;
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
		$neki_sadrzaj = "<b>Dobro došao ".$_SESSION['ime']."</b>. <br /><br />
						Korisničko ime : ".$_SESSION['usr']." <br />
						Lozinka : ".$_SESSION['pswd'].""  ;
		$title = "Pocetna";
	break;

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
	
	<div class="sadrzaj">
		<?php

	
                  $con=mysqli_connect("localhost","root","root","ljekarna");
                        // provjera konekcije
                    if (mysqli_connect_errno())
                      {
                    echo "Failed to connect to MySQL: " . mysqli_connect_error();
                         }
						 
						 
					    mysqli_query($con,"SET NAMES 'utf8'");
					    mysqli_query($con,"SET CHARACTER_SET 'utf8'");
			
					 $json = array();
					    $result = mysqli_query($con,"SELECT * FROM podaci");


					  while($row = mysqli_fetch_array($result))
					   { 
								$polje = array(
								'ime' => $row['ime'],
								'prezime' => $row['prezime'],
								'spol' => $row['spol']
							                );
							array_push($json, $polje);
						}

						$jsonstring = json_encode($json);
												
					  $arrson = json_decode($jsonstring,true);
				
                       echo '<div id="json">
					          
					         
							 </div>
							 
			           ';
                       			 
					
					  
					  mysqli_close($con);


		   

 
                    ?>
					  <button id="prije" type="button" onclick="prethodni()">Prethodni</button>
		      <button id="dalje" type="button" onclick="sljedeci()">Sljedeći</button>
			 
	</div>
</nav>

<footer class="site-footer">
		<h4>Copyright ZKD, 2014</h4>
	</footer>
 <script>
			 var js_var = <?php echo json_encode($arrson);?>;
			var len=Object.keys(js_var);
			var k=len.length;
			 var curr = 0;
			 
						function sljedeci(){
							curr++;
				   
					   document.getElementById("json").innerHTML= 'Pacijent: '+ js_var[curr].ime + ' ' + js_var[curr].prezime +'<br> Spol: ' + js_var[curr].spol;

							
						
                       }
                          
				   
				  
						function prethodni(){
						
							curr--;
		
						    document.getElementById("json").innerHTML= 'Pacijent: '+ js_var[curr].ime + ' ' + js_var[curr].prezime +'<br> Spol: ' + js_var[curr].spol;
							//document.getElementById("json").innerHTML= js_var[curr].prezime;
                       }
            </script>
</body>
</html>