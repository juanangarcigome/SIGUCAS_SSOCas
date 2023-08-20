<?php
require_once("../Modelo/lib/nusoap.php");
$servicio = new soap_server();
$ns = "urn:miserviciowsdl";
$servicio->configureWSDL("miprimerservicio",$ns);
$servicio->schemaTargetNamespace = $ns;

$servicio->register("nuevo_usuario", array('datos' => 'xsd:string','servidor'=> 'xsd:string',
'puerto' => 'xsd:int','baseAdmin'=> 'xsd:string'),
array('return' => 'xsd:string'), $ns);

$servicio->register("actualizar", array('datos' => 'xsd:string','servidor'=> 'xsd:string',
'puerto' => 'xsd:int','baseAdmin'=> 'xsd:string'),
array('return' => 'xsd:string'), $ns);

$servicio->register("eliminar", array('datos' => 'xsd:string','servidor'=> 'xsd:string',
'puerto' => 'xsd:int','baseAdmin'=> 'xsd:string'),
array('return' => 'xsd:string'), $ns);

$servicio->register("autenticar", array('datos' => 'xsd:string','servidor'=> 'xsd:string',
'puerto' => 'xsd:int','baseAdmin'=> 'xsd:string'),
array('return' => 'xsd:string'), $ns);

$servicio->register("actualizar_contrasenia", array('datos' => 'xsd:string','servidor'=> 'xsd:string',
'puerto' => 'xsd:int','baseAdmin'=> 'xsd:string'),
array('return' => 'xsd:string'), $ns);

$servicio->register("nuevo_grupo", array('datos' => 'xsd:string','servidor'=> 'xsd:string',
'puerto' => 'xsd:int','baseAdmin'=> 'xsd:string'),
array('return' => 'xsd:string'), $ns);

$servicio->register("nuevo_sistema", array('datos' => 'xsd:string','servidor'=> 'xsd:string',
'puerto' => 'xsd:int','baseAdmin'=> 'xsd:string'),
array('return' => 'xsd:string'), $ns);

$servicio->register("obtener_sistemas", array('datos' => 'xsd:string','servidor'=> 'xsd:string',
'puerto' => 'xsd:int','baseAdmin'=> 'xsd:string'),
array('return' => 'xsd:string'), $ns);


function nuevo_usuario($datos,$servidor,$puerto,$baseAdmin){
$user_name=$datos[0];
$password=$datos[1];
$nombre1 = $datos[2];
$nombre2 = $datos[3];
$apellido1 = $datos[4];
$apellido2 = $datos[5];
$cedula = $datos[6];
$telefono = $datos[7];
$correo = $datos[8];
$tipoU = $datos[9];
$host =$servidor;
$port = $puerto;   //PUERTO DE CONEXI?^?N DEL SERVIDOR
$baseGeneral = "ou=personal,"."".$baseAdmin;
$baseEstudiantes = "ou=estudiantes,ou=academicos,"."".$baseGeneral;
$baseDocentes = "ou=docentes,ou=academicos,"."".$baseGeneral;
$baseServidores = "ou=servidores,ou=administrativos,"."".$baseGeneral;
$baseTrabajadores = "ou=trabajadores,ou=administrativos,"."".$baseGeneral;
$baseOtros = "ou=otros,"."".$baseGeneral;
$baseGrupo = "universidad_implementacion";
$baseGeneral2 = "ou=universidad_implementacion,dc=unl,dc=edu,dc=ec";
$baseAcademicos = "ou=academicos,"."".$baseGeneral;
$baseAdministrativos = "ou=administrativos,"."".$baseGeneral;

/*$hashFormat = "$2y$10$";
$salt = "cas&ySiGUCAS&LdapCas22";
$key = $hashFormat.$salt;
$contra = hash_hmac('sha256', $cedula, $key, false);
*/

$conectar = ldap_connect("ldap://{$host}:{$port}") or die("No se puede conectar al servidor LDAP");
ldap_set_option($conectar, LDAP_OPT_PROTOCOL_VERSION, 3);

    @$letra1 = lcfirst($nombre1);
    @$letra2 = lcfirst($nombre2[0]);
    @$letra3 = lcfirst($apellido1);
    @$letra4 = lcfirst($apellido2[0]); 

    @$uid = $letra1.".".$letra3;
    @$uid2 = $letra1.".".$letra2.".".$letra3;
    @$uid3 = $letra1.".".$letra2.".".$letra3.".".$letra4;
    if($conectar) {
        if(@ldap_bind($conectar, "cn={$user_name},{$baseAdmin}", $password)) {
            $filtro = "eduPersonTargetedID=$cedula";
            $arreglo = array("eduPersonTargetedID");
            $resultadoU = @ldap_search($conectar, $baseGeneral, $filtro, $arreglo);
            $valorU = ldap_count_entries($conectar, $resultadoU);
            if($valorU == 0){
                $info["cn"][0] = $nombre1." ".$nombre2;
                $info["sn"][0] = $apellido1." ".$apellido2;
                $info["givenName"][0] = $nombre1." ".$nombre2;
                $info["objectclass"][0] = "person";
                $info["objectclass"][1] = "inetOrgPerson";
                $info["objectclass"][2] = "organizationalPerson";
                $info["objectclass"][3] = "top";
                $info["objectclass"][4] = "eduPerson";
                $info["userPassword"][0] = "$cedula";
                $info["telephoneNumber"][0] = "$telefono";
                $info["ou"][0] = "$tipoU";
                $info['eduPersonTargetedID'][0] = "$cedula";
                $info["eduPersonPrincipalName"][0] = "$uid";
                $info["mail"][0] = "$correo";

                $academico = "ou=$tipoU,"."".$baseAcademicos;
                $administrativo = "ou=$tipoU,"."".$baseAdministrativos;
                 $otros = $baseOtros;

                        // $mensaje = "Bienvenido al Sistema de Autenticción Central CAS \n";
                        // $mensaje .=  "Sus credenciales son: \n";
                        // $mensaje .=  "Usuario : $correo \n";
                        // $mensaje .=  "Contraseña : $cedula";
                        $destino = $correo;

                if($tipoU == 'estudiantes' or $tipoU == 'docentes'){
                    if(@ldap_add($conectar, "uid={$uid},{$academico}" , $info)){
                        //correo_crear($destino ,$uid , $cedula);
                    	$token = 4;
                    }else{
                        if(@ldap_add($conectar, "uid={$uid2},{$academico}" , $info)){
                        	$token = 4;
                        }else{
                            if(@ldap_add($conectar, "uid={$uid3},{$academico}" , $info)){
                            	$token = 4;
                            }else{
                                $token = 2;
                            }
                        }
                    }
                }else{
                	if($tipoU == 'servidores' or $tipoU == 'trabajadores'){
                        if(@ldap_add($conectar, "uid={$uid},{$administrativo}" , $info)){
                          //correo_crear($destino ,$uid , $cedula);
        					$token = 4;
                        }else{
                            if(@ldap_add($conectar, "uid={$uid2},{$administrativo}" , $info)){
        							$token = 4;
                            }else{
                                if(@ldap_add($conectar, "uid={$uid3},{$administrativo}" , $info)){
        							$token = 4;
                                }else{
                                    $token = 2;
                                }
                            }
                        }
                    }else{
                    	if(@ldap_add($conectar, "uid={$uid},{$otros}" , $info)){
                            //correo_crear($destino ,$uid , $cedula);
        					$token = 4;
                        }else{
                            if(@ldap_add($conectar, "uid={$uid2},{$otros}" , $info)){
        						$token = 4;
                            }else{
                                if(@ldap_add($conectar, "uid={$uid3},{$otros}" , $info)){
        							$token = 4;
                                }else{
                                    $token = 2;
                                }
                            }
                        }
                    }
                }
            }else{
                $token = 1;
            }
        }else{
        	$token = 3;
        }
    }else{
    	$token = 2;
    }

    return json_encode(array("token" => $token,"status" => $uid,"DNI" => $cedula,"destino" => $correo,"nombre"=> $nombre1, "apellido"=> $apellido1));

}

function actualizar($datos,$servidor,$puerto,$baseAdmin){
  $user_name=$datos[0];
  $password=$datos[1];
  $nombre1 = $datos[2];
  $nombre2 = $datos[3];
  $apellido1 = $datos[4];
  $apellido2 = $datos[5];
  $cedula = $datos[6];
  $telefono = $datos[7];
  $correo = $datos[9];
  $tipoU = $datos[8];
  $contrasena = $datos[10];
	$user = $datos[11];
  $host =$servidor;
  $port = $puerto;

  $baseGeneral = "ou=personal,"."".$baseAdmin;
  $baseEstudiantes = "ou=estudiantes,ou=academicos,"."".$baseGeneral;
  $baseDocentes = "ou=docentes,ou=academicos,"."".$baseGeneral;
  $baseServidores = "ou=servidores,ou=administrativos,"."".$baseGeneral;
  $baseTrabajadores = "ou=trabajadores,ou=administrativos,"."".$baseGeneral;
  $baseOtros = "ou=otros,"."".$baseGeneral;
  $baseGrupo = "universidad_implementacion";
  $baseGeneral2 = "ou=universidad_implementacion,dc=unl,dc=edu,dc=ec";
  $baseAcademicos = "ou=academicos,"."".$baseGeneral;
  $baseAdministrativos = "ou=administrativos,"."".$baseGeneral;


  $conectar = ldap_connect("ldap://{$host}:{$port}") or die("No se puede conectar al servidor LDAP");
  ldap_set_option($conectar, LDAP_OPT_PROTOCOL_VERSION, 3);


      $academico = "ou=".$tipoU.",".$baseAcademicos;
      $administrativos = "ou=".$tipoU.",".$baseAdministrativos;
      $otro = $baseOtros;
      $uid = $user;

      if($conectar){
          if(@ldap_bind($conectar, "cn={$user_name},{$baseAdmin}", $password)){
              $filtro = "uid=$user";
              $arreglo = array("userPassword", "ou");
              $resultadoU = @ldap_search($conectar, $baseGeneral, $filtro, $arreglo);
              $entradaA = ldap_get_entries($conectar, $resultadoU);
              for ($i=0; $i<$entradaA["count"]; $i++){
                  //@$uid = $entradaA[$i]["uid"][0];
                  @$contrasenaA = $entradaA[$i]["userpassword"][0];
                  @$ou = $entradaA[$i]["ou"][0];
              }
              // if($contrasena == NULL){
              //     //Si se presenta error toca encriptar también la contraseña. Estar pendiente
              //     $cambioContra1 = $contrasenaA;
              // }else{
              //     $hashFormat = "$2y$10$";
              //     $salt = "cas&ySiGUCAS&LdapCas22";
              //     $key = $hashFormat.$salt;
              //     $contra = hash_hmac('sha256', $contrasena, $key, false);
              //     $cambioContra1 = $contra;
              // }



              if($tipoU == $ou){
                  $info["cn"][0] = $nombre1." ".$nombre2;
                  $info["sn"][0] = $apellido1." ".$apellido2;
                  $info["givenName"][0] = $nombre1." ".$nombre2;
                  $info["userPassword"][0] = "$contrasena";
                  $info["telephoneNumber"][0] = "$telefono";
                  $info["ou"][0] = "$ou";
                  $info["eduPersonTargetedID"][0] = "$cedula";
                  $info["eduPersonPrincipalName"][0] = "$user";
                  $info["mail"][0] = "$correo";
                  if($tipoU == 'estudiantes' or $tipoU == 'docentes'){
                      if(@ldap_mod_replace($conectar, "uid={$uid},{$academico}" , $info)){
                        $token = 4;
                      }else{
                          $token = 2;
                      }
                  }else{
                      if($tipoU == 'servidores' or $tipoU == 'trabajadores'){
                          if(@ldap_mod_replace($conectar, "uid={$uid},{$administrativos}" , $info)){
                              $token = 4;
                          }else{
                              $token = 2;
                          }
                      }else{
                          if(@ldap_mod_replace($conectar, "uid={$uid},{$otro}", $info)){
                              $token = 4;
                          }else{
                              $token = 2;
                          }
                      }
                  }
         }else{
                      $info["cn"][0] = $nombre1." ".$nombre2;
                      $info["sn"][0] = $apellido1." ".$apellido2;
                      $info["givenName"][0] = $nombre1." ".$nombre2;
                       $info["objectclass"][0] = "person";
                       $info["objectclass"][1] = "inetOrgPerson";
                      $info["objectclass"][2] = "organizationalPerson";
                      $info["objectclass"][3] = "top";
                      $info["objectclass"][4] = "eduPerson";
                      $info["userPassword"][0] = "$contrasena";
                      $info["telephoneNumber"][0] = "$telefono";
                      $info["ou"][0] = "$tipoU";
                      $info["eduPersonTargetedID"][0] = "$cedula";
                      $info["eduPersonPrincipalName"][0] = "$user";
                      $info["mail"][0] = "$correo";
                      if($ou == 'estudiantes' or $ou == 'docentes'){
                          $baseAcademicosE = "uid=$uid,ou=$ou,ou=academicos,"."".$baseGeneral;
                          @ldap_delete($conectar, $baseAcademicosE);
                          if($tipoU == 'estudiantes' or $tipoU == 'docentes'){
                                  if(@ldap_add($conectar, "uid={$correo},{$academico}" , $info)){
                                    $token = 4;
                                  }else{
                                      $token = 2;
                                  }
                              }else{
                                  if($tipoU == 'servidores' or $tipoU == 'trabajadores'){
                                      if(@ldap_add($conectar, "uid={$uid},{$administrativos}" , $info)){
                                          $token = 4;
                                      }else{
                                          $token = 2;
                                      }
                                  }else{
                                      if(@ldap_add($conectar, "uid={$uid},{$otro}" , $info)){
                                        $token = 4;
                                      }else{
                                          $token = 2;
                                      }
                                  }
                              }
                      }else{
                          if($ou == 'servidores' or $ou == 'trabajadores'){
                              $baseAdministrativosE = "uid=$uid,ou=$ou,ou=administrativos,"."".$baseGeneral;
                              @ldap_delete($conectar, $baseAdministrativosE);
                              if($tipoU == 'estudiantes' or $tipoU == 'docentes'){
                                  if(@ldap_add($conectar, "uid={$uid},{$academico}" , $info)){
                                      $token = 4;
                                  }else{
                                      $token = 2;
                                  }
                              }else{
                                  if($tipoU == 'servidores' or $tipoU == 'trabajadores'){
                                      if(@ldap_add($conectar, "uid={$uid},{$administrativos}" , $info)){
                                          $token = 4;
                                      }else{
                                          $token = 2;
                                      }
                                  }else{
                                      if(@ldap_add($conectar, "uid={$uid},{$otro}" , $info)){
                                        $token = 4;
                                      }else{
                                          $token = 2;
                                      }
                                  }
                              }
                          }else{
                              $baseOtrosE = "uid=$uid,ou=$ou,"."".$baseGeneral;
                              @ldap_delete($conectar, $baseOtrosE);
                              if($tipoU == 'estudiantes' or $tipoU == 'docentes'){
                                  if(@ldap_add($conectar, "uid={$uid},{$academico}" , $info)){
                                      $token = 4;
                                  }else{
                                      $token = 2;
                                  }
                              }else{
                                  if($tipoU == 'servidores' or $tipoU == 'trabajadores'){
                                      if(@ldap_add($conectar, "uid={$uid},{$administrativos}" , $info)){
                                        $token = 4;
                                      }else{
                                          $token = 2;
                                      }
                                  }else{
                                      if(@ldap_add($conectar, "uid={$uid},{$otro}" , $info)){
                                          $token = 4;
                                      }else{
                                          $token = 2;
                                      }
                                  }
                              }
                          }
                      }
                  }

          }else{
              $token = 1;
          }

      }else{
          $token = 0;
      }
      return json_encode(array("token" => $token));

}

function eliminar($datos,$servidor,$puerto,$baseAdmin){
  $user_name=$datos[0];
  $password=$datos[1];
  $usuario = $datos[2];
  $host =$servidor;
  $port = $puerto;
  $baseGeneral = "ou=personal,"."".$baseAdmin;
  $baseGeneral2 = "ou=universidad_implementacion,"."".$baseAdmin;

  $conectar = ldap_connect("ldap://{$host}:{$port}") or die("No se puede conectar al servidor LDAP");
  ldap_set_option($conectar, LDAP_OPT_PROTOCOL_VERSION, 3);
      if ($conectar) {
          if(@ldap_bind($conectar, "cn={$user_name},{$baseAdmin}", $password)){
                 //ldap_delete($conectar, $baseEliminar);
                  $filtro = "cn=*";
                  $arreglo = array("cn");
                  $resultado = @ldap_search($conectar, $baseGeneral2, $filtro, $arreglo) or exit("Buscando...");
                  $entrada = @ldap_get_entries($conectar, $resultado);
                  $valor = @ldap_count_entries($conectar, $resultado);
                  $firs = @ldap_first_entry($conectar, $resultado);
                  $infoUsuario["memberUid"] = "$usuario";

                  $filtroE = "uid=$usuario";
                  $arregloE = array("ou");
                  $resultadoE = @ldap_search($conectar, $baseGeneral, $filtroE, $arregloE) or exit("Buscando...");
                  $entrada = @ldap_get_entries($conectar, $resultadoE);
                  $firsE = @ldap_first_entry($conectar, $resultadoE);
                  $dnE = ldap_get_dn($conectar, $firsE);
                  do{
                  $dn = ldap_get_dn($conectar, $firs);
                  $cn = ldap_explode_dn($dn, 0);
                  @ldap_mod_del($conectar, $dn, $infoUsuario);
                  }while($firs = ldap_next_entry($conectar, $firs));
                  ldap_delete($conectar, $dnE);
                  $token = 2;
          }else{
              $token = 1;
          }
      }else{
          $token = 0;
      }
return json_encode(array("token" => $token));
}

function autenticar($datos,$servidor,$puerto,$baseAdmin){

  $nombres = $datos[0];
  $password = $datos[1];
  $host = $servidor;
  $port = $puerto;
  $baseGeneral = "ou=personal,"."".$baseAdmin;
  $baseEstudiantes = "ou=estudiantes,ou=academicos,"."".$baseGeneral;
  $baseDocentes = "ou=docentes,ou=academicos,"."".$baseGeneral;
  $baseServidores = "ou=servidores,ou=administrativos,"."".$baseGeneral;
  $baseTrabajadores = "ou=trabajadores,ou=administrativos,"."".$baseGeneral;
  $baseOtros = "ou=otros,"."".$baseGeneral;
  $baseGrupo = "universidad_implementacion";
  $baseGeneral2 = "ou=universidad_implementacion,dc=unl,dc=edu,dc=ec";
  $baseAcademicos = "ou=academicos,"."".$baseGeneral;
  $baseAdministrativos = "ou=administrativos,"."".$baseGeneral;


  $conectar = ldap_connect("ldap://{$host}:{$port}") or die("No se puede conectar al servidor LDAP");
  ldap_set_option($conectar, LDAP_OPT_PROTOCOL_VERSION, 3);

  if ($conectar) {
    if(@ldap_bind($conectar, "cn={$nombres},{$baseAdmin}", $password)){
      $filtro = "cn=$nombres";
      $arreglo = array("cn");
      $resultado = ldap_search($conectar, "cn={$nombres},{$baseAdmin}", $filtro, $arreglo) or exit("Buscando...");
      $entrada = ldap_get_entries($conectar, $resultado);
      $valor = ldap_count_entries($conectar, $resultado);
            for ($i=0; $i<$entrada["count"]; $i++){
                $nombre = $entrada[$i]["cn"][0];
                 $datos[$i][0] = $nombre;
                 $token = 1;
            }
    }else{
      if(    @ldap_bind($conectar, "uid={$nombres},{$baseEstudiantes}", $password)
        || @ldap_bind($conectar, "uid={$nombres},{$baseDocentes}", $password)
        || @ldap_bind($conectar, "uid={$nombres},{$baseServidores}", $password)
        || @ldap_bind($conectar, "uid={$nombres},{$baseTrabajadores}", $password)
        || @ldap_bind($conectar, "uid={$nombres},{$baseOtros}", $password)){

        $filtro = "uid=$nombres";
        $arreglo = array("uid","sn", "givenName", "mail","userpassword");
        $resultado = @ldap_search($conectar, $baseGeneral, $filtro, $arreglo);
        $entrada = ldap_get_entries($conectar, $resultado);
          for ($i=0; $i<$entrada["count"]; $i++){
               $usuario = $entrada[$i]["uid"][0];
                $apellido = $entrada[$i]["sn"][0];
               $nombre = $entrada[$i]["givenname"][0];
               $correo = $entrada[$i]["mail"][0];
               $password = $entrada[$i]["userpassword"][0];
               $datos[$i][0] = $usuario;
               $datos[$i][1] = $nombre;
               $datos[$i][2] = $apellido;
               $datos[$i][3] = $correo;
                $datos[$i][4] = $password;
               $token = 2;
          }
      }else{
        $token = 3;
      }
  }

  }else{
    $token = 4;
  }
  return json_encode(array("token" => $token,"usuario" => $nombres,"password" => $password,"nombre" => $nombre,"apellido" => $apellido,"correo" => $correo));
}

function actualizar_contrasenia($datos,$servidor,$puerto,$baseAdmin){
$user_name=$datos[0];
$password=$datos[1];
$passwordActual = $datos[2];
$passwordNueva = $datos[3];
$passwordNueva2 = $datos[4];
$host =$servidor;
$port = $puerto;   //PUERTO DE CONEXI?^?N DEL SERVIDOR
$baseGeneral = "ou=personal,"."".$baseAdmin;
$baseEstudiantes = "ou=estudiantes,ou=academicos,"."".$baseGeneral;
$baseDocentes = "ou=docentes,ou=academicos,"."".$baseGeneral;
$baseServidores = "ou=servidores,ou=administrativos,"."".$baseGeneral;
$baseTrabajadores = "ou=trabajadores,ou=administrativos,"."".$baseGeneral;
$baseOtros = "ou=otros,"."".$baseGeneral;
$baseGrupo = "universidad_implementacion";
$baseGeneral2 = "ou=universidad_implementacion,dc=unl,dc=edu,dc=ec";
$baseAcademicos = "ou=academicos,"."".$baseGeneral;
$baseAdministrativos = "ou=administrativos,"."".$baseGeneral;
$conectar = ldap_connect("ldap://{$host}:{$port}") or die("No se puede conectar al servidor LDAP");
ldap_set_option($conectar, LDAP_OPT_PROTOCOL_VERSION, 3);

if ($conectar){
    if(@ldap_bind($conectar, "cn={$user_name},{$baseAdmin}", $password)){
    $infoG["objectclass"][0] = "organizationalUnit";
    $infoG["objectclass"][1] = "top";
    $infoG["description"][0] = $descripcion;
    $filtro = "ou=$gse";
          $arreglo = array("ou");
          $resultado = @ldap_search($conectar, $baseGeneral2, $filtro, $arreglo) or exit("Buscando...");
          $firs = @ldap_first_entry($conectar, $resultado);
          $dn = ldap_get_dn($conectar, $firs);
            $filtroS = "cn=*";
            $arregloS = array("cn");
            $resultadoS = @ldap_search($conectar, $baseGeneral2, $filtroS, $arregloS) or exit("Buscando...");
            $valorS = @ldap_count_entries($conectar, $resultadoS);
            $valorS++;
            $infoS["objectclass"][0] = "posixGroup";
            $infoS["objectclass"][1] = "top";
            $infoS["description"][0] = "Sistema";
            $infoS["gidNumber"][0] = "$valorS";

            if($nombreG != NULL){
              $dominioG = "ou=$nombreG,"."".$dn;
            @ldap_add($conectar, $dominioG, $infoG);
        if($gse != NULL){
          for($i=1; $i<$to; $i++){
          $ng = $tok[$i];

            $dominioG = "ou=$ng,"."".$dominioG;
            $infoSG["objectclass"][0] = "organizationalUnit";
          $infoSG["objectclass"][1] = "top";
          $infoSG["description"][0] = "subgrupo";
          @ldap_add($conectar, $dominioG, $infoSG);
        }
          $nombreS = "cn=$nombres".",".$dominioG;
          if(@ldap_add($conectar, $nombreS, $infoS)){
            $token = 2;
          }else{
            $token = 3;
          }
        }else{
          $nombreS = "cn=$nombreS".",".$dominioG;
          if(@ldap_add($conectar, $nombreS, $infoS)){
            $token = 2;
          }else{
            $token = 3;
          }
        }
    }else{
      $nombreS = "cn=$nombres".",".$dn;
      if(@ldap_add($conectar, $nombreS, $infoS)){
            $token = 2;
          }else{
            $token = 3;
        }
    }
    }else{
    $token = 0;
  }
}else{
  $token = 1;
}
return json_encode(array("token" => $token));
}
//
function nuevo_sistema($datos,$servidor,$puerto,$baseAdmin){
  $user_name=$datos[0];
  $password=$datos[1];
  $nombres = $datos[2];
  $sub = $datos[3];
  $gse = $datos[4];
  $host =$servidor;
  $port = $puerto;
  $baseGeneral = "ou=personal,"."".$baseAdmin;
  $baseGeneral2 = "ou=universidad_implementacion,"."".$baseAdmin;

  $tok = explode(',',$sub);    //
  $to = count($tok);

  $conectar = ldap_connect("ldap://{$host}:{$port}") or die("No se puede conectar al servidor LDAP");       // Conexión al servidor LDAP
  ldap_set_option($conectar, LDAP_OPT_PROTOCOL_VERSION, 3);

  	if ($conectar){
  	   	if(@ldap_bind($conectar, "cn={$user_name},{$baseAdmin}", $password)){
  			$infoG["objectclass"][0] = "organizationalUnit";
  			$infoG["objectclass"][1] = "top";
  			$infoG["description"][0] = "prueba";
  			$filtro = "ou=$gse";
              $arreglo = array("ou");
              $resultado = @ldap_search($conectar, $baseGeneral2, $filtro, $arreglo) or exit("Buscando...");
              $firs = @ldap_first_entry($conectar, $resultado);
              $dn = ldap_get_dn($conectar, $firs);


  	            $filtroS = "cn=*";
  	            $arregloS = array("cn");
  	            $resultadoS = @ldap_search($conectar, $baseGeneral2, $filtroS, $arregloS) or exit("Buscando...");
  	            $valorS = @ldap_count_entries($conectar, $resultadoS);
  	            $valorS++;
  	            $infoS["objectclass"][0] = "posixGroup";
  				$infoS["objectclass"][1] = "top";
  				$infoS["description"][0] = "subgrupos";
  				$infoS["gidNumber"][0] = "$valorS";

                   if($nombres != NULL){
                   	$nombreS = "cn=$nombres".",".$dn;
  				ldap_add($conectar, $nombreS, $infoS);
  				$token =2;
                   }

                   for($i=1; $i<$to; $i++){
  			    	$ng = $tok[$i];

  			    	$nombreS = "cn=$ng".",".$dn;
  				ldap_add($conectar, $nombreS, $infoS);
                  }

  	  	}else{
  			$token = 0;
  		}
  	}else{
  		$token = 1;
  	}
    return json_encode(array("token" => $token));
}

function obtener_sistemas($datos,$servidor,$puerto,$baseAdmin){
  $user_name=$datos[0];
  $password=$datos[1];
  $host =$servidor;
  $port = $puerto;
  $baseGeneral = "ou=personal,"."".$baseAdmin;
  $baseGeneral2 = "ou=universidad_implementacion,"."".$baseAdmin;

  $conectar = ldap_connect("ldap://{$host}:{$port}") or die("No se puede conectar al servidor LDAP");
  ldap_set_option($conectar, LDAP_OPT_PROTOCOL_VERSION, 3);
      if ($conectar) {
          if(@ldap_bind($conectar, "cn={$user_name},{$baseAdmin}", $password)){

                  $filtro = "cn=*";
                  $arreglo = array("cn");
                  $resultado = @ldap_search($conectar, $baseGeneral2, $filtro, $arreglo) or exit("Buscando...");
                  $entrada = @ldap_get_entries($conectar, $resultado);
                  $valor = @ldap_count_entries($conectar, $resultado);
                  $firs = @ldap_first_entry($conectar, $resultado);
                  $i = 0;
                  do{
                  $dn = ldap_get_dn($conectar, $firs);
                  $cn = ldap_explode_dn($dn, 0);
                  $cn2 = $entrada[$i]["cn"][0];
                  $token = 2;
                  $i++;
                  }while($firs = ldap_next_entry($conectar, $firs));
          }else{
              $token = 1;
          }
      }else{
            $token = 0;
      }
return json_encode(array("token" => $token, "sistemas" => $cn2 ));
}



$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
//$GLOBALS['HTTP_RAW_POST_DATA'] = file_get_contents('php://input';);
$HTTP_RAW_POST_DATA = $GLOBALS['HTTP_RAW_POST_DATA'];
$servicio->service(file_get_contents("php://input"));

 ?>
