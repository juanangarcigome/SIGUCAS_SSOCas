<?php
header('Access-Control-Allow-Origin: *');	
	session_start();

//echo "Usted se encuentra en el Sistema denominado: $syst";
//echo "<br>";

$servicioLdap="http://localhost/serviceldap/servicioadmin.php?wsdl"; //url del servicio
	$arrays=array();                                            //parametros de la llamada
	$arrays = [
	    "user_name" => $user_name,
	    "password" => $password,
	];

	$client = new SoapClient($servicioLdap, $arrays);
	$result = $client->usuarios($);    //llamamos al métdo que nos interesa con los parámetros
	//var_dump($result);


?>

