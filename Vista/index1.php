<?php

header('Access-Control-Allow-Origin: *');
session_start();
$usuario = "admin";
$password = "ldap1234";

	require_once('config.php');

	$conectar = ldap_connect("ldap://{$host}:{$port}") or die("No se puede conectar al servidor LDAP");
	ldap_set_option($conectar, LDAP_OPT_PROTOCOL_VERSION, 3);


		$filtro = "uid=*";

		$arreglo = array("edupersontargetedid","sn", "givenname", "mail","telephonenumber","uid");


		/*if($seleccion=="Estudiantes"){
	    $resultado = ldap_search($conectar, $baseEstudiantes, $filtro, $arreglo) or exit("Buscando...");
		}else if($seleccion=="Docentes"){
	    $resultado = ldap_search($conectar, $baseDocentes, $filtro, $arreglo) or exit("Buscando...");
		} else if($seleccion=="Servidores"){
		$resultado = ldap_search($conectar, $baseServidores, $filtro, $arreglo) or exit("Buscando...");
		}else if($seleccion=="Trabajadores"){
		$resultado = ldap_search($conectar, $baseTrabajadores, $filtro, $arreglo) or exit("Buscando...");
		}else if($seleccion=="Otros"){
		$resultado = ldap_search($conectar, $baseOtros, $filtro, $arreglo) or exit("Buscando...");
		}else{
			$resultado = ldap_search($conectar, $baseEstudiantes, $filtro, $arreglo) or exit("Buscando...");
		}*/

	$resultado = ldap_search($conectar, $baseEstudiantes, $filtro, $arreglo) or exit("Buscando...");
		$entrada = ldap_get_entries($conectar, $resultado);
		$valor = ldap_count_entries($conectar, $resultado);


		if ($valor==0){

        return 0;

		}else{
			$a = 0;
					for ($i=0; $i<$entrada["count"]; $i++){
						@$cedula = $entrada[$i]["edupersontargetedid"][0];
					    $nombre = $entrada[$i]["sn"][0];
					    $apellido = $entrada[$i]["givenname"][0];
					     $correo = $entrada[$i]["mail"][0];
					    $telefono = $entrada[$i]["telephonenumber"][0];
					    $uid = $entrada[$i]["uid"][0];
					      $datos[$i][0] = $cedula;
					     $datos[$i][1] = $nombre;
					     $datos[$i][2] = $apellido;
					     $datos[$i][3] = $correo;
					     $datos[$i][4] = $telefono;
					     $datos[$i][5] = $uid;
					     $datos[$i][6] = $seleccion;

}
}

echo "$valor";


?>


<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="datatables.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.18/datatables.min.css"/>

<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.18/datatables.min.js"></script>


<script type="text/javascript" charset="utf8" src="js/jquery.js"></script>


<script type="text/javascript" charset="utf8" src="datatables.js"></script>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
      <!-- Optional theme -->
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

      <link rel="stylesheet" type="text/css" href="css/alertify.css">
       <link rel="stylesheet" type="text/css" href="css/themes/default.css">
      <!-- Latest compiled and minified JavaScript -->
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>


      </head>

</head>
<body>
<div class="container">
	<div class="panel panel-default">

  <div class="panel-body"> <?php  if ($datos==0){echo "No existen Usuarios ";}else echo "Existe un total de ".count($datos)." Registros de Usuarios";  ?> </div>

<div class="table-responsive">
<table class="table table-hover" >

	<thead class="thead-dark">
		<tr class="bg-primary">
			<td>Cédula <span class="glyphicon glyphicon-credit-card" aria-hidden="true"></span></td>
      		<td>Nombre <span class="glyphicon glyphicon-user" aria-hidden="true"></span></td>
      		<td>Apellido <span class="glyphicon glyphicon-user" aria-hidden="true"></span></td>
      		<td>Correo <span class="glyphicon glyphicon-envelope" aria-hidden="true"></span></td>
      		<td>Teléfono <span class="glyphicon glyphicon-phone" aria-hidden="true"></span></td>
      		<td>Usuario <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></td>



		</tr>
	</thead>
	<tbody>

		<?php


 for ($i=0; $i<count($datos); $i++) {

 	$dtos = $datos[$i][0].'||'.
 			$datos[$i][2].'||'.
 			$datos[$i][1].'||'.
 			$datos[$i][3].'||'.
      $datos[$i][4].'||'.
      $datos[$i][5].'||'.
 			$datos[$i][6];

  ?>
		<tr>
      <td><?php  echo $datos[$i][0]    ?></td>
      <td><?php  echo $datos[$i][2]    ?></td>
      <td><?php  echo $datos[$i][1]    ?></td>
      <td><?php  echo $datos[$i][3]    ?></td>
      <td><?php  echo $datos[$i][4]    ?></td>
      <td><?php  echo $datos[$i][5]    ?></td>
    </tr>
		<?php
    }
    ?>
	</tbody>
</table>
</div>
</div>
</div>


</body>
</html>
