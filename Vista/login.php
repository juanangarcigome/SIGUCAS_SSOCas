<?php

require_once('config.php');
require_once("lib/nusoap.php");

$casService = 'https://sac.unl.edu.ec/cas';
$thisService = 'http://localhost:8888/sacfinals/login.php';


if ($_SERVER["REQUEST_METHOD"] && $_GET["ticket"]) {
   if ($response = responseForTicket($_GET["ticket"])) {
      if ($uid = uid($response)) {
        echo $uid;
         if(autenticar($uid)==1){
          header ("Location: perfilUsuario.php");
         exit();
         }

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
   header("Location: $casService/login?service=$thisService");
}
 
 
/*
* Returns the CAS response if the ticket is valid, and false if not.
*/
function responseForTicket($ticket) {
   global $casService, $thisService;
 
   $casGet = "$casService/serviceValidate?ticket=$ticket&service=".urlencode($thisService);
 
   // See the PHP docs for warnings about using this method:
   // http://us3.php.net/manual/en/function.file-get-contents.php
   $response = file_get_contents($casGet);
 
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





<!DOCTYPE html>
<html lang="en">
<head>

  <title> Iniciar Sesión</title>
       <meta charset="utf-8">
       <meta http-equiv="X-UA-Compatible" content="IE=edge">
       <meta name="viewport" content="width=device-width, initial-scale=1">
       <meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
    


<script src="js/alertify.js"></script>
     <script src="js/jquery.js" ></script>
       <script src="js/funciones.js" ></script>


<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
      <!-- Optional theme -->
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

      <link rel="stylesheet" type="text/css" href="css/alertify.css">
       <link rel="stylesheet" type="text/css" href="css/themes/default.css">
      <!-- Latest compiled and minified JavaScript -->
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</head>

<body>


<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Inicio de Sesión</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form method="post" action="../modelo/autenticar.php">
  

<div class="row">
    <div class="col-md-4">
    </div>

    <div class="col-md-4">
     
  <div class="form-group">
    <label for="exampleInputEmail1">Usuario</label>
    <input type="text" name="user_name" class="form-control" id="user_name" aria-describedby="emailHelp" placeholder="Ingrese su Usuario" required>
    <small id="emailHelp" class="form-text text-muted">El Usuario asignado por defecto es su correo</small>
  </div>
 

  <div class="form-group">
    <label for="exampleInputPassword1">Contraseña</label>
    <input type="password" name="password" class="form-control" id="password" placeholder="Contraseña" required>
  </div>
 
  
  <center><button type="submit" name="submit" class="btn btn-primary">Ingresar</button></center>
</div>


  <div class="col-md-4">
    </div>
  </div>

</form>



      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary">Acceder</button>
      </div>
    </div>
  </div>
</div>





</body>
</html>





<script type="text/javascript">
          $(document).ready(function(){
                   $('#myModal').delay(0).fadeIn("slow");
               
});
</script>

