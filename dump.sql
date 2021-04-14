-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema dbusuario
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema dbusuario
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `dbusuario` DEFAULT CHARACTER SET latin1 ;
USE `dbusuario` ;

-- -----------------------------------------------------
-- Table `dbusuario`.`hash`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbusuario`.`hash` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `hash` VARCHAR(255) NOT NULL,
  `status` INT(1) NOT NULL,
  `id_usuario` INT(11) NOT NULL,
  `data_cadastro` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 8
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `dbusuario`.`usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbusuario`.`usuario` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(100) NOT NULL,
  `login` VARCHAR(20) NOT NULL,
  `senha` VARCHAR(50) NOT NULL,
  `status` INT(1) NOT NULL,
  `data_cadastro` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `email` (`email` ASC),
  UNIQUE INDEX `login` (`login` ASC))
ENGINE = InnoDB
AUTO_INCREMENT = 26
DEFAULT CHARACTER SET = utf8;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
