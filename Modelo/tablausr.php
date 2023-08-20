<?php
$seleccion = $_GET['id1'];
$seleccion = strtolower($seleccion);
?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
      </head>
</head>
<body>

	<div class="panel panel-default">

  <div class="panel-body"><center><b>Lista de Registros de Usuarios</b></center></div>

<div class="table-responsive">
<table id="example" class="display compact" style="width:100%">
        <thead>
            <tr>
                <th>Cedula</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Correo</th>
                <th>Telefono</th>
                <th>Usuario</th>
                <th>Modificar</th>
                  <th>Eliminar</th>
                  <th>Vincular</th>
            </tr>
        </thead>
        <!-- <tfoot>
            <tr>
                <th>Cedula</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Correo</th>
                <th>Telefono</th>
                <th>usuario</th>
                <th></th>
            </tr>
        </tfoot>  -->
    </table>
</div>
</div>



<script type="text/javascript" charset="utf-8">

	$(document).ready(function() {
    var table = $('#example').DataTable( {
        "processing": true,
        "serverSide": true,
        "order": [[ 2, "asc" ]],
        "ajax": {
        	url:"../Modelo/lista.php?tipo=<?php echo $seleccion;?>",
        	type: "post"

        },
        "columns": [
            { "data": "0" },
            { "data": "1"},
            { "data": "2" },
            { "data": "3"},
            { "data": "4" },
            { "data": "5"},
            {'defaultContent': "<button type='button' class='editar btn btn-success glyphicon glyphicon-edit' data-toggle='modal' data-target='#modalactualizar'>Editar</button>"
          },
          {'defaultContent': "<button type='button' class='eliminar btn btn-danger glyphicon glyphicon-trash'>Eliminar</button>"
        },
        {'defaultContent': "<button type='button' class='vincular btn btn-warning glyphicon glyphicon-share' data-toggle='modal' data-target='#modalvincular'>Vincular</button>"
                     }
        ],
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        },

    } );

obtener_data_editor("#example tbody",table);


} );

	var obtener_data_editor = function(tbody,table){
$(tbody).on("click", "button.eliminar", function(){
	var data = table.row($(this).parents("tr")).data();
  eliminarusuario(data[5]);
  $('#example').DataTable().ajax.reload();
})

$(tbody).on("click", "button.editar", function(){
	var data = table.row($(this).parents("tr")).data();
agregardatos(data, "<?php echo $seleccion;?>" );
$('#example').DataTable().ajax.reload();
})

$(tbody).on("click", "button.vincular", function(){
	var data = table.row($(this).parents("tr")).data();
selecgrupos(data[5]);
})
	}
</script>

</body>
</html>
