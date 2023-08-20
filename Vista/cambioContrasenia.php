<?php
require_once('../Modelo/vendor/autoload.php');
require_once('../Modelo/config.php');
use \Firebase\JWT\JWT;

$variable = $_GET['token'];
$hashFormat = "$2y$10$";
$salt = "cas&ySiGUCAS&LdapCas22";
$key = $hashFormat.$salt;

try {
   $data = JWT::decode($variable, $key, array('HS256'));
   $dato = $data->uid;
  //print_r("Usuario: " . $data->uid . "<br />");
   //CAMBIAR DIRECCIÓN DEPENDIENDO EL SERVIDOR
    } catch (\Exception $e) {

      echo ("<script LANGUAGE='JavaScript'>
            window.alert('EL ENLACE CADUCÓ');
            window.location.href='../index.php';
         </script>");

    }

function html_init_js(){
    global $server_url;
    $texto =
    "<script type='text/javascript'>;
        var server_url='".$server_url."';
    </script>
    <script src='../Controlador/js/funciones.js'></script>";
    return $texto;
}

echo html_init_js();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Restablecer Contraseña</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <script src="../Controlador/js/alertify.js"></script>
        <script src="../Controlador/js/jquery.js" ></script>
        <script src="../Controlador/js/jquery.validate.min.js" ></script>
        <script src="../Controlador/js/jquery.validate.es.min.js" ></script>

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="css/alertify.css">
        <link rel="stylesheet" type="text/css" href="css/themes/default.css">
        <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <link rel="stylesheet" type="text/css" href="css/login.css?v=1.3">           
    </head>
    <body>
        <div class="limiter">
          <div class="jumbotron">
            <style type="text/css" media="screen">
            .jumbotron {
             padding-top: 20px;
             padding-bottom: 20px;
              }
                    </style>
             <div class="container">
                 <div class="row">
                     <div class="col-sm-8 col-md-8">
                  <h2>Sistema de Administración Central - SAC</h2>
          <p>SAC - Es un sistema para gestionar la información de usuarios almacenada en un servidor OpenLDAP.</p>
             </div>
             <div class="col-sm-4 col-md-4">
                 <center><img width="300px" height="100px" src="img/sigucas.png" alt="Sistema de Autenticació Único"></center>
             </div>
         </div>
     </div>
 </div>

            <section class="container-login100">

                <!-- Modal -->
                <div class="wrap-login100" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">

                    <div class="">                       
                        <span class="form-title">
                            Recuperar Contraseña
                        </span>
                    </div>
<p class="text-center"><label for="basic-url">Ingrese su contraseña nueva:</label></p>
<form id="frmPassword">
<div class="input-group">
  <span class="input-group-addon" id="basic-addon3"><i class="glyphicon glyphicon-lock"></i></span>
  <input type="password" class="form-control required"  minlength="8" maxlength="30" aria-describedby="basic-addon3" placeholder="Ingrese su nueva contraseña" id="passwordnueva">
</div>
<div class="input-group">
  <span class="input-group-addon" id="basic-addon3"><i class="glyphicon glyphicon-lock"></i></span>
  <input type="password" class="form-control required"  minlength="8" maxlength="30" equalTo="#passwordnueva" aria-describedby="basic-addon3" placeholder="Confirme su nueva contraseña" id="passwordnueva1">
</form>
</div>
<br>
<div id="restablecercontra" style="display:none; color:green;"><center>Cargando...</center></div>
<button type="button" class="btn btn-primary btn-block" onclick="restableceContrasenia('<?php echo $dato ?>');" >Restablecer Contraseña</button>

<button type="button" class="btn btn-secondary btn-block"><a href='<?php echo $server_url; ?>'> FINALIZAR </a></button>
                </div>
            </section>
        </div>
        <script type="text/javascript">
            $(function () {
                var form = $('#frmPassword').validate();
            });
        </script>
    </body>
<div class="limiter-footer">
            <center>
                Copyright (CC BY) 2019 - Wilmer Antonio Aguilar (waaguilars@unl.edu.ec) -
                <br>
                Manuel Stalin Armijos (manuel.s.armijos@unl.edu.ec) - Desarrollo SiGUCAS.
            </center>
</div>

</html>
