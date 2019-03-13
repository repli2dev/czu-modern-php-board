-- Adminer 4.7.1 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `board_post`;
CREATE TABLE `board_post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `type` LONGTEXT NOT NULL,
  `title` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8_unicode_ci NOT NULL,
  `posted_at` datetime NOT NULL,
  `active` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_801C35AEA76ED395` (`user_id`),
  CONSTRAINT `FK_801C35AEA76ED395` FOREIGN KEY (`user_id`) REFERENCES `board_user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `board_user`;
CREATE TABLE `board_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_57058F6AF85E0677` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `board_user` (`id`, `username`, `password_hash`) VALUES
(1,	'test',	'$2a$10$wx1x7I2t8WquDYEE5klb6eT8QsYWm9TtjDV1BXJrylaHU2wBq7A4O'), -- test
(2,	'test2',	'$2a$10$2iG4R713xjYWM7QWubpCaOVT5NCOaLerw1VaZTHnIf4hGPFhJu3EG'); -- test2
