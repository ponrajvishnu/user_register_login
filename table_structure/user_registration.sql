create table user_registration(
	`id` int(11) NOT NULL AUTO_INCREMENT,
    `firstname` varchar(50) NOT NULL,
    `lastname` varchar(50) NOT NULL,
    `email` varchar(100) NOT NULL,
    `password` varchar(50) NOT NULL,
    `created_date` datetime DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
);