<?php
header('Access-Control-Allow-Origin: *');
session_start();
require_once('../Modelo/config.php');

$user_name = $_SESSION['usuario'];
$password = $_SESSION['password'];
$nombres = $_POST['nsistema'];   //
$sub = $_POST['nsub'];   //
$gse = $_POST['gse'];    //Nombre del grupo 	Seleccionado
$tok = explode(',',$sub);    //
$to = count($tok);    //

$conectar = ldap_connect("ldap://{$host}:{$port}") or die("No se puede conectar al servidor LDAP");       // Conexión al servidor LDAP
ldap_set_option($conectar, LDAP_OPT_PROTOCOL_VERSION, 3);

	if ($conectar){
	   	if(@ldap_bind($conectar, "cn={$user_name},{$baseAdmin}", $password)){
			$infoG["objectclass"][0] = "organizationalUnit";
			$infoG["objectclass"][1] = "top";
			$infoG["description"][0] = "prueba";
			$filtro = "ou=$gse";
            $arreglo = array("ou");
            $resultado = @ldap_search($conectar, $baseGeneral2, $filtro, $arreglo) or exit("Buscando...");
            $firs = @ldap_first_entry($conectar, $resultado);
            $dn = ldap_get_dn($conectar, $firs);


	            $filtroS = "cn=*";
	            $arregloS = array("cn");
	            $resultadoS = @ldap_search($conectar, $baseGeneral2, $filtroS, $arregloS) or exit("Buscando...");
	            $valorS = @ldap_count_entries($conectar, $resultadoS);
	            $valorS++;
	            $infoS["objectclass"][0] = "posixGroup";
				$infoS["objectclass"][1] = "top";
				$infoS["description"][0] = "subgrupos";
				$infoS["gidNumber"][0] = "$valorS";

                 if($nombres != NULL){
                 	$nombreS = "cn=$nombres".",".$dn;
				ldap_add($conectar, $nombreS, $infoS);
				$token =2;
				echo $token;
                 }

                 for($i=1; $i<$to; $i++){
			    	$ng = $tok[$i];

			    	$nombreS = "cn=$ng".",".$dn;
				ldap_add($conectar, $nombreS, $infoS);
                }

	  	}else{
			$token = 0;
			echo $token;
		}
	}else{
		$token = 1;
			echo $token;
	}
?>
