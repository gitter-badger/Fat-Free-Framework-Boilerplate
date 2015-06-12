CREATE TABLE `user` (
  `id`           SMALLINT(6) NOT NULL AUTO_INCREMENT,
  `login`        VARCHAR(32) NULL     DEFAULT NULL,
  `email`        VARCHAR(64) NULL     DEFAULT NULL,
  `username`     VARCHAR(32) NULL     DEFAULT NULL,
  `password`     CHAR(60)    NULL     DEFAULT NULL,
  `language`     VARCHAR(5)  NULL     DEFAULT NULL,
  `created_date` DATETIME    NOT NULL,
  `deleted_date` DATETIME    NULL     DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `login` (`login`),
  UNIQUE INDEX `email` (`email`)
)
  COLLATE = 'utf8_general_ci'
  ENGINE = InnoDB;

INSERT INTO `user` (`id`, `login`, `email`, `username`, `password`, `language`, `created_date`, `deleted_date`) VALUES
  (1, 'admin', 'admin@mvc.local', 'Admin', '$2y$10$7ftcJlx6FSfM6hOSKbXbK.W68d.APjJmv7wx4LEKekcH/Si/q2h9C', 'ru',
   '2015-06-13 00:34:01', NULL);