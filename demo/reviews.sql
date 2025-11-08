-- AdminNeo 4.17.2 MySQL 8.0.35 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `reviews`;
CREATE TABLE `reviews` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `nume` tinytext NOT NULL,
  `email` varchar(30) NOT NULL,
  `review` tinytext NOT NULL,
  `movie` tinytext NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

INSERT INTO `reviews` (`id`, `nume`, `email`, `review`, `movie`) VALUES
(1,	'Aaam... Andrei',	'sigurMaCheamaAndrei@gmail.com',	'Nu m-am uiat la film, da nu pot sa inteleg de ce e pe toate tricourile si sucurile din magazin. ',	'1'),
(3,	'D. Fyodor',	'iAmFyodor@yahoo.com',	'I love rats so much. In fact, this movie made me relate to the main character so much. THIS MOVIE IS A MASTERPIECE',	'6'),
(8,	'Alfredo Linguini',	'AlfredoLinguini1@gmail.com',	'This movie inspired me to open a restaurant for rats. Now my grandma threw me out.',	'6'),
(9,	'euu',	'eu@gmail.com',	'Great movie. I laughed so much that my years started burning.',	'9'),
(10,	'aaa...Vasilica',	'VasiVasi@yahoo.com',	'The facial expressions of the main character were funnier than the movie.',	'14'),
(11,	'haha',	'haha@gmail.com',	'hahhahahahhahahahah',	'6'),
(12,	'yeye',	'yeye@yahoo.com',	'This movie would ve been so much better as a musical. A french musical ',	'9');

-- 2025-07-04 10:40:23 UTC
