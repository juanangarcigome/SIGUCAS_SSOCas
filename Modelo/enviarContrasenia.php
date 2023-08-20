<?php
header('Access-Control-Allow-Origin: *');
session_start();
//$user_name = $_SESSION['usuario'];
//$password = $_SESSION['password'];
$cedula = $_POST['dni'];
$usuario = $_POST['user'];

require_once('config.php');
require_once('correo.php');
require_once('vendor/autoload.php');
use Firebase\JWT\JWT;

$conectar = ldap_connect("ldap://{$host}:{$port}") or die("No se puede conectar al servidor LDAP");
ldap_set_option($conectar, LDAP_OPT_PROTOCOL_VERSION, 3);
    if($conectar) {
        if(@ldap_bind($conectar, "cn=$ldap_admin_user,{$baseAdmin}", $ldap_admin_password)){
            $filtro = "uid=$usuario";
            $arreglo = array("mail","eduPersonTargetedID");
            $resultado = @ldap_search($conectar, $baseGeneral, $filtro, $arreglo) or exit("Buscando...");
            $entrada = @ldap_get_entries($conectar, $resultado);
            //print_r($entrada);
            $valor = @ldap_count_entries($conectar, $resultado);
            if($valor != 0){
                $entrada = @ldap_get_entries($conectar, $resultado);
                $dni = @implode($entrada[0]["edupersontargetedid"]);
		$destino = $entrada[0]["mail"][0];
                $dnivalido = substr($dni, 1);
                if($cedula == $dnivalido) {

                    $time = time();
                    $hashFormat = "$2y$10$";
                    $salt = "cas&ySiGUCAS&LdapCas22";
                    $key = $hashFormat.$salt;
                    $token = array(
                        "uid" => "$usuario",
                        "iat" => $time,
                        "exp" => $time + 60
                    );
                    $jwt = JWT::encode($token, $key);
                    $enlace=  $server_url."/Vista/cambioContrasenia.php?token=$jwt";
                    correo_restablecer(@$destino , $enlace);
                    $token = $destino;    //Se envía la nueva contraseña
                    echo "$token";
                } else {
                    $token = 2;   //la cedula no es valida
                    echo "$token";
                }
            }else{
                $token = 1; //No existe ese usuario
                echo "$token";
            }
            }
    }else{
        $token = 0; //no se conecto
        echo "$token";
    }
?>
