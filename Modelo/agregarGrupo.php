<?php
header('Access-Control-Allow-Origin: *');
require_once('../Modelo/config.php');
session_start();
$user_name = $_SESSION['usuario'];
$password = $_SESSION['password'];
$nombreG = $_POST['ngrupo'];
$nombres = $_POST['nsistema'];
$descripcion = $_POST['ndescripcion'];
$sub = $_POST['nsub'];
$gse = $_POST['gse'];
$tok = explode(',',$sub);
$to = count($tok);

$conectar = ldap_connect("ldap://{$host}:{$port}") or die("No se puede conectar al servidor LDAP");       // Conexión al servidor LDAP
ldap_set_option($conectar, LDAP_OPT_PROTOCOL_VERSION, 3);
	if ($conectar){
	   	if(@ldap_bind($conectar, "cn={$user_name},{$baseAdmin}", $password)){
			$infoG["objectclass"][0] = "organizationalUnit";
			$infoG["objectclass"][1] = "top";
			$infoG["description"][0] = $descripcion;
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
				$infoS["description"][0] = "Sistema";
				$infoS["gidNumber"][0] = "$valorS";


			if($nombreG != NULL){
				$dominioG = "ou=$nombreG,"."".$dn;
	            @ldap_add($conectar, $dominioG, $infoG);
			    if($gse != NULL){
			    	for($i=1; $i<$to; $i++){
			    	$ng = $tok[$i];

			    		$dominioG = "ou=$ng,"."".$dominioG;
			    		$infoSG["objectclass"][0] = "organizationalUnit";
						$infoSG["objectclass"][1] = "top";
						$infoSG["description"][0] = "subgrupo";

			    		@ldap_add($conectar, $dominioG, $infoSG);

}

			    	$nombreS = "cn=$nombres".",".$dominioG;
			    	if(@ldap_add($conectar, $nombreS, $infoS)){
			    		$token = 2;
			echo $token;
			    	}else{
			    		$token = 3;
			echo $token;
			    	}
			    }else{
			    	$nombreS = "cn=$nombreS".",".$dominioG;
			    	if(@ldap_add($conectar, $nombreS, $infoS)){
			    		$token = 2;
					echo $token;
			    	}else{
			    		$token = 3;
			echo $token;
			    	}
			    }
			}else{
				$nombreS = "cn=$nombres".",".$dn;
				if(@ldap_add($conectar, $nombreS, $infoS)){
			    		echo "El sistema se agrego con éxito";
			    	}else{
			    		echo "Error al agregar el sistema";
			    }
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
