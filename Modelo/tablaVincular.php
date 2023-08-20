<?php
require_once "coneccion.php";
$seleccion = $_GET['id1'];
$seleccion = strtolower($seleccion);
$datos = usuarios($seleccion);

?>

<html>
<div class="panel panel-default">
  <div class="panel-body"><?php  if ($datos==0){echo "No existen Usuarios para vincular";}else echo "Existe un total de ".count($datos)." Registros de Usuarios";  ?></div>

<div class="table-responsive">
<table class="display compact"  id="tablav" class="display" cellspacing="0" width="100%">

  <thead class="thead-dark">
    <tr class="bg-primary">
      <td>Cédula <span class="glyphicon glyphicon-credit-card" aria-hidden="true"></span></td>
      <td>Nombre <span class="glyphicon glyphicon-user" aria-hidden="true"></span></td>
      <td>Apellido <span class="glyphicon glyphicon-user" aria-hidden="true"></span></td>
      <td>Correo <span class="glyphicon glyphicon-envelope" aria-hidden="true"></span></td>
      <td>Teléfono <span class="glyphicon glyphicon-phone" aria-hidden="true"></span></td>
      <td>Usuario <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></td>
      <td>Seleccionar</td>
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
      <td><input type="checkbox" name="usuariosVincular" value="<?php echo $datos[$i][5]; ?>"></button> </td>
    </tr>
    <?php
    }
    ?>

  </tbody>
</table>
</div>
</div>

<div class="row">
  <div class="col-lg-2 col-md-2 ">
<button type="button" class="btn btn-primary btn-block" onclick="selecGrupos()">Vincular Usuarios
<span class="glyphicon glyphicon-resize-full" aria-hidden="true"></span></button>
</div>
<div class="col-lg-2 col-md-2 ">
<button type="button" class="btn btn-danger btn-block" onclick="cancelarVincular()">Cancelar
<span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
</div>
</div>
<script type="text/javascript" charset="utf-8">
	$(document).ready(function(){
    $('#tablav').DataTable( {
      destroy: true,
      "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        }
        } );
});
</script>
</html>
