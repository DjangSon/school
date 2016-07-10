-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2016-03-28 17:19:01
-- 服务器版本： 5.6.24
-- PHP Version: 5.6.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `school`
--

-- --------------------------------------------------------

--
-- 表的结构 `admin`
--

CREATE TABLE `admin` (
  `ID` int(20) NOT NULL,
  `adminName` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL,
  `lastLogin` datetime DEFAULT '0000-00-00 00:00:00',
  `state` tinyint(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `admin`
--

INSERT INTO `admin` (`ID`, `adminName`, `password`, `lastLogin`, `state`) VALUES
(5, 'admin', '21232f297a57a5a743894a0e4a801fc3', '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- 表的结构 `article`
--

CREATE TABLE `article` (
  `ID` int(20) NOT NULL,
  `author` varchar(40) NOT NULL,
  `title` text NOT NULL,
  `content` longtext NOT NULL,
  `datetime` datetime NOT NULL,
  `flag` tinyint(1) NOT NULL,
  `files` text NOT NULL,
  `filename` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `article`
--

INSERT INTO `article` (`ID`, `author`, `title`, `content`, `datetime`, `flag`, `files`, `filename`) VALUES
(11, '李老师', '关于Python的学习相关入门资料', '最近开设python课程，希望同学们先自我预先一下上传的资料。', '2016-03-28 17:12:38', 1, 'uploads/20160328051238pmNXAyTzZJQ0I1YmlJpython.zip', 'python学习资料包'),
(12, '李老师', 'linux系统操作入门', '上次很多同学需要这份资料，现在放出来给大家下。', '2016-03-28 17:15:22', 1, 'uploads/20160328051522pmNXAyTzZJQ0I1YmlJlinuxϵͳ', 'linux系统操作入门'),
(13, '王五', '求王老师数据库第15页第三题答案详解', '实在太难，做了好几次都不对，希望哪位老师指导一下', '2016-03-28 17:16:17', 0, 'uploads/20160328051617pmNTQ2TDVMcVU=2314.jpg', '图文无关，仅表达我做不出来的悲伤');

-- --------------------------------------------------------

--
-- 表的结构 `chat`
--

CREATE TABLE `chat` (
  `ID` int(20) NOT NULL,
  `fromwho` varchar(20) NOT NULL,
  `towho` varchar(20) NOT NULL,
  `message` text NOT NULL,
  `sendtime` datetime NOT NULL,
  `readtime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `flag` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `chat`
--

INSERT INTO `chat` (`ID`, `fromwho`, `towho`, `message`, `sendtime`, `readtime`, `flag`) VALUES
(122, '王五', '李老师', '老师好', '2016-03-28 17:17:00', '0000-00-00 00:00:00', 1),
(123, '王五', '李老师', '老师我是王五，我最近学Python的课程，对于Python无法深入理解，希望老师给予指导', '2016-03-28 17:18:13', '0000-00-00 00:00:00', 1);

-- --------------------------------------------------------

--
-- 表的结构 `users`
--

CREATE TABLE `users` (
  `ID` int(20) NOT NULL,
  `username` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `regTime` datetime NOT NULL,
  `online` tinyint(2) DEFAULT '0',
  `flag` tinyint(1) NOT NULL DEFAULT '0',
  `message` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `users`
--

INSERT INTO `users` (`ID`, `username`, `email`, `password`, `regTime`, `online`, `flag`, `message`) VALUES
(17, '李老师', 'lilaoshi@qq.com', 'e10adc3949ba59abbe56e057f20f883e', '0000-00-00 00:00:00', 1, 1, 1),
(18, '王老师', 'wanglaoshi@qq.com', 'e10adc3949ba59abbe56e057f20f883e', '0000-00-00 00:00:00', 0, 1, 0),
(19, '毛老师', 'maolaoshi@qq.com', 'e10adc3949ba59abbe56e057f20f883e', '0000-00-00 00:00:00', 0, 1, 0),
(20, '王五', 'wangwu@qq.com', 'e10adc3949ba59abbe56e057f20f883e', '2016-03-28 17:13:37', 1, 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `chat`
--
ALTER TABLE `chat`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `admin`
--
ALTER TABLE `admin`
  MODIFY `ID` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- 使用表AUTO_INCREMENT `article`
--
ALTER TABLE `article`
  MODIFY `ID` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- 使用表AUTO_INCREMENT `chat`
--
ALTER TABLE `chat`
  MODIFY `ID` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=124;
--
-- 使用表AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
