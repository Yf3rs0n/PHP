<?php

namespace App\Controllers;

use App\Config\ResponseHttp;
use App\Models\FoodModel;

class FoodController extends BaseController
{
    /**********************Consultar todos las comidas*********************/
    final public function getAll(string $endPoint)
    {
        if ($this->getMethod() == 'get' && $endPoint == $this->getRoute()) {
            // Crea una instancia de FoodModel
            $foodModel = new FoodModel([]);

            // Llama al método getAll() de la instancia creada
            echo json_encode($foodModel->getAll());
            exit;
        }
    }

    /************************************Registrar comida**********************************/
    final public function postSave(string $endPoint)
    {
        if ($this->getMethod() == 'post' && $endPoint == $this->getRoute()) {
            // Obtiene los datos enviados en el cuerpo de la petición (usando el método getParam())
            $data = $this->getParam();

            // Crea una instancia de FoodModel con los datos recibidos
            $foodModel = new FoodModel($data);

            // Llama al método postSave() de la instancia creada
            echo json_encode($foodModel->postSave());
            exit;
        }
    }
/**************************Consultar comidas por ID de categoría***************************/
    final public function getByCategory(string $endPoint)
    {
        if ($this->getMethod() == 'get' && $endPoint == $this->getRoute()) {
            // Obtiene el ID de la categoría enviado como parámetro en la URL
            $categoryId = (int) $this->getAttribute()[2];

            // Llama al método getByCategoryId de FoodModel con el ID de categoría
            $foodsByCategory = FoodModel::getByCategoryId($categoryId);

            // Verifica si hay resultados y envía la respuesta
            if (!empty($foodsByCategory['data'])) {
                echo json_encode($foodsByCategory);
            } else {
                echo json_encode(ResponseHttp::status404());
            }
            exit;
        }
    }

}
