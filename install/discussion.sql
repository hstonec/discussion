-- phpMyAdmin SQL Dump
-- version 4.4.8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 28, 2015 at 05:49 PM
-- Server version: 5.6.25-log
-- PHP Version: 5.6.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `discussion`
--
CREATE DATABASE IF NOT EXISTS `discussion` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `discussion`;

-- --------------------------------------------------------

--
-- Table structure for table `t_department`
--

CREATE TABLE IF NOT EXISTS `t_department` (
  `id_department` int(10) unsigned NOT NULL,
  `id_parent` int(10) unsigned NOT NULL,
  `department_name` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `t_department`
--

INSERT INTO `t_department` (`id_department`, `id_parent`, `department_name`) VALUES
(1, 1, 'Root');

-- --------------------------------------------------------

--
-- Table structure for table `t_group`
--

CREATE TABLE IF NOT EXISTS `t_group` (
  `id_group` int(10) unsigned NOT NULL,
  `id_owner` int(10) unsigned NOT NULL,
  `group_name` varchar(100) NOT NULL,
  `activate_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `t_group_member`
--

CREATE TABLE IF NOT EXISTS `t_group_member` (
  `id_group` int(10) unsigned NOT NULL,
  `id_user` int(10) unsigned NOT NULL,
  `accept_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `t_record`
--

CREATE TABLE IF NOT EXISTS `t_record` (
  `id_record` int(10) unsigned NOT NULL,
  `id_group` int(10) unsigned NOT NULL,
  `id_user` int(10) unsigned NOT NULL,
  `message_type` int(11) NOT NULL,
  `content` mediumtext NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `display_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `t_role`
--

CREATE TABLE IF NOT EXISTS `t_role` (
  `id_role` int(10) unsigned NOT NULL,
  `role_name` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `t_role`
--

INSERT INTO `t_role` (`id_role`, `role_name`) VALUES
(1, 'Root'),
(2, 'Administrator'),
(3, 'User'),
(4, 'Forbiden');

-- --------------------------------------------------------

--
-- Table structure for table `t_user`
--

CREATE TABLE IF NOT EXISTS `t_user` (
  `id_user` int(10) unsigned NOT NULL,
  `id_role` int(10) unsigned NOT NULL,
  `id_department` int(10) unsigned NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `gender` int(11) NOT NULL,
  `photo_url` varchar(300) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

INSERT INTO `t_user` (`id_user`, `id_role`, `id_department`, `username`, `password`, `first_name`, `last_name`, `gender`, `photo_url`) VALUES
(1, 1, 1, 'rootroot', '$2y$10$W7mLvWNVtkM3HCf2xQIrq.WB.piLKoMzPKK0Yj02YzdNJYFWcABvW', 'Anakin', 'Skywalker', 1, 'photo/default.png');
--
-- Indexes for dumped tables
--

--
-- Indexes for table `t_department`
--
ALTER TABLE `t_department`
  ADD PRIMARY KEY (`id_department`);

--
-- Indexes for table `t_group`
--
ALTER TABLE `t_group`
  ADD PRIMARY KEY (`id_group`),
  ADD KEY `index_id_owner` (`id_owner`);

--
-- Indexes for table `t_group_member`
--
ALTER TABLE `t_group_member`
  ADD PRIMARY KEY (`id_group`,`id_user`),
  ADD KEY `index_id_group` (`id_group`) USING BTREE,
  ADD KEY `index_id_user` (`id_user`) USING BTREE;

--
-- Indexes for table `t_record`
--
ALTER TABLE `t_record`
  ADD PRIMARY KEY (`id_record`),
  ADD KEY `index_id_group` (`id_group`),
  ADD KEY `index_id_user` (`id_user`);

--
-- Indexes for table `t_role`
--
ALTER TABLE `t_role`
  ADD PRIMARY KEY (`id_role`);

--
-- Indexes for table `t_user`
--
ALTER TABLE `t_user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `index_username` (`username`) USING BTREE,
  ADD KEY `index_id_role` (`id_role`) USING BTREE,
  ADD KEY `index_id_department` (`id_department`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `t_department`
--
ALTER TABLE `t_department`
  MODIFY `id_department` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `t_group`
--
ALTER TABLE `t_group`
  MODIFY `id_group` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_record`
--
ALTER TABLE `t_record`
  MODIFY `id_record` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_role`
--
ALTER TABLE `t_role`
  MODIFY `id_role` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `t_user`
--
ALTER TABLE `t_user`
  MODIFY `id_user` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `t_group`
--
ALTER TABLE `t_group`
  ADD CONSTRAINT `fk_id_owner` FOREIGN KEY (`id_owner`) REFERENCES `t_user` (`id_user`);

--
-- Constraints for table `t_group_member`
--
ALTER TABLE `t_group_member`
  ADD CONSTRAINT `fk_id_group` FOREIGN KEY (`id_group`) REFERENCES `t_group` (`id_group`),
  ADD CONSTRAINT `fk_id_user` FOREIGN KEY (`id_user`) REFERENCES `t_user` (`id_user`);

--
-- Constraints for table `t_user`
--
ALTER TABLE `t_user`
  ADD CONSTRAINT `fk_id_department` FOREIGN KEY (`id_department`) REFERENCES `t_department` (`id_department`),
  ADD CONSTRAINT `fk_id_role` FOREIGN KEY (`id_role`) REFERENCES `t_role` (`id_role`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
