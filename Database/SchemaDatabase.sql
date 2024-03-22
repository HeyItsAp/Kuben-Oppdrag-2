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
  `admin` INT NOT NULL DEFAULT 0,
  PRIMARY KEY (`id_bruker`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Oppdrag2`.`problem`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Oppdrag2`.`problem` (
  `id_problem` INT NOT NULL AUTO_INCREMENT,
  `problem_nummer` INT NOT NULL,
  `problem_title` VARCHAR(255) NOT NULL,
  `problem_text` LONGTEXT NOT NULL,
  `problem_status` INT NOT NULL,
  `problem_hashtags` LONGTEXT NOT NULL,
  `forfatter_id` INT NULL,
  PRIMARY KEY (`id_problem`),
  INDEX `fk_problem_bruker1_idx` (`forfatter_id` ASC),
  UNIQUE INDEX `problemcol_UNIQUE` (`problem_nummer` ASC),
  CONSTRAINT `fk_problem_bruker1`
    FOREIGN KEY (`forfatter_id`)
    REFERENCES `Oppdrag2`.`bruker` (`id_bruker`)
    ON DELETE SET NULL
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Oppdrag2`.`fiks`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Oppdrag2`.`fiks` (
  `id_fiks` INT NOT NULL AUTO_INCREMENT,
  `fiks_text` LONGTEXT NOT NULL,
  `forfatter_fiks_id` INT NULL,
  `problem_fiks_id` INT NOT NULL,
  PRIMARY KEY (`id_fiks`),
  INDEX `fk_fiks_bruker1_idx` (`forfatter_fiks_id` ASC),
  INDEX `fk_fiks_problem1_idx` (`problem_fiks_id` ASC),
  CONSTRAINT `fk_fiks_bruker1`
    FOREIGN KEY (`forfatter_fiks_id`)
    REFERENCES `Oppdrag2`.`bruker` (`id_bruker`)
    ON DELETE SET NULL
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_fiks_problem1`
    FOREIGN KEY (`problem_fiks_id`)
    REFERENCES `Oppdrag2`.`problem` (`id_problem`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Test data
-- -----------------------------------------------------


INSERT INTO bruker (brukernavn, passord, admin) VALUES (`test1`, `test2`, 0);
INSERT INTO bruker (brukernavn, passord, admin) VALUES (`testansatt`, `ansatt`, 1);
INSERT INTO bruker (brukernavn, passord, admin) VALUES (`testadmin`, `admin123`, 2);

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
