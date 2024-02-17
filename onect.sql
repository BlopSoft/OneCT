SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


CREATE TABLE `banlist` (
  `id` int(16) NOT NULL,
  `user_id` int(16) NOT NULL COMMENT 'ID пользователя',
  `reason` text DEFAULT NULL COMMENT 'Причина бана'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `comments` (
  `id` int(16) NOT NULL,
  `post_id` int(16) NOT NULL,
  `user_id` int(16) NOT NULL,
  `text` varchar(512) NOT NULL,
  `date` int(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `likes` (
  `id` int(16) NOT NULL,
  `post_id` int(16) NOT NULL,
  `user_id` int(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `post` (
  `id` int(16) NOT NULL,
  `id_user` int(16) NOT NULL,
  `id_who` int(16) NOT NULL,
  `post` varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `img` varchar(256) DEFAULT NULL,
  `pin` int(1) NOT NULL DEFAULT 0,
  `date` int(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE `users` (
  `id` int(16) NOT NULL,
  `email` varchar(128) NOT NULL,
  `name` varchar(50) NOT NULL,
  `pass` text NOT NULL,
  `ip` varchar(16) NOT NULL,
  `descr` varchar(256) DEFAULT NULL,
  `ban` int(1) NOT NULL DEFAULT 0,
  `yespost` varchar(3) NOT NULL DEFAULT '0',
  `priv` int(1) NOT NULL DEFAULT 0,
  `img50` varchar(255) DEFAULT NULL,
  `img100` varchar(255) DEFAULT NULL,
  `img200` varchar(255) DEFAULT NULL,
  `img` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `users` (`id`, `email`, `name`, `pass`, `ip`, `descr`, `ban`, `yespost`, `priv`, `img50`, `img100`, `img200`, `img`) VALUES
(1, 'admin@admin.org', 'Admin', '$2y$10$wqy6H/8Yy1CV1OrZcE22nOdMLXDet2I2O37mwgHoSO83Fv976ZgD6', '0', '', 0, '0', 3, '', '', '', '');


ALTER TABLE `banlist`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `post`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `banlist`
  MODIFY `id` int(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE `comments`
  MODIFY `id` int(16) NOT NULL AUTO_INCREMENT;

ALTER TABLE `likes`
  MODIFY `id` int(16) NOT NULL AUTO_INCREMENT;

ALTER TABLE `post`
  MODIFY `id` int(16) NOT NULL AUTO_INCREMENT;

ALTER TABLE `users`
  MODIFY `id` int(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
