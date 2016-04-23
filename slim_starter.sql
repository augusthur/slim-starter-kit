CREATE DATABASE IF NOT EXISTS `slim_starter`;
USE `slim_starter`;

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=ucs2;

LOCK TABLES `users` WRITE;
INSERT INTO `users` VALUES (1,'Nelson'),(2,'Paula'),(3,'Eleo');
UNLOCK TABLES;
