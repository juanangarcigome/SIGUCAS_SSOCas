<?php
header('Access-Control-Allow-Origin: *');
session_start();
@$user_name = $_SESSION['usuario'];
@$password = $_SESSION['password'];
@$grupo = $_POST['ngrupo'];
@$grupos = explode(" ", $grupo);
require_once("../Modelo/config.php");
$conectar = ldap_connect("ldap://{$host}:{$port}") or die("No se puede conectar al servidor LDAP");
ldap_set_option($conectar, LDAP_OPT_PROTOCOL_VERSION, 3);

    //$baseG = "ou=$sistema,"."".$baseGeneral2;
    if ($conectar) {
        if(@ldap_bind($conectar, "cn={$user_name},{$baseAdmin}", $password)){
          $ban = 0;
            for ($i=0; $i <(count($grupos)-1); $i++) {
              $filtroS = "ou=$grupos[$i]";
              $arregloS = array("ou");
              $resultadoS = @ldap_search($conectar, $baseGeneral2, $filtroS, $arregloS) or exit("Buscando...");
              $firs = @ldap_first_entry($conectar, $resultadoS);
              $dn = @ldap_get_dn($conectar, $firs);
              $filtroCN = "cn=*";
              $arregloCN = array("cn");
              $resultadoCN = @ldap_search($conectar, $dn, $filtroCN, $arregloCN) or exit("Buscando...");
              $firsCN = @ldap_first_entry($conectar, $resultadoCN);
              do{
                $dnCN = @ldap_get_dn($conectar, $firsCN);
                  if(@ldap_delete($conectar, $dnCN)){
                    $ban = 1;
                  }
                }while($firsCN = @ldap_next_entry($conectar, $firsCN));
              $filtroOU = "ou=*";
              $arregloOU = array("ou");
              $resultadoOU = @ldap_search($conectar, $dn, $filtroOU, $arregloOU) or exit("Buscando...");
              $firsOU = @ldap_first_entry($conectar, $resultadoOU);
              $bandera = 0;
                do{
                $dnOU = @ldap_get_dn($conectar, $firsOU);
                $ouT[$bandera] = $dnOU;
                //@ldap_delete($conectar, $dnOU);
                $bandera++;
                }while($firsOU = @ldap_next_entry($conectar, $firsOU));
                $bandera--;
                while ($bandera >= 0) {
                  $dnOU = $ouT[$bandera];
                  @ldap_delete($conectar, $dnOU);
                  $bandera--;
                }
                  @ldap_delete($conectar, $dn);
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
?>

