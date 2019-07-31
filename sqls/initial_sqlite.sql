CREATE TABLE `company_types` (
    `id` INTEGER PRIMARY KEY AUTOINCREMENT,
    `naming_conv` VARCHAR(50) NOT NULL
);

CREATE TABLE `companies` (
    `id` INTEGER PRIMARY KEY  AUTOINCREMENT,
    `name` VARCHAR(200) NOT NULL,
    `address` VARCHAR(300) NOT NULL, -- quite composite, should be splitted if it was real proj
    `type` INTEGER NOT NULL,

    FOREIGN KEY (`type`) REFERENCES `company_types`(`id`)
);

CREATE TABLE `company_contacts` (
    `id` INTEGER PRIMARY KEY AUTOINCREMENT,
    `company` INTEGER NOT NULL,
    `name` VARCHAR(200) NOT NULL,
    `phone` VARCHAR(20) NOT NULL,

    FOREIGN KEY (`company`) REFERENCES `companies` (`id`)
);

INSERT INTO `company_types` 
(`naming_conv`) 
VALUES
("client"),
("supplier");