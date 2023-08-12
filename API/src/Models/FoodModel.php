<?php
namespace App\Models;

use App\Config\ResponseHttp;
use App\DB\ConnectionDB;
use App\DB\Sql;

/**
 * Clase FoodModel que hereda de ConnectionDB
 */
class FoodModel extends ConnectionDB {
    // Propiedades de la clase
    private $id;
    private $name;
    private $description;
    private $id_category;
    private $price;
    private $status = 1;
    
    /**
     * Constructor de la clase, recibe un arreglo de datos para inicializar propiedades
     */
    public function __construct(array $data){
        $this->id = $data['id'] ?? null;
        $this->name = $data['name'] ?? null;
        $this->description = $data['description'] ?? null;
        $this->id_category = $data['id_category'] ?? null;
        $this->price = $data['price'] ?? null;
    }
    
    /**
     * Getters
     * Getters para obtener los valores de las propiedades
     */
    public function getId() { return $this->id; }
    public function getName() { return $this->name; }
    public function getDescription() { return $this->description; }
    public function getIdCategory() { return $this->id_category; }
    public function getPrice() { return $this->price; }
    public function getStatus() { return $this->status; }

    /**
     * Setters
     * Setters para asignar valores a las propiedades
     */
    public function setName(string $name) { $this->name = $name; }
    public function setDescription(string $description) { $this->description = $description; }
    public function setIdCategory(int $id_category) { $this->id_category = $id_category; }
    public function setPrice(int $price) { $this->price = $price; }
    public function setStatus(int $status) { $this->status = $status; }

    /**
     * Query food by ID
     * Método para obtener una comida por su ID
     * 
    */
    public static function getFoodById($id){
        try {
            // Obtiene la conexión a la base de datos
            $con = self::getConnection();
            // Prepara y ejecuta la consulta SQL
            $query = $con->prepare("
                SELECT f.name food_name, f.description, f.price, c.name_category category_name
                FROM foods f
                JOIN categories c ON f.id_category = c.id_category
                WHERE f.id = :id AND f.status = 1
            ");
            $query->execute(['id' => $id]);
            // Retorna el resultado o un mensaje si no se encuentra la comida            
            $result = $query->fetch(\PDO::FETCH_ASSOC);
            return $result ? ['data' => $result] : ['message' => 'Food not found' ];
        } catch (\PDOException $e) {
            error_log("FoodModel::getFoodById -> ".$e);
            die(json_encode(ResponseHttp::status500('Error fetching food by ID')));
        }
    }
    
    
    /**
     * 
     * Check all the foods active
     * Método para consultar todas las comidas activas
     * 
     */
    final public static function getAllActive(){
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
            die(json_encode(ResponseHttp::status500('Unable to get the data')));
        }
    }

    /**
     * 
     * Create a new food
     * Método para registrar una comida
     * 
     */
    public function createFood(){
        try {
            $con = self::getConnection();
            $query = $con->prepare("
                INSERT INTO foods (name, description, id_category, price)
                VALUES (:name, :description, :id_category, :price)
            ");
    
            $query->execute([
                'name' => $this->name,
                'description' => $this->description,
                'id_category' => $this->id_category,
                'price' => $this->price
            ]);
            return ['message' => 'Food created successfully'];
        } catch (\PDOException $e) {
            error_log("FoodModel::createFood -> " . $e);
            die(json_encode(ResponseHttp::status500('Error creating food')));
        }
    }
    /**
     * Update a feed
     * Método para actualizar una comida
     */
    public function updateFood(){
        try {
            $con = self::getConnection();
            $query = $con->prepare("
                UPDATE foods
                SET name = :name, description = :description, id_category = :id_category, price = :price
                WHERE id = :id AND status = 1
            ");
        
            $query->execute([
                'id' => $this->id,
                'name' => $this->name,
                'description' => $this->description,
                'id_category' => $this->id_category,
                'price' => $this->price
            ]);
            // Retorna la comida actualizada en JSON
            return ['message' => 'Food updated successfully'];
            return ['data' => $this->getFoodById($this->id)];
        } catch (\PDOException $e) {
            error_log("FoodModel::updateFood -> " . $e);
            die(json_encode(ResponseHttp::status500('Error updating food')));
        }
    }
}