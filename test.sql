-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- ホスト: 127.0.0.1
-- 生成日時: 
-- サーバのバージョン： 10.4.11-MariaDB
-- PHP のバージョン: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `test`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `calendar`
--

CREATE TABLE `calendar` (
  `target_id` int(8) NOT NULL,
  `target_name` varchar(30) CHARACTER SET utf8 NOT NULL,
  `target_date` date NOT NULL,
  `target_time` int(8) NOT NULL,
  `study_how` int(1) NOT NULL,
  `user_id` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- テーブルのデータのダンプ `calendar`
--

INSERT INTO `calendar` (`target_id`, `target_name`, `target_date`, `target_time`, `study_how`, `user_id`) VALUES
(31, '初めまして', '2020-12-04', 122, 1, 11),
(32, 'test', '2020-11-13', 12, 2, 11),
(33, 'こんにちわ', '2020-11-19', 90, 2, 12);

-- --------------------------------------------------------

--
-- テーブルの構造 `friend`
--

CREATE TABLE `friend` (
  `user_id` int(8) NOT NULL,
  `friendid` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- テーブルのデータのダンプ `friend`
--

INSERT INTO `friend` (`user_id`, `friendid`) VALUES
(11, 12),
(12, 11);

-- --------------------------------------------------------

--
-- テーブルの構造 `missword`
--

CREATE TABLE `missword` (
  `user_id` int(8) NOT NULL,
  `missword_id` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- テーブルのデータのダンプ `missword`
--

INSERT INTO `missword` (`user_id`, `missword_id`) VALUES
(11, 1);

-- --------------------------------------------------------

--
-- テーブルの構造 `user`
--

CREATE TABLE `user` (
  `user_id` int(8) NOT NULL,
  `user_name` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- テーブルのデータのダンプ `user`
--

INSERT INTO `user` (`user_id`, `user_name`, `password`) VALUES
(11, 'test', 'test'),
(12, 'abc', 'abc');

-- --------------------------------------------------------

--
-- テーブルの構造 `word`
--

CREATE TABLE `word` (
  `user_id` int(8) NOT NULL,
  `lastword_id` int(8) DEFAULT NULL,
  `language` int(1) DEFAULT NULL,
  `level_id` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- テーブルのデータのダンプ `word`
--

INSERT INTO `word` (`user_id`, `lastword_id`, `language`, `level_id`) VALUES
(11, NULL, NULL, NULL),
(12, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- テーブルの構造 `word_info`
--

CREATE TABLE `word_info` (
  `user_id` int(8) NOT NULL,
  `missword_total` int(8) DEFAULT NULL,
  `missnum_total` int(8) DEFAULT NULL,
  `overcome_total` int(8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- テーブルのデータのダンプ `word_info`
--

INSERT INTO `word_info` (`user_id`, `missword_total`, `missnum_total`, `overcome_total`) VALUES
(11, 4, 4, 4),
(12, NULL, NULL, NULL);

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `calendar`
--
ALTER TABLE `calendar`
  ADD PRIMARY KEY (`target_id`),
  ADD UNIQUE KEY `target_unique` (`target_id`,`target_name`),
  ADD KEY `cal_userid` (`user_id`);

--
-- テーブルのインデックス `friend`
--
ALTER TABLE `friend`
  ADD UNIQUE KEY `user_id` (`user_id`,`friendid`) USING BTREE;

--
-- テーブルのインデックス `missword`
--
ALTER TABLE `missword`
  ADD UNIQUE KEY `user_id` (`user_id`,`missword_id`) USING BTREE;

--
-- テーブルのインデックス `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- テーブルのインデックス `word`
--
ALTER TABLE `word`
  ADD KEY `word_user` (`user_id`);

--
-- テーブルのインデックス `word_info`
--
ALTER TABLE `word_info`
  ADD PRIMARY KEY (`user_id`) USING BTREE,
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- ダンプしたテーブルのAUTO_INCREMENT
--

--
-- テーブルのAUTO_INCREMENT `calendar`
--
ALTER TABLE `calendar`
  MODIFY `target_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- テーブルのAUTO_INCREMENT `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- ダンプしたテーブルの制約
--

--
-- テーブルの制約 `calendar`
--
ALTER TABLE `calendar`
  ADD CONSTRAINT `cal_userid` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

--
-- テーブルの制約 `friend`
--
ALTER TABLE `friend`
  ADD CONSTRAINT `friend_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

--
-- テーブルの制約 `missword`
--
ALTER TABLE `missword`
  ADD CONSTRAINT `missword_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

--
-- テーブルの制約 `word`
--
ALTER TABLE `word`
  ADD CONSTRAINT `word_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

--
-- テーブルの制約 `word_info`
--
ALTER TABLE `word_info`
  ADD CONSTRAINT `word_info` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
