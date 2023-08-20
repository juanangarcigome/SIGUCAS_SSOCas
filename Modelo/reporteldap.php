<?php
header('Access-Control-Allow-Origin: *');
session_start();
@$user_name =$_SESSION['usuario'];
@$password = $_SESSION['password'];
$tipo = $_GET['tipoU'];
$str = strtolower($tipo);

$time = time();
$Name = 'Reporte.csv';
$FileName = "./$Name";
$Datos = "UNIVERSIDAD NACIONAL DE LOJA";
$Datos .= "\r\n";
$Datos .= "REPORTE GENERADO SOBRE "." ".$tipo;
$Datos .= "\r\n";
$Datos .= "FECHA = ".date("Y-m-d ", $time);
$Datos .= "\r\n";
$Datos .= "HORA = ".date("H:i:s", $time);
$Datos .= "\r\n";
$Datos .= "\r\n";
$Datos .= 'cedula;nombres;apellidos;correo;telefono;tipo';
$Datos .= "\r\n";

header('Expires: 0');
header('Cache-control: private');
header('Content-Type: application/x-octet-stream'); // Archivo de Excel
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Content-Description: File Transfer');
header('Last-Modified: '.date('D, d M Y H:i:s'));
header('Content-Disposition: attachment; filename="'.$Name.'"');
header("Content-Transfer-Encoding: binary");

require_once('config.php');
$conectar = ldap_connect("ldap://{$host}:{$port}") or die("No se puede conectar al servidor LDAP");
ldap_set_option($conectar, LDAP_OPT_PROTOCOL_VERSION, 3);
    if ($conectar) {
        if(@ldap_bind($conectar, "cn=$user_name,{$baseAdmin}", $password)){
                $filtro = "uid=*";
                $arreglo = array("edupersontargetedid","sn", "givenname", "mail","telephonenumber","uid");
                if($str=="estudiantes"){
                  $resultadoE = ldap_search($conectar, $baseEstudiantes, $filtro, $arreglo) or exit("Buscando...");
                }else if($str=="docentes"){
                  $resultadoE = ldap_search($conectar, $baseDocentes, $filtro, $arreglo) or exit("Buscando...");
                } else if($str=="servidores"){
                $resultadoE = ldap_search($conectar, $baseServidores, $filtro, $arreglo) or exit("Buscando...");
                }else if($str=="trabajadores"){
                $resultadoE = ldap_search($conectar, $baseTrabajadores, $filtro, $arreglo) or exit("Buscando...");
                }else if($str=="otros"){
                $resultadoE = ldap_search($conectar, $baseOtros, $filtro, $arreglo) or exit("Buscando...");
                }else{
                  $resultadoE = ldap_search($conectar, $baseEstudiantes, $filtro, $arreglo) or exit("Buscando...");
                }
                $entrada = @ldap_get_entries($conectar, $resultadoE);
                $firsE = @ldap_first_entry($conectar, $resultadoE);
                $dnE = ldap_get_dn($conectar, $firsE);
                $a = 1;

                for ($i=0; $i<$entrada["count"]; $i++){
                    $cedula = $entrada[$i]["edupersontargetedid"][0];
      					    $nombres = $entrada[$i]["sn"][0];
      					    $apellidos = $entrada[$i]["givenname"][0];
      					    $correo = $entrada[$i]["mail"][0];
      					    $telefono = $entrada[$i]["telephonenumber"][0];
                    $Datos .= "$cedula;$nombres;$apellidos;$correo;$telefono;$str";
                    $Datos .= "\r\n";

                }

              }else{
                $token = 1;
                echo "$token";
              }
            }else{
              $token = 0;
              echo "$token";
            }
            echo $Datos;

?>
