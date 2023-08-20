<?php

header('Access-Control-Allow-Origin: *');   
$user_name = $_POST['usuario'];
$passwordNueva = $_POST['passN'];
$passwordNueva2 = $_POST['passN2'];



require_once('config.php');
require_once('correo.php');

$conectar = ldap_connect("ldap://{$host}:{$port}") or die("No se puede conectar al servidor LDAP");
ldap_set_option($conectar, LDAP_OPT_PROTOCOL_VERSION, 3);
        if ($conectar) {
                if($passwordNueva == $passwordNueva2){
                    $filtro = "uid=$user_name";
                    $arreglo = array("mail");
                    $resultado = @ldap_search($conectar, $baseGeneral, $filtro, $arreglo) or exit("Buscando...");
		$entrada = ldap_get_entries($conectar,$resultado);
                    $firs = @ldap_first_entry($conectar, $resultado);
                    $dn = ldap_get_dn($conectar, $firs);
                    if(@ldap_bind($conectar, "cn={$ldap_admin_user},{$baseAdmin}", $ldap_admin_password)){
                        $info["userPassword"][0] = "$passwordNueva";
                        @ldap_mod_replace($conectar, $dn, $info);
$destino = $entrada[0]["mail"][0];
correo_cambio_contra($destino);
                        $token = 2;
                        echo "$token";
                    }
                }else{
                    $token = 1;
                    echo "$token";   
                }
        }else{
            $token = 0;
            echo "$token";
        }
?>
