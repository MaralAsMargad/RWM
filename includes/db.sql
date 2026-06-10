DROP DATABASE IF EXISTS `rwm_db`;
CREATE DATABASE IF NOT EXISTS `rwm_db`
DEFAULT CHARACTER SET utf8mb4
COLLATE utf8mb4_general_ci;
USE `rwm_db`;

CREATE TABLE if NOT EXISTS `users` (
`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`username` VARCHAR(100) NOT NULL,
`email` VARCHAR(100) NOT NULL UNIQUE,
`hashed_password` VARCHAR(255) NOT NULL,
`role` ENUM('user', 'admin') DEFAULT 'user',
`created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE if NOT EXISTS `movies` (
`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
`title` VARCHAR(255) NOT NULL,
`image` VARCHAR(255) NOT NULL,
`release_year` YEAR,
`genre` VARCHAR(100),
`summary` TEXT,
`created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE if NOT EXISTS `ratings` (
`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
`user_id` INT NOT NULL,
`movie_id` INT NOT NULL,
`rating` INT NOT NULL CHECK (`rating` BETWEEN 1 AND 10),
`comment` TEXT,
`created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

FOREIGN KEY (`user_id`)
   REFERENCES `users`(`id`)
   ON DELETE CASCADE,

FOREIGN KEY (`movie_id`)
   REFERENCES `movies`(`id`)
   ON DELETE CASCADE,
   
UNIQUE (`user_id`, `movie_id`) -- user kann denselben Film einmal bewerten 
);

-- FAVORITES
CREATE TABLE IF NOT EXISTS `favorites` (
`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
`user_id` INT NOT NULL,
`movie_id` INT NOT NULL,
`created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

FOREIGN KEY (`user_id`)
   REFERENCES `users`(`id`)
   ON DELETE CASCADE,
FOREIGN KEY (`movie_id`)
   REFERENCES `movies`(`id`)
   ON DELETE CASCADE,

UNIQUE (`user_id`, `movie_id`)
);