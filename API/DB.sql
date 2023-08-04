CREATE DATABASE tienda;
USE tienda;

CREATE TABLE categories (
  id_category INT NOT NULL AUTO_INCREMENT,
  name_category VARCHAR(50),
  PRIMARY KEY (id_category)
);

CREATE TABLE foods (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    id_category INT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    status TINYINT DEFAULT 1, -- 1 para activo, 0 para inactivo (eliminado)
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,-- fecha de creacion
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, -- fecha de actualizacion
    FOREIGN KEY (id_category) REFERENCES categories(id_category)
);


INSERT INTO `categories` VALUE(NULL,'pizza'), (NULL,'bebida'),(NULL,'empanada'),(NULL,'postre');


INSERT INTO foods VALUE 
              --pizzas
              (NULL,'Pizza de calabaza','Pizza de calabaza',1,10,1,now(),now()),
              (NULL,'Pizza de tomate','Pizza de tomate',1,10,1,now(),now()),
              (NULL,'Pizza de queso','Pizza de queso',1,10,1,now(),now()),
              (NULL,'Pizza de jamón','Pizza de jamón',1,10,1,now(),now()),
              (NULL,'Pizza de champiñones','Pizza de champiñones',1,10,1,now(),now()),
              (NULL,'Pizza de queso','Pizza de queso',1,10,1,now(),now()),
              --bebidas
              (NULL,'Coca Cola','Coca Cola',2,5,1,now(),now()),
              (NULL,'Fanta','Fanta',2,5,1,now(),now()),
              (NULL,'Sprite','Sprite',2,5,1,now(),now()),
              (NULL,'Agua','Agua',2,5,1,now(),now()),
              (NULL,'Cerveza','Cerveza',2,5,1,now(),now()),
              --empanadas
              (NULL,'Empanada de carne','Empanada de carne',3,10,1,now(),now()),
              (NULL,'Empanada de jamón','Empanada de jamón',3,10,1,now(),now()),
              (NULL,'Empanada de queso','Empanada de queso',3,10,1,now(),now()),
              (NULL,'Empanada de carne','Empanada de carne',3,10,1,now(),now()),
              (NULL,'Empanada de jamón','Empanada de jamón',3,10,1,now(),now()),
              (NULL,'Empanada de queso','Empanada de queso',3,10,1,now(),now()),
              --postres
              (NULL,'Postre de chocolate','Postre de chocolate',4,10,1,now(),now()),
              (NULL,'Postre de vainilla','Postre de vainilla',4,10,1,now(),now()),


#OBTENER UNA LISTA DE LAS COMIDAS INACTIVAS
SELECT * FROM foods WHERE status = 0 

#OBTENER UNA LISTA DE LAS COMIDAS ACTIVAS
SELECT * FROM foods WHERE status = 1

#OBTENER UNA LISTA DE LAS COMIDAS POR ID
SELECT * FROM foods WHERE id =

#OBTERNER TODAS LOS ALIMENTOS CON SU CATEGORIA 
SELECT * FROM foods INNER JOIN categories ON foods.id_category = categories.id_category