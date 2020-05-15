CREATE TABLE `instadb`.`users` ( 
	`username` VARCHAR(50) NOT NULL , 
	`email` VARCHAR(50) NOT NULL , 
	`password` VARCHAR(20) NOT NULL , 
	PRIMARY KEY (`username`)
) ENGINE = InnoDB;

CREATE TABLE `instadb`.`images` ( 
	`id` INT(11) NOT NULL AUTO_INCREMENT , 
	`image` VARCHAR(200) NOT NULL , 
	`hash` VARCHAR(100) NOT NULL , 
	`username` VARCHAR(50) NOT NULL ,
	PRIMARY KEY (`id`)
) ENGINE = InnoDB;
 
ALTER TABLE `images` ADD INDEX(`username`);