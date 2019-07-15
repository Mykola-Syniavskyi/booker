CREATE TABLE `b_users` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`name` char(50) NOT NULL,
	`email` char(50) NOT NULL UNIQUE,
	`password` char(50) NOT NULL,
	`role` enum('user','admin') NOT NULL,
	`status` int(11) NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `b_events` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`user_id` int(11) NOT NULL,
	`note` char(250) NOT NULL,
	`start` TIMESTAMP NOT NULL,
	`end` TIMESTAMP NOT NULL,
	`room_id` int(11) NOT NULL,
	`recurent_id` int(11) NOT NULL,
	`created_data` TIMESTAMP NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `b_rooms` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`name` char(50) NOT NULL,
	PRIMARY KEY (`id`)
);

ALTER TABLE `b_events` ADD CONSTRAINT `b_events_fk0` FOREIGN KEY (`user_id`) REFERENCES `b_users`(`id`);

ALTER TABLE `b_events` ADD CONSTRAINT `b_events_fk1` FOREIGN KEY (`room_id`) REFERENCES `b_rooms`(`id`);

