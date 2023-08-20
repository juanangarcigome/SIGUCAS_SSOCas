<?php

$host = "192.168.1.2" ; //RUTA DEL SERVIDOR
$port = 389;   //PUERTO DE CONEXIÓN DEL SERVIDOR
$baseAdmin = "dc=cas,dc=com";
$baseGeneral = "ou=personal,dc=cas,dc=com";
$baseEstudiantes = "ou=estudiantes,ou=academicos,"."".$baseGeneral;
$baseDocentes = "ou=docentes,ou=academicos,"."".$baseGeneral;
$baseServidores = "ou=servidores,ou=administrativos,"."".$baseGeneral;
$baseTrabajadores = "ou=trabajadores,ou=administrativos,"."".$baseGeneral;
$baseOtros = "ou=otros,"."".$baseGeneral;
$baseGrupo = "unl";
$baseGeneral2 = "ou=unl,dc=cas,dc=com";
$baseAcademicos = "ou=academicos,"."".$baseGeneral;
    $baseAdministrativos = "ou=administrativos,"."".$baseGeneral;
    $paginacion = 500;


// $host ="ldap.unl.edu.ec"; //RUTA DEL SERVIDOR
// $port = 389;   //PUERTO DE CONEXI?^?N DEL SERVIDOR
// $baseAdmin = "dc=unl,dc=edu,dc=ec";
// $baseGeneral = "ou=personal,dc=unl,dc=edu,dc=ec";
// $baseEstudiantes = "ou=estudiantes,ou=academicos,"."".$baseGeneral;
// $baseDocentes = "ou=docentes,ou=academicos,"."".$baseGeneral;
// $baseServidores = "ou=servidores,ou=administrativos,"."".$baseGeneral;
// $baseTrabajadores = "ou=trabajadores,ou=administrativos,"."".$baseGeneral;
// $baseOtros = "ou=otros,"."".$baseGeneral;
// $baseGrupo = "universidad_implementacion";
// $baseGeneral2 = "ou=universidad_implementacion,dc=unl,dc=edu,dc=ec";
// $baseAcademicos = "ou=academicos,"."".$baseGeneral;
//     $baseAdministrativos = "ou=administrativos,"."".$baseGeneral;
//     $paginacion = 500;
?>
