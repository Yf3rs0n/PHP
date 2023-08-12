<?php

use App\Config\Errorlog;
use App\Config\ResponseHttp;

require 'vendor/autoload.php';
/**
 *Todos los errores de php los va a guardar en el archivo php-error.log
 */
Errorlog::activateErrorLog();

/**
 * Obtiene la ruta de la solicitud 
 */
if (isset($_GET['route'])) {

    $url = explode('/', $_GET['route']);
    $lista = ['food']; //Contiene las rutas que van a ser permitidas
    //Buscar las carpetas donde estan nuestras rutas
    $file = 'src/Routes/' .$url[0]. '.php';

    //validamos que esa ruta tenga permisos
    if (!in_array($url[0], $lista)) {
        echo json_encode(ResponseHttp::status400());
        exit;
    }
    if (is_readable($file)) {//ese archivo es legible y existe lo vamos a requerir
        require $file;
        exit;
    }else {
        echo json_encode(ResponseHttp::status400());
    }
}else {
    echo json_encode(ResponseHttp::status404());
}
?>