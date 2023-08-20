<?php
header('Access-Control-Allow-Origin: *');
session_start();
@$user_name = $_SESSION['usuario'];
@$password = $_SESSION['password'];
@$passwordActual = $_POST['passwordActual'];
@$passwordNueva = $_POST['passwordNueva'];
@$passwordNueva2 = $_POST['passwordNueva2'];

/*$hashFormat = "$2y$10$";
$salt = "cas&ySiGUCAS&LdapCas22";
$key = $hashFormat.$salt;
$contra = hash_hmac('sha256', $passwordNueva2, $key, false);
$contraactual = hash_hmac('sha256', $passwordActual, $key, false);
*/
require_once('config.php');
require_once('correo.php');

$conectar = ldap_connect("ldap://{$host}:{$port}") or die("No se puede conectar al servidor LDAP");
ldap_set_option($conectar, LDAP_OPT_PROTOCOL_VERSION, 3);

        if ($conectar) {
            if ($password ==$passwordActual) {
                if($passwordNueva == $passwordNueva2){
                  $filtro = "uid=$user_name";
                  $arreglo = array("eduPersonTargetedID");
                  $resultado = @ldap_search($conectar, $baseGeneral, $filtro, $arreglo) or  exit("Buscando...");
 $entrada = ldap_get_entries($conectar, $resultado);
                                //@$uid = $entradaA[$i]["uid"][0];
                  //@$contrasenaA = $entradaA[$i]["userpassword"][0];
                  @$DNI = $entrada[0]["edupersontargetedid"][0];
              
if($passwordNueva == $DNI) {
	$token = 3;   //La nueva contraseña no coincide
                    echo "$token";
}else{
                  $firs = @ldap_first_entry($conectar, $resultado);
                  $dn = ldap_get_dn($conectar, $firs);
                  if(@ldap_bind($conectar, "cn={$ldap_admin_user},{$baseAdmin}", $ldap_admin_password)){
                    $info["userPassword"][0] = "$passwordNueva2";
                    @ldap_mod_replace($conectar, $dn, $info);
                    $token = 4; //Funciono
                    correo_cambio_contra($_SESSION['correo']);
                    echo $token;
                    session_destroy();
                  }
}
                }else{
                    $token = 2;   //La nueva contraseña no coincide
                    echo "$token";
                }
            }else{
                $token = 1;  //La antigua contraseña no coincide
                echo "$token";
            }
        }else{
            $token = 0; //Error servidor
            echo "$token";
        }
?>

