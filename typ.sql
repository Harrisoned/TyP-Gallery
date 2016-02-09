-- phpMyAdmin SQL Dump
-- version 4.5.3.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 09, 2016 at 04:05 PM
-- Server version: 5.7.10-log
-- PHP Version: 5.6.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `typ`
--

DELIMITER $$
--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `notes_next_id` (`post` BIGINT) RETURNS INT(11) BEGIN
	DECLARE iv1 INTEGER;
	DECLARE iv2 INTEGER;
	SELECT id INTO iv1 FROM notes WHERE post_id=post ORDER BY id DESC LIMIT 1;
	SET iv2 = (iv1+1);
	RETURN iv2;
	END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `alias`
--

CREATE TABLE `alias` (
  `tag` varchar(255) DEFAULT NULL,
  `alias` varchar(255) DEFAULT NULL,
  `status` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `banned_ip`
--

CREATE TABLE `banned_ip` (
  `id` int(11) NOT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `user` text,
  `reason` text,
  `date_added` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `comment` text,
  `ip` varchar(255) DEFAULT NULL,
  `user` varchar(255) DEFAULT NULL,
  `posted_at` int(11) DEFAULT NULL,
  `edited_at` int(11) DEFAULT '0',
  `score` bigint(20) DEFAULT '0',
  `post_id` bigint(20) UNSIGNED NOT NULL,
  `spam` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `comment_votes`
--

CREATE TABLE `comment_votes` (
  `ip` varchar(255) DEFAULT NULL,
  `post_id` bigint(20) UNSIGNED DEFAULT NULL,
  `comment_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `delete_images`
--

CREATE TABLE `delete_images` (
  `hash` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `favorites`
--

CREATE TABLE `favorites` (
  `user_id` bigint(99) UNSIGNED NOT NULL,
  `favorite` bigint(99) UNSIGNED DEFAULT NULL,
  `added` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `favorites_count`
--

CREATE TABLE `favorites_count` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `fcount` bigint(20) UNSIGNED DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `folder_index`
--

CREATE TABLE `folder_index` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` text,
  `count` int(10) UNSIGNED DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `forum_posts`
--

CREATE TABLE `forum_posts` (
  `id` bigint(99) UNSIGNED NOT NULL,
  `title` text,
  `post` text NOT NULL,
  `author` varchar(256) DEFAULT NULL,
  `creation_date` int(11) DEFAULT NULL,
  `topic_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `forum_topics`
--

CREATE TABLE `forum_topics` (
  `id` bigint(99) UNSIGNED NOT NULL,
  `topic` text,
  `author` varchar(256) DEFAULT NULL,
  `last_updated` int(11) DEFAULT NULL,
  `creation_post` bigint(20) UNSIGNED NOT NULL,
  `priority` int(99) UNSIGNED DEFAULT '0',
  `locked` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `group_name` text,
  `delete_posts` tinyint(1) DEFAULT '0',
  `delete_comments` tinyint(1) DEFAULT '0',
  `admin_panel` tinyint(1) DEFAULT '0',
  `reverse_notes` tinyint(1) DEFAULT '0',
  `reverse_tags` tinyint(1) DEFAULT '0',
  `default_group` tinyint(1) DEFAULT '1',
  `is_admin` tinyint(1) DEFAULT '0',
  `delete_forum_posts` tinyint(1) DEFAULT '0',
  `delete_forum_topics` tinyint(1) DEFAULT '0',
  `lock_forum_topics` tinyint(1) DEFAULT '0',
  `edit_forum_posts` tinyint(1) DEFAULT '0',
  `pin_forum_topics` tinyint(1) DEFAULT '0',
  `alter_notes` tinyint(1) DEFAULT '0',
  `can_upload` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `group_name`, `delete_posts`, `delete_comments`, `admin_panel`, `reverse_notes`, `reverse_tags`, `default_group`, `is_admin`, `delete_forum_posts`, `delete_forum_topics`, `lock_forum_topics`, `edit_forum_posts`, `pin_forum_topics`, `alter_notes`, `can_upload`) VALUES
(1, 'Administrator', 1, 1, 1, 1, 1, 0, 1, 1, 1, 1, 1, 1, 1, 1),
(2, 'Regular Member', 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `hit_counter`
--

CREATE TABLE `hit_counter` (
  `count` bigint(20) UNSIGNED DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `hit_counter`
--

INSERT INTO `hit_counter` (`count`) VALUES
(0);

-- --------------------------------------------------------

--
-- Table structure for table `notes`
--

CREATE TABLE `notes` (
  `id` int(10) UNSIGNED DEFAULT '0',
  `post_id` bigint(20) UNSIGNED NOT NULL,
  `x` int(99) DEFAULT NULL,
  `y` int(99) DEFAULT NULL,
  `width` int(10) UNSIGNED DEFAULT NULL,
  `height` int(10) UNSIGNED DEFAULT NULL,
  `body` text,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `version` bigint(20) UNSIGNED DEFAULT '1',
  `user_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `notes_history`
--

CREATE TABLE `notes_history` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `x` int(11) DEFAULT NULL,
  `y` int(11) DEFAULT NULL,
  `width` int(10) UNSIGNED DEFAULT NULL,
  `height` int(10) UNSIGNED DEFAULT NULL,
  `body` text,
  `version` int(10) UNSIGNED DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `post_id` int(10) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `notices`
--

CREATE TABLE `notices` (
  `id` int(11) NOT NULL,
  `notice` varchar(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `parent_child`
--

CREATE TABLE `parent_child` (
  `id` bigint(20) NOT NULL,
  `parent` bigint(20) NOT NULL,
  `child` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `creation_date` datetime DEFAULT NULL,
  `score` bigint(99) DEFAULT '0',
  `hash` text NOT NULL,
  `last_comment` datetime DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `source` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `owner` varchar(256) DEFAULT NULL,
  `height` int(10) UNSIGNED DEFAULT '0',
  `width` int(10) UNSIGNED DEFAULT '0',
  `ext` varchar(10) DEFAULT NULL,
  `rating` text,
  `tags` text NOT NULL,
  `directory` text,
  `recent_tags` text,
  `spam` tinyint(1) DEFAULT '0',
  `tags_version` bigint(20) UNSIGNED DEFAULT '1',
  `active_date` text NOT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `reason` text,
  `parent` bigint(20) NOT NULL DEFAULT '0',
  `post_version` bigint(99) UNSIGNED DEFAULT '0',
  `comment_version` bigint(99) UNSIGNED DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `post_count`
--

CREATE TABLE `post_count` (
  `access_key` varchar(255) DEFAULT NULL,
  `pcount` bigint(20) UNSIGNED DEFAULT '0',
  `last_update` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `post_count`
--

INSERT INTO `post_count` (`access_key`, `pcount`, `last_update`) VALUES
('posts', 0, NULL),
('comment_count', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `post_votes`
--

CREATE TABLE `post_votes` (
  `rated` varchar(4) NOT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `post_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `tag_history`
--

CREATE TABLE `tag_history` (
  `total_amount` bigint(99) UNSIGNED NOT NULL,
  `id` bigint(20) UNSIGNED NOT NULL,
  `tags` text,
  `active` tinyint(1) DEFAULT '1',
  `version` bigint(20) UNSIGNED DEFAULT '1',
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `tag_index`
--

CREATE TABLE `tag_index` (
  `tag` varchar(255) NOT NULL,
  `index_count` bigint(20) UNSIGNED DEFAULT '0',
  `version` bigint(20) UNSIGNED DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(99) UNSIGNED NOT NULL,
  `user` varchar(255) DEFAULT NULL,
  `pass` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) NOT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `my_tags` text,
  `login_session` text,
  `ugroup` bigint(20) UNSIGNED DEFAULT NULL,
  `mail_reset_code` text,
  `forum_can_create_topic` tinyint(1) DEFAULT '1',
  `forum_can_post` tinyint(1) DEFAULT '1',
  `post_count` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `record_score` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `comment_count` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `tag_edit_count` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `forum_post_count` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `signup_date` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user`, `pass`, `email`, `avatar`, `ip`, `my_tags`, `login_session`, `ugroup`, `mail_reset_code`, `forum_can_create_topic`, `forum_can_post`, `post_count`, `record_score`, `comment_count`, `tag_edit_count`, `forum_post_count`, `signup_date`) VALUES
(1, 'Admin', '63982e54a7aeb0d89910475ba6dbd3ca6dd4e5a1', 'admin@localhost', '0', NULL, NULL, NULL, 1, NULL, 1, 1, 0, 0, 0, 0, 0, '2016-02-03 16:26:09');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alias`
--
ALTER TABLE `alias`
  ADD KEY `status` (`status`),
  ADD KEY `alias` (`alias`),
  ADD KEY `tag` (`tag`);

--
-- Indexes for table `banned_ip`
--
ALTER TABLE `banned_ip`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ip` (`ip`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `posted_at` (`posted_at`);

--
-- Indexes for table `favorites`
--
ALTER TABLE `favorites`
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `folder_index`
--
ALTER TABLE `folder_index`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `forum_posts`
--
ALTER TABLE `forum_posts`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `forum_posts` ADD FULLTEXT KEY `post` (`post`);

--
-- Indexes for table `forum_topics`
--
ALTER TABLE `forum_topics`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notes`
--
ALTER TABLE `notes`
  ADD KEY `post_id` (`post_id`);

--
-- Indexes for table `notes_history`
--
ALTER TABLE `notes_history`
  ADD KEY `post_id` (`post_id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `notices`
--
ALTER TABLE `notices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `parent_child`
--
ALTER TABLE `parent_child`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent` (`parent`),
  ADD KEY `child` (`child`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `creation_date` (`creation_date`),
  ADD KEY `parent` (`parent`);
ALTER TABLE `posts` ADD FULLTEXT KEY `tags` (`tags`);

--
-- Indexes for table `post_count`
--
ALTER TABLE `post_count`
  ADD KEY `access_key` (`access_key`);

--
-- Indexes for table `tag_history`
--
ALTER TABLE `tag_history`
  ADD PRIMARY KEY (`total_amount`),
  ADD KEY `id` (`id`),
  ADD KEY `version` (`version`);

--
-- Indexes for table `tag_index`
--
ALTER TABLE `tag_index`
  ADD KEY `tag` (`tag`),
  ADD KEY `index_count` (`index_count`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `banned_ip`
--
ALTER TABLE `banned_ip`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `folder_index`
--
ALTER TABLE `folder_index`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `forum_posts`
--
ALTER TABLE `forum_posts`
  MODIFY `id` bigint(99) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `forum_topics`
--
ALTER TABLE `forum_topics`
  MODIFY `id` bigint(99) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `notices`
--
ALTER TABLE `notices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `parent_child`
--
ALTER TABLE `parent_child`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=175;
--
-- AUTO_INCREMENT for table `tag_history`
--
ALTER TABLE `tag_history`
  MODIFY `total_amount` bigint(99) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(99) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
