<?php
header('Access-Control-Allow-Origin: *');
session_start();
require_once('correo.php');
$usuario= $_SESSION['usuario'];
$password = $_SESSION['password'];


$usuariov = $_POST['usuariov'];
$gruposv = $_POST['gruposv'];
$usuariosv = $_POST['usuariosv'];

require_once('config.php');

$conectar = ldap_connect("ldap://{$host}:{$port}") or die("No se puede conectar al servidor LDAP");
ldap_set_option($conectar, LDAP_OPT_PROTOCOL_VERSION, 3);



    $cn = explode(" ", $gruposv);
    $bandera = count($cn) - 1;


            if(empty($usuariosv)){
            $banderaU=1;
               $usuV[0]=$usuariov;;
            }else{
             $usuV = explode(" ", $usuariosv);
            $banderaU = count($usuV) -1;
            }



    if($conectar){
        if(@ldap_bind($conectar, "cn={$usuario},{$baseAdmin}", $password)){

            for($i=0; $i<$banderaU; $i++){

            $info["memberUid"][0]= $usuV[$i];


            for ($j=0; $j<$bandera; $j++) {

                //Aqu debe ir el for anterior que te mencione para que guarde todos los datos
                if(@ldap_mod_add($conectar, $cn[$j], $info) == 1){
                    $token = 1;
                    correo_vincular($usuario , $cn[$j]);
                    echo $token;

                }else{
                      $token =0;
                    echo $token;
                }

            }
        }

        }else{
            $token = 2;
                    echo $token;
        }
    }else{
       $token = 3;
                    echo $token;
    }





?>
