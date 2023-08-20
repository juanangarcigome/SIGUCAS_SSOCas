<?php
require_once('Modelo/config.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>

	<title>Sistema de Administración Único CAS</title>
	    <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
	    <script src="Controlador/js/alertify.js"></script>
      <script src="Controlador/js/jquery.js" ></script>
      <script src="Controlador/js/funciones.js" ></script>

      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
      <!-- Optional theme -->
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
      <link rel="stylesheet" type="text/css" href="Vista/css/alertify.css">
      <link rel="stylesheet" type="text/css" href="Vista/css/themes/default.css">
      <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
      <!-- Latest compiled and minified JavaScript -->
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

      <style type="text/css">
        .limiter-footer {
         color: #131212;
          background-color: #eee;
          padding: 20px 0px;
          background-image: url("../img/pattern07.png");
          position: relative;
          bottom: 0;
          left: 0;
          right: 0;
          height: auto;
      }
      </style>

      <style type="text/css">
      .jumbotron {
        padding-top: 0px; */
        padding-bottom: 0px; */
        margin-bottom: 0px; */
      }
      </style>

<body>
	<div class="jumbotron">
		<div class="container">
			<div class="row">
				<div class="col-sm-4 col-md-8">
				  <h2 style="text-align: justify">Sistema de Gestión Único CAS - SiGUCAS</h2>
			     <p style="text-align: justify">SiGUCAS - Permite el acceso a múltiples aplicaciones web
				    mediante un Inicio de Sesión Único SSO.</p>
			  </div>
			  <div class="col-sm-8 col-md-4">
				 <center><img width="300px" height="100px" src="Vista/img/sigucas.png" alt="Sistema de Autenticació Único"></center>
			  </div>
		  </div>
	  </div>
 </div>

<div class="limiter-header"></div>

</body>

<div class="container"><br>
  <div class="row">
    <?php
      $total = count($sistemas_integrar);
        for ($i=0; $i <$total ; $i++) {
        ?>
    <div class="col-sm-6 col-md-4">
	    <div class="thumbnail">
        <p><center><b><?php echo $sistemas_integrar[$i][0] ?></b></center></>
        <img style="width:330px; height:150px;" src="<?php echo $sistemas_integrar[$i][1]?>" alt="Sistema Jenkins"  title="Sistema Jenkins">
        <div class="caption">
		        <center><a href="<?php echo $sistemas_integrar[$i][3] ?>" role="button" class="btn btn-link" title="Acceso" target="_blank">Acceder</a></center>
        </div>
      </div>
    </div>
    <?php
    }
    ?>
  </div>
</div>


<!-- <div class="row">
  <div class="col-sm-6 col-md-4">
    <div class="thumbnail">
      <img style="width:350px; height:197px;" src="Moodle.png" alt="Sistema Moodle"  title="Sistema Moodle">
      <div class="caption">

        <a href="https://10.30.22.89:8443/cas/login?service=http%3A%2F%2F10.30.22.89%2Fmoodle%2Flogin%2Findex.php%3FauthCAS%3DCAS" role="button" class="btn btn-link" title="Acceso a usuarios">Usuario</a> <a>|</a>   <a href="http://10.30.22.89/moodle/login/index.php?authCAS=NOCAS" role="button" class="btn btn-link" title="Acceso Administrador">Administrador</a>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-md-4">
    <div class="thumbnail">
      <img style="width:350px; height:197px;" src="wordpress.png" alt="Sistema Wordpress" title="Sistema Wordpress">
      <div class="caption">

        <a href="https://10.30.22.89:8443/cas/login?service=http://10.30.22.89/wordpress/wp-admin/" role="button" class="btn btn-link" title="Acceso a usuarios">Usuario</a> <a>|</a>   <a href="https://10.30.22.89:8443/cas/login?service=http://10.30.22.89/wordpress/wp-admin/" role="button" class="btn btn-link" title="Acceso Administrador">Administrador</a>
      </div>
    </div>
  </div>

  <div class="col-sm-6 col-md-4">
    <div class="thumbnail">
      <img style="width:350px; height:197px;" src="Jenkins.png" alt="Sistema Jenkins"  title="Sistema Jenkins">
      <div class="caption">

        <a href="https://10.30.22.89:8443/cas/login?service=http%3A%2F%2F10.30.22.89%3A8001%2FsecurityRealm%2FfinishLogin" role="button" class="btn btn-link" title="Acceso a usuarios">Usuario</a> <a>|</a>   <a href="https://10.30.22.89:8443/cas/login?service=http%3A%2F%2F10.30.22.89%3A8001%2FsecurityRealm%2FfinishLogin" role="button" class="btn btn-link" title="Acceso Administrador">Administrador</a>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-sm-6 col-md-4">
    <div class="thumbnail">
      <img style="width:350px; height:197px;" src="drupal2.jpg" alt="Sistema Drupal" title="Sistema Drupal">
      <div class="caption">
        <a href="https://10.30.22.89:8443/cas/login?service=http%3A//10.30.22.89/drupal/casservice" role="button" class="btn btn-link" title="Acceso a usuarios">Usuario</a> <a>|</a>   <a href="http://10.30.22.89/drupal/user/login" role="button" class="btn btn-link" title="Acceso Administrador">Administrador</a>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-md-4">
    <div class="thumbnail">
      <img style="width:350px; height:197px;" src="gitlab.png" alt="Sistema GitLab" title="Sistema Gitlab">
      <div class="caption">

        <a href="#" role="button" class="btn btn-link" title="Acceso a usuarios">Usuario</a> <a>|</a>   <a href="#" role="button" class="btn btn-link" title="Acceso administrador">Administrador</a>
      </div>
    </div>
  </div>

  <div class="col-sm-6 col-md-4">
    <div class="thumbnail">
      <img style="width:350px; height:197px;" src="images1.png" alt="SiGUCAS" title="Sistema SiGUCAS">
      <div class="caption">
        <a href="http://localhost:8888/sacfinal/" role="button" class="btn btn-link" title="Acceso al perfil de usuario">Usuario</a> <a>|</a>   <a href="http://localhost:8888/sacfinal/" role="button" class="btn btn-link" title="Acceso al módulo de administración">Administrador</a>
  </div>
    </div>
  </div>
</div>
</div> -->
</head>

<div class="limiter-footer">
  <center>
    Copyright (CC BY) 2019 - Wilmer Antonio Aguilar (waaguilars@unl.edu.ec) -<br>
    Manuel Stalin Armijos (manuel.s.armijos@unl.edu.ec) - Desarrollo SiGUCAS.
  </center>
</div>
</html>
