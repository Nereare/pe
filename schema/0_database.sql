CREATE DATABASE IF NOT EXISTS `pe`
  CHARACTER SET = utf8mb4
  COLLATE = utf8mb4_0900_ai_ci;
CREATE USER IF NOT EXISTS
  'pe'@'localhost'
  IDENTIFIED BY 'pe'
  FAILED_LOGIN_ATTEMPTS 3
  PASSWORD_LOCK_TIME 7;
GRANT ALL ON `pe`.* TO 'pe'@'localhost';

USE `pe`;
