<?php

use App\Config\ResponseHttp;
use App\Controllers\FoodController;

/*************Parametros enviados por la URL*******************/
$params  = explode('/' ,$_GET['route']);

/*************Instancia del controlador de usuario**************/
$app = new FoodController();

/*************Rutas***************/
$app->getAll('food/');
$app->postSave('food/');

/*************Nueva ruta para filtrar comidas por categoría**************/
if ($params[0] === 'food' && $params[1] === 'category' && isset($params[2])) {
    // Llama al método getByCategory del controlador para filtrar por categoría
    $app->getByCategory('food/');
}

/****************Error 404*****************/
echo json_encode(ResponseHttp::status404());