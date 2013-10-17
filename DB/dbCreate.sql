CREATE TABLE `knowledge_base` (
  `ngram` varchar(10) NOT NULL,
  `belongs` varchar(10) NOT NULL,
  `repite` int(11) NOT NULL,
  `percent` float NOT NULL,
  PRIMARY KEY (`ngram`,`belongs`),
  KEY `repite` (`repite`)
) ENGINE=MyISAM;
CREATE  TABLE `grabr`.`exclusions` (

  `id` INT NOT NULL AUTO_INCREMENT ,

  `domain` VARCHAR(145) NULL ,

  PRIMARY KEY (`id`) )

COMMENT = 'A list of sites that do not follow normal API rules';
CREATE  TABLE `grabr`.`functions` (

  `id` INT NOT NULL AUTO_INCREMENT ,

  `exclusion_id` INT NULL ,

  `function` VARCHAR(75) NULL ,

  PRIMARY KEY (`id`) )

COMMENT = 'Functions to use for excluded domains';

