-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- ホスト: localhost
-- 生成日時: 2021-07-15 02:46:44
-- サーバのバージョン： 10.6.3-MariaDB
-- PHP のバージョン: 7.4.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `board`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `message`
--

CREATE TABLE message (
  `id` int(11) NOT NULL,
  `list_name` varchar(100) NOT NULL,
  `view_name` varchar(100) NOT NULL,
  `youtube_url` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `post_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `message`
--

INSERT INTO message (`id`, `list_name`, `view_name`, `youtube_url`, `message`, `post_date`) VALUES
(2, 'test', 'たけさん', 'ba600DlIRAo', 'aaaaaaaaaaaa<br>', '2021-07-13 11:41:36');

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `message`
--
ALTER TABLE message
  ADD PRIMARY KEY (`id`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `message`
--
ALTER TABLE message
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
