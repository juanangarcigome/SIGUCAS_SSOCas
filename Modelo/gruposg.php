<?php
header('Access-Control-Allow-Origin: *');
session_start();
$user_name= $_SESSION['usuario'];
$password = $_SESSION['password'];
$usuario  = $_GET['usuario'];

require_once('config.php');

@$grupo1 = $baseGrupo;

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
                //echo "$firs";
                //Sepuede dejar este for, ya depende de como se desee imprimir
                /*for ($i=0; $i<$entrada["count"]; $i++){
                    $cn = $entrada[$i]["cn"][0];
                    echo "$cn";
                    echo "\n";
                    echo "<br>";
                }*/
                $i = 0;
                do{
                $dn = ldap_get_dn($conectar, $firs);
                $cn = ldap_explode_dn($dn, 0);
                $cn2 = $entrada[$i]["cn"][0];
                $filtroMU = "memberUid=$usuario";
                $arregloMU = array("memberUid");
                $resultadoMU = @ldap_search($conectar, $dn, $filtroMU, $arregloMU) or exit("Buscando...");
                $entradaMU = @ldap_get_entries($conectar, $resultadoMU);
                $valorMU = @ldap_count_entries($conectar, $resultadoMU);
                if($valorMU != 1){
                    echo '<input type="checkbox" name="grupos" value="'.$dn.'"><b>'.$cn2. '</b>'." " .$dn.'<br>';
                }
                //echo '<input type="checkbox" name="grupos" value="'.$dn.'"><b>'.$cn2. '</b>'." " .$dn.'<br>';
                //echo '<label for="inputnombre" class="col-sm-2 col-form-label">'.$dn. '</label><br><br>';
                $i++;
                }while($firs = ldap_next_entry($conectar, $firs));
        }else{
            return "Datos incorrectos";
        }
    }else{
        return "No hay conexión con el servidor LDAP";
    }
    /*if ($conectar) {
        if(@ldap_bind($conectar, "cn={$user_name},{$baseGeneral}", $password)){
            //echo "$entry";
            do{
                $filtro = "ou=*";
                $arreglo = array("ou", "description");
                //$resultado = ldap_search($conectar, $baseG, $filtro, $arreglo) or exit("Buscando...");
                $resultado = ldap_list($conectar, $baseG, $filtro, $arreglo);
                $entrada = ldap_get_entries($conectar, $resultado);
                $valor = ldap_count_entries($conectar, $resultado);
                $firs = ldap_first_entry($conectar, $resultado);
                //$entry = ldap_next_entry($conectar, $firs);
                $dn = ldap_get_dn($conectar, $firs);
                    if($valor != 0){
                        for ($i=0; $i<$entrada["count"]; $i++){
                            $respuesta =  $entrada[$i]["ou"][0]."\n".$entrada[$i]["description"][0]."\n";
                            print_r($respuesta);
                        }
                    }else{
                            echo "No existe grupos para visualizar";
                    }
                $baseG = "ou=$grupo1,"."".$baseG;
            }while($firs = ldap_next_entry($conectar, $firs));
        }else{
            return "Datos incorrectos";
        }
    }else{
        return "No hay conexión con el servidor LDAP";
    }*/

?>
