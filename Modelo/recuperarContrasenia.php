<?php


//session_destroy();
//header ("Location: http://localhost/adminprueba1/indexldap.php");



?>

<!DOCTYPE html>
<html lang="en">
<head>

	<title>Recuperar Contraseña</title>
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
       <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
      <!-- Latest compiled and minified JavaScript -->
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>


<body>


	<section class="intro">



<!-- Modal -->
<div class="modal fade" id="recuperar" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <p class="lead"><h5 class="modal-title" id="exampleModalLongTitle"><center>Recuperar Contraseña</center></h5></p>

      
      </div>
      <div class="modal-body">

      <center><img src="perfil1.png" class="img-responsive" alt="texto alternativo descriptivo" /></center>

<p class="text-center"><label for="basic-url">Ingrese su número de cédula:</label></p>
<div class="input-group">
  <span class="input-group-addon" id="basic-addon3"><i class="glyphicon glyphicon-lock"></i></span>
  <input type="text" class="form-control" aria-describedby="basic-addon3" placeholder="Ingrese su número de cédula" id="cedula">
</div>

<p class="text-center"><label for="basic-url">Ingrese su usuario:</label></p>
<div class="input-group">
  <span class="input-group-addon" id="basic-addon3"><i class="glyphicon glyphicon-lock"></i></span>
  <input type="text" class="form-control" aria-describedby="basic-addon3" placeholder="Ingrese su usuario" id="usuario">
</div>
<br>

<button type="button" class="btn btn-primary btn-block" onclick= "restablecerContra1();" >Recuperar Contraseña</button>

<button type="button" class="btn btn-succes btn-block" id="cancelar"><a href="index.php">Cancelar</button>


      </div>
      
    </div>
  </div>
</div>
</body>
</html>

<script type="text/javascript">

    $('#recuperar').modal({backdrop: 'static', keyboard: false}, 'show');
</script>
