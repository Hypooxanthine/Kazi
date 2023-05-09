DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category`
(
  `idCategory` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  PRIMARY KEY (`idCategory`),
  UNIQUE KEY `name` (`name`)
);

DROP TABLE IF EXISTS `question`;
CREATE TABLE IF NOT EXISTS `question` (
  `idQuestion` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `nbTokens` int UNSIGNED NOT NULL,
  `imagePath` varchar(100) DEFAULT NULL,
  `badTokenIndex` int UNSIGNED NOT NULL,
  `correctToken` varchar(50) NOT NULL,
  `idCategory` int UNSIGNED NOT NULL,
  PRIMARY KEY (`idQuestion`)
);

DROP TABLE IF EXISTS `token`;
CREATE TABLE IF NOT EXISTS `token` (
  `idToken` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `content` varchar(50) NOT NULL,
  `tokenIndex` int UNSIGNED NOT NULL,
  `idQuestion` int UNSIGNED NOT NULL,
  PRIMARY KEY (`idToken`)
);
