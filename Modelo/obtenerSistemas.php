<?php
header('Access-Control-Allow-Origin: *');
session_start();
$user_name = $_SESSION['usuario'];
$password = $_SESSION['password'];
//@$grupo1 = $_POST['grupo1'];
require_once("config.php");

$conectar = ldap_connect("ldap://{$host}:{$port}") or die("No se puede conectar al servidor LDAP");
ldap_set_option($conectar, LDAP_OPT_PROTOCOL_VERSION, 3);


    if ($conectar) {
        if(@ldap_bind($conectar, "cn={$user_name},{$baseAdmin}", $password)){

                $filtro = "cn=*";
                $arreglo = array("cn");
                $resultado = @ldap_search($conectar, $baseGeneral2, $filtro, $arreglo) or exit("Buscando...");
                $entrada = @ldap_get_entries($conectar, $resultado);
                $valor = @ldap_count_entries($conectar, $resultado);
                $firs = @ldap_first_entry($conectar, $resultado);
                $i = 0;
                do{
                $dn = ldap_get_dn($conectar, $firs);
                $cn = ldap_explode_dn($dn, 0);
                $cn2 = $entrada[$i]["cn"][0];

              echo '<input type="checkbox" name="sistemas" value="'.$cn2.'">'." ".$cn2.' <br>';

                $i++;
                }while($firs = ldap_next_entry($conectar, $firs));
        }else{
            return "Datos incorrectos";
        }
    }else{
        return "No hay conexión con el servidor LDAP";
    }
?>
