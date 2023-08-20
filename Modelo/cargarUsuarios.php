<?php
header('Access-Control-Allow-Origin: *');
session_start();
$user_name = $_SESSION['usuario'];
$password = $_SESSION['password'];

require_once('../Modelo/config.php');

$conectar = ldap_connect("ldap://{$host}:{$port}") or die("No se puede conectar al servidor LDAP");
ldap_set_option($conectar, LDAP_OPT_PROTOCOL_VERSION, 3);
    $target_path = $_SERVER['DOCUMENT_ROOT'];
    $rutat = $_FILES['csv']['tmp_name'];
    $nombret = $_FILES['csv']['name'];
    $uploads_dir = '/SiGUCAS/Modelo/UsuariosCargados';
    move_uploaded_file($rutat, "$target_path$uploads_dir/$nombret");
    $dir = $target_path.$uploads_dir."/".$nombret;
    echo $dir;

    $linea = 0;
    $añadido= 0;
    $usuariosExistentes = 0;
    $error= 0;
    $archivo = fopen($dir, "rw");

     if($conectar) {
        if(@ldap_bind($conectar, "cn={$user_name},{$baseAdmin}", $password)) {
            if($nombret!=null){
            while (($datos = fgetcsv($archivo, 12000, ";")) == true)
                {
                  $datos = array_map("utf8_encode", $datos);
                  $num = count($datos);
                  $linea++;
                  //Recorremos las columnas de esa linea
                  for ($columna = 0; $columna < $num; $columna++)
                      {
                         $datos[$columna];
                     }

                     if ($linea != 1 ){
                        $cedula = $datos[0];
                         $filtro = "eduPersonTargetedID=$cedula";
                         $arreglo = array("eduPersonTargetedID");
                         $resultadoU = @ldap_search($conectar, $baseGeneral, $filtro, $arreglo);
                         $valorU = ldap_count_entries($conectar, $resultadoU);

        if($valorU == 0){
                            $nombres = $datos[1];
			    $nombreSep = explode(" ", $nombres);
			    @$nombre1 = $nombreSep[0];
			    @$nombre2 = $nombreSep[1];
                            $apellidos = $datos[2];
			    $apellidoSep = explode(" ", $apellidos);
			    @$apellido1 = $apellidoSep[0];
			    @$apellido2 = $apellidoSep[1];
                            $telefono = $datos[4];
                            $tipoU = $datos[5];
			    @$letra1 = lcfirst($nombre1);
			    @$letra2 = lcfirst($nombre2[0]);
			    @$letra3 = lcfirst($apellido1);
			    @$letra4 = lcfirst($apellido2[0]); 

			    @$uid = $letra1.".".$letra3;
			    @$uid2 = $letra1.".".$letra2.".".$letra3;
			    @$uid3 = $letra1.".".$letra2.".".$letra3.".".$letra4;
                            $correo = $datos[3];
                            $hashFormat = "$2y$10$";
                            $salt = "cas&ySiGUCAS&LdapCas22";
                            $key = $hashFormat.$salt;
                            $contra = hash_hmac('sha256', $cedula, $key, false);
                $info["cn"][0] = "$nombres";
                $info["sn"][0] = "$apellidos";
                $info["givenName"][0] = "$nombres";
                $info["objectclass"][0] = "person";
                $info["objectclass"][1] = "inetOrgPerson";
                $info["objectclass"][2] = "organizationalPerson";
                $info["objectclass"][3] = "top";
                $info["objectclass"][4] = "eduPerson";
                $info["userPassword"][0] = "$cedula";
                $info["telephoneNumber"][0] = "$telefono";
                $info["ou"][0] = "$tipoU";
                $info['eduPersonTargetedID'][0] = "$cedula";
                $info["eduPersonPrincipalName"][0] = "$correo";
                $info["mail"][0] = "$correo";
                $baseAcademicos1 = "ou=$tipoU,ou=academicos,"."".$baseGeneral;
                 $baseAdministrativos1 = "ou=$tipoU,ou=administrativos,"."".$baseGeneral;
                $baseOtros1 = "ou=$tipoU,"."".$baseGeneral;
                $mensaje = "Bienvenido al Sistema de Autenticción Central CAS \n";
                        $mensaje .=  "Sus credenciales son: \n";
                        $mensaje .=  "Usuario : $correo \n";
                        $mensaje .=  "Contraseña : $cedula";
                        $destino = $correo;
                        $asunto = 1;

                if($tipoU == 'estudiantes' or $tipoU == 'docentes'){
                    if(@ldap_add($conectar, "uid={$uid},{$baseAcademicos1}" , $info)){
                       $añadido++;
                       //correo($mensaje, $destino , $asunto);
                    }else{
                        if(@ldap_add($conectar, "uid={$uid2},{$baseAcademicos1}" , $info)){
                            $añadido++;
                        }else{
                            if(@ldap_add($conectar, "uid={$uid3},{$baseAcademicos1}" , $info)){
                                 $añadido++;
                            }else{
                                $token = 2;
                                $error++;
                                //echo $token;
                            }
                        }
                    }
                }else{
                    if($tipoU == 'servidores' or $tipoU == 'trabajadores'){
                        if(@ldap_add($conectar, "uid={$uid},{$baseAdministrativos1}" , $info)){
                            $añadido++;
                          //  correo($mensaje, $destino , $asunto);
                        }else{
                            if(@ldap_add($conectar, "uid={$uid2},{$baseAdministrativos1}" , $info)){
                                    $añadido++;
                            }else{
                                if(@ldap_add($conectar, "uid={$uid3},{$baseAdministrativos1}" , $info)){
                                    $añadido++;
                                }else{
                                    $token = 2;
                                      $error++;
                                  //  echo "$token";
                                }
                            }
                        }
                    }else{
                        if(@ldap_add($conectar, "uid={$uid},{$baseOtros1}" , $info)){
                           $añadido++;
                           //correo($mensaje, $destino , $asunto);
                        }else{
                            if(@ldap_add($conectar, "uid={$uid2},{$baseOtros1}" , $info)){
                               $añadido++;
                            }else{
                                if(@ldap_add($conectar, "uid={$uid3},{$baseOtros1}" , $info)){
                                    $añadido++;
                                }else{
                                    $token = 2;
                                      $error++;
                                    //echo "$token";
                                }
                            }
                        }
                    }

                }
            }else{
                $usuariosExistentes++;
            }
        }
    }
fclose($archivo);
echo "$añadido,$usuariosExistentes,$error";
}else{
    $token = 3;
    echo $token;
}
        }else{
                $token = 1;
                echo "$token";
            }
        }else{
                $token = 0;
                echo "$token";
            }

?>
