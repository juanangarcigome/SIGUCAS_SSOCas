<?php
header('Access-Control-Allow-Origin: *');
session_start();
@$user_name = $_SESSION['usuario'];
@$password = $_SESSION['password'];
@$sistema = $_GET['sistema'];

require_once('config.php');

$conectar = ldap_connect("ldap://{$host}:{$port}") or die("No se puede conectar al servidor LDAP");
ldap_set_option($conectar, LDAP_OPT_PROTOCOL_VERSION, 3);
    if ($conectar) {
        if(@ldap_bind($conectar, "cn={$user_name},{$baseAdmin}", $password)){
                $filtroS = "cn=$sistema";
                $arregloS = array("cn");
                $resultadoS = @ldap_search($conectar, $baseGeneral2, $filtroS, $arregloS) or exit("Buscando...");
                $firs = @ldap_first_entry($conectar, $resultadoS);
                $dn = ldap_get_dn($conectar, $firs);
                $filtro = "memberUid=*";
                $arreglo = array("memberUid");
                $resultado = @ldap_search($conectar, $dn, $filtro, $arreglo) or exit("Buscando...");
                $entrada = @ldap_get_entries($conectar, $resultado);
                $valor = @ldap_count_entries($conectar, $resultado);
                @$total = count($entrada[0]["memberuid"])-1;

                //echo "$firs";
                //Sepuede dejar este for, ya depende de como se desee imprimir
                if($valor != 0){
                    for ($i=0; $i<count($entrada[0]["memberuid"]); $i++){
                        //$a = count($entrada[0]["memberuid"]);
                        //echo "$a";
                        //print_r($entrada[0]["memberuid"][0]);
                        //print_r($entrada["memberuid"]["count"]);
                        $cn = @$entrada[0]["memberuid"][$i];
                        //echo "$i";
                    }
                }else{
                    echo "<script>";
                    echo "alert('No existen Usuarios en este sistema');";
                    //cambiar dirección dependiendo del servidor
                    echo "window.location = 'http://10.0.2.15/sactesisFInal/';";
                    echo "</script>";

                }
        }else{
            echo ( "Datos incorrectos");
        }
    }else{
        echo ("No hay conexión con el servidor LDAP");
    }


$nombre_archivo = "reporte.txt";

    if(file_exists($nombre_archivo)){
      for ($i=1; $i<=count(@$entrada[0]["memberuid"])-1; $i++) {

          @$mensaje .= $entrada[0]["memberuid"][$i-1].$dn."\n";

      }
    }

    else
    {
for ($i=1; $i<=count($entrada[0]["memberuid"])-1; $i++) {

        @$mensaje .= $entrada[0]["memberuid"][$i-1].$dn."\n";

    }
    }

    if($archivo = fopen($nombre_archivo, "a"))
    {
        if(fwrite($archivo, date("d m Y H:m:s"). " ". @$mensaje. "\n"))
        {
        }
        else
        {
            echo "Ha existido un problema al crear el archivo";
        }

        fclose($archivo);
    }



?>







<!DOCTYPE html>
<html lang="en">
<head>

  <title>Administrador</title>
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
        <div class="container">

        <?php
            echo"<h1><center>LIista de Usuarios del Sistema ( $sistema ).</center></h1>";

            echo "<p>Existe un total de: $total Registros</p>";
        ?>



<div class="table-responsive">
                <table class="table table-bordered">
  <thead class="thead-dark">
    <tr class="bg-primary">
    <td>Número #<span class="glyphicon glyphicon-credit-card" aria-hidden="true"></span></td>
      <td>Usario Vinculado<span class="glyphicon glyphicon-user" aria-hidden="true"></span></td>
      <td>Nombre del Sistema <span class="glyphicon glyphicon-user" aria-hidden="true"></span></td>
      <td>Ruta del Sistema<span class="glyphicon glyphicon-envelope" aria-hidden="true"></span></td>
    </tr>
  </thead>
  <tbody>
<?php


 for ($i=1; $i<=count($entrada[0]["memberuid"])-1; $i++) {

  ?>

    <tr>
      <td><?php  echo $i    ?></td>
      <td><?php  echo $entrada[0]["memberuid"][$i-1];    ?></td>
      <td><?php  echo $sistema    ?></td>
      <td><?php  echo $dn    ?></td>
    </tr>
    <?php
    }
    ?>

  </tbody>
</table>
</div>
<!--
invisible cuando sea mediano visible-sm-inline-block
visiable cuando sea pequeño visible-xs-block
-->



<div class="row">
        <div class="col-12 col-md-2">

            <button type="button" class="btn btn-primary btn-block" onclick="window.print()"> Imprimir
   <span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button>

        </div>

        <div class="col-0 col-md-2">
          <!-- Cmbiar dirección dependiendo del servidor-->
        <button type="button" class="btn btn-danger btn-block" onclick="location.href='http://localhost:8888/sactesisFInal'"> Cancelar
   <span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button></div>

   <div class="col-0 col-md-2">
        <button type="button" class="btn btn-success btn-block" onclick="alert('Reporte Generado.')">Generar Reporte<span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button></div>
    </div>

<div class="page-header">
  <h1>Servico de Autenticación Central SAC <small>Versión 4.0.1</small></h1>
</div>

</div>



      </body>
      </html>
