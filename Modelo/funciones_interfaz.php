<?php

include_once('../Modelo/config.php');
function html_init_js(){
    global $server_url;
    $texto =
    "<script type='text/javascript'>;
        var server_url='".$server_url."';
    </script>
    <script src='../Controlador/js/funciones.js'></script>";
    return $texto;
}

function html_simple_header(){
    global $site_name;
    /*$texto = 
    '<div class="header">
        <center>
            <br/>
            <h2 class="page-title">'.$site_name.'</h2>
            <br/>
        </center>
    </div>';*/
    $texto = 
    '<div class="limiter-header"></div>';
    return $texto;
}

function html_auth_header($nombre, $apellido){
    global $site_name;
    /*$texto = 
    '<div class="header">
        <br/>
        <h4 class="page-title">&nbsp;'.$site_name.'
            <span class="pull-right" style="color: white; padding: 5px; font-size: 12px">
                Bienvenido: '.$nombre . " " . $apellido.' <a style="color: #e1ca79; font-weight: bold" href="cerrar.php">
                    [ Cerrar sesión ]
                </a>
            </span>
        </h4>
        <br/>
    </div>';*/
    $texto = 
   // '<div class="limiter-header">
     //   <br/>
       // <h4 class="page-title">
         //   <span class="pull-right" style="color: white; padding: 5px; font-size: 12px">
    //</a>
           // </span>
        //</h4>
      //  <br/>
    //</div>
    //<div class="limiter-header">
       // <br/>
       // '<h4 class="page-title">
           // '<span class="pull-right" style="color: white; padding: 5px; font-size: 12px">
                'Bienvenido: '.$nombre . " " . $apellido.' <a style="color: #e1ca79; font-weight: bold" href="../Modelo/cerrar.php">
                    [ Cerrar sesión ]
                </a>';
            //</span>
        //</h4>
        //<br/>
    //</div>

    return $texto;
}

?>
