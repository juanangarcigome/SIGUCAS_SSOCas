<?php
header('Access-Control-Allow-Origin: *');
require_once('../Modelo/config.php');
require_once('../Modelo/correo.php');
require_once("../Modelo/lib/nusoap.php");
session_start();

$cadena = array($_SESSION['usuario'], $_SESSION['password'], $_POST['nombre1'], $_POST['nombre2'], $_POST['apellido1'], $_POST['apellido2'], $_POST['cedula'], $_POST['telefono'], $_POST['correo'],$_POST['tipoU']);

$cliente = new nusoap_client($server_url."/Controlador/servicio.php",false);
$respuesta = $cliente->call("nuevo_usuario",array('datos' => $cadena, 'servidor' => $host,'puerto' => $port,'baseAdmin'=>$baseAdmin));
$manage = json_decode($respuesta, true);
if($manage['token']!=4){
echo $manage['token'];
}else {
echo $manage['status'];
correo_crear($manage['destino'] ,$manage['status'] , $manage['DNI'], $manage['nombre'], $manage['apellido']);
}





// $hashFormat = "$2y$10$";
// $salt = "cas&ySiGUCAS&LdapCas22";
// $key = $hashFormat.$salt;
// $contra = hash_hmac('sha256', $cedula, $key, false);
//
// $conectar = ldap_connect("ldap://{$host}:{$port}") or die("No se puede conectar al servidor LDAP");
// ldap_set_option($conectar, LDAP_OPT_PROTOCOL_VERSION, 3);
//     /*$baseAdmin = "cn=$usuario,dc=cas,dc=com";
//     $baseGeneral = "ou=personal,dc=cas,dc=com";
//     $baseAcademicos = "ou=$tipoU,ou=academicos,"."".$baseGeneral;
//     $baseAdministrativos = "ou=$tipoU,ou=administrativos,"."".$baseGeneral;
//     $baseOtros = "ou=$tipoU,"."".$baseGeneral;
//     $letra1 = lcfirst($nombre1);
//     $letra2 = lcfirst($nombre2[0]);
//     $letra3 = lcfirst($apellido1);
//     $letra4 = lcfirst($apellido2[0]); */
//
//     @$uid = $correo;
//     @$uid2 = $correo;
//     @$uid3 = $correo;
//     if($conectar) {
//         if(@ldap_bind($conectar, "cn={$user_name},{$baseAdmin}", $password)) {
//             $filtro = "eduPersonTargetedID=$cedula";
//             $arreglo = array("eduPersonTargetedID");
//             $resultadoU = @ldap_search($conectar, $baseGeneral, $filtro, $arreglo);
//             $valorU = ldap_count_entries($conectar, $resultadoU);
//             if($valorU == 0){
//                 $info["cn"][0] = $nombre1." ".$nombre2;
//                 $info["sn"][0] = $apellido1." ".$apellido2;
//                 $info["givenName"][0] = $nombre1." ".$nombre2;
//                 $info["objectclass"][0] = "person";
//                 $info["objectclass"][1] = "inetOrgPerson";
//                 $info["objectclass"][2] = "organizationalPerson";
//                 $info["objectclass"][3] = "top";
//                 $info["objectclass"][4] = "eduPerson";
//                 $info["userPassword"][0] = "$cedula";
//                 $info["telephoneNumber"][0] = "$telefono";
//                 $info["ou"][0] = "$tipoU";
//                 $info['eduPersonTargetedID'][0] = "$cedula";
//                 $info["eduPersonPrincipalName"][0] = "$correo";
//                 $info["mail"][0] = "$correo";
//
//                 $academico = "ou=$tipoU,"."".$baseAcademicos;
//                 $administrativo = "ou=$tipoU,"."".$baseAdministrativos;
//                  $otros = $baseOtros;
//
//                         // $mensaje = "Bienvenido al Sistema de Autenticción Central CAS \n";
//                         // $mensaje .=  "Sus credenciales son: \n";
//                         // $mensaje .=  "Usuario : $correo \n";
//                         // $mensaje .=  "Contraseña : $cedula";
//                         $destino = $correo;
//
//                 if($tipoU == 'estudiantes' or $tipoU == 'docentes'){
//                     if(@ldap_add($conectar, "uid={$uid},{$academico}" , $info)){
//                         correo_crear($destino ,$uid , $cedula);
//                     	echo "$uid";
//                     }else{
//                         if(@ldap_add($conectar, "uid={$uid2},{$academico}" , $info)){
//                         	echo "$uid2";
//                         }else{
//                             if(@ldap_add($conectar, "uid={$uid3},{$academico}" , $info)){
//                             	echo "$uid3";
//                             }else{
//                                 $token = 2;
//         						echo "$token";
//                             }
//                         }
//                     }
//                 }else{
//                 	if($tipoU == 'servidores' or $tipoU == 'trabajadores'){
//                         if(@ldap_add($conectar, "uid={$uid},{$administrativo}" , $info)){
//                           correo_crear($destino ,$uid , $cedula);
//         					echo "$uid";
//                         }else{
//                             if(@ldap_add($conectar, "uid={$uid2},{$administrativo}" , $info)){
//         							echo "$uid2";
//                             }else{
//                                 if(@ldap_add($conectar, "uid={$uid3},{$administrativo}" , $info)){
//         							echo "$uid3";
//                                 }else{
//                                     $token = 2;
//         							echo "$token";
//                                 }
//                             }
//                         }
//                     }else{
//                     	if(@ldap_add($conectar, "uid={$uid},{$otros}" , $info)){
//                             correo_crear($destino ,$uid , $cedula);
//         					echo "$uid";
//                         }else{
//                             if(@ldap_add($conectar, "uid={$uid2},{$otros}" , $info)){
//         						echo "$uid2";
//                             }else{
//                                 if(@ldap_add($conectar, "uid={$uid3},{$otros}" , $info)){
//         							echo "$uid3";
//                                 }else{
//                                     $token = 2;
//         							echo "$token";
//                                 }
//                             }
//                         }
//                     }
//                 }
//             }else{
//                 $token = 1;
//         		echo "$token";
//             }
//         }else{
//         	$token = 3;
//         	echo "$token";
//         }
//     }else{
//     	$token = 0;
//         echo "$token";
//     }
?>
