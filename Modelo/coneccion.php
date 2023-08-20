
<?php
header('Access-Control-Allow-Origin: *');
session_start();
$usuario = $_SESSION['usuario'];
$password = $_SESSION['password'];

function usuarios($seleccion){

	//ARCHIVO DE CONIGURACIÓN config.php
	require_once('config.php');
	// Conexión al servidor LDAP
	$conectar = ldap_connect("ldap://{$host}:{$port}") or die("No se puede conectar al servidor LDAP");
	ldap_set_option($conectar, LDAP_OPT_PROTOCOL_VERSION, 3);
	if ($conectar) {
 		if(ldap_bind($conectar, "cn=admin,dc=cas,dc=com", "ldap1234")){

 		$filtro = "uid=*";


 		$arreglo = array("edupersontargetedid","sn", "givenname", "mail","telephonenumber","uid");
 		if($seleccion=="estudiantes"){
 	    $resultado = ldap_search($conectar, $baseEstudiantes, $filtro, $arreglo, 0, 0, 0, 3) or exit("Buscando...");
 		}else if($seleccion=="docentes"){
 	    $resultado = ldap_search($conectar, $baseDocentes, $filtro, $arreglo) or exit("Buscando...");
 		} else if($seleccion=="servidores"){
 		$resultado = ldap_search($conectar, $baseServidores, $filtro, $arreglo) or exit("Buscando...");
	}else if($seleccion=="trabajadores"){
 		$resultado = ldap_search($conectar, $baseTrabajadores, $filtro, $arreglo) or exit("Buscando...");
	}else if($seleccion=="otros"){
 		$resultado = ldap_search($conectar, $baseOtros, $filtro, $arreglo) or exit("Buscando...");
 		}else{
 			$resultado = ldap_search($conectar, $baseEstudiantes, $filtro, $arreglo) or exit("Buscando...");
 		}

 		$entrada = ldap_get_entries($conectar, $resultado);
 		$valor = ldap_count_entries($conectar, $resultado);

 		if ($valor==0){

         return 0;

 		}else{
 					for ($i=0; $i<$entrada["count"]; $i++){
 						@$cedula = $entrada[$i]["edupersontargetedid"][0];
 					    $nombre = $entrada[$i]["sn"][0];
 					    $apellido = $entrada[$i]["givenname"][0];
 					     $correo = $entrada[$i]["mail"][0];
 					    $telefono = $entrada[$i]["telephonenumber"][0];
 					    $uid = $entrada[$i]["uid"][0];
 					      $datos[$i][0] = $cedula;
 					     $datos[$i][1] = $nombre;
 					     $datos[$i][2] = $apellido;
 					     $datos[$i][3] = $correo;
 					     $datos[$i][4] = $telefono;
 					     $datos[$i][5] = $uid;
 					     $datos[$i][6] = $seleccion;

 }
 }

 }
 return $datos;
 }
 }



 ?>
