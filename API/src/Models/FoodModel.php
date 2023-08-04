<?php

namespace App\Models;

use App\Config\ResponseHttp;
use App\DB\ConnectionDB;
use App\DB\Sql;

class FoodModel extends ConnectionDB {
    private $id;
    private $name;
    private $description;
    private $id_category;
    private $price;
    private $status; 
    // Atributo para representar el estado (0: inactivo, 1: activo)
    public function __construct(array $data)
    {
        if (isset($data['id'])) {
            $this->id = $data['id'];
        }
        if (isset($data['name'])) {
            $this->name = $data['name'];
        }

        if (isset($data['description'])) {
            $this->description = $data['description'];
        }

        if (isset($data['id_category'])) {
            $this->id_category = $data['id_category'];
        }

        if (isset($data['price'])) {
            $this->price = $data['price'];
        }
        // Establecer el valor predeterminado del estado a 1 (activo)
        $this->status = 1;
    }
    /************************Metodos Getter**************************/
    final public function getId(){return $this->id;}
    final public function getName(){return $this->name;}
    final public function getDescription(){ return $this->description;}
    final public function getIdCategory(){ return $this->id_category;}
    final public function getPrice(){ return $this->price;}  
    final public function getStatus(){return $this->status;}

    /**********************************Metodos Setter***********************************/
    final public function setName(string $name) {$this->name = $name;}
    final public function setDescription(string $description) {$this->description = $description;}
    final public function setIdCategory(int $id_category) {$this->id_category = $id_category;}
    final public function setPrice(int $price) {$this->price = $price;}
    final public function setStatus(int $status){$this->status = $status;}

    /**************************Consultar todos las comidas***************************/
    final public static function getAllActive()
    {
        try {
            $con = self::getConnection();
            $query = $con->prepare("SELECT f.name food_name, f.description, f.price, c.name_category category_name
            FROM foods f
            JOIN categories c ON f.id_category = c.id_category
            WHERE f.status = 1; -- Mostrar solo comidas activas
            ");
            $query->execute();
            $rs['data'] = $query->fetchAll(\PDO::FETCH_ASSOC);
            return $rs;
        } catch (\PDOException $e) {
            error_log("FoodModel::getAllActive -> ".$e);
            die(json_encode(ResponseHttp::status500('No se pueden obtener los datos')));
        }
    }

    /************************************Registrar comida**********************************/
    final public function postSave()
{
    try {
        $con = self::getConnection();
        if ($this->id) {
            // La comida ya existe en la base de datos, así que actualizamos su estado
            $query = $con->prepare("UPDATE foods SET name = :name, description = :description, id_category = :id_category, price = :price, status = :status WHERE id = :id;");
            $query->bindValue(':id', $this->id);
            $query->bindValue(':name', $this->name);
            $query->bindValue(':description', $this->description);
            $query->bindValue(':id_category', $this->id_category);
            $query->bindValue(':price', $this->price);
            $query->bindValue(':status', $this->status); // Asegúrate de que $this->status tenga el valor correcto (0 para inactivo, 1 para activo)
        } else {
            // La comida es nueva, así que insertamos un nuevo registro en la base de datos
            $query = $con->prepare("INSERT INTO foods (name, description, id_category, price, status) VALUES (:name, :description, :id_category, :price, :status);");
            $query->bindValue(':name', $this->name);
            $query->bindValue(':description', $this->description);
            $query->bindValue(':id_category', $this->id_category);
            $query->bindValue(':price', $this->price);
            $query->bindValue(':status', $this->status); // Asegúrate de que $this->status tenga el valor correcto (0 para inactivo, 1 para activo)
        }
        $query->execute();
        return $query->rowCount();
    } catch (\PDOException $e) {
        error_log("FoodModel::postSave -> ".$e);
        die(json_encode(ResponseHttp::status500('No se pueden obtener los datos')));
    }
}


    /************************************Eliminar comida**********************************/
    final public static function getById(int $foodId)
    {
        try {
            $con = self::getConnection();
            $query = $con->prepare("SELECT * FROM foods WHERE id = :foodId AND status = 1");
            $query->bindParam(':foodId', $foodId, \PDO::PARAM_INT);
            $query->execute();
    
            $foodData = $query->fetch(\PDO::FETCH_ASSOC);
    
            if ($foodData) {
                // Crear una instancia de FoodModel y configurar sus atributos con los datos obtenidos de la base de datos
                $food = new FoodModel([
                    'id' => $foodData['id'],
                    'name' => $foodData['name'],
                    'description' => $foodData['description'],
                    'id_category' => $foodData['id_category'],
                    'price' => $foodData['price'],
                ]);
    
                return $food;
            } else {
                return null;
            }
        } catch (\PDOException $e) {
            error_log("FoodModel::getById -> " . $e);
            die(json_encode(ResponseHttp::status500('No se puede obtener la comida')));
        }
    }
}