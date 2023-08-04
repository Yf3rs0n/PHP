<?php

use App\Config\Errorlog;
use App\Config\ResponseHttp;

require 'vendor/autoload.php';

Errorlog::activateErrorLog();//Todos los errores de php los va a guardar en el archivo php-error.log

if (isset($_GET['route'])) {

    $url = explode('/', $_GET['route']);
    $lista = ['auth','food']; //Contiene las rutas que van a ser permitidas
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