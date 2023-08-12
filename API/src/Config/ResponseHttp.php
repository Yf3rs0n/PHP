<?php
namespace App\Config;

class ResponseHttp {
    /**
     * Devuelve una respuesta con el código de estado 200 (OK).
     */
    final public static function status200(string $message): array {
        return self::getResponseArray(200, 'OK', $message);
    }

    /**
     * Devuelve una respuesta con el código de estado 201 (Creada).
     */
    final public static function status201(string $message = 'Creada'): array {
        return self::getResponseArray(201, 'OK', $message);
    }

    /**
     * Devuelve una respuesta con el código de estado 400 (Solicitud incorrecta).
     */
    final public static function status400(string $message = 'Solicitud incorrecta'): array {
        return self::getResponseArray(400, 'error', $message);
    }

    /**
     * Devuelve una respuesta con el código de estado 401 (No autorizado).
     */
    final public static function status401(string $message = 'No autorizado'): array {
        return self::getResponseArray(401, 'error', $message);
    }

    /**
     * Devuelve una respuesta con el código de estado 404 (No encontrada).
     */
    final public static function status404(string $message = 'No encontrada'): array {
        return self::getResponseArray(404, 'error', $message);
    }

    /**
     * Devuelve una respuesta con el código de estado 500 (Error Interno del Servidor).
     */
    final public static function status500(string $message = 'Error Interno del Servidor'): array {
        return self::getResponseArray(500, 'error', $message);
    }

    /**
     * Devuelve un array de respuesta con los valores dados.
     */
    private static function getResponseArray(int $statusCode, string $statusMessage, string $message): array {
        http_response_code($statusCode);
        return [
            'status' => $statusMessage,
            'message' => $message,
        ];
    }
}
