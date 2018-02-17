DROP TABLE IF EXISTS `addresses`;
CREATE TABLE `addresses` ( 
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`name` varchar(50) NOT NULL,
	`street_number` varchar(50) NOT NULL,
	`city` varchar(50) NOT NULL,
	`state` varchar(50) NOT NULL,
	`zip_code` varchar(50) NOT NULL
	PRIMARY KEY(`id`) 
);
