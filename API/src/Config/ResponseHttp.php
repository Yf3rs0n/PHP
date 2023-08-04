<?php
//Esta clase contienen los codigos de estado http
namespace App\Config;

class ResponseHttp{
    public static $message = array(
        'status' => '',
        'message' => ''
    );

    
/*********************Metodo de respuestas**********************/
    final public static function status200(String $res){
        http_response_code(200);
        self::$message['status'] = 'OK';
        self::$message['message'] = $res;
        return self::$message;
    }

    final public static function status201(String $res = 'Creada'){
        http_response_code(201);
        self::$message['status'] = 'OK';
        self::$message['message'] = $res;
        return self::$message;
    }

    final public static function status400(String $res = 'Solicitud incorrecta'){
        http_response_code(400);
        self::$message['status'] = 'error';
        self::$message['message'] = $res;
        return self::$message;
    }

    final public static function status401(String $res = 'No autorizado'){
        http_response_code(401);
        self::$message['status'] = 'error';
        self::$message['message'] = $res;
        return self::$message;
    }

    final public static function status404(String $res = 'No encontrada'){
        http_response_code(404);
        self::$message['status'] = 'error';
        self::$message['message'] = $res;
        return self::$message;
    }

    final public static function status500(String $res = 'Error Interno del Servidor'){
        http_response_code(500);
        self::$message['status'] = 'error';
        self::$message['message'] = $res;
        return self::$message;
    }
}