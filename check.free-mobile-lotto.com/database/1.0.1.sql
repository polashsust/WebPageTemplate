-- 1.0.1.sql
-- \author sue
-- 
-- Run to set up freelotto :)

ALTER TABLE `lotto` CHANGE `digit1` `digit1` INT( 11 ) NULL ,
CHANGE `digit2` `digit2` INT( 11 ) NULL ,
CHANGE `digit3` `digit3` INT( 11 ) NULL ,
CHANGE `digit4` `digit4` INT( 11 ) NULL ,
CHANGE `digit5` `digit5` INT( 11 ) NULL ,
CHANGE `digit6` `digit6` INT( 11 ) NULL ,
CHANGE `additionaldigit` `additionaldigit` INT( 11 ) NULL;

ALTER TABLE `paymentcustomer` ADD `email` VARCHAR( 255 ) NULL,
ADD `emailsent` TINYINT( 1 ) NOT NULL;