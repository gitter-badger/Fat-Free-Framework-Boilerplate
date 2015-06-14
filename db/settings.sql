CREATE TABLE `settings` (
  `key`   VARCHAR(50) NOT NULL,
  `value` TEXT        NULL,
  PRIMARY KEY (`key`)
)
  COLLATE = 'utf8_general_ci'
  ENGINE = InnoDB;

INSERT INTO `settings` (`key`, `value`) VALUES ('site.name', 'Fat Free MVC and HMVC Boilerplate');
INSERT INTO `settings` (`key`, `value`) VALUES ('site.description', 'This is Project Description');
INSERT INTO `settings` (`key`, `value`) VALUES ('site.test', '{"name":"Test Settings","type":"string"}');
INSERT INTO `settings` (`key`, `value`) VALUES ('DEBUG', '3');
INSERT INTO `settings` (`key`, `value`) VALUES ('CACHE', '1');