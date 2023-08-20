<?php
header('Access-Control-Allow-Origin: *');
session_start();
$usuario = $_SESSION['usuario'];
$password = $_SESSION['password'];
$seleccion = $_GET['tipo'];

	require_once('config.php');

	$conectar = ldap_connect("ldap://{$host}:{$port}") or die("No se puede conectar al servidor LDAP");
	ldap_set_option($conectar, LDAP_OPT_PROTOCOL_VERSION, 3);
	$r = $_REQUEST['start'];
	$a = $_REQUEST['length'];

	if(!empty($_REQUEST['search']['value'])){
	$bu = $_REQUEST['search']['value'];

	//$filtro = ("givenname=$bu*");
	//$filtro1 = ("sn=$bu*");
	$filtro = "(|(uid=$bu*)(cn=$bu*)(sn=$bu*)(eduPersonTargetedID=$bu))";

	}else{
			$filtro = "uid=*";
	}
		$max = ($r + $a);
		$arreglo = array("edupersontargetedid","sn", "givenname", "mail","telephonenumber","uid");
	if(ldap_bind($conectar,"cn={$usuario},{$baseAdmin}",$password)){

	//	if($seleccion== "Estudiantes"){
   //$resultado = ldap_search($conectar, $baseDocentes, $filtro, $arreglo) or exit("Buscando...");
//}esle
//}

if($seleccion=="estudiantes"){
       $resultado = ldap_search($conectar, $baseEstudiantes, $filtro, $arreglo) or exit("Buscando...");
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
		$datos = array();

#for ($i=0; $i <3 ; $i++) {
#	if($valor==0 && !empty($_REQUEST['search']['value'])){
#		$bu = $_REQUEST['search']['value'];
#		$filtro = ("cn=$bu*");

#	}

#}

		if ($valor==0){
  //    $filtro = ("sn=$bu*");
  //    $resultado = ldap_search($conectar, $baseEstudiantes, $filtro, $arreglo) or exit("Buscando...");
		// $entrada = ldap_get_entries($conectar, $resultado);
		// $valor = ldap_count_entries($conectar, $resultado);
		// $datos = array();

           $datos[0][0] = "No existen datos";
           $datos[0][1] = "No existen datos";
           $datos[0][2] = "No existen datos";
           $datos[0][3] = "No existen datos";
           $datos[0][4] = "No existen datos";
           $datos[0][5] = "No existen datos";



		}else{
			if($valor<10){
				$max = $valor;

			}
			for ($i=$r; $i<$max; $i++){
					      $datos[$i-$r][0] = $entrada[$i]["edupersontargetedid"][0];
 					     $datos[$i-$r][2] = $entrada[$i]["sn"][0];
 					     $datos[$i-$r][1] = $entrada[$i]["givenname"][0];
 					     $datos[$i-$r][3] = $entrada[$i]["mail"][0];
 					     $datos[$i-$r][4] = $entrada[$i]["telephonenumber"][0];
 					     $datos[$i-$r][5] = $entrada[$i]["uid"][0];


		}
	}
}

$json_data = array('draw' => (isset($_REQUEST["draw"]) ? $_REQUEST["draw"] : 0), 'recordsTotal' =>  count($entrada) -1, 'recordsFiltered' =>   count($entrada) -1, 'tipo' =>   $seleccion, 'data' =>  $datos );
echo  json_encode($json_data);

?>
