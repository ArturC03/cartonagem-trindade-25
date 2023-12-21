CREATE DATABASE IF NOT EXISTS `plantdb_new`;
USE `plantdb_new`;

CREATE TABLE `user_type` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `type` varchar(20) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

CREATE TABLE `user` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `username` varchar(30) NOT NULL,
    `email` varchar(150) NOT NULL,
    `password` varchar(300) NOT NULL,
    `user_type` INT NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`user_type`) REFERENCES `user_type`(`id`)
) ENGINE=InnoDB;

CREATE TABLE `title` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `title` varchar(50) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

CREATE TABLE `group` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `group_name` varchar(30) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

CREATE TABLE `location` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `location_x` INT,
    `location_y` INT,
    `size_x` INT,
    `size_y` INT,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

CREATE TABLE `sensor` (
    `id` varchar(4) NOT NULL,
    `description` varchar(100),
    `location` INT NOT NULL,
    `group` INT NOT NULL,
    `status` tinyint(1) NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`location`) REFERENCES `location`(`id`),
    FOREIGN KEY (`group`) REFERENCES `group`(`id`)
) ENGINE=InnoDB;

CREATE TABLE `csv` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `generation_date` DATETIME NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

CREATE TABLE `csv_sensor` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `sensor_id` varchar(4) NOT NULL,
    `csv_id` INT NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`sensor_id`) REFERENCES `sensor`(`id`),
    FOREIGN KEY (`csv_id`) REFERENCES `csv`(`id`)
) ENGINE=InnoDB;

CREATE TABLE `sensor_reading` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `sensor_id` varchar(4) NOT NULL,
    `date` DATE NOT NULL,
    `time` TIME NOT NULL,
    `setPoint` varchar(3) NOT NULL,
    `deltaSetPoint` varchar(3) NOT NULL,
    `addressCold` varchar(3) NOT NULL,
    `addressHot` varchar(3) NOT NULL,
    `slaveReply` varchar(4) NOT NULL,
    `slaveCommand` varchar(4) NOT NULL,
    `command1` varchar(3) NOT NULL,
    `command2` varchar(3) NOT NULL,
    `command3` varchar(3) NOT NULL,
    `command4` varchar(3) NOT NULL,
    `temperature` varchar(10) NOT NULL,
    `humidity` varchar(10) NOT NULL,
    `pressure` varchar(10) NOT NULL,
    `altitude` varchar(10) NOT NULL,
    `eCO2` varchar(10),
    `eTVOC` varchar(10),
    `communicationStatus` varchar(2) NOT NULL,
    `f_Mount` varchar(3) NOT NULL,
    `f_Open` varchar(3) NOT NULL,
    `f_Lseek` varchar(3) NOT NULL,
    `f_Write` varchar(3) NOT NULL,
    `f_Close` varchar(3) NOT NULL,
    `f_Dismount` varchar(4) NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`sensor_id`) REFERENCES `sensor`(`id`)
) ENGINE=InnoDB;

ALTER TABLE `user` ADD CONSTRAINT `user_fk0` FOREIGN KEY (`user_type`) REFERENCES `user_type`(`id`);

ALTER TABLE `sensor` ADD CONSTRAINT `sensor_fk0` FOREIGN KEY (`location`) REFERENCES `location`(`id`);

ALTER TABLE `sensor` ADD CONSTRAINT `sensor_fk1` FOREIGN KEY (`group`) REFERENCES `group`(`id`);

ALTER TABLE `csv_sensor` ADD CONSTRAINT `csv_sensor_fk0` FOREIGN KEY (`sensor_id`) REFERENCES `sensor`(`id`);

ALTER TABLE `csv_sensor` ADD CONSTRAINT `csv_sensor_fk1` FOREIGN KEY (`csv_id`) REFERENCES `csv`(`id`);

ALTER TABLE `sensor_reading` ADD CONSTRAINT `sensor_reading_fk0` FOREIGN KEY (`sensor_id`) REFERENCES `sensor`(`id`);