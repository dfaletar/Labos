<?php
	
$con=mysqli_connect("localhost","root","root","ljekarna");
    // provjera konekcije
if (mysqli_connect_errno())
{
die('{"error":"'. mysqli_connect_error().'" }');
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
		'spol' => $row['spol']);
	array_push($json, $polje);
}

$jsonstring = json_encode($json);					
$arrson = json_decode($jsonstring,true);	 
echo $jsonstring;
  

?>