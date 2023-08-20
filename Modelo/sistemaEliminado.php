<?php
header('Access-Control-Allow-Origin: *');
session_start();
@$user_name = $_SESSION['usuario'];
@$password = $_SESSION['password'];
@$sistema = $_POST['nsistema'];
@$sistemas = explode(" ", $sistema);
require_once("config.php");
$conectar = ldap_connect("ldap://{$host}:{$port}") or die("No se puede conectar al servidor LDAP");
ldap_set_option($conectar, LDAP_OPT_PROTOCOL_VERSION, 3);

    //$baseG = "ou=$sistema,"."".$baseGeneral2;
    if ($conectar) {
        if(@ldap_bind($conectar, "cn={$user_name},{$baseAdmin}", $password)){
          $ban = 0;
            for ($i=0; $i <(count($sistemas)-1); $i++) {
              $filtroS = "cn=$sistemas[$i]";
              $arregloS = array("cn");
              $resultadoS = @ldap_search($conectar, $baseGeneral2, $filtroS, $arregloS) or exit("Buscando...");
              $firs = @ldap_first_entry($conectar, $resultadoS);
              $dn = @ldap_get_dn($conectar, $firs);
              if(@ldap_delete($conectar, $dn)){
                $ban = 1;
              }
            }
            if($ban==1){
              $token = 2;
              echo $token;
            }else{
              $token = 3 ;
              echo $token;
            }
        }else{
          $token = 0 ;
          echo $token;
        }
    }else{
      $token = 1 ;
      echo $token;
    }
    /*if ($conectar) {
        if(@ldap_bind($conectar, "cn={$user_name},{$baseGeneral}", $password)){
            //echo "$entry";
            do{
                $filtro = "ou=*";
                $arreglo = array("ou", "description");
                //$resultado = ldap_search($conectar, $baseG, $filtro, $arreglo) or exit("Buscando...");
                $resultado = ldap_list($conectar, $baseG, $filtro, $arreglo);
                $entrada = ldap_get_entries($conectar, $resultado);
                $valor = ldap_count_entries($conectar, $resultado);
                $firs = ldap_first_entry($conectar, $resultado);
                //$entry = ldap_next_entry($conectar, $firs);
                $dn = ldap_get_dn($conectar, $firs);
                    if($valor != 0){
                        for ($i=0; $i<$entrada["count"]; $i++){
                            $respuesta =  $entrada[$i]["ou"][0]."\n".$entrada[$i]["description"][0]."\n";
                            print_r($respuesta);
                        }
                    }else{
                            echo "No existe grupos para visualizar";
                    }
                $baseG = "ou=$grupo1,"."".$baseG;
            }while($firs = ldap_next_entry($conectar, $firs));
        }else{
            return "Datos incorrectos";
        }
    }else{
        return "No hay conexión con el servidor LDAP";
    }*/

?>
