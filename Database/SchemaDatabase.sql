-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema Oppdrag2
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema Oppdrag2
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `Oppdrag2` DEFAULT CHARACTER SET utf8 ;
USE `Oppdrag2` ;

-- -----------------------------------------------------
-- Table `Oppdrag2`.`bruker`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Oppdrag2`.`bruker` (
  `id_bruker` INT NOT NULL AUTO_INCREMENT,
  `brukernavn` VARCHAR(255) NOT NULL,
  `passord` LONGTEXT NOT NULL,
  `admin` INT NOT NULL DEFAULT 1,
  PRIMARY KEY (`id_bruker`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Oppdrag2`.`anmeldelse`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Oppdrag2`.`anmeldelse` (
  `id_anmeldelse` INT NOT NULL AUTO_INCREMENT,
  `anmeldelse_title` VARCHAR(255) NOT NULL,
  `anmeldelse_text` LONGTEXT NOT NULL,
  `anmeldelse_status` INT NOT NULL,
  `bruker_id_bruker` INT NULL,
  PRIMARY KEY (`id_anmeldelse`),
  INDEX `fk_anmeldelse_bruker_idx` (`bruker_id_bruker` ASC),
  CONSTRAINT `fk_anmeldelse_bruker`
    FOREIGN KEY (`bruker_id_bruker`)
    REFERENCES `Oppdrag2`.`bruker` (`id_bruker`)
    ON DELETE SET NULL
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
