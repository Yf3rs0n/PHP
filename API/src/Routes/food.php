<?php

use App\Config\ResponseHttp;
use App\Controllers\FoodController;

/*************Parametros enviados por la URL*******************/
$params = explode('/', $_GET['route']);

/*************Instancia del controlador de comida**************/
$app = new FoodController();

/*************Rutas***************/
if ($params[0] === 'food') {
    // Consultar todas las comidas activas
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $app->getAll('food/');
    }

    // Registrar una nueva comida
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $app->postSave('food/');
    }

    // Eliminar una comida por su ID
    if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
        // Verificar que se haya proporcionado un ID válido
        if (isset($params[1]) && is_numeric($params[1])) {
            $foodId = (int)$params[1];
            $app->deleteFood($foodId);
        } else {
            echo json_encode(ResponseHttp::status400('ID de comida inválido'));
        }
    }
}

/****************Error 404*****************/
echo json_encode(ResponseHttp::status404());