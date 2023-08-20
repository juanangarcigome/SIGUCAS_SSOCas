<?php
header('Access-Control-Allow-Origin: *');
session_start();
@$user_name =$_SESSION['usuario'];
@$password = $_SESSION['password'];
$sistema = $_POST['sistema'];
$str = strtolower($sistema);

require_once('config.php');
$conectar = ldap_connect("ldap://{$host}:{$port}") or die("No se puede conectar al servidor LDAP");
ldap_set_option($conectar, LDAP_OPT_PROTOCOL_VERSION, 3);
    if ($conectar) {
        if(@ldap_bind($conectar, "cn=$user_name,{$baseAdmin}", $password)){


                $filtroE = "uid=*";
                $arregloE = array("uid");

                if($str=="estudiantes"){
                  $resultadoE = ldap_search($conectar, $baseEstudiantes, $filtroE, $arregloE) or exit("Buscando...");
                }else if($str=="docentes"){
                  $resultadoE = ldap_search($conectar, $baseDocentes, $filtroE, $arregloE) or exit("Buscando...");
                } else if($str=="servidores"){
                $resultadoE = ldap_search($conectar, $baseServidores, $filtroE, $arregloE) or exit("Buscando...");
                }else if($str=="trabajadores"){
                $resultadoE = ldap_search($conectar, $baseTrabajadores, $filtroE, $arregloE) or exit("Buscando...");
                }else if($str=="otros"){
                $resultadoE = ldap_search($conectar, $baseOtros, $filtroE, $arregloE) or exit("Buscando...");
                }
                $entrada = @ldap_get_entries($conectar, $resultadoE);
                $firsE = @ldap_first_entry($conectar, $resultadoE);
                $dnE = ldap_get_dn($conectar, $firsE);
                $a = 0;

                for ($i=0; $i<$entrada["count"]; $i++){
                  $nombre = $entrada[$i]["uid"][0];
                  if($str=="estudiantes"){
                    ldap_delete($conectar, "uid={$nombre},{$baseEstudiantes}");
                  }else if($str=="docentes"){
                    ldap_delete($conectar, "uid={$nombre},{$baseDocentes}");
                  } else if($str=="servidores"){
                  ldap_delete($conectar, "uid={$nombre},{$baseServidores}");
                  }else if($str=="trabajadores"){
                  ldap_delete($conectar, "uid={$nombre},{$baseTrabajadores}");
                  }else if($str=="otros"){
                  ldap_delete($conectar, "uid={$nombre},{$baseOtros}");
                  }
                  $a = $a+1;
                }
                echo "$a";
              }else{
                $token = 1;
                echo "$token";
              }
            }else{
              $token = 0;
              echo "$token";
            }


?>
