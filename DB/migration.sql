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

INSERT INTO `plantdb_new`.`location`
SELECT `location_id`, `location_x`, `location_y`, `size_x`, `size_y`
FROM `plantdb`.`location`;

INSERT INTO `plantdb_new`.`group`
VALUES
    ('1', 'Group 1'),
    ('2', 'Group 2'),
    ('3', 'Group 3'),
    ('4', 'Group 4'),
    ('5', 'Group 5'),
    ('6', 'Group 6'),
    ('7', 'Group 7'),
    ('8', 'Group 8'),
	('9', 'Group 9');

-- _____________________________________________________________________________________________________________
-- NA EMPRESA O CSV AUTOMÁTICO AINDA NÃO FOI IMPLEMENTADO, LOGO ESTA QUERY NÃO SERIA NECESSÁRIA NEM IA FUNCIONAR
INSERT INTO `plantdb_new`.`csv`
SELECT * FROM `plantdb`.`hora`;
-- _____________________________________________________________________________________________________________

INSERT INTO `plantdb_new`.`title`
SELECT * FROM `plantdb`.`titulo`
WHERE LENGTH(`Titulo`) < 30;

INSERT INTO `plantdb_new`.`user_type`
VALUES
('1', 'Admin'),
('2', 'User');

INSERT INTO `plantdb_new`.`user`
SELECT `user_id`, `username`, `email`, `password`, IF(`user_type` = 0, 2, 1) FROM `plantdb`.`users`;

INSERT INTO `plantdb_new`.`sensor`
SELECT DISTINCT
    `plantdb`.`sensors`.`id_sensor`,
    '' AS `description`,
    `plantdb`.`location`.`location_id`,
    1 AS `group`,
    `plantdb`.`location`.`status`
FROM
    `plantdb`.`sensors`
LEFT JOIN
`plantdb`.`location` ON CONCAT(SUBSTRING(`plantdb`.`sensors`.`id_sensor`, 1, LENGTH(`plantdb`.`sensors`.`id_sensor`) - 2),LPAD(CAST(CONV(RIGHT(sensors.id_sensor, 2), 16, 10) AS SIGNED), 2, '0')) = `plantdb`.`location`.`id_sensor`;

INSERT INTO `plantdb_new`.`sensor_reading`
SELECT
`sensor_id`, `id_sensor`,`date`, `hour`, `SetPoint`, `DeltaSetPoint`, `AddressCold`,
`AddressHot`, `SlaveReply`, `SlaveComand`, `Command1`, `Command2`, `Command3`, `Command4`,
`temperature`, `humidity`, `pressure`, `altitude`, `eCO2`, `eTVOC`, `CommunicationStatus`,
`F_Mount`, `F_Open`, `F_Lseek`, `F_write`, `F_Close`, `F_Dismount`
FROM `plantdb`.`sensors`;

INSERT INTO `plantdb_new`.`csv_sensor`(`sensor_id`, `csv_id`)
SELECT DISTINCT `sensors`.`id_sensor`, 1 AS `id_hora` FROM `plantdb`.`sensors`, `plantdb`.`location`
WHERE `plantdb`.`sensors`.`id_sensor` = `plantdb`.`location`.`id_sensor` AND `plantdb`.`location`.`gerar` = 1;