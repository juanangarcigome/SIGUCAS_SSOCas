<?php
session_start();
require_once("../Modelo/config.php");
$nombr =$_SESSION['nombre'];
$password = $_SESSION['password'];
session_destroy();



header("Location: $cas_url/logout?service=$server_url");


?>
