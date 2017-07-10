CREATE TABLE `__PREFIX__redfinch_optim_logs` (
  `logID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `taskID` int(11) unsigned NOT NULL,
  `logLevel` varchar(255) NOT NULL DEFAULT '',
  `logMessage` text NOT NULL,
  `logCreated` datetime NOT NULL,
  PRIMARY KEY (`logID`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

CREATE TABLE `__PREFIX__redfinch_optim_settings` (
  `settingKey` varchar(255) NOT NULL DEFAULT '',
  `settingValue` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `__PREFIX__redfinch_optim_tasks` (
  `taskID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `taskFile` varchar(255) NOT NULL DEFAULT '',
  `taskPath` varchar(255) NOT NULL DEFAULT '',
  `taskPreSize` int(11) NOT NULL DEFAULT '0',
  `taskPostSize` int(11) NOT NULL DEFAULT '0',
  `taskStatus` enum('OK','WAITING','FAILED') NOT NULL DEFAULT 'WAITING',
  `taskStart` int(11) unsigned NOT NULL DEFAULT '0',
  `taskEnd` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`taskID`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
