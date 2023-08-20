<?php
header('Access-Control-Allow-Origin: *');
session_start();
require_once('../Modelo/config.php');
require_once("../Modelo/lib/nusoap.php");

$cadena = array($_SESSION['usuario'], $_SESSION['password'], $_POST['usuario']);

$cliente = new nusoap_client($server_url."/Controlador/servicio.php",false);
$respuesta = $cliente->call("eliminar",array('datos' => $cadena,'servidor' => $host,'puerto' => $port,'baseAdmin'=>$baseAdmin));
$manage = json_decode($respuesta, true);
echo $manage['token'];

?>
