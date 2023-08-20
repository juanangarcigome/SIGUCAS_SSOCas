<?php
header('Access-Control-Allow-Origin: *');
session_start();
require_once('../Modelo/config.php');
require_once("../Modelo/lib/nusoap.php");

$cadena = array($_SESSION['usuario'], $_SESSION['password'], $_POST['nombre1'], $_POST['nombre2'], $_POST['apellido1'], $_POST['apellido2'], $_POST['cedula'], $_POST['telefono'], $_POST['tipoU'],$_POST['correo'],$_POST['contrasenia'],$_POST['user']);


$cliente = new nusoap_client($server_url."/Controlador/servicio.php",false);
$respuesta = $cliente->call("actualizar",array('datos' => $cadena,'servidor' => $host,'puerto' => $port,'baseAdmin'=>$baseAdmin));
$manage = json_decode($respuesta, true);

echo $manage['token'];


?>
