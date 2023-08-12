<?php

namespace App\Controllers;

use App\Config\ResponseHttp;
use App\Models\FoodModel;

class FoodController extends BaseController{
    /**
     * Query food by ID
     */
    public function getFoodById($id){
        // Verifica si la solicitud es GET y si la ruta coincide con "food/$id"
        if ($this->isGetMethod() && $this->getRoute() === "food/$id") {
            // Llama al método estático de FoodModel para obtener la comida por su ID
            $result = FoodModel::getFoodById($id);
            // Convierte el resultado en formato JSON y lo envía como respuesta
            echo json_encode($result);
            exit;
        }
    }
    /**
     * Check all the foods active
     */
    final public function getAll(string $endPoint){
        // Verifica si la solicitud es GET
        if ($this->isGetMethod() == 'get' && $endPoint == $this->getRoute()) {
            // Crea una instancia de FoodModel
            $foodModel = new FoodModel([]);
            // Llama al método getAllActive() de la instancia creada para obtener las comidas activas
            $activeFoods = $foodModel->getAllActive();
            echo json_encode($activeFoods);
            exit;
        }
    }

    /**
     * Create a new food
     */
    public function createFood(){
        // Verifica si la solicitud es POST
        if ($this->isGetMethod() && $this->getRoute() === 'food/create') {
            // Obtiene los parámetros de la solicitud
            $param = $this->getParam();
            // Crea una instancia de FoodModel con los parámetros proporcionados
            $foodModel = new FoodModel([
                'name' => $param['name'],
                'description' => $param['description'],
                'id_category' => $param['id_category'],
                'price' => $param['price']
            ]);

            $result = $foodModel->createFood();

            echo json_encode($result);
            exit;
        }
    }
    /**
     * Update a feed
     * @param $id
     */
    public function updateFood($id){
        // Verifica si la solicitud es PUT
        if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
            $param = $this->getParam();
    
            $foodModel = new FoodModel([
                'id' => $id,
                'name' => $param['name'],
                'description' => $param['description'],
                'id_category' => $param['id_category'],
                'price' => $param['price']
            ]);
    
            $result = $foodModel->updateFood();
    
            echo json_encode($result);
            exit;
        }
    }
}    
    

