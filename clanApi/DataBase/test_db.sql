CREATE TABLE `clans` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` varchar(12) NOT NULL,
  `description` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `clan_users` ( 
	`id` INT NOT NULL AUTO_INCREMENT,
	`clan_id` INT NOT NULL,
	`user_id` INT NOT NULL,
	`rule` INT NOT NULL,
	PRIMARY KEY (`id`),
	UNIQUE `clan_id_user_id_uk` (`clan_id`, `user_id`),
	INDEX(`user_id`)
) ENGINE = InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `clan_users`
  ADD CONSTRAINT `clan_users_clan_id_fk` FOREIGN KEY (`clan_id`) REFERENCES `clans` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `clan_users_user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

INSERT INTO `users` (`id`, `name`) VALUES
(1, 'user_1'),
(2, 'user_2'),
(3, 'user_3'),
(4, 'user_4'),
(5, 'user_5'),
(6, 'user_6'),
(7, 'user_7');
