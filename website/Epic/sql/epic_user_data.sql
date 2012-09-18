-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2012 年 09 月 18 日 09:23
-- 服务器版本: 5.5.16
-- PHP 版本: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `eva`
--

-- --------------------------------------------------------

--
-- 表的结构 `eva_user_accounts`
--

DROP TABLE IF EXISTS `eva_user_accounts`;
CREATE TABLE IF NOT EXISTS `eva_user_accounts` (
  `user_id` int(11) NOT NULL,
  `credits` decimal(10,2) NOT NULL DEFAULT '0.00',
  `points` decimal(10,2) NOT NULL DEFAULT '0.00',
  `discount` decimal(5,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `eva_user_accounts`
--

INSERT INTO `eva_user_accounts` (`user_id`, `credits`, `points`, `discount`) VALUES
(253, 0.00, 0.00, 0.00);

-- --------------------------------------------------------

--
-- 表的结构 `eva_user_fieldoptions`
--

DROP TABLE IF EXISTS `eva_user_fieldoptions`;
CREATE TABLE IF NOT EXISTS `eva_user_fieldoptions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `field_id` int(11) unsigned NOT NULL,
  `label` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `option` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `order` smallint(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `field_id` (`field_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=75 ;

--
-- 转存表中的数据 `eva_user_fieldoptions`
--

INSERT INTO `eva_user_fieldoptions` (`id`, `field_id`, `label`, `option`, `order`) VALUES
(1, 2, 'Gastronomy and Fine Dining', 'Gastronomy and Fine Dining', 0),
(2, 2, 'Wine(oenology)', 'Wine(oenology)', 0),
(3, 2, 'Fine Spirit: Rhum, Cognac, Armagnac, Whisky, Vodka, Gin', 'Fine Spirit: Rhum, Cognac, Armagnac, Whisky, Vodka, Gin', 0),
(4, 2, 'Cocktails', 'Cocktails', 0),
(5, 2, 'Cigar', 'Cigar', 0),
(6, 2, 'Cooking', 'Cooking', 0),
(7, 2, 'Photographing food', 'Photographing food', 0),
(8, 2, 'Others', 'Others', 0),
(9, 3, 'Events(cocktail parties, wine tasting, tea party...)', 'Events(cocktail parties, wine tasting, tea party...)', 0),
(10, 3, 'Exhibitions', 'Exhibitions', 0),
(11, 3, 'Wine Trips', 'Wine Trips', 0),
(12, 3, 'Buying and collection Advices', 'Buying and collection Advices', 0),
(13, 3, 'Photo sharing', 'Photo sharing', 0),
(14, 3, 'Cooking classes', 'Cooking classes', 0),
(15, 3, 'Insider opinions sharing(locating new spots for dining, drinking.)', 'Insider opinions sharing(locating new spots for dining, drinking.)', 0),
(16, 3, 'Others', 'Others', 0),
(17, 5, 'Food, Wine and Spirit Production', 'Food, Wine and Spirit Production', 0),
(18, 5, 'Hospitality', 'Hospitality', 0),
(19, 5, 'Restaurant, bar and club', 'Restaurant, bar and club', 0),
(20, 5, 'Distribution and Trade', 'Distribution and Trade', 0),
(21, 5, 'Media and Press', 'Media and Press', 0),
(22, 5, 'Marketing and Communication', 'Marketing and Communication', 0),
(23, 5, 'Consultancy', 'Consultancy', 0),
(24, 5, 'Educational Institution', 'Educational Institution', 0),
(25, 5, 'Research and Development', 'Research and Development', 0),
(26, 5, 'Other', 'Other', 0),
(27, 6, 'Exhibition', 'exhibition', 0),
(28, 6, 'Business network events', 'business network events', 0),
(29, 6, 'Branding', 'branding', 0),
(30, 6, 'Business partners, Merge and Acquisition', 'Business partners, Merge and Acquisition', 0),
(31, 6, 'Talents search and recruiting', 'Talents search and recruiting', 0),
(32, 6, 'Consulting Services', 'Consulting Services', 0),
(33, 6, 'Financial Services', 'Financial Services', 0),
(34, 6, 'Other', 'Other', 0),
(35, 7, 'Jobs, internship Opportunities', 'Jobs, internship Opportunities', 0),
(36, 7, 'Exhibitions, Events', 'Exhibitions, Events', 0),
(37, 7, 'Distribution and International Trade', 'Distribution and International Trade', 0),
(38, 7, 'Consulting Service', 'Consulting Service', 0),
(39, 7, 'Talents search and recruiting', 'Talents search and recruiting', 0),
(40, 7, 'Consulting Services', 'Consulting Services', 0),
(41, 7, 'Financial Services', 'Financial Services', 0),
(42, 7, 'Other', 'Other', 0),
(43, 10, 'Food, Wine and Spirit Production', 'Food, Wine and Spirit Production', 0),
(44, 10, 'Hospitality', 'Hospitality', 0),
(45, 10, 'Restaurant, bar and club', 'Restaurant, bar and club', 0),
(46, 10, 'Distribution and Trade', 'Distribution and Trade', 0),
(47, 10, 'Media and Press', 'Media and Press', 0),
(48, 10, 'Marketing and Communication', 'Marketing and Communication', 0),
(49, 10, 'Consultancy', 'Consultancy', 0),
(50, 10, 'Educational Institution', 'Educational Institution', 0),
(51, 10, 'Research and Development', 'Research and Development', 0),
(52, 10, 'Other', 'Other', 0),
(53, 11, 'Jobs and Intern Opportunities', 'Jobs and Intern Opportunities', 0),
(54, 11, 'Social Network Opportunities', 'Social Network Opportunities', 0),
(55, 11, 'Others', 'Others', 0),
(56, 12, 'Chef, Sommelier, Mixologist barman', 'Chef, Sommelier, Mixologist barman', 0),
(57, 12, 'hospitality', 'hospitality', 0),
(58, 12, 'Restaurant and bar management', 'Restaurant and bar management', 0),
(59, 12, 'Distribution, Logistics, and trade', 'Distribution, Logistics, and trade', 0),
(60, 12, 'Public Communication', 'Public Communication', 0),
(61, 12, 'Marketing and Promotion', 'Marketing and Promotion', 0),
(62, 12, 'Events Planning', 'Events Planning', 0),
(63, 12, 'Consultancy', 'Consultancy', 0),
(64, 12, 'Financial Service(seed funding, venture capital. Insurance)', 'Financial Service(seed funding, venture capital. Insurance)', 0),
(65, 12, 'Design', 'Design', 0),
(72, 13, 'Mr.', 'Mr.', 0),
(73, 13, 'Miss.', 'Miss.', 0),
(74, 13, 'Mrs', 'Mrs', 0);

-- --------------------------------------------------------

--
-- 表的结构 `eva_user_fields`
--

DROP TABLE IF EXISTS `eva_user_fields`;
CREATE TABLE IF NOT EXISTS `eva_user_fields` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `fieldName` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `fieldKey` varchar(24) COLLATE utf8_unicode_ci NOT NULL,
  `fieldType` enum('text','radio','select','multiCheckbox','number','email','textarea','url') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'text',
  `label` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `applyToAll` tinyint(1) NOT NULL DEFAULT '0',
  `required` tinyint(1) NOT NULL DEFAULT '0',
  `display` tinyint(1) unsigned NOT NULL,
  `order` smallint(3) unsigned NOT NULL DEFAULT '0',
  `defaultValue` text COLLATE utf8_unicode_ci NOT NULL,
  `config` text COLLATE utf8_unicode_ci,
  `validators` text COLLATE utf8_unicode_ci,
  `filters` text COLLATE utf8_unicode_ci,
  `style` text COLLATE utf8_unicode_ci,
  `error` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=14 ;

--
-- 转存表中的数据 `eva_user_fields`
--

INSERT INTO `eva_user_fields` (`id`, `fieldName`, `fieldKey`, `fieldType`, `label`, `description`, `applyToAll`, `required`, `display`, `order`, `defaultValue`, `config`, `validators`, `filters`, `style`, `error`) VALUES
(1, 'Hobbies(Connoisseur)', 'Hobbies', 'text', 'Hobbies', '', 0, 0, 1, 0, '', NULL, NULL, NULL, NULL, NULL),
(2, 'Central Interests(Connoisseur)', 'CentralInterests', 'multiCheckbox', 'Central Interests', '', 0, 0, 1, 0, '', NULL, NULL, NULL, NULL, NULL),
(3, 'You might interested in(Connoisseur)', 'YouMightInterestedIn', 'multiCheckbox', 'You might interested in', '', 0, 0, 1, 0, '', NULL, NULL, NULL, NULL, NULL),
(4, 'Company Name(Corporate)', 'CompanyName', 'text', 'Company Name', '', 0, 0, 1, 0, '', NULL, NULL, NULL, NULL, NULL),
(5, 'Industry(Corporate)', 'IndustryIndustrie', 'select', 'Industry', '', 0, 0, 1, 0, '', NULL, NULL, NULL, NULL, NULL),
(6, 'How could we help you?(Corporate)', 'HowCouldWehelpYou', 'multiCheckbox', 'How could we help you?', '', 0, 0, 1, 0, '', NULL, NULL, NULL, NULL, NULL),
(7, 'What you are offering?(Corporate)', 'WhatYouAreOffering', 'multiCheckbox', 'What you are offering?', '', 0, 0, 1, 0, '', NULL, NULL, NULL, NULL, NULL),
(8, 'Hobbies(Professional)', 'Hobbies', 'text', 'Hobbies', '', 0, 0, 1, 0, '', NULL, NULL, NULL, NULL, NULL),
(9, 'School(Professional)', 'School', 'text', 'School', '', 0, 0, 1, 0, '', NULL, NULL, NULL, NULL, NULL),
(10, 'Industry(Professional)', 'IndustryIndustrie', 'select', 'Industry', '', 0, 0, 1, 0, '', NULL, NULL, NULL, NULL, NULL),
(11, 'How could we help you?(Professional)', 'HowCouldWehelpYou', 'multiCheckbox', 'How could we help you?', '', 0, 0, 1, 0, '', NULL, NULL, NULL, NULL, NULL),
(12, 'Your Expertise(Professional)', 'YourExpertise', 'multiCheckbox', 'Your Expertise', '', 0, 0, 1, 0, '', NULL, NULL, NULL, NULL, NULL),
(13, 'Title', 'aQR7Jv', 'select', 'Title', '', 1, 0, 0, 0, '', NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `eva_user_fields_roles`
--

DROP TABLE IF EXISTS `eva_user_fields_roles`;
CREATE TABLE IF NOT EXISTS `eva_user_fields_roles` (
  `field_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  PRIMARY KEY (`field_id`,`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `eva_user_fields_roles`
--

INSERT INTO `eva_user_fields_roles` (`field_id`, `role_id`) VALUES
(1, 12),
(2, 12),
(3, 12),
(4, 11),
(5, 11),
(6, 11),
(7, 11),
(8, 13),
(9, 13),
(10, 13),
(11, 13),
(12, 13);

-- --------------------------------------------------------

--
-- 表的结构 `eva_user_fieldvalues`
--

DROP TABLE IF EXISTS `eva_user_fieldvalues`;
CREATE TABLE IF NOT EXISTS `eva_user_fieldvalues` (
  `field_id` int(11) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL DEFAULT '0',
  `value` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`field_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `eva_user_friends`
--

DROP TABLE IF EXISTS `eva_user_friends`;
CREATE TABLE IF NOT EXISTS `eva_user_friends` (
  `from_user_id` int(10) NOT NULL,
  `to_user_id` int(10) NOT NULL,
  `relationShipStatus` enum('pending','refused','active','blocked') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'pending',
  `requestTime` datetime NOT NULL,
  `approcalTime` datetime DEFAULT NULL,
  `refusedTime` datetime DEFAULT NULL,
  `blockedTime` datetime DEFAULT NULL,
  PRIMARY KEY (`from_user_id`,`to_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `eva_user_oauths`
--

DROP TABLE IF EXISTS `eva_user_oauths`;
CREATE TABLE IF NOT EXISTS `eva_user_oauths` (
  `user_id` int(10) NOT NULL,
  `appType` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `tokenSecret` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `version` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `refreshToken` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `refreshTime` datetime DEFAULT NULL,
  `expireTime` datetime DEFAULT NULL,
  `appUserId` bigint(20) DEFAULT NULL,
  `appUserName` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `appExt` mediumtext COLLATE utf8_unicode_ci,
  PRIMARY KEY (`user_id`,`appType`,`token`,`tokenSecret`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `eva_user_options`
--

DROP TABLE IF EXISTS `eva_user_options`;
CREATE TABLE IF NOT EXISTS `eva_user_options` (
  `user_id` int(10) NOT NULL,
  `optionKey` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `optionValue` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`user_id`,`optionKey`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `eva_user_profiles`
--

DROP TABLE IF EXISTS `eva_user_profiles`;
CREATE TABLE IF NOT EXISTS `eva_user_profiles` (
  `user_id` int(10) NOT NULL,
  `site` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `photoDir` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `photoName` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fullName` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `height` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `weight` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `country` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `addressMore` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `province` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `state` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `zipcode` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `degree` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `industry` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phoneBusiness` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phoneMobile` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phoneHome` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fax` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `signature` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `longitude` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `latitude` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `location` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bio` text COLLATE utf8_unicode_ci,
  `localIm` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `internalIm` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `otherIm` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `eva_user_profiles`
--

INSERT INTO `eva_user_profiles` (`user_id`, `site`, `photoDir`, `photoName`, `fullName`, `birthday`, `height`, `weight`, `country`, `address`, `addressMore`, `city`, `province`, `state`, `zipcode`, `degree`, `industry`, `phoneBusiness`, `phoneMobile`, `phoneHome`, `fax`, `signature`, `longitude`, `latitude`, `location`, `bio`, `localIm`, `internalIm`, `otherIm`) VALUES
(253, '', '', '', '', '0000-00-00', '', '', '001', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- 表的结构 `eva_user_roles`
--

DROP TABLE IF EXISTS `eva_user_roles`;
CREATE TABLE IF NOT EXISTS `eva_user_roles` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `roleKey` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `roleName` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=14 ;

--
-- 转存表中的数据 `eva_user_roles`
--

INSERT INTO `eva_user_roles` (`id`, `roleKey`, `roleName`, `description`) VALUES
(1, 'ADMIN', 'Admin', ''),
(2, 'USER', 'User', ''),
(3, 'GUEST', 'Guest', ''),
(11, 'CORPORATE_MEMBER', 'Corporate Member', ''),
(12, 'CONNOISSEUR_MEMBER', 'Connoisseur Member', ''),
(13, 'PROFESSIONAL_MEMBER', 'Professional Member', '');

-- --------------------------------------------------------

--
-- 表的结构 `eva_user_roles_users`
--

DROP TABLE IF EXISTS `eva_user_roles_users`;
CREATE TABLE IF NOT EXISTS `eva_user_roles_users` (
  `role_id` int(5) NOT NULL,
  `user_id` int(10) NOT NULL,
  `status` enum('active','pending','expired') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'pending',
  `pendingTime` datetime DEFAULT NULL,
  `activeTime` datetime DEFAULT NULL,
  `expiredTime` datetime DEFAULT NULL,
  PRIMARY KEY (`role_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `eva_user_roles_users`
--

INSERT INTO `eva_user_roles_users` (`role_id`, `user_id`, `status`, `pendingTime`, `activeTime`, `expiredTime`) VALUES
(11, 253, 'pending', NULL, NULL, NULL),
(12, 253, 'pending', NULL, NULL, NULL),
(13, 253, 'pending', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `eva_user_tags`
--

DROP TABLE IF EXISTS `eva_user_tags`;
CREATE TABLE IF NOT EXISTS `eva_user_tags` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `tagName` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `language` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'en',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `eva_user_tags_users`
--

DROP TABLE IF EXISTS `eva_user_tags_users`;
CREATE TABLE IF NOT EXISTS `eva_user_tags_users` (
  `user_id` int(10) NOT NULL,
  `tag_id` int(10) NOT NULL,
  `createTime` datetime NOT NULL,
  `orderNumber` int(5) NOT NULL,
  PRIMARY KEY (`user_id`,`tag_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `eva_user_users`
--

DROP TABLE IF EXISTS `eva_user_users`;
CREATE TABLE IF NOT EXISTS `eva_user_users` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `userName` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(320) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` enum('active','deleted','inactive') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'active',
  `screenName` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `salt` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `firstName` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lastName` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `oldPassword` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lastPasswordChangeTime` datetime DEFAULT NULL,
  `gender` enum('male','female','other') COLLATE utf8_unicode_ci DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `timezone` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `registerTime` datetime DEFAULT NULL,
  `lastLoginTime` datetime DEFAULT NULL,
  `language` varchar(10) COLLATE utf8_unicode_ci DEFAULT 'en',
  `setting` int(10) NOT NULL DEFAULT '0',
  `inviteUserId` int(10) DEFAULT '0',
  `onlineStatus` enum('online','busy','invisible','offline') COLLATE utf8_unicode_ci DEFAULT 'offline',
  `lastFleshTime` datetime DEFAULT NULL,
  `viewCount` bigint(20) NOT NULL DEFAULT '0',
  `registerIp` varbinary(16) DEFAULT NULL,
  `lastLoginIp` varbinary(16) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=254 ;

--
-- 转存表中的数据 `eva_user_users`
--

INSERT INTO `eva_user_users` (`id`, `userName`, `email`, `status`, `screenName`, `salt`, `firstName`, `lastName`, `password`, `oldPassword`, `lastPasswordChangeTime`, `gender`, `avatar`, `timezone`, `registerTime`, `lastLoginTime`, `language`, `setting`, `inviteUserId`, `onlineStatus`, `lastFleshTime`, `viewCount`, `registerIp`, `lastLoginIp`) VALUES
(253, 'AlloVince', '', 'active', '', '6ZJVR3juYjeqMnYRF3', '', '', '', '', NULL, 'other', '', 'Etc/Unknown', NULL, NULL, 'aa', 0, 0, 'offline', NULL, 0, NULL, NULL);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
