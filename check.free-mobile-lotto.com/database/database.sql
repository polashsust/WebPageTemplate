-- database.sql
-- \author ck
-- 
-- Run to set up freelotto :)

-- Create schema
CREATE DATABASE IF NOT EXISTS `freelotto` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;;
USE freelotto;

-- Table to keep track of payments
CREATE TABLE  `payment` (
	`id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	`uniquenumber` CHAR( 40 ) NOT NULL ,
	`shortnumber` CHAR( 14 ) NOT NULL ,
	`descriptor` VARCHAR( 196 ) NOT NULL ,
	`state` VARCHAR( 255 ) NULL ,
	`okforlottery` TINYINT(1) NOT NULL DEFAULT 0,
	`ip` VARCHAR( 45 ) NOT NULL ,
	`created` DATETIME NOT NULL ,
	`modified` DATETIME NOT NULL
) ENGINE = INNODB;

-- Table to keep track of lottery entries
CREATE TABLE  `lotto` (
	`id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	`payment_id` INT UNSIGNED NOT NULL ,
	`uniqueid` CHAR( 16 ) NULL,
	`fortunoruniqueid` CHAR( 32 ) NULL,
	
	`digit1` INT NOT NULL ,
	`digit2` INT NOT NULL ,
	`digit3` INT NOT NULL ,
	`digit4` INT NOT NULL ,
	`digit5` INT NOT NULL ,
	`digit6` INT NOT NULL , 
	`additionaldigit` INT NOT NULL ,
	
	`startdate` DATE NULL,
	`enddate` DATE NULL,
	`created` DATETIME NOT NULL ,
	`modified` DATETIME NOT NULL ,
	INDEX (  `payment_id` )
) ENGINE = INNODB;

ALTER TABLE  `lotto` ADD FOREIGN KEY (  `payment_id` ) REFERENCES  `payment` (
`id`
) ON DELETE RESTRICT ON UPDATE CASCADE ;

CREATE TABLE `paymentcustomer` (
	`id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	`payment_id` INT UNSIGNED NOT NULL ,
	`given` VARCHAR( 255 ) NULL ,
	`family` VARCHAR( 255 ) NULL ,
	`gender` TINYINT( 1 ) NULL ,
	INDEX (  `payment_id` )
) ENGINE = INNODB;

ALTER TABLE  `paymentcustomer` ADD FOREIGN KEY (  `payment_id` ) REFERENCES  `payment` (
`id`
) ON DELETE CASCADE ON UPDATE CASCADE ;
