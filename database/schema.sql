

-- create database service_adept;
use service_adept;

-- drop all tables if exists
-- drop table user;
-- drop table service;
-- drop table PriceType;
-- drop table provider;
-- drop table organization;
-- drop table OrganizationManager;
-- drop table OrganizationAdmin;
-- drop table ServiceProvider;
-- drop table ServiceOrder;
-- drop table AccessLevel;
-- drop table CustomerCareExecutive;
-- drop table Complaint;
-- drop table Payments;





CREATE TABLE `User` (
  `id` INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `username` varchar(64) UNIQUE NOT NULL,
  `name` varchar(64) NOT NULL,
  `password` varchar(256) NOT NULL,
  `email` varchar(320) UNIQUE NOT NULL,
  `phone` varchar(13),
  `address` varchar(200),
  `city_id` INT NOT NULL,
  `access_level` INT NOT NULL,
  `gender` INT NOT NULL,
  `relogin` INT DEFAULT 0
);

CREATE TABLE `Service` (
  `id` INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `service_name` varchar(64) NOT NULL,
  `description` TEXT(500) NOT NULL,
  `price_type_id` INT NOT NULL,
  `price` FLOAT NOT NULL,
  `city_id` INT NOT NULL,
  `organization_id` INT NOT NULL,
  `category_id` INT NOT NULL
);

CREATE TABLE `PriceType` (
  `id` INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `type` varchar(32) NOT NULL
);

CREATE TABLE `provider` (
  `id` INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL UNIQUE,
  `organization_id` INT NOT NULL 
);

CREATE TABLE `Organization` (
  `id` INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL 
  
);

CREATE TABLE `OrganizationManager` (
  `id` INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL UNIQUE,
  `organization_id` INT NOT NULL 
);

CREATE TABLE `OrganizationAdmin` (
  `id` INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `user_id` INT  NOT NULL UNIQUE,
  `organization_id` INT NOT NULL 
);

CREATE TABLE `ServiceProvider` (
  `id` INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `provider_id` INT NOT NULL,
  `service_id` INT NOT NULL
);

ALTER TABLE `ServiceProvider` ADD UNIQUE (`provider_id`, `service_id`);

CREATE TABLE `ServiceOrder` (
  `id` INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `service_provider_id` INT NOT NULL,
  `quantity` INT DEFAULT 0,
  `time` TIME NOT NULL,
  `date` DATE NOT NULL,
  `subscription` INT DEFAULT 0,
  `completed` INT DEFAULT 0
);

CREATE TABLE `AccessLevel` (
  `id` INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `description` varchar(32) NOT NULL
);

CREATE TABLE `CustomerCareExecutive` (
  `id` INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL UNIQUE,
  `care_count` INT
);

CREATE TABLE `Complaint` (
  `id` INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `executive_id` INT NOT NULL,
  `status` INT NOT NULL DEFAULT 1,
  `description` TEXT(500) NOT NULL
);


CREATE TABLE `Payments` (
  `id` INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `service_order_id` INT NOT NULL,
  `amount` INT NOT NULL,
  `is_paid` INT DEFAULT 0
);

CREATE TABLE `Category` (
  `id` INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL
);

CREATE TABLE `City` (
  `id` INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL
);

ALTER TABLE `User` ADD FOREIGN KEY (`city_id`) REFERENCES `City`(`id`);

ALTER TABLE `User` ADD FOREIGN KEY (`access_level`) REFERENCES `AccessLevel` (`id`);

ALTER TABLE `Service` ADD FOREIGN KEY (`price_type_id`) REFERENCES `PriceType` (`id`);

ALTER TABLE `Service` ADD FOREIGN KEY (`organization_id`) REFERENCES `Organization` (`id`);

ALTER TABLE `Service` ADD FOREIGN KEY (`category_id`) REFERENCES `Category` (`id`);

ALTER TABLE `Service` ADD FOREIGN KEY (`city_id`) REFERENCES `City` (`id`);

ALTER TABLE `provider` ADD FOREIGN KEY (`user_id`) REFERENCES `User` (`id`);

ALTER TABLE `provider` ADD FOREIGN KEY (`organization_id`) REFERENCES `Organization` (`id`);

ALTER TABLE `OrganizationManager` ADD FOREIGN KEY (`user_id`) REFERENCES `User` (`id`);

ALTER TABLE `OrganizationManager` ADD FOREIGN KEY (`organization_id`) REFERENCES `Organization` (`id`);

ALTER TABLE `OrganizationAdmin` ADD FOREIGN KEY (`user_id`) REFERENCES `User` (`id`);

ALTER TABLE `OrganizationAdmin` ADD FOREIGN KEY (`organization_id`) REFERENCES `Organization` (`id`);

ALTER TABLE `ServiceProvider` ADD FOREIGN KEY (`provider_id`) REFERENCES `provider` (`id`);

ALTER TABLE `ServiceProvider` ADD FOREIGN KEY (`service_id`) REFERENCES `Service` (`id`);

ALTER TABLE `ServiceOrder` ADD FOREIGN KEY (`user_id`) REFERENCES `User` (`id`);

ALTER TABLE `ServiceOrder` ADD FOREIGN KEY (`service_provider_id`) REFERENCES `ServiceProvider` (`id`);

ALTER TABLE `CustomerCareExecutive` ADD FOREIGN KEY (`user_id`) REFERENCES `User` (`id`);

ALTER TABLE `Complaint` ADD FOREIGN KEY (`user_id`) REFERENCES `User` (`id`);

ALTER TABLE `Complaint` ADD FOREIGN KEY (`executive_id`) REFERENCES `CustomerCareExecutive` (`id`);

ALTER TABLE `Payments` ADD FOREIGN KEY (`user_id`) REFERENCES `User` (`id`);

ALTER TABLE `Payments` ADD FOREIGN KEY (`service_order_id`) REFERENCES `ServiceOrder` (`id`);



-- insert into AccessLevel
INSERT INTO `AccessLevel` (`description`) VALUES
('User'),
('Service Provider'),
('Organization Manager'),
('Organization Admin'),
('Customer Care Executive'),
('Admin');


-- insert into PriceType
INSERT INTO `PriceType` (`type`) VALUES
('Once'),
('Hourly'),
('Daily'),
('Weekly'),
('Monthly');


-- insert into Category 
INSERT INTO `Category` (`name`) VALUES
('Cleaning'),
('Handyman'),
('Plumbing'),
('Electrical'),
('Other');

-- insert into City
INSERT INTO `City` (`name`) VALUES 
('Mumbai'),
('Pune'),
('Delhi'),
('Bangalore'),
('Chennai');

-- inserting testing values


