ALTER TABLE  `users` CHANGE  `slug`  `slug` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE  `users` ADD  `first_name` VARCHAR( 30 ) NOT NULL AFTER  `password_token` , ADD  `last_name` VARCHAR( 30 ) NOT NULL AFTER  `first_name`;
