<?php
require_once("lib/nusoap.php");

$cliente = new nusoap_client("http://localhost:8888/sacfinals/servicio.php",false);

$texto = "hola";
$parametros = array('miparametro' => $texto);
//$respuesta = $cliente->call("miFuncion",array('miparametro' => 'Bart'));

$respuesta = $cliente->call("nuevo",array('n1' => 'Bart','n2' => 'Bartolomeo','a1' => 'Simpsonp','a2' => 'Simpson','c' => '12127891','t' => '0991189175','co' => 'bart@unl.edu.ec','ti' => 'otros'));

echo ($respuesta);
 ?>
