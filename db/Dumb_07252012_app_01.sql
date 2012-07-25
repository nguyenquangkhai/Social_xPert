SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

CREATE SCHEMA IF NOT EXISTS `social_xpert_app` DEFAULT CHARACTER SET latin1 ;
USE `social_xpert_app` ;

-- -----------------------------------------------------
-- Table `social_xpert_app`.`post`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `social_xpert_app`.`post` ;

CREATE  TABLE IF NOT EXISTS `social_xpert_app`.`post` (
  `post_id` BIGINT NOT NULL AUTO_INCREMENT ,
  `message` VARCHAR(60000) NOT NULL ,
  `highlight` TINYINT NULL DEFAULT 0 ,
  `pin_to_top` TINYINT NULL DEFAULT 0 ,
  `tag` TINYINT NULL DEFAULT 0 ,
  `milestone_id` BIGINT NULL ,
  `event_id` BIGINT NULL COMMENT 'event id' ,
  `image_id` BIGINT NULL ,
  `video_id` BIGINT NULL ,
  `poll_id` BIGINT NULL ,
  `schedule` VARCHAR(50) NULL ,
  `privacy` VARCHAR(300) NULL COMMENT 'String of privacy ( country, language, city )' ,
  `type` INT NOT NULL DEFAULT 0 COMMENT '0 : Status; 1:Image; 2:Videos; 3:Poll; 4:Event; 5:Milestone' ,
  `addtime` DATETIME NULL ,
  `updtime` DATETIME NULL ,
  PRIMARY KEY (`post_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `social_xpert_app`.`page_post`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `social_xpert_app`.`page_post` ;

CREATE  TABLE IF NOT EXISTS `social_xpert_app`.`page_post` (
  `page_id` BIGINT NOT NULL ,
  `post_id` BIGINT NOT NULL ,
  PRIMARY KEY (`page_id`, `post_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `social_xpert_app`.`tag_post`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `social_xpert_app`.`tag_post` ;

CREATE  TABLE IF NOT EXISTS `social_xpert_app`.`tag_post` (
  `tag_post_id` BIGINT NOT NULL AUTO_INCREMENT ,
  `post_id` BIGINT NOT NULL ,
  `uid` VARCHAR(100) NOT NULL ,
  `user_name` VARCHAR(300) NOT NULL ,
  PRIMARY KEY (`tag_post_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `social_xpert_app`.`milestone`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `social_xpert_app`.`milestone` ;

CREATE  TABLE IF NOT EXISTS `social_xpert_app`.`milestone` (
  `milestone_id` BIGINT NOT NULL AUTO_INCREMENT ,
  PRIMARY KEY (`milestone_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `social_xpert_app`.`event`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `social_xpert_app`.`event` ;

CREATE  TABLE IF NOT EXISTS `social_xpert_app`.`event` (
  `event_id` BIGINT NOT NULL AUTO_INCREMENT ,
  PRIMARY KEY (`event_id`) )
ENGINE = InnoDB;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
