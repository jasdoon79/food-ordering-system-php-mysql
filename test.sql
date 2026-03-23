/*
SQLyog Community v13.3.0 (64 bit)
MySQL - 8.0.42 : Database - test
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`test` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;

USE `test`;

/*Table structure for table `clients` */

DROP TABLE IF EXISTS `clients`;

CREATE TABLE `clients` (
  `client_id` int NOT NULL AUTO_INCREMENT,
  `client_name` varchar(50) NOT NULL,
  `client_phone` varchar(50) NOT NULL,
  `client_email` varchar(100) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`client_id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb3;

/*Data for the table `clients` */

insert  into `clients`(`client_id`,`client_name`,`client_phone`,`client_email`,`password`) values 
(9,'Client_1','02020202020','client1@gmail.com','Client@1'),
(10,'Client 10','0638383933','client10@gmail.com',NULL),
(11,'Client 11','06242556272','client11@yahoo.fr',NULL),
(13,'Client 12','030303030202','client1133@gmail.com',NULL),
(14,'Client 12','030303030','client14@gmail.com',NULL),
(16,'Client 14','0203203203','client14@gmail.com',NULL),
(17,'Client 17','0737373822','client17@gmail.com',NULL),
(18,'Client 12','02920320','client12@yahoo.fr',NULL),
(19,'Test','1034304300','test@gmail.com',NULL);

/*Table structure for table `image_gallery` */

DROP TABLE IF EXISTS `image_gallery`;

CREATE TABLE `image_gallery` (
  `image_id` int NOT NULL AUTO_INCREMENT,
  `image_name` varchar(30) NOT NULL,
  `image` varchar(255) NOT NULL,
  PRIMARY KEY (`image_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb3;

/*Data for the table `image_gallery` */

insert  into `image_gallery`(`image_id`,`image_name`,`image`) values 
(1,'Moroccan Tajine','58146_Moroccan Chicken Tagine.jpeg'),
(2,'Italian Pasta','img_1.jpg'),
(3,'Cook','img_2.jpg'),
(4,'Pizza','img_3.jpg');

/*Table structure for table `in_order` */

DROP TABLE IF EXISTS `in_order`;

CREATE TABLE `in_order` (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_id` int NOT NULL,
  `menu_id` int NOT NULL,
  `quantity` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fk_menu` (`menu_id`),
  KEY `fk_order` (`order_id`),
  CONSTRAINT `fk_menu` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`menu_id`),
  CONSTRAINT `fk_order` FOREIGN KEY (`order_id`) REFERENCES `placed_orders` (`order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb3;

/*Data for the table `in_order` */

insert  into `in_order`(`id`,`order_id`,`menu_id`,`quantity`) values 
(8,10,16,1),
(9,11,12,1),
(10,11,16,1),
(11,12,11,1),
(12,12,12,1),
(13,12,16,1);

/*Table structure for table `menu_categories` */

DROP TABLE IF EXISTS `menu_categories`;

CREATE TABLE `menu_categories` (
  `category_id` int NOT NULL AUTO_INCREMENT,
  `category_name` varchar(50) NOT NULL,
  `restaurant_id` int DEFAULT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb3;

/*Data for the table `menu_categories` */

insert  into `menu_categories`(`category_id`,`category_name`,`restaurant_id`) values 
(2,'desserts',2),
(3,'drinks',2),
(4,'pasta',2),
(5,'pizzas',16),
(6,'salads',16),
(8,'Traditional Food',8),
(11,'Rice',16);

/*Table structure for table `menus` */

DROP TABLE IF EXISTS `menus`;

CREATE TABLE `menus` (
  `menu_id` int NOT NULL AUTO_INCREMENT,
  `menu_name` varchar(100) NOT NULL,
  `menu_description` varchar(255) NOT NULL,
  `menu_price` decimal(6,2) NOT NULL,
  `menu_image` varchar(255) NOT NULL,
  `category_id` int NOT NULL,
  `restaurant_id` int DEFAULT NULL,
  PRIMARY KEY (`menu_id`),
  KEY `FK_menu_category_id` (`category_id`),
  CONSTRAINT `FK_menu_category_id` FOREIGN KEY (`category_id`) REFERENCES `menu_categories` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb3;

/*Data for the table `menus` */

insert  into `menus`(`menu_id`,`menu_name`,`menu_description`,`menu_price`,`menu_image`,`category_id`,`restaurant_id`) values 
(5,'Coffee','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam posuere, lectus et mollis ultricies, justo arcu dignissim enim, eu eleifend lectus nulla.',70.00,'62205_Screenshot 2025-04-26 211132.png',3,16),
(8,'Cannelloni','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam posuere, lectus et mollis ultricies, justo arcu dignissim enim, eu eleifend lectus nulla.',10.00,'cooked_pasta.jpeg',4,2),
(9,'Margherita','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam posuere, lectus et mollis ultricies, justo arcu dignissim enim, eu eleifend lectus nulla.',24.00,'pizza.jpeg',5,2),
(11,'Moroccan Tajine','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam posuere, lectus et mollis ultricies, justo arcu dignissim enim, eu eleifend lectus nulla.',20.00,'58146_Moroccan Chicken Tagine.jpeg',8,16),
(12,'Moroccan Bissara','Bissara is a traditional Moroccan dish made from dried split fava beans (also known as broad beans) that are cooked and blended into a smooth and flavorful soup.',10.00,'61959_Bissara.jpg',8,2),
(16,'Couscous','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam posuere, lectus et mollis ultricies, justo arcu dignissim enim, eu eleifend lectus nulla.',20.00,'76635_57738_w1024h768c1cx256cy192.jpg',8,16),
(19,'Fried Rice','Fried Rice',10.00,'99663_Screenshot 2025-04-29 124528.png',11,8);

/*Table structure for table `placed_orders` */

DROP TABLE IF EXISTS `placed_orders`;

CREATE TABLE `placed_orders` (
  `order_id` int NOT NULL AUTO_INCREMENT,
  `order_time` datetime NOT NULL,
  `client_id` int NOT NULL,
  `delivery_address` varchar(255) NOT NULL,
  `delivered` tinyint(1) NOT NULL DEFAULT '0',
  `canceled` tinyint(1) NOT NULL DEFAULT '0',
  `cancellation_reason` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`order_id`),
  KEY `fk_client` (`client_id`),
  CONSTRAINT `fk_client` FOREIGN KEY (`client_id`) REFERENCES `clients` (`client_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb3;

/*Data for the table `placed_orders` */

insert  into `placed_orders`(`order_id`,`order_time`,`client_id`,`delivery_address`,`delivered`,`canceled`,`cancellation_reason`) values 
(7,'2020-06-22 12:01:00',9,'Bloc A Nr 80000 Hay ElAgadir',0,1,'Sorry! I changed my mind!'),
(8,'2020-06-23 06:07:00',10,'Chengdu, China',0,1,''),
(9,'2020-06-24 16:40:00',11,'Hay El Houda Agadir',1,0,NULL),
(10,'2023-07-01 04:02:00',16,'Bloc A',0,1,''),
(11,'2023-10-30 20:09:00',18,'Test testst asds',0,1,''),
(12,'2023-10-30 21:46:00',19,'tests sd',0,0,NULL);

/*Table structure for table `reservations` */

DROP TABLE IF EXISTS `reservations`;

CREATE TABLE `reservations` (
  `reservation_id` int NOT NULL AUTO_INCREMENT,
  `date_created` datetime NOT NULL,
  `client_id` int NOT NULL,
  `selected_time` datetime NOT NULL,
  `nbr_guests` int NOT NULL,
  `table_id` int NOT NULL,
  `liberated` tinyint(1) NOT NULL DEFAULT '0',
  `canceled` tinyint(1) NOT NULL DEFAULT '0',
  `cancellation_reason` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`reservation_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3;

/*Data for the table `reservations` */

insert  into `reservations`(`reservation_id`,`date_created`,`client_id`,`selected_time`,`nbr_guests`,`table_id`,`liberated`,`canceled`,`cancellation_reason`) values 
(1,'2020-07-18 09:07:00',13,'2020-07-30 09:07:00',0,1,0,0,NULL),
(2,'2020-07-18 09:11:00',14,'2020-07-29 13:00:00',4,1,0,0,NULL),
(3,'2023-07-01 04:01:00',15,'2023-07-02 05:00:00',2,1,0,0,NULL),
(4,'2023-10-30 20:03:00',17,'2023-11-08 20:03:00',1,1,0,0,NULL);

/*Table structure for table `restaurants` */

DROP TABLE IF EXISTS `restaurants`;

CREATE TABLE `restaurants` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `rating` decimal(2,1) DEFAULT NULL,
  `time` int DEFAULT NULL,
  `forTwo` int DEFAULT NULL,
  `offer` varchar(255) DEFAULT NULL,
  `img` varchar(255) DEFAULT NULL,
  `owner` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `restaurants` */

insert  into `restaurants`(`id`,`name`,`type`,`rating`,`time`,`forTwo`,`offer`,`img`,`owner`,`email`,`status`) values 
(1,'Bodypower Cafe','Indian, Pizzas',4.7,34,450,'FLAT150 off | Use FLATDEAL','../img/popular1.png','Resr User','rest@gmail.com','active'),
(2,'Meghana Foods','Biryani, Andhra, South Indian, North Indian, Chinese, Seafood',4.6,25,500,'FREE DELIVARY','../img/popular2.png','	Rest Roo','rest2@mail.com','active'),
(3,'Anjappar','Chettinad, Thalis, Biryani, Chinese, Tandoor, Indian',4.1,28,400,'40% off | Use TRYNEW','../img/popular3.png','asd ff','asdf@gmail.com','active'),
(4,'Kannur Food Point','Kerala, Chinese',3.8,37,300,'50% off on all orders','../img/popular4.png',NULL,NULL,'active'),
(5,'Rahhams','Biryani, Mughlai, North Indian, Kebabs, Chinese, Seafood, Beverages',4.4,42,700,'FREE DELIVERY','../img/popular5.png',NULL,NULL,'inactive'),
(6,'Nandhini Deluxe','Andhra, Biryani, Chinese, North Indian',4.2,34,500,'FLAT100 off | Use FLATDEAL','../img/popular6.png',NULL,NULL,'inactive'),
(8,'Abhi Di Hatti','Punjabi',4.4,30,120,'Free Delivery','../img/Abhi Di Hatti.png','Abhi Gpta','abhinavg2712@gmail.com','active'),
(9,'APS Chai Corner','Indian',3.8,20,60,'Free Delivery','../img/APS Chai Corner.png','Prabhanshu Singh','prabhanshusingh94@gmail.com','inactive'),
(10,'Jai Shankar Prasad','Indian',3.2,30,50,'Friday Sale','./img/Jai Shankar Prasad.png','Mayank Mehra','mynkmhra200@gmail.com','inactive');

/*Table structure for table `tables` */

DROP TABLE IF EXISTS `tables`;

CREATE TABLE `tables` (
  `table_id` int NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`table_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;

/*Data for the table `tables` */

insert  into `tables`(`table_id`) values 
(1);

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `email` varchar(30) NOT NULL,
  `full_name` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `user_r` varchar(7) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb3;

/*Data for the table `users` */

insert  into `users`(`user_id`,`username`,`email`,`full_name`,`password`,`user_r`) values 
(1,'admin_user','admin@gmail.com','Admin Admin','7ab515d12bd2cf431745511ac4ee13fed15ab578','admin'),
(2,'rest_user','rest@gmail.com','Rest Rest','7abSISd12bd2cf43174SS11ac4ee1Sfed1SabS78','rest'),
(16,'abhi','abhinavg2712@gmail.com','Abhi Gpta','e0c95748a455c27a80fd289269120d4944d1f318','rest'),
(20,'Prabh','prabhanshusingh94@gmail.com','Prabhanshu Singh','e0c95748a455c27a80fd289269120d4944d1f318','rest'),
(21,'Mayank','mynkmhra200@gmail.com','Mayank Mehra','b1b3773a05c0ed0176787a4f1574ff0075f7521e','rest');

/*Table structure for table `website_settings` */

DROP TABLE IF EXISTS `website_settings`;

CREATE TABLE `website_settings` (
  `option_id` int NOT NULL AUTO_INCREMENT,
  `option_name` varchar(255) NOT NULL,
  `option_value` varchar(255) NOT NULL,
  PRIMARY KEY (`option_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3;

/*Data for the table `website_settings` */

insert  into `website_settings`(`option_id`,`option_name`,`option_value`) values 
(1,'restaurant_name','VINCENT PIZZA'),
(2,'restaurant_email','vincent.pizza@gmail.com'),
(3,'admin_email','admin_email@gmail.com'),
(4,'restaurant_phonenumber','088866777555'),
(5,'restaurant_address','1580  Boone Street, Corpus Christi, TX, 78476 - USA');

/*Table structure for table `webusers` */

DROP TABLE IF EXISTS `webusers`;

CREATE TABLE `webusers` (
  `user_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `password_hash` varchar(255) DEFAULT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `address_line_1` varchar(100) DEFAULT NULL,
  `address_line_2` varchar(100) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `state` varchar(50) DEFAULT NULL,
  `postal_code` varchar(20) DEFAULT NULL,
  `country` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `webusers` */

insert  into `webusers`(`user_id`,`name`,`username`,`email`,`phone_number`,`password_hash`,`profile_picture`,`address_line_1`,`address_line_2`,`city`,`state`,`postal_code`,`country`) values 
(1,'abhinav','abhinav_27','abhi27@gmail.com',NULL,'$2y$10$3E2z0ItRThjJQr9VFFoET.nDdonxs5sj1YMQAV1PdKmj0EBxYidQG',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(2,'asdf','asdf','asdf@gmail.com',NULL,'$2y$10$ueZ9GpGBnJgjYJlcTu.6gOQkaHlleDk7X2ce09/Lvsf8XrzXE7zhC',NULL,NULL,NULL,NULL,NULL,NULL,NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
