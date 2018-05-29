a-- MySQL Script generated by MySQL Workbench
-- Tue May 29 11:13:39 2018
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema multiversum
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema multiversum
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `multiversum` DEFAULT CHARACTER SET utf8 ;
USE `multiversum` ;

-- -----------------------------------------------------
-- Table `multiversum`.`Products`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `multiversum`.`Products` ;

CREATE TABLE IF NOT EXISTS `multiversum`.`Products` (
  `product_id` INT NOT NULL AUTO_INCREMENT,
  `price` DECIMAL(2) NOT NULL,
  `platform` VARCHAR(255) NULL,
  `display` VARCHAR(255) NULL,
  `resolution` VARCHAR(255) NULL,
  `refresh_rate` VARCHAR(255) NULL,
  `view` VARCHAR(255) NULL,
  `function` VARCHAR(255) NULL,
  `color` VARCHAR(255) NULL,
  `accessoires` VARCHAR(255) NULL,
  `product_name` VARCHAR(255) NULL,
  `image` VARCHAR(255) NULL,
  PRIMARY KEY (`product_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `multiversum`.`photos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `multiversum`.`photos` ;

CREATE TABLE IF NOT EXISTS `multiversum`.`photos` (
  `photos_id` INT NOT NULL AUTO_INCREMENT,
  `image_path` VARCHAR(255) NOT NULL,
  `Products_product_id` INT NOT NULL,
  PRIMARY KEY (`photos_id`),
  INDEX `fk_photos_Products1_idx` (`Products_product_id` ASC),
  CONSTRAINT `fk_photos_Products1`
    FOREIGN KEY (`Products_product_id`)
    REFERENCES `multiversum`.`Products` (`product_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `multiversum`.`orders`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `multiversum`.`orders` ;

CREATE TABLE IF NOT EXISTS `multiversum`.`orders` (
  `order_id` INT NOT NULL AUTO_INCREMENT,
  `firstname` VARCHAR(255) NOT NULL,
  `lastname` VARCHAR(255) NOT NULL,
  `straat` VARCHAR(255) NOT NULL,
  `country` VARCHAR(255) NOT NULL,
  `postcode` VARCHAR(255) NOT NULL,
  `iban` INT NOT NULL,
  `huisnummer` VARCHAR(255) NOT NULL,
  `Plaats` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`order_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `multiversum`.`orders_has_Products`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `multiversum`.`orders_has_Products` ;

CREATE TABLE IF NOT EXISTS `multiversum`.`orders_has_Products` (
  `orders_order_id` INT NOT NULL,
  `Products_product_id` INT NOT NULL,
  PRIMARY KEY (`orders_order_id`, `Products_product_id`),
  INDEX `fk_orders_has_Products_Products1_idx` (`Products_product_id` ASC),
  INDEX `fk_orders_has_Products_orders1_idx` (`orders_order_id` ASC),
  CONSTRAINT `fk_orders_has_Products_orders1`
    FOREIGN KEY (`orders_order_id`)
    REFERENCES `multiversum`.`orders` (`order_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_orders_has_Products_Products1`
    FOREIGN KEY (`Products_product_id`)
    REFERENCES `multiversum`.`Products` (`product_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;



-- -- instert
-- INSERT INTO `products` (`price`,`platform`,`display`,`resolution`,`refresh_rate`,`function`,`color`,`accessoires`,`product_name`)
-- VALUES(599,"PC","JA","2160x1200","90hz","Accelerometer, Camera, Gyroscoop, Verstelbare lenzen","zwart","Controller(s),Headset bedraad, Kabels","HTC Vive");