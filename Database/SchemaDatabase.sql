-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';
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
  `clearance` INT NOT NULL DEFAULT 0,
  PRIMARY KEY (`id_bruker`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Oppdrag2`.`kategori`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Oppdrag2`.`kategori` (
  `id_kategori` INT NOT NULL AUTO_INCREMENT,
  `kategori` VARCHAR(255) NOT NULL DEFAULT 'Noe',
  PRIMARY KEY (`id_kategori`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Oppdrag2`.`problem`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Oppdrag2`.`problem` (
  `id_problem` INT NOT NULL AUTO_INCREMENT,
  `forfatter_id` INT NULL,
  `kategori_id_kategori` INT NULL,
  `problem_title` VARCHAR(255) NOT NULL,
  `problem_text` LONGTEXT NOT NULL,
  `problem_status` INT NOT NULL DEFAULT 0,
  `fiks_text` LONGTEXT NULL DEFAULT NULL,
  `fiks_dato` DATE NULL DEFAULT NULL,
  PRIMARY KEY (`id_problem`),
  INDEX `fk_problem_bruker1_idx` (`forfatter_id` ASC),
  INDEX `fk_problem_kategori1_idx` (`kategori_id_kategori` ASC),
  CONSTRAINT `fk_problem_bruker1`
    FOREIGN KEY (`forfatter_id`)
    REFERENCES `Oppdrag2`.`bruker` (`id_bruker`)
    ON DELETE SET NULL
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_problem_kategori1`
    FOREIGN KEY (`kategori_id_kategori`)
    REFERENCES `Oppdrag2`.`kategori` (`id_kategori`)
    ON DELETE SET NULL
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;


-- -----------------------------------------------------
-- Test data
-- -----------------------------------------------------


INSERT INTO bruker (brukernavn, passord, clearance) VALUES ('fjellBruker', 'Bruker', 0);
INSERT INTO bruker (brukernavn, passord, clearance) VALUES ('fjellAnsatt', 'Ansatt', 1);
INSERT INTO bruker (brukernavn, passord, clearance) VALUES ('fjellAdmin', 'Admin', 2);

INSERT INTO kategori (kategori) VALUES ('Drift');
INSERT INTO kategori (kategori) VALUES ('Utvikling');



-- -----------------------------------------------------
-- Database brukere
-- -----------------------------------------------------

CREATE USER adminUser@localhost IDENTIFIED BY 'admin123';
GRANT ALL PRIVILEGES ON *.* TO 'adminUser'@localhost IDENTIFIED BY 'admin123';

CREATE USER kundeUser@localhost IDENTIFIED BY 'kunde123';
GRANT SELECT, INSERT ON Oppdrag2.* TO 'kundeUser'@localhost IDENTIFIED BY 'kunde123';



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
