#
# TABLE STRUCTURE FOR: admin_groups
#

DROP TABLE IF EXISTS `admin_groups`;

CREATE TABLE `admin_groups` (
 `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

INSERT INTO `admin_groups` (`id`, `name`, `description`) VALUES ('1', 'webmaster', 'Webmaster');
INSERT INTO `admin_groups` (`id`, `name`, `description`) VALUES ('2', 'admin', 'Administrator');
INSERT INTO `admin_groups` (`id`, `name`, `description`) VALUES ('3', 'manager', 'Manager');
INSERT INTO `admin_groups` (`id`, `name`, `description`) VALUES ('4', 'staff', 'Staff');


#
# TABLE STRUCTURE FOR: admin_login_attempts
#

DROP TABLE IF EXISTS `admin_login_attempts`;

CREATE TABLE `admin_login_attempts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(45) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# TABLE STRUCTURE FOR: admin_users
#

DROP TABLE IF EXISTS `admin_users`;

CREATE TABLE `admin_users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(45) NOT NULL,
  `username` varchar(100) NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(254) NOT NULL,
  `activation_selector` varchar(255) DEFAULT NULL,
  `activation_code` varchar(255) DEFAULT NULL,
  `forgotten_password_selector` varchar(255) DEFAULT NULL,
  `forgotten_password_code` varchar(255) DEFAULT NULL,
  `forgotten_password_time` int(11) unsigned DEFAULT NULL,
  `remember_selector` varchar(255) DEFAULT NULL,
  `remember_code` varchar(255) DEFAULT NULL,
  `created_on` int(11) unsigned NOT NULL,
  `last_login` int(11) unsigned DEFAULT NULL,
  `active` tinyint(1) unsigned DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `uc_email` UNIQUE (`email`),
  CONSTRAINT `uc_activation_selector` UNIQUE (`activation_selector`),
  CONSTRAINT `uc_forgotten_password_selector` UNIQUE (`forgotten_password_selector`),
  CONSTRAINT `uc_remember_selector` UNIQUE (`remember_selector`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

INSERT INTO `admin_users` (`id`, `ip_address`, `username`, `password`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`) VALUES ('1', '127.0.0.1', 'webmaster', '$2y$08$/X5gzWjesYi78GqeAv5tA.dVGBVP7C1e1PzqnYCVe5s1qhlDIPPES','info1@example.it', NULL, NULL, NULL, NULL, '1451900190', '1465489592', '1', 'Webmaster', '');
INSERT INTO `admin_users` (`id`, `ip_address`, `username`, `password`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`) VALUES ('2', '127.0.0.1', 'admin', '$2y$08$7Bkco6JXtC3Hu6g9ngLZDuHsFLvT7cyAxiz1FzxlX5vwccvRT7nKW','info2@example.it', NULL, NULL, NULL, NULL, '1451900228', '1465489580', '1', 'Admin', '');
INSERT INTO `admin_users` (`id`, `ip_address`, `username`, `password`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`) VALUES ('3', '127.0.0.1', 'manager', '$2y$08$snzIJdFXvg/rSHe0SndIAuvZyjktkjUxBXkrrGdkPy1K6r5r/dMLa','info3@example.it', NULL, NULL, NULL, NULL, '1451900430', '1465489585', '1', 'Manager', '');
INSERT INTO `admin_users` (`id`, `ip_address`, `username`, `password`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`) VALUES ('4', '127.0.0.1', 'staff', '$2y$08$NigAXjN23CRKllqe3KmjYuWXD5iSRPY812SijlhGeKfkrMKde9da6','info4@example.it', NULL, NULL, NULL, NULL, '1451900439', '1465489590', '1', 'Staff', '');


#
# TABLE STRUCTURE FOR: admin_users_groups
#

DROP TABLE IF EXISTS `admin_users_groups`;

CREATE TABLE `admin_users_groups` (
   `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_admin_users_groups_users1_idx` (`user_id`),
  KEY `fk_admin_users_groups_groups1_idx` (`group_id`),
  CONSTRAINT `uc_admin_users_groups` UNIQUE (`user_id`, `group_id`),
  CONSTRAINT `fk_admin_users_groups_users1` FOREIGN KEY (`user_id`) REFERENCES `admin_users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_admin_users_groups_groups1` FOREIGN KEY (`group_id`) REFERENCES `admin_groups` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

INSERT INTO `admin_users_groups` (`id`, `user_id`, `group_id`) VALUES ('1', '1', '1');
INSERT INTO `admin_users_groups` (`id`, `user_id`, `group_id`) VALUES ('2', '2', '2');
INSERT INTO `admin_users_groups` (`id`, `user_id`, `group_id`) VALUES ('3', '3', '3');
INSERT INTO `admin_users_groups` (`id`, `user_id`, `group_id`) VALUES ('4', '4', '4');



