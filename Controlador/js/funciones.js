$(document).ready(function(){
		selec = "Estudiantes";
		page =1;
		$('#tabla').load('../Modelo/tablausr.php?id1='+selec);
		vin = 0;
		user = "";
	});

$(function() {
  // elementos de la lista
	var enlace = "http://localhost/SiGUCAS";
  	var menues = $(".nav li");

  	menues.click(function() {
  		// eliminamos active de todos los elementos
  		menues.removeClass("active");
  		var selec1 = 0;
  		// activamos el elemento clicado.
  		$(this).addClass("active");
  		selec = $(this).text();

  			if(selec==("Estudiantes") || selec==("Docentes") || selec==("Servidores") || selec==("Trabajadores") || selec==("Otros") && vin==0 ){
    			$('#botones').show();
    			$('#tabla').load('../Modelo/tablausr.php?id1='+selec);
				}

     		if(selec == "Cargar"){
     			$('#modalcargar').modal({backdrop: 'static', keyboard: false}, 'show');
     		}

       		if(selec == "Administrador"){
     			$('#modaladministrador').modal({backdrop: 'static', keyboard: false}, 'show');
			 	}

     	 	if(selec == "Detalles"){
     			$('#modaldetalle').modal({backdrop: 'static', keyboard: false}, 'show');
       		}

      		if(vin==1){
				$('#botones').hide();
     			$('#tabla').load('../Modelo/tablaVincular.php?id1='+selec);
     		}

     		if(selec == "Grupos"){
			 		vin == 0;
     			mostrarGrupos();
     			gs="universidad_implementacion";
     		}

     		$('#info').click(function(){
     			selec1 =1;
     			alert(selec1);
     		});

     		if(selec1==1 && selec=="Estudiantes"){
     			alert("si");
     		}
  });
});

//MÉTODO AGREGAR NUEVO USUARIO
function agregarusuario(cedula,nombre,apellido,correo,telefono,grupo){
	var nombre1 = nombre.split(' ')[0];
	var nombre2 = nombre.split(' ')[1];
	var apellido1 = apellido.split(' ')[0];
	var apellido2 = apellido.split(' ')[1];
	cadena =  "cedula=" + cedula +
						"&nombre1=" + nombre1 +
						"&nombre2=" + nombre2 +
						"&apellido1=" + apellido1 +
						"&apellido2=" + apellido2 +
						"&correo=" + correo +
						"&telefono=" + telefono +
						"&tipoU=" + grupo;
		$.ajax({
			type:"POST",
			url:"../Modelo/agregarusuario.php",
			data:cadena,
				success:function(datos){
					if(datos==0){
						alertify.error("No se estableció la conexión con el servidor");
						$("#usuarionuevo").css("display", "none");
						$("#modalnuevo").modal('hide');
					}else{
						if (datos==1) {
							alertify.error("El usuario que desea ingresar ya existe");
							$("#usuarionuevo").css("display", "none");
							$("#modalnuevo").modal('hide');
						}else{
							if (datos==2) {
								alertify.error("El usuario que desea ingresar ya existe");
								$("#usuarionuevo").css("display", "none");
								$("#modalnuevo").modal('hide');
							}else{
								if (datos==3) {
									alertify.error("Los datos que ingreso son incorrectos");
									$("#usuarionuevo").css("display", "none");
									$("#modalnuevo").modal('hide');
								}else{
									$("#usuarionuevo").css("display", "none");
									$("#modalnuevo").modal('hide');
									//$('#tabla').load('tablausr.php?id1='+selec);
									alertify.success("El usuario se agrego con éxito :)");
									alertify.alert("Identificador de Usuario : "+datos);
									$('#example').DataTable().ajax.reload();
								}
							}
						}
					}
				}
			});
}

//MÉTODO PPAGINACION
function paginacion(dato){
	datosb=$('#buscar').val();
	page = dato;
	$('#tabla').load('../Modelo/tablausr.php?id='+datosb+'&id1='+selec+'&id2='+page);
}

//MÉTODO PARA CREAR UN NUEVO ADMINISTRADOR
function crearAdmin(){
	var usuario = $('#nadmin').val();
	var contra =  $('#cadmin').val();
	var descrip = $('#dadmin').val();
	cadena =	"usuario=" + usuario +
						"&contra=" + contra +
						"&descrip=" + descrip;
		$.ajax({
			type:"POST",
			url:"../Modelo/crearAdmin.php",
			data:cadena,
			success:function(datos){
				if(datos==0){
					alertify.error("No se estableció la conexión con el servidor");
				}else{
					if (datos==1) {
						alertify.error("El usuario que desea ingresar ya existe");
					}else{
						if (datos==2) {
							alertify.error("El usuario que desea ingresar ya existe");
						}else{
							if (datos==3) {
								alertify.error("Los datos que ingreso son incorrectos");
							}else{
								alertify.success("El usuario se agrego con éxito :)");
								alertify.alert("Identificador de Usuario : "+datos);
							}
						}
					}
				}
			}
		});
}

//MÉTODO PARA VERIFICAR LAS CREDENCIALES DE UN USUARIO
function autenticarUsuario(nombre,pasword){
	cadena = "nombre=" + nombre +
					 "&pasword=" + pasword;
		$.ajax({
			type:"POST",
			url:"Modelo/verificarUsuario.php",
			data:cadena,
			success:function(datos){
				if(datos==4){
					alertify.error("No se estableció la conexión con el servidor");
				}else{
					if (datos==3) {
						alertify.error("Los datos ingresados son incorrectos");
					}else{
						if (datos==2) {
							location.href = server_url + "/Vista/perfilUsuario.php";
						}else if(datos==1){
							location.href = server_url + "/Vista/indexusuario.php";
						}
					}
				}
			}
		});
}

//MÉTODO PARA ACTUALIZAR LA CONTRASEÑA
function actualizar_password(paswordactual,paswordnueva,paswordnueva1){
event.preventDefault();
$("#cargando").css("display", "inline");
	cadena = 	"passwordActual=" + paswordactual +
						"&passwordNueva=" + paswordnueva +
						"&passwordNueva2=" + paswordnueva1;
		$.ajax({
			type:"POST",
			url:"../Modelo/actualizarContrasenia.php",
			data:cadena,
			success:function(datos){
				if(datos==0){
					alertify.error("No se estableció la conexión con el servidor");
								$("#cargando").css("display", "none");
				}else{
					if(datos==1){
						alertify.error("Ingrese correctamente su contraseña actual");
								$("#cargando").css("display", "none");
					}else{
						if(datos==2){
							alertify.error("Su nueva contraseña no coincide");
								$("#cargando").css("display", "none");
						}else{
							if(datos==3){
								alertify.error("Su comtraseña no puede ser su número de identificación");
								$("#cargando").css("display", "none");
							}else{
							alert("Su contraseña se actualizo con éxito, vuelva a iniciar sesión");
								//Cambiar dirección dependiendo el servidor
								$("#cargando").css("display", "none");
								window.location.href = server_url+"/Modelo/cerrar.php";
							}
						}
					}
				}
			}
		});
}

//EVENTO PARA CAPTURAR EL CLIK DEL BOTÓN GUARDAR
$(document).ready(function(){
	$('#guardar').click(function(){
	event.preventDefault();
	cedula = $('#cedula').val();
 	nombre = $('#nombre').val();
  apellido = $('#apellido').val();
  correo = $('#correo').val();
  telefono = $('#telefono').val();
  grupo = $('input:radio[name=grupo]:checked').val();
		if (cedula == 0 || apellido==0 || correo==0 || telefono==0 || nombre==0 ) {
  	 	alertify.alert("Debe Ingresar Todos los Campos requeridos (*)");
  	}else  if($("#correo").val().indexOf('@', 0) == -1 || $("#correo").val().indexOf('.', 0) == -1) {
             alertify.alert("El correo electrónico debe tener la siguiente estructura ejemplo@ejemplo.com");
        	 }else{

	        	if(cedula.length == 10){
		        	//Obtenemos el digito de la region que sonlos dos primeros digitos
		        	var digito_region = cedula.substring(0,2);
	        		//Pregunto si la region existe ecuador se divide en 24 regiones

							if( digito_region >= 1 && digito_region <=24 ){
			          // Extraigo el ultimo digito
			          var ultimo_digito   = cedula.substring(9,10);
			          //Agrupo todos los pares y los sumo
			          var pares = parseInt(cedula.substring(1,2)) + parseInt(cedula.substring(3,4)) + parseInt(cedula.substring(5,6)) + parseInt(cedula.substring(7,8));
			          //Agrupo los impares, los multiplico por un factor de 2, si la resultante es > que 9 le restamos el 9 a la resultante
			          var numero1 = cedula.substring(0,1);
			          var numero1 = (numero1 * 2);

							  if( numero1 > 9 ){ var numero1 = (numero1 - 9); }
			          var numero3 = cedula.substring(2,3);
			          var numero3 = (numero3 * 2);

	          		if( numero3 > 9 ){ var numero3 = (numero3 - 9); }
				        var numero5 = cedula.substring(4,5);
				        var numero5 = (numero5 * 2);

								if( numero5 > 9 ){ var numero5 = (numero5 - 9); }
			          var numero7 = cedula.substring(6,7);
			          var numero7 = (numero7 * 2);

			          if( numero7 > 9 ){ var numero7 = (numero7 - 9); }
			          var numero9 = cedula.substring(8,9);
			          var numero9 = (numero9 * 2);

			          if( numero9 > 9 ){ var numero9 = (numero9 - 9); }
			          var impares = numero1 + numero3 + numero5 + numero7 + numero9;
			          //Suma total
			          var suma_total = (pares + impares);
			          //extraemos el primero digito
			          var primer_digito_suma = String(suma_total).substring(0,1);
			          //Obtenemos la decena inmediata
			          var decena = (parseInt(primer_digito_suma) + 1)  * 10;
			          //Obtenemos la resta de la decena inmediata - la suma_total esto nos da el digito validador
			          var digito_validador = decena - suma_total;
			          //Si el digito validador es = a 10 toma el valor de 0

								if(digito_validador == 10)
	            		var digito_validador = 0;
	          			//Validamos que el digito validador sea igual al de la cedula
	          			if(digito_validador == ultimo_digito){
										agregarusuario(cedula,nombre,apellido,correo,telefono,grupo);
										$("#usuarionuevo").css("display", "inline");

	          			}else{
	            			alertify.alert('la cédula:' + cedula + ' es incorrecta');
	          			}

	        		}else{
	          		// imprimimos en consola si la region no pertenece
	          		alertify.alert('Esta cédula no pertenece a ninguna región');
	        		}
     				}else{
        		//imprimimos en consola si la cedula tiene mas o menos de 10 digitos
        		alertify.alert('Esta cédula tiene menos de 10 Dígitos');
     				}
					}
  });
});

//EVENTO PARA CAPTURAR EL CLIK DE FORMULARIO
$(document).ready(function(){
	$('#formulario').submit(function () {
		event.preventDefault();
		$("#cargando").css("display", "inline");
		var parametros=new FormData($(this)[0])
			$.ajax({
        type: "POST",
        url: "../Modelo/cargarUsuarios.php",
        data: parametros,
        contentType: false, //importante enviar este parametro en false
        processData: false, //importante enviar este parametro en false
        success: function (data) {
        	if(data==0){
						alertify.error("No se estableció la conexión con el servidor");
					}else{
						if(data==1){
							alertify.error("Ingrese correctamente su contraseña actual");
						}else{
							if(data==3){
								alertify.alert("NO A SELECCIONADO NINGUN ARCHIVO");
							}else{
								if(data==4){
									alertify.alert("Estructura mal definida (Cédula,Nombres, Apellidos, Correo, Teléfono, Tipo");
								}else{
				  				$('#tabla').load('../Modelo/tablausr.php?id1='+selec);
									alertify.alert(data.split(",")[0].concat(" Ingresados ",data.split(",")[1]," Repetidos",data.split(",")[2]," No ingresados"));
									$("#cargando").css("display", "none");
									$("#modalcargar").modal('hide');
								}
							}
						}
					}
        },
        	error: function (r) {
          	alert("Error del servidor");
          }
      });
    })
});

//EVENTO PARA CAPTURAR EL CLIK DEL BOTÓN AUTENTICAR
$(document).ready(function(){
	$('#autenticar').click(function(){
  	nombre = $('#usuario').val();
  	pasword = $('#pasword').val();
		autenticarUsuario(nombre,pasword);
	});
});


//Metodo para generar Reportes
function reporte(){
	grupo = $('input:radio[name=gruporeporte]:checked').val();
	alert("Reporte creado con éxito");
	$(location).attr('href', server_url + '/Modelo/reporteldap.php?tipoU='+grupo);
}

//MÉTODO PARA RESTABLECER LA CONTRASEÑA
function restablecerContra(){
	cedula = $('#cedula').val();
	usuario = $('#usuario').val();
	cadena = "dni=" + cedula +
					 "&user=" + usuario;
		$.ajax({
			type:"POST",
			url:"../Modelo/enviarContrasenia.php",
			data:cadena,
			success:function(datos){
				if(datos==0){
					alertify.error("No se estableció la conexión con el servidor");
				}else{
					if (datos==1) {
						alertify.error("El usuario o correo que ingreso es incorrecto");
					}else{
						if (datos==2) {
							alertify.error("La cédula que ingreso es incorrecta");
						}else{
						alertify.alert("Se envio la contraseña a su correo:  " + datos);
						}
					}
				}
			}
		});
}

//MÉTODO PARA ELIMINAR TODOS LOS REGISTROS DE UN GRUPO
function eliminartodos(){
	event.preventDefault();
	$("#cargandoeliminar").css("display", "inline");
	grupoeliminar = $('input:radio[name=grupoeliminar]:checked').val();
	cadena = "sistema=" + grupoeliminar;
		$.ajax({
			type:"POST",
			url:"../Modelo/eliminarTodos.php",
			data:cadena,
			success:function(datos){
				if(datos==0){
					alertify.error("No se estableció la conexión con el servidor");
				}else{
					if (datos==1) {
						alertify.error("El usuario o contraseña que ingreso son incorrectos");
					}else{
			  		$('#tabla').load('../Modelo/tablausr.php?id1='+selec);
						alertify.alert("Eliminación exitosa  " + datos + "Eliminados");
						$("#cargandoeliminar").css("display", "none");
						$("#modaleliminartodos").modal('hide');//ocultamos el modal
					}
				}
			}
		});
}

//MÉTODO PARA ENVIAR LAS INDICACIONES DE RESTABLECER LA CONTRASEÑA 1
function restablecerContra1(){
	event.preventDefault();
	$("#cargando").css("display", "inline");
	cedula = $('#cedula').val();
	usuario = $('#usuario').val();
	cadena = "dni=" + cedula +
					 "&user=" + usuario;
		$.ajax({
			type:"POST",
			url:"../Modelo/enviarContrasenia.php",
			data:cadena,
			success:function(datos){
				if(datos==0){
					alertify.error("No se estableció la conexión con el servidor");
							$("#cargando").css("display", "none");
				}else{
					if(datos==1){
						alertify.error("El usuario o correo que ingreso es incorrecto");
							$("#cargando").css("display", "none");
					}else{
						if(datos==2){
							alertify.error("La cédula que ingreso es incorrecta");
							$("#cargando").css("display", "none");
						}else{
							alert("Por favor revise las instrucciones enviadas a su correo: "+ datos);
							$("#cargando").css("display", "none");
							window.location.href = server_url;
						}
					}
				}
			}
		});
}

//MÉTODO PARA RESTABLECER LA CONTRASEÑA
function restableceContrasenia(datos){
event.preventDefault();
	$("#restablecercontra").css("display", "inline");
var v = $('#frmPassword').valid();
   if (v) {
	var passwordnueva = $('#passwordnueva').val();
	var passwordnueva1 = $('#passwordnueva1').val();
	cadena = "passN=" + passwordnueva +
					 "&passN2=" + passwordnueva1 +
			     "&usuario=" + datos;
		$.ajax({
			type:"POST",
			url:"../Modelo/contraseniaRestablecida.php",
			data:cadena,
			success:function(datos){
				if(datos==0){
					alertify.error("No se estableció la conexión con el servidor");
							$("#restablecercontra").css("display", "none");
				}else{
					if (datos==1) {
						alertify.error("Error, la contraseña no coincide");
							$("#restablecercontra").css("display", "none");
					}else{
						if(datos==2){
							alert("La contraseñia se cambio con éxito");
							$("#restablecercontra").css("display", "none");
							window.location.href=server_url;
						}
					}
				}
			}
		});
    }
}

//MÉTODO PARA ELIMINAR UN USUARIO
function eliminarusuario(datos){
	cadena = "usuario=" + datos;
		$.ajax({
			type:"POST",
			url:"../Modelo/usuarioEliminado.php",
			data:cadena,
			success:function(datos){
				if(datos==0){
					alertify.error("No se estableció la conexión con el servidor");
				}else{
					if (datos==1) {
						alertify.error("Datos mal ingresados");
					}else{
						if(datos==2){
							//$('#tabla').load('tablausr.php?id1='+selec);
							alertify.success("Usuario Elimnado con éxito.");
						}
					}
				}
			}
		});
}

//EVENTO PARA CAPTURAR EL EVENTO DE CLICK
$(document).ready(function(){
	$('#actualizar_contra').click(function(){
	var v = $('#frmPassword').valid();
   if (v) {
	  paswordactual = $('#passwordactual').val();
	  paswordnueva = $('#passwordnueva').val();
	  paswordnueva1= $('#passwordnueva1').val();
	actualizar_password(paswordactual,paswordnueva,paswordnueva1);
   }
});

    $.validator.addClassRules({
        password: {
            notEqualActual: ".passwordactual",
        },
    });
    $.validator.addMethod("notEqualActual",
            function (value, element, param) {
                return value !== $(param).val();
            },
            "Escriba una contraseña diferente a la actual");

});


//MÉTODO PARA AGREGAR LOS DATOS
function agregardatos(datos,selec){
	d=datos;
	$('#cedulaa').val(d[0]);
	$('#nombrea').val(d[1]);
	$('#apellidoa').val(d[2]);
	$('#correoa').val(d[3]);
	$('#telefonoa').val(d[4]);
	$('input:radio[name="grupoa"]').filter('[value="'+selec+'"]').attr('checked', true);
	user = d[5];
}

//MÉTODO PARA CARGAR USUARIOS
function cargarUsuarios(){
	$('#botones').hide();
  $('#tabla').load('../Modelo/tablaVincular.php?id1='+selec);
  vin = 1;
}

//MÉTODO PARA CANCELAR LA VINCULACIÓN DE USUARIOS
function cancelarVincular() {
	$('#botones').show();
  $('#tabla').load('../Modelo/tablausr.php?id1='+selec);
  vin = 0;
}

//EVENTO PARA CAPTURAR EL CLICK DEL BOTÓN ACTUALIZAR
$(document).ready(function(){
	$('#actualizar').click(function(){
  	cedula=$('#cedulaa').val();
		nombre=$('#nombrea').val();
		apellido=$('#apellidoa').val();
		correo=$('#correoa').val();
		telefono=$('#telefonoa').val();
		contrasena=$('#contrasenaa').val();
		grupo=$('input:radio[name=grupoa]:checked').val();
		actualizar(cedula,nombre,apellido,correo,telefono,contrasena,grupo);
	});
});

//MÉTODO PARA VINCULAR VARIOS USUARIOS
function vincularUsuarios(){
  usuariov=$('#usuariov').val();
  var selected="";
  var selected1="";
  	$('input:checkbox[name=grupos]').each(function(){
      if (this.checked) {
        selected += $(this).val()+' ';
      }
    });

  	$('input:checkbox[name=usuariosVincular]').each(function(){
      if (this.checked) {
        selected1 += $(this).val()+' ';
      }
        usuariov=0;
    });
	cadena = 	"usuariov=" + usuariov +
						"&gruposv=" + selected +
						"&usuariosv=" + selected1;
		$.ajax({
			type:"POST",
			url:"../Modelo/vincularUsuarios.php",
			data:cadena,
				success:function(datos){
					if(datos==0){
						alertify.error("El usuario ya se encuentra vinculado");
					}else{
						if(datos==1){
							alertify.success("Usuario vinculado con éxito");
						}else{
							if(datos==2){
								alertify.error("No se pudo establecer la conección");
							}else{
								if(datos==3){
									alertify.error("No se pudo establecer la conección con el servidor");
								}else{
									alertify.success("Usuario vinculado con éxito");
								}
							}
						}
					}
				}
			});
}

//MÉTODO PARA SELECCIONAR UN GRUPO
function selecgrupos(datos){
	$('#usuariov').val(datos);
	$('.contenido').load('../Modelo/gruposg.php?usuario='+datos,function(){
    $('#modalvincular').modal({show:true});
  });
}

//MÉTODO PARA MOSTRAR LOS GRUPOS
function mostrarGrupos(){
	$('#botones').hide();
 	$('#tabla').load('../Modelo/grupos.php');
}

//MÉTODO PARA SELECCIONAR GRUPOS
function selecGrupos(){
	$('.contenidoM').load('../Modelo/gruposg.php?',function(){
    $('#modalvincularM').modal({show:true});
  });
}

//MÉTODO PARA CREAR GRUPOS
function creargrupos(){
	if (typeof gs == 'undefined') {
    gse = "universidad_implementacion";
	}else{
		gse = gs;
	}
	alert(gs);
	alert(gse);
	ngrupo = $('#ngrupo').val();
	nsistema = $('#nsistema').val();
	ndescripcion = $('#ndescripcion').val();
	nsub  = [];
		for (i=1; i<=nextinput; i++) {
			nsub[i] = $('#campo'+i+'').val();
		}
	var arv = nsub.toString();
	cadena = 	"ngrupo=" + ngrupo +
						"&nsistema=" + nsistema +
						"&ndescripcion=" + ndescripcion +
						"&gse=" + gse +
						"&nsub=" + arv;
		$.ajax({
			type:"POST",
			url:"../Modelo/agregarGrupo.php",
			data:cadena,
			success:function(datos){
				if(datos==0){
					alertify.error("Datos mal ingresados");
				}else{
					if(datos==1){
						alertify.error("No hay conexión con el servidor");
					}else{
						if(datos==2){
							alertify.success("Creados con éxito");
							$('#tabla').load('../Modelo/grupos.php?g='+gs);
						}else{
							if (datos==3) {
								alertify.error("No se pudo crear ");
							}else{
								alert(datos);
							}
						}
					}
				}
			}
		});
}

//MÉTODO PARA CREAR SISTEMAS
function crearSistemas(){
	if (typeof gs == 'undefined') {
		gse = "universidad_implementacion";
	}else{
		gse = gs;
	}
	nsistema = $('#nsistemas').val();
	nsis  = [];
		for (i=1; i<=nextinputs; i++) {
			nsis[i] = $('#campo'+i+'').val();
		}
		var arv = nsis.toString();
		cadena = 	"nsistema=" + nsistema +
							"&gse=" + gse +
							"&nsub=" + arv;
		 $.ajax({
			 type:"POST",
			 url:"../Modelo/agregarSistemas.php",
			 data:cadena,
			 success:function(datos){
				 if(datos==0){
					 alertify.error("Datos mal ingresados");
				 }else{
					 if(datos==1){
						 alertify.error("No hay conexión con el servidor");
					 }else{
						 if(datos==2){
							 $('#tabla').load('../Modelo/grupos.php?g='+gse);
							 alertify.success("Sistema creado con éxito");
						 }else{
							 if(datos==3){
								 alertify.error("No se puede eliminar ");
							 }else{
								 alert(datos);
							 }
						 }
					 }
				 }
			 }
		 });
}

//MÉTODO PARA ELIMINAR UN GRUPO
function eliminarGrupo() {
    eliminarg = [];
    $('input:checkbox[name=grupose]').each(function () {
        if (this.checked) {
            eliminarg += $(this).val() + ' ';
        }
    });
    cadena = "ngrupo=" + eliminarg;

    $.ajax({
        type: "POST",
        url: "../Modelo/grupoEliminado.php",
        data: cadena,
        success: function (datos) {
            if (datos == 0) {
                alertify.error("Datos mal ingresados");
            } else {
                if (datos == 1) {
                    alertify.error("No hay conexión con el servidor");
                } else {
                    if (datos == 2) {
                        $('#tabla').load('../Modelo/grupos.php');
                        alertify.success("Eliminado con éxito");
                    } else {
                        if (datos == 3) {
                            alertify.error("No se puede eliminar ");
                        } else {
                            alert(datos);
                        }
                    }

                }
            }
        }
    });
}

//MÉTODO PARA MOSTRAR LOS SISTEMAS
function mostrarSistemas(){
	$('.contenidoSi').load('../Modelo/obtenerSistemas.php?',function(){
	$('#eliminarSistema').modal({show:true});
	});
}

//MÉTODO PARA ELIMINAR UN SISTEMA
function eliminarSistema(){
	var a = "universidad_implementacion";
	eliminars  = [];
		$('input:checkbox[name=sistemas]').each(function(){
      if (this.checked) {
        eliminars += $(this).val()+' ';
      }
    });
	cadena = 	"nsistema=" + eliminars;
		$.ajax({
			type:"POST",
			url:"../Modelo/sistemaEliminado.php",
			data:cadena,
			success:function(datos){
				if(datos==0){
					alertify.error("Datos mal ingresados");
				}else{
					if(datos==1){
						alertify.error("No hay conexión con el servidor");
					}else{
						if(datos==2){
							$('#tabla').load('../Modelo/grupos.php?g='+a);
							alertify.success("Eliminado con éxito");
						}else{
							if(datos==3){
								alertify.error("No se puede eliminar ");
							}else{
								alert(datos);
							}
						}
					}
				}
			}
		});
}

//MÉTODO PARA ACTUALIZAR LA INFORMACIÓN DE UN USUARIO
function actualizar(cedula,nombre,apellido,correo,telefono,contrasena,grupo){
	var nombre1 = nombre.split(' ')[0];
	var nombre2 = nombre.split(' ')[1];
	var apellido1 = apellido.split(' ')[0];
	var apellido2 = apellido.split(' ')[1];
	cadena =  "cedula=" + cedula +
						"&nombre1=" + nombre1 +
						"&nombre2=" + nombre2 +
						"&apellido1=" + apellido1 +
						"&apellido2=" + apellido2 +
						"&correo=" + correo +
						"&telefono=" + telefono +
						"&contrasenia=" + contrasena +
						"&user=" + user +
						"&tipoU=" + grupo;
		$.ajax({
			type:"POST",
			url:"../Modelo/modificarusuario.php",
			data:cadena,
			success:function(datos){
				if(datos==0){
					alertify.error("No se estableció la conexión con el servidor");
				}else{
					if(datos==1){
						alertify.error("Los datos ingresados son incorrectos");
					}else{
						if(datos==2){
							alertify.error("Error al actualizar los datos. Vuelva a intentarlo");
						}else{
							if(datos==3){
								alertify.error("Error al cambiar el usuario de grupo");
							}else{
								//	$('#tabla').load('tablausr.php?id1='+selec);
								alertify.success("Los datos se actualizaron correctamente.");
								$('#example').DataTable().ajax.reload();
							}
						}
					}
				}
			}
		});
}

var nextinputs = 0;
//MÉTODO PARA AGREGAR MAS CAMPOS
function AgregarCampossistemas(){
	nextinputs++;
	campo = '<li id="rut'+nextinputs+'">Sistema:<input type="text" class="form-control"  id="campo' + nextinputs + '"&nbsp; name="campo' + nextinputs + '"&nbsp; /></li>';
	$("#camposs").append(campo);
}

//MÉTODO PARA MOSTRAR GRUPOS
function myFunction(datos) {
  gs = datos;
  $('#botones').hide();
  $('#tabla').load('../Modelo/grupos.php?g='+datos);
}
