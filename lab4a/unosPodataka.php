<?php

    

	$link = mysqli_connect('localhost','root','root','ljekarna');

	if(mysqli_connect_errno()) {
		printf("Connect faild: %s\n", mysqli_connect_error());
		exit();
	}

	
$query="INSERT INTO podaci (ime,prezime,spol,datumRodenja,mjestoRodenja,adresa,krvnaGrupa,tipKrvi,tegobe,opisTegobe,alergije,opisAlergije) VALUES ('".$_POST['firstname']."','".$_POST['lastname']."','".$_POST['gender']."','".$_POST['birthDate']."','".$_POST['birthPlace']."','".$_POST['address']."','".$_POST['bloodGroup']."','".$_POST['bloodType']."','".$_POST['diseases']."','".$_POST['diseasesDescription']."','".$_POST['allergy']."','".$_POST['allergyDescription']."')";
$result=mysqli_query($link,$query) or die('Error qouering database');
if($query==true) echo('Pacijent je uspjesno unesen za novi unos kliknite <a href="formular_za_pacijenta.php">Ovdje</a> ');
	else echo ('greška!');
	mysqli_close($link);
?>