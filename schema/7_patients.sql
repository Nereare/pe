CREATE TABLE IF NOT EXISTS `patients` (
  -- Internal ID
  `id`                  INT UNSIGNED NOT NULL AUTO_INCREMENT,
  -- Identification
  `name_prefix`         VARCHAR(8) DEFAULT NULL,
  `first_name`          VARCHAR(128) NOT NULL,
  `last_name`           VARCHAR(256) NOT NULL,
  `social_name`         VARCHAR(128) DEFAULT NULL,
  `name_suffix`         VARCHAR(32) DEFAULT NULL,
  `birth`               DATE NOT NULL,
  `bio_sex`             ENUM('female', 'male', 'intersex') NOT NULL,
  `gender`              VARCHAR(32) NOT NULL,
  `sexual_orientation`  VARCHAR(32) DEFAULT NULL,
  `race`                ENUM('branca', 'preta', 'parda', 'amarela', 'indígena') NOT NULL,
  `ethnicity`           INT UNSIGNED DEFAULT NULL,
  `religion`            VARCHAR(64) DEFAULT NULL,
  -- Progeny
  `mother`              VARCHAR(256) NOT NULL,
  `father`              VARCHAR(256) DEFAULT NULL,
  -- Brazil ID Documents
  `rg_id`               VARCHAR(16) NOT NULL,
  `rg_emitter`          VARCHAR(8) NOT NULL,
  `rg_state`            CHAR(2) NOT NULL,
  `cpf`                 CHAR(11) NOT NULL,
  `cns`                 VARCHAR(16) DEFAULT NULL,
  -- Contact Information
  --   Address
  `address_street`      VARCHAR(256) NOT NULL,
  `address_number`      VARCHAR(8) NOT NULL,
  `address_complement`  VARCHAR(16) DEFAULT NULL,
  `address_shire`       VARCHAR(64) DEFAULT NULL,
  `address_city`        VARCHAR(64) NOT NULL,
  `address_state`       CHAR(2) NOT NULL,
  `postcode`            VARCHAR(16) NOT NULL,
  `country`             VARCHAR(16) NOT NULL,
  --   Phone
  `home_phone`          VARCHAR(32) DEFAULT NULL,
  `mobile_phone`        VARCHAR(32) DEFAULT NULL,
  `other_phone`         VARCHAR(32) DEFAULT NULL,
  `emergency_phone`     VARCHAR(32) DEFAULT NULL,
  `emergency_name`      VARCHAR(128) DEFAULT NULL,
  `emergency_relation`  VARCHAR(128) DEFAULT NULL,
  --   Email
  `email`               VARCHAR(256) NOT NULL,
  `backup_email`        VARCHAR(256) DEFAULT NULL,
  -- Work & Education
  `education_level`     INT UNSIGNED NOT NULL DEFAULT 0,
  `occupation`          INT UNSIGNED DEFAULT NULL,
  -- Access
  `has_user_panel`      BOOLEAN NOT NULL DEFAULT FALSE,
  -- Death
  `death_date`          DATE DEFAULT NULL,
  `death_cause`         VARCHAR(512) DEFAULT NULL,
  -- Keys
  PRIMARY KEY (`id`),
  UNIQUE KEY (`cpf`),
  UNIQUE KEY (`cns`),
  FOREIGN KEY (`ethnicity`) REFERENCES `ethnicities`(`id`),
  FOREIGN KEY (`education_level`) REFERENCES `education_levels`(`id`),
  FOREIGN KEY (`occupation`) REFERENCES `occupations`(`id`)
);
