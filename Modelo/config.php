<?php

$host = "ldapserver.cas.com" ; //RUTA DEL SERVIDOR
$port = 389;   //PUERTO DE CONEXIÓN DEL SERVIDOR
$ldap_admin_user='admin'; //Admin user
$ldap_admin_password='ldap1234'; //Admin password
$baseAdmin = "dc=cas,dc=com";
$baseGeneral = "ou=personal,dc=cas,dc=com";
$baseEstudiantes = "ou=estudiantes,ou=academicos,"."".$baseGeneral;
$baseDocentes = "ou=docentes,ou=academicos,"."".$baseGeneral;
$baseServidores = "ou=servidores,ou=administrativos,"."".$baseGeneral;
$baseTrabajadores = "ou=trabajadores,ou=administrativos,"."".$baseGeneral;
$baseOtros = "ou=otros,"."".$baseGeneral;
$baseGrupo = "universidad_implementacion";
$baseGeneral2 = "ou=universidad_implementacion,dc=cas,dc=com";
$baseAcademicos = "ou=academicos,"."".$baseGeneral;
$baseAdministrativos = "ou=administrativos,"."".$baseGeneral;
$paginacion = 500;
$server_url='http://localhost/SiGUCAS';
$cas_url = 'https://localhost:8443/cas';

// $sistemas_integrar[0] = array("EVA","moodle.png","sistema Moodle","https://eva.unl.edu.ec","Entorno Virtual de Aprendizaje");
// $sistemas_integrar[1] = array("SIAAF","siaaf.png","sistema Wordpress","https://siaaf.unl.edu.ec","Sistema de Información Académico Administrativo y Financiero");
// $sistemas_integrar[2] = array("FILESENDER","filesender.jpg","File Sender","https://filesender.cedia.org.ec","FileSender");
// $sistemas_integrar[3] = array("SGA DOCENTES","sga-docentes.png","SGA Docentes","https://docentes.unl.edu.ec","Sistema de Gestión Académico - Docentes");
// $sistemas_integrar[4] = array("EDUROAM","eduroam.png","Eduroam","https://sac.unl.edu.ec","Eduroam");
// $sistemas_integrar[5] = array("ZOOM","zoom.jpg","Zoom","https://zoom.us/support/download","ZOOM");

$sistemas_integrar[0] = array("MOODLE","Vista/img/Moodle.png","sistema Moodle","http://localhost/moodle","Moodle");
$sistemas_integrar[1] = array("WORDPRESS","Vista/img/wordpress.png","sistema Wordpress","http://localhost/wordpress","Wordpress");
$sistemas_integrar[2] = array("JENKINS","Vista/img/Jenkins.png","Sistema Jenkins","http://localhost:8001","Jenkins");
$sistemas_integrar[3] = array("DRUPAL","Vista/img/drupal2.jpg","Sistema Drupal","http://localhost/drupal/user/login","Drupal");
$sistemas_integrar[4] = array("GITLAB","Vista/img/gitlab.png","Sistema Gitlab","gitlab.ejemplo.com:8060","Gitlab");
$sistemas_integrar[5] = array("Sistema de Administración Central SAC","Vista/img/inicios.jpg","SAC",
	"http://localhost/SiGUCAS/vistaLogin.php","SAC");

// $host ="192.168.1.2"; //RUTA DEL SERVIDOR
// $port = 389;   //PUERTO DE CONEXI?^?N DEL SERVIDOR
// $ldap_admin_user='admin'; //Admin user
// $ldap_admin_password='j8J6gc6GJ45fGHks3bv'; //Admin password
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
// $baseAdministrativos = "ou=administrativos,"."".$baseGeneral;


/*$mensaje_crear = "Usuario Creado con éxito";
$mensaje_eliminar = "Usuario Eliminado con éxito";
$mensaje_modificar = "Usuario modificado con éxito";
$mensaje_cambiar_contra = "Contraseña modificada con éxito";
$mensaje_recuperar = "Link enviado a su correo";
*/
//$mail_user = "sac.noreply@unl.edu.ec";
//$mail_password = "sdir@uti#19010943.Sac";
$mail_user = "soporte.sac.sigucas@gmail.com";
$mail_password = "ldap1234";
$mail_port= 587;
$mail_smtp = 'tls';
$mail_host = 'smtp.gmail.com';

$enlace_token_time=1; #Tiempo de en minutos de vigencia de enlace para reestablecer contraseña

$institucion='Universidad Naciona de Loja';
$departamento='Carrera de Ingenieria en Sistemas';
$texto_soporte='07 2724451 / 2722724 soporte.sac.sigucas@gmail.com o acérquese a nuestras oficinas';

$site_name ='Servicio de Administración Centralizada - SAC';
$site_alias='SAC';

?>
