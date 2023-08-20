<?php
session_start();
@$usuario = $_SESSION['usuario'];
@$pasword = $_SESSION['pasword'];
@$correo = $_SESSION['correo'];

require_once('Modelo/login_cas.php');



function html_init_js(){
    global $server_url;
    $texto =
    "<script type='text/javascript'>;
        var server_url='".$server_url."';
    </script>
    <script src='Controlador/js/funciones.js'></script>";
    return $texto;
}

echo html_init_js();


if (isset($usuario) && empty($correo)) {
    header("Location: $server_url" . "/Vista/indexusuario.php");
    exit();
} else {
    if (isset($usuario) && isset($correo)) {
        header("Location: $server_url" . "/Vista/perfilUsuario.php");
        exit();
    }
}
?>


<!DOCTYPE html>
<html lang="en">
    <head>

        <title>Inicio de sesión Administrador SAC</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <script src="Controlador/js/alertify.js"></script>
        <script src="Controlador/js/jquery.js" ></script>
            <script src="Controlador/js/funciones.js" ></script>
        <script src="Controlador/js/jquery.validate.min.js" ></script>
        <script src="Controlador/js/jquery.validate.es.min.js" ></script>
    
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="Vista/css/alertify.css">
        <link rel="stylesheet" type="text/css" href="Vista/css/themes/default.css">
        <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <link rel="stylesheet" type="text/css" href="Vista/css/login.css">
        <style type="text/css" media="screen">
            .jumbotron {
           padding-top: 20px;
           padding-bottom: 20px;
            }
        </style>

    </head>
    <body>
        <div class="limiter">
          <div class="jumbotron">
             <div class="container">
                <div class="row">
                  <div class="col-sm-8 col-md-8">
                    <h2>Sistema de Administración Central - SAC</h2>
                    <p>SAC - Es un sistema para gestionar la información de usuarios almacenada en un servidor OpenLDAP.</p>
                 </div>
                 <div class="col-sm-4 col-md-4">
                   <center><img width="300px" height="100px" src="Vista/img/sigucas.png" alt="Sistema de Autenticació Único"></center>
                 </div>
                </div>
            </div>
          </div>

          <section class="container-login100">
                <!-- Modal -->
                <div class="wrap-login100" id="exampleModalCenter">

                    <div class="">

                        <center><h2> Inicio de Sesión único </h2></center>
                        <br>
                        <center><img src="Vista/img/login1.png" alt="Inicio de Sesión"></center>
<br>

                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon3"><i class="glyphicon glyphicon-user"></i></span>
                            <input type="text" class="form-control" id="usuario" aria-describedby="basic-addon3" placeholder="Ingrese su usuario: ejemplo@unl.edu.ec">
                        </div>
                        <br>

                        <div class="input-group">
                            <span class="input-group-addon " id="basic-addon3"><i class="glyphicon glyphicon-lock"></i></span>
                            <input type="password" class="form-control" id="pasword" aria-describedby="basic-addon3" placeholder="Ingrese su contraseña">
                        </div>
                        <br>

                        <button type="button" class="btn btn-primary btn-block" id="autenticar">Ingresar</button>
                        <a class="btn btn-default btn-block" href="recuperarContrasenia.php"> Recuperar contraseña </a>

                    </div>


                </div>
        </div>

    </body>

<div class="limiter-footer">
            <center>
                Copyright (CC BY) 2019 - Wilmer Antonio Aguilar (waaguilars@unl.edu.ec) -
                <br>
                Manuel Stalin Armijos (manuel.s.armijos@unl.edu.ec) - Desarrollo SiGUCAS.
            </center>
</div>

</html>
