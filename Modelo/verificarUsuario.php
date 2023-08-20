<?php

$nombres = $_POST['nombre'];
$password= $_POST['pasword'];

// $hashFormat = "$2y$10$";
// $salt = "cas&ySiGUCAS&LdapCas22";
// $key = $hashFormat.$salt;
// $contra = hash_hmac('sha256', $password, $key, false);
require_once('../Modelo/config.php');
require_once("../Modelo/lib/nusoap.php");


  $conectar = ldap_connect("ldap://{$host}:{$port}") or die("No se puede conectar al servidor LDAP");
  ldap_set_option($conectar, LDAP_OPT_PROTOCOL_VERSION, 3);

  if ($conectar) {
    if(@ldap_bind($conectar, "cn={$nombres},{$baseAdmin}", $password)){
      $filtro = "cn=$nombres";
      $arreglo = array("cn");
      $resultado = ldap_search($conectar, "cn={$nombres},{$baseAdmin}", $filtro, $arreglo) or exit("Buscando...");
      $entrada = ldap_get_entries($conectar, $resultado);
      $valor = ldap_count_entries($conectar, $resultado);
            for ($i=0; $i<$entrada["count"]; $i++){
                $nombre = $entrada[$i]["cn"][0];
                 $datos[$i][0] = $nombre;
                 $token = 1;
                 session_start();
                 	$_SESSION['usuario']=$nombres;
			$_SESSION['password']=$password;
                   echo $token;
            }
    }else{
      if(    @ldap_bind($conectar, "uid={$nombres},{$baseEstudiantes}", $password)
        || @ldap_bind($conectar, "uid={$nombres},{$baseDocentes}", $password)
        || @ldap_bind($conectar, "uid={$nombres},{$baseServidores}", $password)
        || @ldap_bind($conectar, "uid={$nombres},{$baseTrabajadores}", $password)
        || @ldap_bind($conectar, "uid={$nombres},{$baseOtros}", $password)){

        $filtro = "uid=$nombres";
        $arreglo = array("uid","sn", "givenName", "mail","userpassword");
        $resultado = @ldap_search($conectar, $baseGeneral, $filtro, $arreglo);
        $entrada = ldap_get_entries($conectar, $resultado);
          for ($i=0; $i<$entrada["count"]; $i++){
               $usuario = $entrada[$i]["uid"][0];
                $apellido = $entrada[$i]["sn"][0];
               $nombre = $entrada[$i]["givenname"][0];
               $correo = $entrada[$i]["mail"][0];
               $password = $entrada[$i]["userpassword"][0];
               $datos[$i][0] = $usuario;
               $datos[$i][1] = $nombre;
               $datos[$i][2] = $apellido;
               $datos[$i][3] = $correo;
                $datos[$i][4] = $password;
                $token = 2;
                session_start();
                $_SESSION['usuario']=$nombres;
								$_SESSION['password']=$password;
								$_SESSION['nombre']=$nombre;
								$_SESSION['apellido']=$apellido;
								$_SESSION['correo']=$correo;
                echo $token;
          }
      }else{
        $token = 3;
        echo $token;
      }
  }

  }else{
    $token = 4;
    echo $token;
  }
?>
