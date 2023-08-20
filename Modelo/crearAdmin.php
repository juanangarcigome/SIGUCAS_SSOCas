<?php
header('Access-Control-Allow-Origin: *');   
session_start();
require_once('../Modelo/config.php'); 
$user_name = $_SESSION['usuario'];
$password = $_SESSION['password'];
$user = $_POST['usuario'];
$passw = $_POST['contra'];
$descr = $_POST['descrip'];
                  // puerto del servidor LDAP  
// Conexión al servidor LDAP
$conectar = ldap_connect("ldap://{$host}:{$port}") or die("No se puede conectar al servidor LDAP");
ldap_set_option($conectar, LDAP_OPT_PROTOCOL_VERSION, 3);

    if($conectar) {
        if(@ldap_bind($conectar, "cn={$user_name},{$baseAdmin}", $password)) {
                //$info["cn"][0] = $user;
                $info["objectclass"][0] = "top";
                $info["objectclass"][1] = "organizationalRole";
                $info["objectclass"][2] = "simpleSecurityObject";
                $info["userPassword"][0] = "$passw";
                $info["description"][0] = "$descr";
               
                    if(@ldap_add($conectar, "cn={$user},{$baseAdmin}" , $info)){
                    	echo "$user";
                    }else{
                        $token = 2;
                        echo "$token";
                    }
        }else{
        	$token = 3;
        	echo "$token";
        }   
    }else{
    	$token = 0;
        echo "$token";
    }
?>
