<?php
require_once('../Modelo/config.php');
require_once('../Modelo/funciones_interfaz.php');
session_start();
@$usuario = $_SESSION['usuario'];
@$nombre = $_SESSION['nombre'];
@$pasword = $_SESSION['pasword'];
@$apellido = $_SESSION['apellido'];
@$correo = $_SESSION['correo'];
@$cedula = $_SESSION['cedula'];

if (empty($usuario)) {
    header("Location: $server_url");
    exit();
} else {
    if (isset($usuario) && empty($correo)) {
        header("Location: $server_url" . "/Vista/indexusuario.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Perfil de Usuario</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <script src="../Controlador/js/alertify.js"></script>
        <script src="../Controlador/js/jquery.js" ></script>
        <script src="../Controlador/js/jquery.validate.min.js" ></script>
        <script src="../Controlador/js/jquery.validate.es.min.js" ></script>
        <?php echo html_init_js(); ?>

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
             <?php echo html_auth_header($nombre, $apellido); ?>
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
                            Perfil de Usuario
                        </span>
                    </div>
                    <div class="">
                        <input type="hidden" class="cedula" value="<?php echo $cedula; ?>">
                        <p class="text-center"><label for="basic-url">Datos Personales:</label></p>
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon3"><i class="glyphicon glyphicon-user"></i></span>
                            <input type="text" class="form-control" aria-describedby="basic-addon3" value="<?php echo $nombre . " " . $apellido; ?>" readonly="readonly">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon3"><i class="glyphicon glyphicon-envelope"></i></span>
                            <input type="text" class="form-control usuario" aria-describedby="basic-addon3" value="<?php echo $correo ?>" readonly="readonly">
                        </div>
                        <br>
                        <p class="text-center"><label for="basic-url">Ingrese su contraseña nueva:</label></p>
                        <form id="frmPassword">
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon3"><i class="glyphicon glyphicon-lock"></i></span>
                                <input type="password" class="form-control required passwordactual" aria-describedby="basic-addon3" placeholder="Ingrese su contraseña actual" id="passwordactual" name="act_password">
                            </div>
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon3"><i class="glyphicon glyphicon-lock"></i></span>
                                <input type="password" class="form-control required password" minlength="8" maxlength="30" aria-describedby="basic-addon3" placeholder="Ingrese su nueva contraseña" id="passwordnueva" name="new_password">
                            </div>
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon3"><i class="glyphicon glyphicon-lock"></i></span>
                                <input type="password" class="form-control required"  minlength="8" maxlength="30" equalTo="#passwordnueva" aria-describedby="basic-addon3" placeholder="Reingresar su nueva contraseña" id="passwordnueva1" name="con_password">

                            </div>
                        </form>
                        <br>
<div id="cargando" style="display:none; color:green;"><center>Cargando...</center></div>

                        <button type="button" class="btn btn-primary btn-block" id="actualizar_contra">Actualizar contraseña</button>                        
                    </div>
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
