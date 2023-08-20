<?php

header('Access-Control-Allow-Origin: *');

session_start();

$user_name = $_SESSION['usuario'];
$password = $_SESSION['password'];
require_once('../Modelo/config.php');

@$grupo1 = $baseGrupo;
@$grupo2 = $_GET["g"];


$conectar = ldap_connect("ldap://{$host}:{$port}") or die("No se puede conectar al servidor LDAP");

ldap_set_option($conectar, LDAP_OPT_PROTOCOL_VERSION, 3);
    if ($conectar) {

        if(@ldap_bind($conectar, "cn={$user_name},{$baseAdmin}", $password)){

            if($grupo1 == $baseGrupo && empty($grupo2)){

                $filtro = "(|(ou=*)(cn=*))";

                $arreglo = array("ou", "description","cn");

                $resultado = @ldap_list($conectar, $baseGeneral2, $filtro, $arreglo) or exit("Buscando...");

                //$resultado = ldap_list($conectar, $baseG, $filtro, $arreglo);

                $entrada = @ldap_get_entries($conectar, $resultado);

                $valor = @ldap_count_entries($conectar, $resultado);

                $firs = @ldap_first_entry($conectar, $resultado);

                $dn = $baseGrupo;

                if($valor != 0){

                        for ($i=0; $i<$entrada["count"]; $i++){

                            @$respuesta =  $entrada[$i]["ou"][0]."\n".$entrada[$i]["description"][0]."\n"."\n".$entrada[$i]["cn"][0]."\n";
                        }

                    }else{

                            echo "No existe grupos para visualizar";

                    }

            }else{

                $filtro = "(|(ou=$grupo2)(cn=$grupo2))";

                $arreglo = array("ou", "description","cn");

                $resultado = @ldap_search($conectar, $baseAdmin, $filtro, $arreglo) or exit("Buscando...");
                $entrada = @ldap_get_entries($conectar, $resultado);

                $valor = @ldap_count_entries($conectar, $resultado);

                $firs = @ldap_first_entry($conectar, $resultado);

                $dn = ldap_get_dn($conectar, $firs);
                $rutadn = ldap_explode_dn($dn,0);
                $atras = $rutadn[1];
                $rest = substr($atras, 3);
                $atras1 = $rutadn[0];
                if($atras1==$baseGrupo){
                  $rest = $baseGrupo;
                }

                $filtro2 = "(|(ou=*)(cn=*))";

                $arreglo2 = array("ou", "description","cn");

                $resultado2 = @ldap_list($conectar, $dn, $filtro2, $arreglo2) or exit("Buscando...");
                $entrada = @ldap_get_entries($conectar, $resultado2);

                $valor2 = @ldap_count_entries($conectar, $resultado2);

                $firs2 = @ldap_first_entry($conectar, $resultado2);

                if($valor2 != 0){

                        for ($i=0; $i<$entrada["count"]; $i++){

                            @$respuesta =  $entrada[$i]["ou"][0]."\n".$entrada[$i]["description"][0]."\n"."\n".$entrada[$i]["cn"][0]."\n";

                        }

                    }else{

                            echo "No existe grupos para visualizar";

                    }

            }

        }else{

            return "Datos incorrectos";

        }

    }else{

        return "No hay conexión con el servidor LDAP";

    }


?>


<!DOCTYPE html>
<html lang="en">
<head>

    <title>Grupos</title>
    <meta charset="utf-8">
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <meta name="viewport" content="width=device-width, initial-scale=1">
     <meta http-equiv="Content-Type" content="text/html; charset=windows-1252">


</head>
<body>


  <div class="row">
<div class="col-lg-3 col-md-3 ">

      <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#nuevoGrupo">Nuevo Grupo
   <span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button>


  </div>
  <div class="col-lg-3 col-md-3">

      <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#crearSistemas">Nuevo sistema
   <span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button>

  </div>

  <div class="col-lg-3 col-md-3">

      <button type="button" class="btn btn-danger btn-block" data-toggle="modal" data-target="#eliminarGrupo">Elimar Grupo
   <span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>


  </div>

  <div class="col-lg-3 col-md-3">

      <button type="button" class="btn btn-danger btn-block" onclick="mostrarSistemas()">Elimar Sistema
   <span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>



  </div>
</div>
<br>
<div class="input-group">
  <span class="input-group-addon" id="basic-addon3">Navegador</span>
  <?php
        $cadena = explode(",", $dn);
        $resultado = str_replace(",", " / ", $dn);
  echo("<input type='text' class='form-control' id='basic-url' value= '$resultado' disabled>");
  ?>



</div>
</div>
<br>
  <div class="row">
<div class="col-lg-3 col-md-3">
<button type="button" class="btn btn-success btn-block" onclick="myFunction('<?php  if(empty($grupo2)){echo $grupo1;}else{if($grupo2==$baseGrupo){echo $grupo2;}else{echo $rest;}} ?>')"><span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span> Atras
</button>
</div>
</div>

<div class="row">
  <div class="col-xs-12 col-md-4 col-sm-4 col-lg-4 ">
    <center><h4>NOMBRE DEL GRUPO O SISTEMA</h4></center>
    <nav>
    <ul class="list-group">
         <?php
                for ($i=0; $i<$entrada["count"]; $i++){
                @$respuesta =  $entrada[$i]["ou"][0]."\n".$entrada[$i]["description"][0]."\n"."\n".$entrada[$i]["cn"][0]."\n";
?>

 <?php
    if(@$entrada[$i]["ou"][0]!=NULL){
  ?>

<li class="list-group-item list-group-item-danger" id="gruposs", onclick="myFunction('<?php echo $entrada[$i]["ou"][0]?>')"><a href="#"><?php  echo @$entrada[$i]["ou"][0] ?></a></li>

 <?php

    }else{
      $sistem = $entrada[$i]["cn"][0];

      echo "<li class='list-group-item list-group-item-success' id='gruposs'><a href='../Modelo/obtenerMiembrosSistema.php?sistema=$sistem' target='_blank'><b>".$entrada[$i]["cn"][0]."</b></a></li>";

}
    }
    ?>


    </ul>
</nav>
  </div>
  <div class="col-xs-12 col-md-4 col-sm-4 col-lg-4 ">
    <center><h4>DESCRIPCIÓN</h4></center>
    <nav>
    <ul class="list-group">
         <?php
                for ($i=0; $i<$entrada["count"]; $i++){
                @$respuesta =  $entrada[$i]["ou"][0]."\n".$entrada[$i]["description"][0]."\n"."\n".$entrada[$i]["cn"][0]."\n";
?>

 <?php
    if(@$entrada[$i]["ou"][0]!=NULL){
  ?>

<li class="list-group-item list-group-item-info" id="gruposs"><?php  echo @$entrada[$i]["description"][0] ?></li>

 <?php

    }else{
      $usr = $entrada[$i]["cn"][0];

      echo "<li class='list-group-item list-group-item-info' id='gruposs'>"."------>".$entrada[$i]["description"][0]."</li>";

}
    }
    ?>


    </ul>
</nav>
  </div>
  <div class="col-xs-12 col-md-4 col-sm-4 col-lg-4 ">
    <center><h4>INFORMACIÓN</h4></center>
    <nav>
    <ul class="list-group">
         <?php
                for ($i=0; $i<$entrada["count"]; $i++){
                @$respuesta =  $entrada[$i]["ou"][0]."\n".$entrada[$i]["description"][0]."\n"."\n".$entrada[$i]["cn"][0]."\n";
?>

 <?php
    if(@$entrada[$i]["ou"][0]!=NULL){
  ?>

<li class="list-group-item list-group-item-warning" id="gruposs">GRUPO DE SERVIDOR LDAP</li>

 <?php

    }else{
      $usr = $entrada[$i]["cn"][0];

      echo "<li class='list-group-item list-group-item-warning' id='gruposs'><b>SISTEMA DEL GRUPO</b></li>";

}
    }
    ?>


    </ul>
</nav>
  </div>
</div>



<div class="container">

</div>

<div class="modal fade" id="eliminarGrupo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Eliminar grupos</h4>
      </div>
         <form>
      <div class="modal-body">

                <?php
                $ban=0;
                for ($i=0; $i<$entrada["count"]; $i++){
                    if(@$entrada[$i]["ou"][0]!=NULL){
                        $ban=1;
?>
                <input type="checkbox" name="grupose" value="<?php echo $entrada[$i]["ou"][0]?>"> <?php echo $entrada[$i]["ou"][0]?>
            <br>


 <?php
}
    }

    if($ban==0){
     echo "No existen grupos para eliminar";
    }
    ?>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary"  data-dismiss="modal" onclick="eliminarGrupo()">Eliminar</button>
      </div>
      </form>
    </div>
  </div>
</div>


<div class="modal fade" id="eliminarSistema" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Eliminar Sistemas</h4>
      </div>
         <form>
      <div class="modal-body">
        <div class="contenidoSi"></div>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary"  data-dismiss="modal" onclick="eliminarSistema()">Eliminar</button>
      </div>
      </form>
    </div>
  </div>
</div>


<div class="modal fade" id="crearSistemas" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Crer nuevo sistema</h4>
      </div>
         <form>
      <div class="modal-body">



      <div class="form-group row">
    <label for="inputnombresistema" class="col-sm-2 col-form-label">Sistema: </label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="nsistemas" placeholder="Nombre *"  >
        <div id="camposs"></div>
    </div>
  </div>

        <a href="#" onclick="AgregarCampossistemas();">Agregar sistemas</a>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary"  data-dismiss="modal" onclick="crearSistemas();">Insertar</button>
      </div>
      </form>
    </div>
  </div>
</div>

</body>
</html>
