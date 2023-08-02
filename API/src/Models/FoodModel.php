<?php

namespace App\Models;

use App\Config\ResponseHttp;
use App\DB\ConnectionDB;
use App\DB\Sql;

class FoodModel extends ConnectionDB {
    private $name;
    private $description;
    private $id_category;
    private $price;

    public function __construct(array $data)
    {
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
    }
    /************************Metodos Getter**************************/
    final public function getName(){return $this->name;}
    final public function getDescription(){ return $this->description;}
    final public function getIdCategory(){ return $this->id_category;}
    final public function getPrice(){ return $this->price;}  

    /**********************************Metodos Setter***********************************/
    final public function setName(string $name) {$this->name = $name;}
    final public function setDescription(string $description) {$this->description = $description;}
    final public function setIdCategory(int $id_category) {$this->id_category = $id_category;}
    final public function setPrice(int $price) {$this->price = $price;}

    /**************************Consultar todos las comidas***************************/
    final public static function getAll()
    {
        try {
            $con = self::getConnection();
            $query = $con->prepare("SELECT f.name food_name, f.description, f.price, c.name_category category_name
            FROM foods f
            JOIN categories c ON f.id_category = c.id_category;
            ");
            $query->execute();
            $rs['data'] = $query->fetchAll(\PDO::FETCH_ASSOC);
            return $rs;
        } catch (\PDOException $e) {
            error_log("FoodModel::getAll -> ".$e);
            die(json_encode(ResponseHttp::status500('No se pueden obtener los datos')));
        }
    }

    /*******************************************Registrar comida**********************************/
    final public function postSave()
    {
        try {
            $con = self::getConnection();
            $query = $con->prepare("INSERT INTO foods (name, description, id_category, price) VALUES (:name, :description, :id_category, :price);");
            $query->bindValue(':name', $this->name);
            $query->bindValue(':description', $this->description);
            $query->bindValue(':id_category', $this->id_category);
            $query->bindValue(':price', $this->price);
            $query->execute();
            return $query->rowCount();
        } catch (\PDOException $e) {
            error_log("FoodModel::postSave -> ".$e);
            die(json_encode(ResponseHttp::status500('No se pueden obtener los datos')));
        }
    }
    /**************************Consultar comidas por ID de categoría***************************/
    final public static function getByCategoryId(int $category_id)
    {
        try {
            $con = self::getConnection();
            $query = $con->prepare("SELECT f.name food_name, f.description, f.price, c.name_category category_name
            FROM foods f
            JOIN categories c ON f.id_category = c.id_category
            WHERE f.id_category = :category_id;
            ");
            $query->bindValue(':category_id', $category_id, \PDO::PARAM_INT);
            $query->execute();
            $rs['data'] = $query->fetchAll(\PDO::FETCH_ASSOC);
            return $rs;
        } catch (\PDOException $e) {
            error_log("FoodModel::getByCategoryId -> ".$e);
            die(json_encode(ResponseHttp::status500('No se pueden obtener los datos')));
        }
    }
}