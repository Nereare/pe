CREATE TABLE IF NOT EXISTS `posts` (
  `id`            INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `author`        INT UNSIGNED NOT NULL,
  `published`     DATE NOT NULL,
  `edited`        DATE,
  `title`         VARCHAR(100) NOT NULL,
  `tags`          VARCHAR(255),
  `category`      VARCHAR(64),
  `header`        VARCHAR(512),
  `body`          MEDIUMTEXT NOT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS `pages` (
  `id`            INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `author`        INT UNSIGNED NOT NULL,
  `name`          VARCHAR(100) NOT NULL,
  `published`     DATE NOT NULL,
  `edited`        DATE,
  `body`          MEDIUMTEXT NOT NULL,
  PRIMARY KEY (`id`)
);
