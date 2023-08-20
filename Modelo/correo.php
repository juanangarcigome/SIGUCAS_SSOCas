<?php
$ruta_raiz = isset($ruta_raiz) ? $ruta_raiz : ".";

require("$ruta_raiz/class.phpmailer.php");
require_once("$ruta_raiz/config.php");
date_default_timezone_set('UTC');

function init_body($plantilla){
    global $server_url;
    global $site_name;
    global $institucion;
    global $departamento;
    global $texto_soporte;
    global $ruta_raiz;

    $fecha = date("Y-m-d H:i:s");    
    
    $body = file_get_contents("$ruta_raiz/$plantilla");            
    $body = str_replace("{fecha}", $fecha, $body);
    $body = str_replace("{site_name}", $site_name, $body);
    $body = str_replace("{server_url}", $server_url, $body);
    $body = str_replace("{institucion}", $institucion, $body);
    $body = str_replace("{departamento}", $departamento, $body);
    $body = str_replace("{texto_soporte}", $texto_soporte, $body);
    
    return $body;
}

function correo_crear($destino,$uid,$cedula,$nombre,$apellido){    
    global $site_alias;
    $body = init_body('../Vista/Plantillas/correo_crear_cuenta.html');    
    $body = str_replace("{usuario}", $uid, $body);
    $body = str_replace("{cedula}", $cedula, $body);
    $body = str_replace("{nombre}", $nombre, $body);
    $body = str_replace("{apellido}", $apellido, $body);    
    
    $subject = $site_alias . " - Cuenta de usuario";
    enviar_correo($subject,$body,$destino);
}

function correo_vincular($destino ,$grupo){    
    global $site_alias;
    
    $body = init_body('../Vista/Plantillas/correo_vincular_grupo.html');        
    $body = str_replace("{grupo}", $grupo, $body);    
    $subject = $site_alias . " - Vinculación de usaurio";
    enviar_correo($subject, $body, $destino);
}

function correo_restablecer($destino ,$enlace){    
    global $enlace_token_time;
    global $site_alias;
    
    $body = init_body('../Vista/Plantillas/correo_recuperar_password.html');
    $body = str_replace("{enlace}", $enlace, $body);    
    $body = str_replace("{enlace_token_time}", $enlace_token_time, $body);            
    $subject = $site_alias . " - Restablecer contraseña";
    enviar_correo($subject,$body,$destino);
}

function correo_cambio_contra($destino){    
    global $site_alias;
    
    $body = init_body('../Vista/Plantillas/correo_cambio_password.html');        
    $subject = $site_alias . " - Cambio de contraseña";
    enviar_correo($subject,$body,$destino);
}

function enviar_correo($subject, $body, $destino){
    global $mail_host;
    global $mail_port;
    global $mail_user;
    global $mail_password;
    global $mail_smtp;
    global $site_name;
    global $site_alias;
    
    $subject = "=?UTF-8?B?".base64_encode($subject)."=?=";
    
    $mail = new PHPMailer;
    $mail->isSMTP();
    $mail->SMTPDebug = 0;
    $mail->SMTPAuth = true;
    $mail->CharSet = "UTF-8";
    $mail->Host = $mail_host;
    $mail->Port = $mail_port;
    $mail->SMTPSecure = $mail_smtp;
    $mail->Username = $mail_user;
    $mail->Password = $mail_password;
    $mail->setFrom('sac.noreply@unl.edu.ec', $site_name);
    $mail->IsHTML(true);
    $mail->addAddress($destino, 'USUARIO '.$site_alias);
    $mail->Body = $body;
    $mail->Subject = $subject;
    if (!$mail->send()) {
        echo "Mailer Error: " . $mail->ErrorInfo;
    }
}


?>

