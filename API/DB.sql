CREATE DATABASE tienda;
USE tienda;

CREATE TABLE `categories` (
  `id_category` INT NOT NULL AUTO_INCREMENT,
  `name_category` VARCHAR(50),
  PRIMARY KEY (`id_category`)
);

CREATE TABLE `foods` (
  `id_food` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(25),
  `description` VARCHAR(50),
  `id_category` INT NOT NULL,
  `price` DECIMAL(4, 2),
  FOREIGN KEY (`id_category`) REFERENCES `categories` (`id_category`),
  PRIMARY KEY (`id_food`)
);



INSERT INTO `categories` VALUE(NULL,'pizza'), 
							(NULL,'bebida'),
                            (NULL,'empanada'),
							(NULL,'postre');


INSERT INTO `foods` VALUE(NULL,'napolitana','queso muzzarella y tomate',1,10.5),
						(NULL,'cuatro quesos','queso mozzarella, gorgonzola, parmesano y fontina',1,10.7),
						(NULL,'champiñones','champiñones, queso y la salsa de tomate',1,10.3),
						(NULL,'especial','queso muzzarella, jamón cocido, huevo y tomate, ',1,10.9),
						(NULL,'carne','carner de ternera, huevo y aceitunas',3,1),
                        (NULL,'verdura','acelga, huevos y aceitunas',3,1),
						(NULL,'coca cola','gaseosa de 500 ml',2,1.5),
                        (NULL,'Santa Julia','vino 1000 ml',2,3),
                        (NULL,'Jugo','jugo de naranja 1000 ml',2,2),
						(NULL,'Andes','agua mineral 500 ml',2,1);