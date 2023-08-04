<?php

namespace App\Controllers;

use App\Config\ResponseHttp;
use App\Models\FoodModel;

class FoodController extends BaseController
{
    /**********************Consultar las comidas activas*********************/
    final public function getAll(string $endPoint)
    {
        if ($this->getMethod() == 'get' && $endPoint == $this->getRoute()) {
            // Crea una instancia de FoodModel
            $foodModel = new FoodModel([]);

            // Llama al método getAllActive() de la instancia creada para obtener las comidas activas
            $activeFoods = $foodModel->getAllActive();
            echo json_encode($activeFoods);
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

            // Llama al método postSave() de la instancia creada para registrar la comida
            echo json_encode($foodModel->postSave());
            exit;
        }
    }

    /************************************Eliminar comida**********************************/
    final public function deleteFood(int $foodId)
    {
        // Obtener la comida por su ID
        $food = FoodModel::getById($foodId);
    
        // Verificar si la comida existe
        if ($food) {
            // Cambiar el estado a "inactivo" en lugar de eliminarla
            $food->setStatus(0);
            $food->postSave(); // Guardar el cambio en la base de datos
    
            echo json_encode(['status' => 'success', 'message' => 'Comida desactivada correctamente']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Comida no encontrada']);
        }
        exit;
    }
    
}

