SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

DROP TABLE IF EXISTS `eva_group_categories`;
CREATE TABLE IF NOT EXISTS `eva_group_categories` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `categoryName` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `urlName` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `parentId` int(10) NOT NULL DEFAULT '0',
  `rootId` int(10) NOT NULL DEFAULT '0',
  `orderNumber` int(10) NOT NULL DEFAULT '0',
  `createTime` datetime NOT NULL,
  `count` int(10) NOT NULL DEFAULT '0',
  `left` int(15) NOT NULL DEFAULT '0',
  `right` int(15) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `eva_group_categories_groups`;
CREATE TABLE IF NOT EXISTS `eva_group_categories_groups` (
  `category_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  PRIMARY KEY (`category_id`,`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `eva_group_counts`;
CREATE TABLE IF NOT EXISTS `eva_group_counts` (
  `group_id` int(20) NOT NULL,
  `memberCount` int(5) NOT NULL DEFAULT '0',
  PRIMARY KEY (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `eva_group_groups`;
CREATE TABLE IF NOT EXISTS `eva_group_groups` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `groupKey` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `groupName` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('active','pending','deleted') COLLATE utf8_unicode_ci NOT NULL,
  `summary` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(10) NOT NULL,
  `createTime` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `eva_group_groups_files`;
CREATE TABLE IF NOT EXISTS `eva_group_groups_files` (
  `group_id` int(11) NOT NULL,
  `file_id` int(11) NOT NULL,
  PRIMARY KEY (`group_id`,`file_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `eva_group_groups_users`;
CREATE TABLE IF NOT EXISTS `eva_group_groups_users` (
  `user_id` int(10) NOT NULL,
  `group_id` int(10) NOT NULL,
  `role` enum('admin','member') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'member',
  `requestStatus` enum('pending','refused','active','blocked') COLLATE utf8_unicode_ci NOT NULL,
  `requestTime` datetime NOT NULL,
  `approvalTime` datetime DEFAULT NULL,
  `refusedTime` int(11) DEFAULT NULL,
  `blockedTime` int(11) DEFAULT NULL,
  `operator_id` int(10) NOT NULL,
  PRIMARY KEY (`user_id`,`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
