DROP DATABASE IF EXISTS `MiniCRM_DB`;
CREATE DATABASE `MiniCRM_DB`;
USE `MiniCRM_DB`;

CREATE TABLE `company_types` (
    `id` INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    `naming_conv` VARCHAR(50) NOT NULL
);

CREATE TABLE `companies` (
    `id` INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(200) NOT NULL,
    `address` VARCHAR(300) NOT NULL, -- quite composite, should be splitted if it was real proj
    `type` INT NOT NULL,

    FOREIGN KEY (`type`) REFERENCES `company_types`(`id`)
);

CREATE TABLE `company_contacts` (
    `id` INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    `company` INT NOT NULL,
    `name` VARCHAR(200) NOT NULL,
    `phone` VARCHAR(20) NOT NULL,

    FOREIGN KEY (`company`) REFERENCES `companies` (`id`)
);

INSERT INTO `company_types` 
(`naming_conv`) 
VALUES
("client"),
("supplier");