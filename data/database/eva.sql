SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;


CREATE TABLE IF NOT EXISTS `eva_activity_atindexes` (
  `atuser_id` int(10) NOT NULL,
  `message_id` bigint(30) NOT NULL,
  `messageTime` datetime NOT NULL,
  PRIMARY KEY (`atuser_id`,`message_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `eva_activity_atusers` (
  `message_id` int(30) NOT NULL,
  `user_id` int(10) NOT NULL,
  KEY `message_id` (`message_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `eva_activity_followers` (
  `user_id` int(10) NOT NULL,
  `follower_id` int(10) NOT NULL,
  `relationshipStatus` enum('single','double') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'single',
  `followTime` datetime NOT NULL,
  PRIMARY KEY (`user_id`,`follower_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `eva_activity_indexes` (
  `user_id` int(10) NOT NULL,
  `author_id` int(10) NOT NULL,
  `message_id` bigint(32) NOT NULL,
  `messageTime` datetime NOT NULL,
  PRIMARY KEY (`user_id`,`author_id`,`message_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `eva_activity_messages` (
  `id` bigint(32) NOT NULL AUTO_INCREMENT,
  `messageHash` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `messageType` enum('original','comment','forword') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'original',
  `content` varchar(280) COLLATE utf8_unicode_ci NOT NULL,
  `connect_id` bigint(32) NOT NULL DEFAULT '0',
  `status` enum('active','pending','deleted') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'active',
  `user_id` int(10) NOT NULL,
  `commentedCount` int(10) NOT NULL DEFAULT '0',
  `transferredCount` int(10) NOT NULL DEFAULT '0',
  `createTime` datetime NOT NULL,
  `sourceId` int(5) NOT NULL DEFAULT '0',
  `sourceName` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'web',
  `resourceIdString` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `atUserIdString` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `eva_activity_references` (
  `original_user_id` int(11) NOT NULL,
  `original_message_id` int(11) NOT NULL,
  `reference_user_id` int(11) NOT NULL,
  `reference_message_id` int(11) NOT NULL,
  `referenceType` enum('comment','forword') COLLATE utf8_unicode_ci NOT NULL,
  `referenceTime` datetime NOT NULL,
  PRIMARY KEY (`reference_user_id`,`reference_message_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `eva_activity_sources` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `sourceName` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `sourceUrl` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `eva_album_albums` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `urlName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `visibility` enum('public','private','password') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'public',
  `description` text COLLATE utf8_unicode_ci,
  `visitPassword` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_id` int(10) NOT NULL,
  `user_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `orderNumber` int(10) DEFAULT NULL,
  `createTime` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `eva_album_categories` (
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `eva_album_categories_albums` (
  `album_id` int(10) NOT NULL,
  `category_id` int(10) NOT NULL,
  PRIMARY KEY (`album_id`,`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `eva_blog_categories` (
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `eva_blog_categories_posts` (
  `category_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  PRIMARY KEY (`category_id`,`post_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `eva_blog_comments` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `status` enum('approved','pending','spam','deleted') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'pending',
  `post_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `user_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `screen_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `site` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ip` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `createTime` datetime NOT NULL,
  `editor_id` int(10) DEFAULT NULL,
  `editor_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `editor_screenname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `rootId` int(10) DEFAULT NULL,
  `parentId` int(10) DEFAULT NULL,
  `commentRank` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `eva_blog_posts` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('deleted','draft','published','pending') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'published',
  `visibility` enum('public','private','password') COLLATE utf8_unicode_ci NOT NULL,
  `codeType` enum('markdown','html','wiki','ubb','other') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'markdown',
  `language` varchar(5) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'en',
  `parentId` tinyint(1) NOT NULL DEFAULT '0',
  `connect_id` int(10) DEFAULT NULL,
  `trackback` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `urlName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `preview` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `orderNumber` int(10) DEFAULT NULL,
  `setting` int(10) NOT NULL DEFAULT '0',
  `createTime` datetime NOT NULL,
  `user_id` int(10) NOT NULL,
  `user_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `updateTime` datetime DEFAULT NULL,
  `editor_id` int(10) DEFAULT NULL,
  `editor_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `postPassword` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `commentStatus` enum('open','closed','authority') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'open',
  `commentType` enum('local','disqus','youyan','duoshuo') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'local',
  `commentCount` int(10) NOT NULL DEFAULT '0',
  `viewCount` bigint(20) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `eva_blog_posts_old` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('deleted','draft','published','pending') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'published',
  `visibility` enum('public','private','password') COLLATE utf8_unicode_ci NOT NULL,
  `codeType` enum('markdown','html','wiki','ubb','other') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'markdown',
  `language` varchar(5) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'en',
  `postUsage` enum('post','page','faq','news') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'post',
  `connect_id` int(10) DEFAULT NULL,
  `trackback` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `urlName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `preview` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `orderNumber` int(10) DEFAULT NULL,
  `setting` int(10) NOT NULL DEFAULT '0',
  `createTime` datetime NOT NULL,
  `user_id` int(10) NOT NULL,
  `user_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `updateTime` datetime DEFAULT NULL,
  `editor_id` int(10) DEFAULT NULL,
  `editor_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `postPassword` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `commentStatus` enum('open','closed','authority') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'open',
  `commentType` enum('local','disqus','youyan','duoshuo') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'local',
  `commentCount` int(10) NOT NULL DEFAULT '0',
  `viewCount` bigint(20) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `eva_blog_tags` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `tagName` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `linkTo` enum('book','tag','post','page') COLLATE utf8_unicode_ci DEFAULT NULL,
  `parentId` int(10) DEFAULT NULL,
  `rootId` int(10) DEFAULT NULL,
  `orderNumber` int(10) DEFAULT NULL,
  `count` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `eva_blog_tags_posts` (
  `tag_id` int(10) NOT NULL,
  `post_id` int(10) NOT NULL,
  PRIMARY KEY (`tag_id`,`post_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `eva_blog_textarchives` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8_unicode_ci,
  `archiveTime` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `post_id` (`post_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `eva_blog_texts` (
  `post_id` int(20) NOT NULL,
  `metaKeywords` text COLLATE utf8_unicode_ci,
  `metaDescription` text COLLATE utf8_unicode_ci,
  `toc` text COLLATE utf8_unicode_ci,
  `content` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`post_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `eva_blog_texts_old` (
  `post_id` int(20) NOT NULL,
  `metaKeywords` text COLLATE utf8_unicode_ci,
  `metaDescription` text COLLATE utf8_unicode_ci,
  `toc` text COLLATE utf8_unicode_ci,
  `content` longtext COLLATE utf8_unicode_ci NOT NULL,
  `contentHtml` longtext COLLATE utf8_unicode_ci,
  `test` blob NOT NULL,
  PRIMARY KEY (`post_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `eva_core_resources` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `resourceName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `eva_core_roles_resources` (
  `operation` enum('index','get','put','post','delete') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'get',
  `role_id` int(10) NOT NULL,
  `resource_id` int(10) NOT NULL,
  PRIMARY KEY (`operation`,`role_id`,`resource_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `eva_core_sessions` (
  `session_id` char(32) COLLATE utf8_unicode_ci NOT NULL,
  `save_path` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `modified` int(11) DEFAULT NULL,
  `lifetime` int(11) DEFAULT NULL,
  `session_data` varchar(2000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_id` int(10) DEFAULT NULL,
  PRIMARY KEY (`session_id`,`save_path`,`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `eva_dict_dicts` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `word` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `wordType` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dictType` enum('jp_zh','zh_jp') COLLATE utf8_unicode_ci NOT NULL,
  `meaning` text COLLATE utf8_unicode_ci NOT NULL,
  `spelling` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `spellingAlias` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tags` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `spelling` (`spelling`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `eva_file_avatars` (
  `user_id` int(10) NOT NULL,
  `file_id` bigint(30) NOT NULL,
  PRIMARY KEY (`user_id`,`file_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `eva_file_files` (
  `id` bigint(30) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` enum('deleted','draft','published','pending') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'published',
  `isImage` tinyint(1) NOT NULL DEFAULT '0',
  `fileName` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `fileExtension` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `originalName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `configKey` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `fileServerKey` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fileServerName` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cdnServerKey` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cdnServerName` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `filePath` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `fileHash` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fileSize` bigint(20) DEFAULT NULL,
  `imageWidth` smallint(5) DEFAULT NULL,
  `imageHeight` smallint(5) DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `orderNumber` int(10) DEFAULT NULL,
  `user_id` int(10) DEFAULT NULL,
  `user_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `createTime` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `eva_file_files_connections` (
  `file_id` int(11) NOT NULL,
  `connect_id` int(11) NOT NULL,
  `connectType` varchar(50) NOT NULL,
  `orderNumber` int(5) NOT NULL DEFAULT '0',
  PRIMARY KEY (`file_id`,`connect_id`,`connectType`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `eva_file_syncs` (
  `id` bigint(40) NOT NULL AUTO_INCREMENT,
  `file_id` bigint(30) NOT NULL,
  `syncType` enum('fastDFS','googleCloud','amazonCloud','flickr') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'fastDFS',
  `syncServer` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `syncPath` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `syncFilename` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `syncExtra` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `eva_group_groups` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `groupKey` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `groupName` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('active','pending','deleted') COLLATE utf8_unicode_ci NOT NULL,
  `summary` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `creator_id` int(10) NOT NULL,
  `createTime` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `eva_group_groups_users` (
  `user_id` int(10) NOT NULL,
  `group_id` int(10) NOT NULL,
  `requestStatus` enum('pending','refused','active','blocked') COLLATE utf8_unicode_ci NOT NULL,
  `requestTime` datetime NOT NULL,
  `approvalTime` datetime DEFAULT NULL,
  `refusedTime` int(11) DEFAULT NULL,
  `blockedTime` int(11) DEFAULT NULL,
  `operator_id` int(10) NOT NULL,
  PRIMARY KEY (`user_id`,`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `eva_group_text` (
  `group_id` int(10) NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `eva_message_conversations` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sender_id` int(10) NOT NULL,
  `recipient_id` int(10) NOT NULL,
  `readFlag` tinyint(1) NOT NULL DEFAULT '0',
  `status` enum('active','pending','deleted') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'active',
  `createTime` datetime NOT NULL,
  `readTime` datetime DEFAULT NULL,
  `isBulkMessage` tinyint(1) NOT NULL DEFAULT '0',
  `message_id` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `eva_message_messages` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `conversation_id` int(10) NOT NULL,
  `body` text COLLATE utf8_unicode_ci NOT NULL,
  `readFlag` tinyint(1) NOT NULL DEFAULT '0',
  `readTime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `eva_movie_manufacturers` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `nameAlias` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nameEn` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nameZh` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `homepage` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `logo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `eva_movie_moviedownloads` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `movie_id` int(10) NOT NULL,
  `type` enum('http','torrent','emule','magnet','other') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'other',
  `url` longtext COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `eva_movie_moviepreviews` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `movie_id` int(10) NOT NULL,
  `type` enum('pic','swf','webpage') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'pic',
  `originalUrl` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `localPath` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cdnUrl` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `eva_movie_movies` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `titleAlias` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `urlName` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `identifier` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `imdb` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `language` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `country` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `isAdult` tinyint(1) NOT NULL DEFAULT '0',
  `isAnime` tinyint(1) NOT NULL DEFAULT '0',
  `cover` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `summary` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `directorIdString` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `directorNameString` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `actorIdString` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `actorNameString` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `authorIdString` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `authorNameString` varchar(400) COLLATE utf8_unicode_ci DEFAULT NULL,
  `manufacturer_id` int(10) DEFAULT NULL,
  `manufacturerName` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `series_id` int(10) DEFAULT NULL,
  `seriesTitle` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `genreIdString` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `genreNameString` varchar(400) COLLATE utf8_unicode_ci DEFAULT NULL,
  `movieYear` year(4) DEFAULT NULL,
  `saleDate` date DEFAULT NULL,
  `siteUrl` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `movieLength` int(5) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `urlName` (`urlName`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `eva_movie_staffimages` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `staff_id` int(10) NOT NULL,
  `isAdult` tinyint(1) NOT NULL DEFAULT '0',
  `originalUrl` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `localPath` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cdnUrl` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `eva_movie_staffprofiles` (
  `staff_id` int(10) NOT NULL,
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
  `measurements` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `bloodType` enum('A','B','O','AB','Other') COLLATE utf8_unicode_ci DEFAULT NULL,
  `cup` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`staff_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `eva_movie_staffs` (
  `id` int(10) NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `nameEn` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nameZh` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nameKana` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nameKanaIndex` varchar(2) COLLATE utf8_unicode_ci DEFAULT NULL,
  `isDirector` tinyint(1) NOT NULL DEFAULT '0',
  `isActor` tinyint(1) NOT NULL DEFAULT '0',
  `isAuthor` tinyint(1) NOT NULL DEFAULT '0',
  `avator` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gender` enum('male','female','other') COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `eva_movie_staffs_manufacturers` (
  `staff_id` int(10) NOT NULL,
  `manufacturer_id` int(6) NOT NULL,
  PRIMARY KEY (`staff_id`,`manufacturer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `eva_notification_indexes` (
  `user_id` int(10) NOT NULL,
  `message_id` int(10) NOT NULL,
  `readFlag` tinyint(1) NOT NULL DEFAULT '0',
  `messageTime` datetime NOT NULL,
  PRIMARY KEY (`user_id`,`message_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `eva_notification_messages` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `messageType` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'custom',
  `template_id` int(10) NOT NULL DEFAULT '0',
  `message_from_id` int(10) NOT NULL DEFAULT '0',
  `subject` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `createTime` datetime NOT NULL,
  `message` longtext COLLATE utf8_unicode_ci,
  `attachments` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `eva_notification_messages_users` (
  `message_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `sendAs` enum('to','cc','bcc') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'to',
  `sendBy` varchar(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'email',
  `sendStatus` enum('waiting','sending','sent','failed') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'waiting',
  `sendTime` datetime DEFAULT NULL,
  `readFlag` tinyint(1) NOT NULL DEFAULT '0',
  `readTime` datetime DEFAULT NULL,
  PRIMARY KEY (`message_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `eva_notification_templates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `templateKey` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `subject` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `eva_queue_queuemessages` (
  `message_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue_id` int(10) unsigned NOT NULL,
  `handle` char(32) DEFAULT NULL,
  `body` varchar(8192) NOT NULL,
  `md5` char(32) NOT NULL,
  `timeout` decimal(14,4) unsigned DEFAULT NULL,
  `created` int(10) unsigned NOT NULL,
  PRIMARY KEY (`message_id`),
  UNIQUE KEY `message_handle` (`handle`),
  KEY `message_queueid` (`queue_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `eva_queue_queues` (
  `queue_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `queue_name` varchar(100) NOT NULL,
  `timeout` smallint(5) unsigned NOT NULL DEFAULT '30',
  PRIMARY KEY (`queue_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `eva_user_accounts` (
  `user_id` int(11) NOT NULL,
  `credits` decimal(10,2) NOT NULL DEFAULT '0.00',
  `points` decimal(10,2) NOT NULL DEFAULT '0.00',
  `discount` decimal(5,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `eva_user_codes` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `code` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `codeSalt` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `codeType` enum('invite','verifyEmail','verifyMobile','other') COLLATE utf8_unicode_ci NOT NULL,
  `codeStatus` enum('active','used','expired') COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(10) NOT NULL,
  `createTime` datetime NOT NULL,
  `expiredTime` datetime DEFAULT NULL,
  `usedTime` datetime DEFAULT NULL,
  `used_by_id` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `eva_user_fieldoptions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `field_id` int(11) unsigned NOT NULL,
  `label` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `option` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `order` smallint(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `field_id` (`field_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `eva_user_fields_roles` (
  `field_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  PRIMARY KEY (`field_id`,`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `eva_user_fieldvalues` (
  `field_id` int(11) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL DEFAULT '0',
  `value` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`field_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `eva_user_friends` (
  `from_user_id` int(10) NOT NULL,
  `to_user_id` int(10) NOT NULL,
  `relationShipStatus` enum('pending','refused','active','blocked') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'pending',
  `requestTime` datetime NOT NULL,
  `approvalTime` datetime DEFAULT NULL,
  `refusedTime` datetime DEFAULT NULL,
  `blockedTime` datetime DEFAULT NULL,
  PRIMARY KEY (`from_user_id`,`to_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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

CREATE TABLE IF NOT EXISTS `eva_user_options` (
  `user_id` int(10) NOT NULL,
  `optionKey` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `optionValue` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`user_id`,`optionKey`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `eva_user_profiles` (
  `user_id` int(10) NOT NULL,
  `site` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `photoDir` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `photoName` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fullName` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `relationshipStatus` enum('single','inRelationship','engaged','married','widowed','separated','divorced','other') COLLATE utf8_unicode_ci DEFAULT NULL,
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

CREATE TABLE IF NOT EXISTS `eva_user_roles` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `roleKey` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `roleName` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `eva_user_roles_users` (
  `role_id` int(5) NOT NULL,
  `user_id` int(10) NOT NULL,
  `status` enum('active','pending','expired') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'pending',
  `pendingTime` datetime DEFAULT NULL,
  `activeTime` datetime DEFAULT NULL,
  `expiredTime` datetime DEFAULT NULL,
  PRIMARY KEY (`role_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `eva_user_tags` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `tagName` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `language` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'en',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `eva_user_tags_users` (
  `user_id` int(10) NOT NULL,
  `tag_id` int(10) NOT NULL,
  `createTime` datetime NOT NULL,
  `orderNumber` int(5) NOT NULL,
  PRIMARY KEY (`user_id`,`tag_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `eva_user_tokens` (
  `sessionId` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `userHash` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(10) NOT NULL,
  `refreshTime` datetime NOT NULL,
  `expiredTime` datetime NOT NULL,
  PRIMARY KEY (`sessionId`,`token`,`userHash`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `eva_user_users` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `userName` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(320) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mobile` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
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
  PRIMARY KEY (`id`),
  KEY `userName` (`userName`),
  KEY `email` (`email`(255))
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
