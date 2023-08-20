<?php

require_once('config.php');
require_once("lib/nusoap.php");


if (@$_SERVER["REQUEST_METHOD"] && @$_GET["ticket"]) {
   if ($response = responseForTicket($_GET["ticket"])) {
      if ($uid = uid($response)) {
         if(autenticar($uid)==1){
          echo "Sesión con éxito";
          header ("Location: Vista/perfilUsuario.php");
         exit();
         }else{ echo "Sesión no con éxito";}

      }
      else {
         echo "Could not get UID from response.";
      }
   }
   else {
      echo "The response was not valid.";
   }
}
else {
  if($_GET['cas']=="noCas"){

  }else{
   header("Location: $cas_url/login?service=$server_url/vistaLogin.php");
  }
}
 
 function autenticar($uid){
  global $host;
  global $port;
  global $ldap_admin_user;
  global $ldap_admin_password;
  global $baseAdmin;
  global $baseGeneral;
  $conectar = ldap_connect("ldap://{$host}:{$port}") or die("No se puede conectar al servidor LDAP");
  ldap_set_option($conectar, LDAP_OPT_PROTOCOL_VERSION, 3);

  if ($conectar) {
    if(@ldap_bind($conectar, "cn={$ldap_admin_user},{$baseAdmin}", $ldap_admin_password)){
      $filtro = "uid=$uid";
        $arreglo = array("uid","sn", "givenName", "mail","userpassword");
        $resultado = @ldap_search($conectar, $baseGeneral, $filtro, $arreglo);
      $entrada = ldap_get_entries($conectar, $resultado);
      $valor = ldap_count_entries($conectar, $resultado);
            for ($i=0; $i<$entrada["count"]; $i++){
                $usuario = $entrada[$i]["uid"][0];
                $apellido = $entrada[$i]["sn"][0];
               $nombre = $entrada[$i]["givenname"][0];
               $correo = $entrada[$i]["mail"][0];
               $password = $entrada[$i]["userpassword"][0];
               $token =1;

                 session_start();
                $_SESSION['usuario']=$usuario;
                $_SESSION['password']=$password;
                $_SESSION['nombre']=$nombre;
                $_SESSION['apellido']=$apellido;
                $_SESSION['correo']=$correo;
            }
    }else{
      $token=2;
  }
}

return $token;
 }
 
/*
* Returns the CAS response if the ticket is valid, and false if not.
*/
function responseForTicket($ticket) {
  global $cas_url;
  global $server_url;
  
  $arrContextOptions=array(
    "ssl"=>array(
        "verify_peer"=>false,
        "verify_peer_name"=>false,
    ),
); 
 
   $casGet = "$cas_url/serviceValidate?ticket=$ticket&service=".urlencode($server_url."/vistaLogin.php");
 
   // See the PHP docs for warnings about using this method:
   // http://us3.php.net/manual/en/function.file-get-contents.php
   $response = file_get_contents($casGet,false,stream_context_create($arrContextOptions));
   // $response = file_get_contents($casGet, false, stream_context_create(array('ssl' => array('verify_peer' => false, 'verify_peer_name' => false))));
 
   if (preg_match('/cas:authenticationSuccess/', $response)) {
      return $response;
   }
   else {
      return false;
   }
}
 
/*
* Returns the UID from the passed in response, or it
* returns false if there is no UID.
*/
function uid($response) {
   // Turn the response into an array
   $responseArray = preg_split("/\n/", $response);
   // Get the line that has the cas:user tag
   $casUserArray = preg_grep("/<\/cas:user>/", $responseArray);
   if (is_array($casUserArray)) {
      $uid = trim(strip_tags(implode($casUserArray)));
         return $uid;
   }
   return false;
}

?>
