-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- ホスト: 127.0.0.1
-- 生成日時: 2024-06-02 06:35:29
-- サーバのバージョン： 10.4.28-MariaDB
-- PHP のバージョン: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `class_community`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `class`
--

CREATE TABLE `class` (
  `id` int(11) NOT NULL,
  `class_number` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- テーブルのデータのダンプ `class`
--

INSERT INTO `class` (`id`, `class_number`) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5),
(6, 6),
(7, 7),
(8, 8);

-- --------------------------------------------------------

--
-- テーブルの構造 `community_posts`
--

CREATE TABLE `community_posts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `subject` text NOT NULL,
  `text` text NOT NULL,
  `create_date` datetime NOT NULL,
  `good` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`good`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- テーブルのデータのダンプ `community_posts`
--

INSERT INTO `community_posts` (`id`, `user_id`, `subject`, `text`, `create_date`, `good`) VALUES
(1, 1, '数学', '教科書20ページの答えを教えてください', '2024-01-21 00:00:00', '{\"users\":[1,2,3,4,5,6,7,8,9,10]}'),
(2, 2, '国語', '考査範囲を教えてください', '2024-01-21 00:00:00', NULL),
(3, 1, '歴史', '参政権に反対か賛成か', '2024-01-21 00:00:00', NULL),
(4, 1, '地学', 'コリオリの力とは', '2024-01-21 00:00:00', NULL),
(5, 2, '生物', '脊椎動物とは', '2024-01-21 00:00:00', NULL),
(6, 1, '幾何', 'ドモルガンの法則とは', '2024-01-26 00:00:00', NULL),
(14, 1, '英語', '現在完了形とは。', '2024-02-04 14:48:08', NULL),
(15, 1, '数学、幾何', '今学期の考査範囲を教えてください。', '2024-02-17 11:13:59', NULL),
(16, 1, '数学', '三平方の定理とは？', '2024-03-22 15:32:51', NULL),
(18, 33, '数学', '二項定理が分かりませんせん', '2024-05-10 20:50:32', NULL);

-- --------------------------------------------------------

--
-- テーブルの構造 `community_replays`
--

CREATE TABLE `community_replays` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `text` text NOT NULL,
  `create_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- テーブルのデータのダンプ `community_replays`
--

INSERT INTO `community_replays` (`id`, `post_id`, `user_id`, `text`, `create_date`) VALUES
(7, 14, 1, 'I have joined a swim club since I was ten.', '2024-02-11 14:04:18'),
(9, 1, 1, '10です', '2024-02-11 15:15:09'),
(10, 3, 1, '賛成!', '2024-02-13 12:33:30'),
(20, 15, 1, '教科書１０ページから５０ページまでです。', '2024-02-17 11:52:34'),
(21, 15, 1, '教科書50ページからです', '2024-02-18 12:31:41'),
(22, 1, 5, '大問１の答えは２０です', '2024-02-18 16:13:44'),
(23, 3, 1, '反対', '2024-03-22 14:44:09'),
(24, 15, 1, '教科書20ページからですよ。', '2024-03-22 15:33:12'),
(25, 15, 29, '20ぺーじからです。', '2024-05-10 20:45:12');

-- --------------------------------------------------------

--
-- テーブルの構造 `grade`
--

CREATE TABLE `grade` (
  `id` int(11) NOT NULL,
  `grade_number` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- テーブルのデータのダンプ `grade`
--

INSERT INTO `grade` (`id`, `grade_number`) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5),
(6, 6);

-- --------------------------------------------------------

--
-- テーブルの構造 `login`
--

CREATE TABLE `login` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profile` text DEFAULT NULL,
  `grade_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- テーブルのデータのダンプ `login`
--

INSERT INTO `login` (`id`, `name`, `email`, `password`, `profile`, `grade_id`, `class_id`) VALUES
(2, '榎本太郎', 'test@youri', 'testyouri', '僕の得意教科は数学と国語です。                    ', 2, 4),
(3, '山本太郎', 'taro@taro', 'tarotaro', '得意教科は数学です', 2, 4),
(4, '坂本次郎', 'jiro@jiro', 'jirojiro', '野球部の主将です', 2, 4),
(5, '田中健', 'ken@ken', 'kenken', '趣味はバスケットボールです                    ', 2, 1),
(6, '中島俊', 'syunn@syunn', 'syunnsyunn', '水泳部に所属しています', 2, 1),
(22, '小沢瑠偉', 'rui@rui', 'ruirui', 'バスケ部です。                    ', 3, 1),
(24, '遠藤聡', 'endo@endo', 'endoendo', '   サッカー部です。サッカーが趣味です。', 3, 2),
(26, '星野春樹', 'hoshino@hoshino', 'hoshinohoshino', '鉄道研究部です。                    ', 3, 3),
(29, '榎本悠里', 'youri@youri', 'youriyouri', '  水泳部の部員です                  ', 3, 2),
(30, '小林凱史', 'kaiji@kaiji', 'kaijikaiji', '数学が得意教科です。                    ', 3, 2),
(31, '西川隆起', 'nishikawa@nishikawa', 'nishikawanishikawa', '水泳部です。主にゲームが趣味です。                    ', 3, 5),
(33, '佐々木壮太', 'souta@souta.com', 'soutasouta', ' 卓球部の部員です                   ', 3, 2);

-- --------------------------------------------------------

--
-- テーブルの構造 `school`
--

CREATE TABLE `school` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `place` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `school_id` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- テーブルのデータのダンプ `school`
--

INSERT INTO `school` (`id`, `name`, `place`, `type`, `school_id`) VALUES
(1, '桐蔭学園中等教育学校', '神奈川県横浜市青葉区', '中学校', 'tointyuto2024/04/30');

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `community_posts`
--
ALTER TABLE `community_posts`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `community_replays`
--
ALTER TABLE `community_replays`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `grade`
--
ALTER TABLE `grade`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `school`
--
ALTER TABLE `school`
  ADD PRIMARY KEY (`id`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `class`
--
ALTER TABLE `class`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- テーブルの AUTO_INCREMENT `community_posts`
--
ALTER TABLE `community_posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- テーブルの AUTO_INCREMENT `community_replays`
--
ALTER TABLE `community_replays`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- テーブルの AUTO_INCREMENT `grade`
--
ALTER TABLE `grade`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- テーブルの AUTO_INCREMENT `login`
--
ALTER TABLE `login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- テーブルの AUTO_INCREMENT `school`
--
ALTER TABLE `school`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
