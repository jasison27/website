drop database if exists `forum`;
create database if not exists `forum`;

use `forum`;

CREATE TABLE IF NOT EXISTS `article` (
  `pid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` varchar(16) DEFAULT NULL,
  `ptime` datetime DEFAULT NULL,
  `title` varchar(40) DEFAULT NULL,
  `content` text,
  PRIMARY KEY (`pid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `cnotice` (
  `cnid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fid` varchar(16) NOT NULL,
  `pid` int(10) unsigned NOT NULL,
  `ptime` datetime NOT NULL,
  `isread` varchar(2) NOT NULL,
  PRIMARY KEY (`cnid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `comment` (
  `cid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(10) unsigned DEFAULT NULL,
  `uid` varchar(16) DEFAULT NULL,
  `ptime` datetime DEFAULT NULL,
  `content` text,
  PRIMARY KEY (`cid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `message` (
  `mid` int(10) NOT NULL AUTO_INCREMENT,
  `toid` varchar(16) DEFAULT NULL,
  `foid` varchar(16) DEFAULT NULL,
  `ptime` datetime DEFAULT NULL,
  `content` text,
  `isread` varchar(1) NOT NULL,
  `isprivate` varchar(1) NOT NULL,
  PRIMARY KEY (`mid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `praise` (
  `uid` varchar(16) NOT NULL DEFAULT '',
  `pid` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid`,`pid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `profile` (
  `uid` varchar(16) NOT NULL,
  `realname` varchar(20) DEFAULT NULL,
  `contact` varchar(20) DEFAULT NULL,
  `signature` text,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `user` (
  `uid` varchar(16) NOT NULL,
  `passwd` char(40) NOT NULL,
  `isadmin` char(1) NOT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `visitor` (
  `vid` int(16) unsigned NOT NULL AUTO_INCREMENT,
  `uid` varchar(16) NOT NULL,
  `vtime` datetime DEFAULT NULL,
  PRIMARY KEY (`vid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
