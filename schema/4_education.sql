CREATE TABLE IF NOT EXISTS `education_levels` (
  `id`    INT UNSIGNED NOT NULL,
  `name`  VARCHAR(64) NOT NULL,
  PRIMARY KEY (`id`)
);

INSERT INTO `education_levels` (`id`, `name`) VALUES (1, 'Analfabeto');
INSERT INTO `education_levels` (`id`, `name`) VALUES (2, 'Até 5º Ano Incompleto');
INSERT INTO `education_levels` (`id`, `name`) VALUES (3, '5º Ano Completo');
INSERT INTO `education_levels` (`id`, `name`) VALUES (4, '6º ao 9º Ano do Fundamental');
INSERT INTO `education_levels` (`id`, `name`) VALUES (5, 'Fundamental Completo');
INSERT INTO `education_levels` (`id`, `name`) VALUES (6, 'Médio Incompleto');
INSERT INTO `education_levels` (`id`, `name`) VALUES (7, 'Médio Completo');
INSERT INTO `education_levels` (`id`, `name`) VALUES (8, 'Superior Incompleto');
INSERT INTO `education_levels` (`id`, `name`) VALUES (9, 'Superior Completo');
INSERT INTO `education_levels` (`id`, `name`) VALUES (10, 'Mestrado');
INSERT INTO `education_levels` (`id`, `name`) VALUES (11, 'Doutorado');
INSERT INTO `education_levels` (`id`, `name`) VALUES (0, 'Ignorado');