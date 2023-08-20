
<?php
require_once("../Modelo/config.php");
require_once("../Modelo/funciones_interfaz.php");
session_start();
@$usuario =$_SESSION['usuario'];
@$correo = $_SESSION['correo'];

if (empty($usuario)){
  header ("Location: ../index.php");
  exit();
} else {
	if(isset($usuario) && isset($correo)){
		header ("Location: perfilUsuario.php");
		exit();
	}
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

      <script src="../Controlador/js/alertify.js"></script>
      <script src="../Controlador/js/jquery.js" ></script>
      <?php echo html_init_js(); ?>
			<link rel="stylesheet" type="text/css" href="datatables.css">
			<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.18/datatables.min.css"/>
			<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.18/datatables.min.js"></script>
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
      <!-- Optional theme -->
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
			<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css"><font></font>
      <font></font>
      <!--<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script><font></font>-->
      <script type="text/javascript" charset="utf8" src="../Controlador/datatables.js"></script>

      <link rel="stylesheet" type="text/css" href="css/alertify.css">
       <link rel="stylesheet" type="text/css" href="css/themes/default.css">
      <!-- Latest compiled and minified JavaScript -->
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</head>

<body>

<div class="container">
<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">Bienvenido: <?php echo $usuario ?></a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="active" id="estudiante"><a href="#">Estudiantes</a></li>
        <li id="docente"><a href="#">Docentes</a></li>
         <li id="administrativo"><a href="#">Servidores</a></li>
         <li id="administrativo"><a href="#">Trabajadores</a></li>
          <li id="otro"><a href="#">Otros</a></li>
          <li id="otro"><a href="#">Cargar</a></li>
          <li id="grupos"><a href="#">Grupos</a></li>
          <li id="detalles"><a href="#">Detalles</a></li>
          <li><a href="#">Administrador</a></li>
        <li><a href="../Modelo/cerrar.php">Cerrar Sesión</a></li>


      </ul>


    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
</div>



<div class="container">


<div id="botones">
<br>
<div class="row">
  <div class="col-lg-4 col-md-4 ">
    <div class="input-group">
      <span class="input-group-btn">
        <button class="btn btn-primary " type="button">Servidor <span class="glyphicon glyphicon-hdd" aria-hidden="true"></button>
      </span>
      <input type="text" class="form-control" id="buscar" value="<?php echo $host.":".$port ?>"  disabled>
    </div><!-- /input-group -->
  </div><!-- /.col-lg-6 -->

  <div class="col-lg-2 col-md-2 ">
      <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#modalnuevo">Añadir Nuevo
   <span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button>


  </div>
  <div class="col-lg-2 col-md-2">

      <button type="button" class="btn btn-success btn-block" onclick="cargarUsuarios()">Vincular Usuarios
   <span class="glyphicon glyphicon-resize-full" aria-hidden="true"></span></button>
  </div>
  <div class="col-lg-2 col-md-2 ">
      <button type="button" class="btn btn-danger btn-block" data-toggle="modal" data-target="#modalseleccionargrupo">Eliminar todo
   <span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>


  </div>
  <div class="col-lg-2 col-md-2 ">
      <button type="button" class="btn btn-warning btn-block" data-toggle="modal" data-target="#modalreporte">Generar Reporte
   <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span></button>


  </div>

</div>

<br>
</div>


<div id="tabla">
</div>
</div>




<!-- MODAL PARA AÑADIR UN NUEVO USUARIO -->

<!-- Modal -->
<div class="modal fade" id="modalnuevo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Añadir Nuevo Usuario</h4>
      </div>
         <form>
      <div class="modal-body">

<div class="form-group row">
    <label for="inputnombre" class="col-sm-2 col-form-label">Cédula: </label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="cedula" placeholder="Cédula *" required pattern="[A-Za-z]+" required>
    </div>
  </div>

      <div class="form-group row">
    <label for="inputnombre" class="col-sm-2 col-form-label">Nombres: </label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="nombre" placeholder="Nombres *" required pattern="[A-Za-z]+" required>
    </div>
  </div>

   <div class="form-group row">
    <label for="inputapellido" class="col-sm-2 col-form-label"></label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="apellido" placeholder="Apellidos *"  >
    </div>
  </div>

   <div class="form-group row">
    <label for="inputcorreo" class="col-sm-2 col-form-label">Correo: </label>
    <div class="col-sm-10">
      <input type="email" class="form-control" id="correo" placeholder="Correo *"  >
    </div>
  </div>

  <div class="form-group row">
    <label for="inputtelefono" class="col-sm-2 col-form-label">Teléfono: </label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="telefono" placeholder="Teléfono"  >
    </div>
  </div>

  <fieldset class="form-group">
    <div class="row">
      <legend class="col-form-label col-sm-2 pt-0">Grupo: </legend>
      <div class="col-sm-10">
        <div class="form-check">
          <input class="form-check-input" type="radio" name="grupo" value="estudiantes" checked>
          <label class="form-check-label" for="gridRadios1">
            Estudiantes
          </label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="grupo" value="docentes">
          <label class="form-check-label" for="gridRadios2">
            Docentes
          </label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="grupo" value="servidores" >
          <label class="form-check-label" for="gridRadios3">
          Servidores
          </label>
        </div>
         <div class="form-check">
          <input class="form-check-input" type="radio" name="grupo" value="trabajadores" >
          <label class="form-check-label" for="gridRadios3">
          Trabajadores
          </label>
        </div>
         <div class="form-check">
          <input class="form-check-input" type="radio" name="grupo"  value="otros">
          <label class="form-check-label" for="gridRadios3">
          Otros
          </label>
        </div>

      </div>
    </div>
  </fieldset>
      </div>
	<div id="usuarionuevo" style="display:none; color:green;"><center>Cargando...</center></div>
	<br>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary"  id="guardar" >Guardar</button>
      </div>
      </form>
    </div>
  </div>
</div>


<!-- MODAL PARA MODIFFICAR LOS DATOS DE UN USUARIO -->
<!-- Modal -->
<div class="modal fade" id="modalactualizar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Actualizar Información</h4>
      </div>
         <form>
      <div class="modal-body">

<div class="form-group row">
    <label for="inputnombre" class="col-sm-2 col-form-label">Cédula: </label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="cedulaa" placeholder="Cédula *" required pattern="[A-Za-z]+" required readonly="readonly">
    </div>
  </div>

      <div class="form-group row">
    <label for="inputnombre" class="col-sm-2 col-form-label">Nombres: </label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="nombrea" placeholder="Nombres *" required pattern="[A-Za-z]+" required>
    </div>
  </div>

   <div class="form-group row">
    <label for="inputapellido" class="col-sm-2 col-form-label"></label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="apellidoa" placeholder="Apellidos *"  >
    </div>
  </div>

   <div class="form-group row">
    <label for="inputcorreo" class="col-sm-2 col-form-label">Correo: </label>
    <div class="col-sm-10">
      <input type="email" class="form-control" id="correoa" placeholder="Correo *"  >
    </div>
  </div>

  <div class="form-group row">
    <label for="inputtelefono" class="col-sm-2 col-form-label">Teléfono: </label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="telefonoa" placeholder="Teléfono"  >
    </div>
  </div>

  <div class="form-group row">
    <label for="inputtelefono" class="col-sm-2 col-form-label">Contraseña: </label>
    <div class="col-sm-10">
      <input type="password" class="form-control" id="contrasenaa" placeholder="Cambiar Contraseña"  >
    </div>
  </div>

  <fieldset class="form-group">
    <div class="row">
      <legend class="col-form-label col-sm-2 pt-0">Grupo: </legend>
      <div class="col-sm-10">
        <div class="form-check">
          <input class="form-check-input" type="radio" name="grupoa" value="estudiantes" checked>
          <label class="form-check-label" for="gridRadios1">
            Estudiantes
          </label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="grupoa" value="docentes">
          <label class="form-check-label" for="gridRadios2">
            Docentes
          </label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="grupoa" value="servidores" >
          <label class="form-check-label" for="gridRadios3">
          Servidores
          </label>
        </div>
         <div class="form-check">
          <input class="form-check-input" type="radio" name="grupoa" value="trabajadores" >
          <label class="form-check-label" for="gridRadios3">
          Trabajadores
          </label>
        </div>
         <div class="form-check">
          <input class="form-check-input" type="radio" name="grupoa"  value="otros">
          <label class="form-check-label" for="gridRadios3">
          Otros
          </label>
        </div>

      </div>
    </div>
  </fieldset>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary"  data-dismiss="modal" id="actualizar" >Actualizar</button>
      </div>
      </form>
    </div>
  </div>
</div>



<!-- MODAL PARA Vincular  UN USUARIO -->
<!-- Modal -->
<div class="modal fade" id="modalvincular" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Vincular Usuario</h4>
      </div>
         <form>
      <div class="modal-body">
          <div class="form-group row" id="usuarioVincular">
          <label for="inputusuario" class="col-sm-2 col-form-label">Usuario: </label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="usuariov" placeholder=""  >
          </div>
        </div>

        <div class="contenido">
        </div>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary"  data-dismiss="modal" onclick="vincularUsuarios()">Vincular</button>
      </div>
      </form>
    </div>
  </div>
</div>

<!-- MODAL PARA Vincular  varios USUARIOs -->
<!-- Modal -->
<div class="modal fade" id="modalvincularM" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Vincular Varios Usuarios</h4>
      </div>
         <form>
      <div class="modal-body">


        <div class="contenidoM">
        </div>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary"  data-dismiss="modal" onclick="vincularUsuarios()">Vincular Usuarios</button>
      </div>
      </form>
    </div>
  </div>
</div>

<!-- MODAL PARA CARGAR UN CSV -->

<!-- Modal -->
<div class="modal fade" id="modalcargar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Cargar archivo CSV</h4>
                </div>
                <div class="modal-body">
                    <form id="formulario" enctype="multipart/form-data" name="form">
                        <div class="form-group">
                            <label for="archivocsv">Adjuntar un archivo</label>
                            <input type="file" id="csv" name="csv" accept=".csv">
                            <p class="help-block">Seleccione un archivo que tenga la extención csv.</p>
                            <p class="help-block">Formato: Cédula, Nombres, Apellidos, Correo, Teléfono, Tipo[estudiantes,docentes,servidores,trabajadores,otros], Clave</p>
                        </div>
                </div>
                <div id="cargando" style="display:none; color:green;"><center>Cargando...</center></div>
                <br>

                <div class="modal-footer">
                    <input type="submit" value="Cargar Usuarios" class="btn btn-primary">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                </div>
                </form>
            </div>
        </div>
    </div>

<!-- MODAL PARA eliminar todos los registros -->

<!-- Modal -->
<div class="modal fade" id="modaleliminartodos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Eliminar Todos los registros</h4>
      </div>
      <div class="modal-body">

    <p class="help-block">¿ESTÁ SEGURO DE ELIMINAR TODOS LOS REGISTROS?</p>

      </div>
      <div id="cargandoeliminar" style="display:none; color:green;"><center>  Cargando...</center></div>
      <br>

      <div class="modal-footer">
       <button type="button" class="btn btn-danger" onclick="eliminartodos();">Aceptar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
      </div>

    </div>
  </div>
</div>


<!-- MODAL PARA seleccionar grupo para eliminar todos los registros -->

<!-- Modal -->
<div class="modal fade" id="modalseleccionargrupo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Por favor seleccione un Grupo</h4>
      </div>
      <div class="modal-body">
        <fieldset class="form-group">
          <div class="row">
            <legend class="col-form-label col-sm-2 pt-0">Grupo: </legend>
            <div class="col-sm-10">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="grupoeliminar" value="estudiantes" checked>
                <label class="form-check-label" for="gridRadios1">
                  Estudiantes
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="grupoeliminar" value="docentes">
                <label class="form-check-label" for="gridRadios2">
                  Docentes
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="grupoeliminar" value="servidores" >
                <label class="form-check-label" for="gridRadios3">
                Servidores
                </label>
              </div>
               <div class="form-check">
                <input class="form-check-input" type="radio" name="grupoeliminar" value="trabajadores" >
                <label class="form-check-label" for="gridRadios3">
                Trabajadores
                </label>
              </div>
               <div class="form-check">
                <input class="form-check-input" type="radio" name="grupoeliminar"  value="otros">
                <label class="form-check-label" for="gridRadios3">
                Otros
                </label>
              </div>

            </div>
          </div>
        </fieldset>

  </div>
      <div class="modal-footer">
       <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modaleliminartodos" data-dismiss="modal">Seleccionar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
      </div>

    </div>
  </div>
</div>

<!-- MODAL PARA seleccionar grupo para generar reporte -->

<!-- Modal -->
<div class="modal fade" id="modalreporte" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Por favor seleccione un Grupo</h4>
      </div>
      <div class="modal-body">
        <fieldset class="form-group">
          <div class="row">
            <legend class="col-form-label col-sm-2 pt-0">Reporte: </legend>
            <div class="col-sm-10">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="gruporeporte" value="estudiantes" checked>
                <label class="form-check-label" for="gridRadios1">
                  Estudiantes
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="gruporeporte" value="docentes">
                <label class="form-check-label" for="gridRadios2">
                  Docentes
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="gruporeporte" value="servidores" >
                <label class="form-check-label" for="gridRadios3">
                Servidores
                </label>
              </div>
               <div class="form-check">
                <input class="form-check-input" type="radio" name="gruporeporte" value="trabajadores" >
                <label class="form-check-label" for="gridRadios3">
                Trabajadores
                </label>
              </div>
               <div class="form-check">
                <input class="form-check-input" type="radio" name="gruporeporte"  value="otros">
                <label class="form-check-label" for="gridRadios3">
                Otros
                </label>
              </div>

            </div>
          </div>
        </fieldset>

  </div>
      <div class="modal-footer">
       <button type="button" class="btn btn-primary" data-toggle="modal" data-dismiss="modal" onclick="reporte()">Seleccionar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
      </div>

    </div>
  </div>
</div>



<!-- MODAL PARA CREAR UN NUEVO ADMINISTRADOR -->

<!-- Modal -->
<div class="modal fade" id="modaladministrador" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Crear nuevo Administradores</h4>
      </div>
      <div class="modal-body">
   <div class="form-group row">
    <label for="nombreadmin" class="col-sm-2 col-form-label">Usuario: </label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="nadmin" placeholder="Administrador *"  >
    </div>
  </div>

  <div class="form-group row">
    <label for="contraadmin" class="col-sm-2 col-form-label">Contraseña: </label>
    <div class="col-sm-10">
      <input type="password" class="form-control" id="cadmin" placeholder="Contraseña *"  >
    </div>
  </div>

  <div class="form-group row">
    <label for="descripadmin" class="col-sm-2 col-form-label">Descripción: </label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="dadmin" placeholder="Descripción"  >
    </div>

  </div>

      </div>
       <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary"  data-dismiss="modal" onclick="crearAdmin();">Crear</button>
      </div>

    </div>
  </div>
</div>

<!-- MODAL DETALLE -->

<!-- Modal -->
<div class="modal fade" id="modaldetalle" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Sistema de Administración Central CAS</h4>
      </div>
      <div class="modal-body">

        <ul class="list-group">
  <li class="list-group-item list-group-item-success">Directorio Centralizado OPENLDAP</li>
  <li class="list-group-item list-group-item-info">Central Authentication Server JASIG CAS versión 4.0.1</li>
  <li class="list-group-item list-group-item-warning">OpenSource</li>
  <li class="list-group-item list-group-item-danger">versión 1.0.0</li>
  <li class="list-group-item list-group-item-default"><center>Autores: Aguilar Antonio - Armijos Manuel</center></li>
</ul>




      </div>
       <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
      </div>

    </div>
  </div>
</div>

<div class="modal fade" id="nuevoGrupo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Crear nuevo grupo</h4>
      </div>
         <form>
      <div class="modal-body">

          <div class="form-group row">
    <label for="inputnombregrupo" class="col-sm-2 col-form-label">Grupo: </label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="ngrupo" placeholder="Nombre *"  >
        <div id="campos"></div>
    </div>
  </div>


  <div class="form-group row">
    <label for="inputnombresistema" class="col-sm-2 col-form-label">Sistema: </label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="nsistema" placeholder="Nombre *"  >
    </div>
  </div>

  <div class="form-group row">
    <label for="inputnombresistema" class="col-sm-2 col-form-label">Descripción: </label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="ndescripcion" placeholder="Descripción"  >
    </div>
  </div>

  <a href="#" onclick="AgregarCampos();">Agregar subgrupos</a>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary"  data-dismiss="modal" onclick="creargrupos();">Insertar</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!--<footer class="footer">
  <span>Manuel Armijos, Wilmer Antonio, version:4.0.0.1</span>

</footer>
-->

</body>

</html>





<script type="text/javascript">
	$(document).ready(function(){
		$('#buscar').keyup(function(event){
      	dato = $('#buscar').val();
		$('#tabla').load('tablausr.php?id='+dato+'&id1='+selec+'&id2='+page);
			});
	});



var nextinput = 0;
function AgregarCampos(){
nextinput++;
campo = '<li id="rut'+nextinput+'">Subgrupo:<input type="text" class="form-control"  id="campo' + nextinput + '"&nbsp; name="campo' + nextinput + '"&nbsp; /></li>';
$("#campos").append(campo);
}




</script>
