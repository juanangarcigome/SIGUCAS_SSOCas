
<?php
header('Access-Control-Allow-Origin: *');
session_start();
$usuario = "admin";
$password = "ldap1234";
$seleccion = "Estudiantes";
	//ARCHIVO DE CONIGURACIÓN config.php
	require_once('config.php');
	// Conexión al servidor LDAP
	$conectar = ldap_connect("ldap://{$host}:{$port}") or die("No se puede conectar al servidor LDAP");
	ldap_set_option($conectar, LDAP_OPT_PROTOCOL_VERSION, 3);

	$arreglo = array("edupersontargetedid","sn", "givenname", "mail","telephonenumber","uid");
	$filtro = "uid=*";
 	$pageSize = 100;
 	$cookie = '';
    $array = array();
    $j=0;
     do {

         ldap_control_paged_result($conectar, $pageSize, true, $cookie);

          $resultado = ldap_search($conectar, $baseEstudiantes, $filtro, $arreglo) or exit("Buscando...");
          $entries = ldap_get_entries($conectar, $resultado);

     for ($i=0;$i<count($entries);$i++) {
     	  //var_dump($e['mail']);
     	  $array[$j][$i]  = $entries[$i]["mail"][0];
        }

$j=$j+1;
         ldap_control_paged_result_response($conectar, $resultado, $cookie);

   } while($cookie !== null && $cookie != '');

	 echo ("logrago");




?>
