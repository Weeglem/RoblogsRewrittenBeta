-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 01-11-2024 a las 03:08:14
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `newroblogs`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `assets_comments`
--

CREATE TABLE `assets_comments` (
  `ID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `AssetID` int(11) NOT NULL,
  `Content_Type` text NOT NULL,
  `Message` text NOT NULL,
  `Date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `assets_favorites`
--

CREATE TABLE `assets_favorites` (
  `UserID` bigint(20) NOT NULL,
  `AssetID` bigint(20) NOT NULL,
  `Type` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `assets_images`
--

CREATE TABLE `assets_images` (
  `Asset_ID` int(11) NOT NULL,
  `Type` int(11) NOT NULL,
  `Img_ID` int(11) NOT NULL,
  `Img_Description` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `badges_list`
--

CREATE TABLE `badges_list` (
  `BadgeID` int(11) NOT NULL,
  `BadgeName` text NOT NULL,
  `BadgeAbout` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `blog_entries`
--

CREATE TABLE `blog_entries` (
  `ID` int(11) NOT NULL,
  `Name` text NOT NULL,
  `Content` text NOT NULL,
  `Owner` text NOT NULL,
  `Date` text NOT NULL,
  `Hidden` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `catalog_data`
--

CREATE TABLE `catalog_data` (
  `ID` int(11) NOT NULL,
  `Category` text NOT NULL,
  `Name` text NOT NULL,
  `Thumbnail` text NOT NULL,
  `Owner` text NOT NULL,
  `Price` int(11) NOT NULL DEFAULT 0,
  `CreationDate` int(11) NOT NULL,
  `public` int(11) NOT NULL DEFAULT 1,
  `Descripcion` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categories`
--

CREATE TABLE `categories` (
  `ID` int(11) NOT NULL,
  `Name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categories_roblox`
--

CREATE TABLE `categories_roblox` (
  `ID` int(11) NOT NULL,
  `Name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `datapacks_data`
--

CREATE TABLE `datapacks_data` (
  `ID` int(11) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Description` varchar(1000) NOT NULL,
  `Thumbnal` text NOT NULL,
  `Creator` text NOT NULL,
  `Creation_Date` date NOT NULL,
  `Update_Date` date NOT NULL,
  `Version` int(11) NOT NULL,
  `Download` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `decals_data`
--

CREATE TABLE `decals_data` (
  `ID` int(11) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Description` text NOT NULL,
  `Creator` text NOT NULL,
  `Creation_Date` text NOT NULL,
  `Update_Date` date NOT NULL DEFAULT current_timestamp(),
  `category_roblox` int(11) NOT NULL DEFAULT 1,
  `category` int(11) NOT NULL DEFAULT 1,
  `Status` bit(1) NOT NULL DEFAULT b'0',
  `Favorites` bigint(20) NOT NULL DEFAULT 0,
  `Public` int(11) NOT NULL DEFAULT 1,
  `Thumbnail` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `forums_following`
--

CREATE TABLE `forums_following` (
  `UserID` int(11) NOT NULL,
  `PostID` int(11) NOT NULL,
  `DATE` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `forums_groups`
--

CREATE TABLE `forums_groups` (
  `GroupID` int(11) NOT NULL,
  `GroupName` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `forums_posts`
--

CREATE TABLE `forums_posts` (
  `ID` int(11) NOT NULL,
  `ParentID` int(11) DEFAULT NULL,
  `CategoryID` int(11) NOT NULL,
  `Name` varchar(100) DEFAULT NULL,
  `Topic` varchar(10000) NOT NULL,
  `Owner` text NOT NULL,
  `Pinned` int(11) NOT NULL DEFAULT 0,
  `Public` int(2) NOT NULL DEFAULT 1,
  `Deleted` int(11) NOT NULL DEFAULT 0,
  `Date` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `forums_replies`
--

CREATE TABLE `forums_replies` (
  `ID` bigint(20) NOT NULL,
  `ThreadID` int(11) NOT NULL,
  `ForumCategory` int(11) NOT NULL,
  `Owner` text NOT NULL,
  `Comment` text NOT NULL,
  `Date` text NOT NULL,
  `Deleted` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `forums_threads`
--

CREATE TABLE `forums_threads` (
  `ID` int(11) NOT NULL,
  `ParentID` int(11) NOT NULL,
  `Category` int(11) NOT NULL,
  `Name` text NOT NULL,
  `Topic` text NOT NULL,
  `Owner` text NOT NULL,
  `Public` int(11) NOT NULL DEFAULT 1,
  `Deleted` int(11) NOT NULL DEFAULT 0,
  `Pinned` int(11) NOT NULL DEFAULT 0,
  `Date` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `forums_threads_groups`
--

CREATE TABLE `forums_threads_groups` (
  `ForumID` int(11) NOT NULL,
  `Name` text NOT NULL,
  `About` text NOT NULL,
  `Public` int(11) NOT NULL,
  `GroupID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `games_data`
--

CREATE TABLE `games_data` (
  `ID` int(11) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Thumbnail` text NOT NULL,
  `Creator` text NOT NULL,
  `Description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Creation_Date` date NOT NULL DEFAULT current_timestamp(),
  `Update_Date` date NOT NULL DEFAULT current_timestamp(),
  `Version` text NOT NULL,
  `category_roblox` int(11) NOT NULL DEFAULT 1,
  `category` int(11) NOT NULL DEFAULT 1,
  `Download` text NOT NULL,
  `Status` varchar(3) NOT NULL DEFAULT '0' COMMENT '0 = "Pending"  1 = "Approved" 2 = Rejected',
  `Comments` bit(1) NOT NULL DEFAULT b'1',
  `Favorites` bigint(20) NOT NULL DEFAULT 0,
  `Public` bit(1) NOT NULL DEFAULT b'1'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `games_requires`
--

CREATE TABLE `games_requires` (
  `GameID` int(11) NOT NULL,
  `AssetID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `games_versions`
--

CREATE TABLE `games_versions` (
  `Tag_Name` varchar(5) NOT NULL,
  `Tag_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `groups_allies`
--

CREATE TABLE `groups_allies` (
  `GroupID` int(11) NOT NULL,
  `AllyID` int(11) NOT NULL,
  `Enemy` bit(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `groups_data`
--

CREATE TABLE `groups_data` (
  `ID` int(11) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Description` varchar(1000) DEFAULT NULL,
  `Creator` int(11) NOT NULL,
  `Date` datetime NOT NULL DEFAULT current_timestamp(),
  `Moderated` bit(1) NOT NULL DEFAULT b'0',
  `Thumbnail` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `groups_members`
--

CREATE TABLE `groups_members` (
  `GroupID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `Rank` bit(6) NOT NULL DEFAULT b'0',
  `Date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `groups_ranks`
--

CREATE TABLE `groups_ranks` (
  `GroupID` int(11) NOT NULL,
  `RankID` int(11) NOT NULL,
  `RankName` varchar(50) NOT NULL DEFAULT 'Member'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `models_categories`
--

CREATE TABLE `models_categories` (
  `ID` int(11) NOT NULL,
  `Name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `models_data`
--

CREATE TABLE `models_data` (
  `ID` int(11) NOT NULL,
  `Name` text NOT NULL,
  `Creator` text NOT NULL,
  `Description` text NOT NULL,
  `Download` text NOT NULL,
  `Thumbnail` text DEFAULT 'QuestionMark',
  `CategoryOG` text NOT NULL,
  `Creation_Date` text NOT NULL,
  `Update_Data` date NOT NULL DEFAULT current_timestamp(),
  `category_roblox` int(11) NOT NULL DEFAULT 1,
  `category` int(11) NOT NULL DEFAULT 1,
  `Public` bit(1) NOT NULL DEFAULT b'1',
  `Status` int(11) NOT NULL DEFAULT 1,
  `Favorites` bigint(20) NOT NULL DEFAULT 0,
  `Comments` int(11) NOT NULL DEFAULT 1
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci COMMENT='Description';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rccserver_games`
--

CREATE TABLE `rccserver_games` (
  `JobID` int(11) NOT NULL,
  `SecurityKey` text NOT NULL,
  `Started` int(11) NOT NULL DEFAULT 0,
  `GameID` int(11) NOT NULL,
  `Port` int(11) NOT NULL,
  `IP` text NOT NULL,
  `Client` text NOT NULL,
  `MaxPlayers` int(11) NOT NULL DEFAULT 12,
  `PlayersOnline` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users_apparences`
--

CREATE TABLE `users_apparences` (
  `ID` int(11) NOT NULL,
  `HeadColor` text NOT NULL,
  `TorsoColor` text NOT NULL,
  `RightArmColor` text NOT NULL,
  `LeftArmColor` text NOT NULL,
  `RightLegColor` text NOT NULL,
  `LeftLegColor` text NOT NULL,
  `TShirt` text NOT NULL,
  `Shirt` text NOT NULL,
  `Pants` text NOT NULL,
  `Hat` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users_badges`
--

CREATE TABLE `users_badges` (
  `BadgeID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users_banned`
--

CREATE TABLE `users_banned` (
  `ID` int(11) NOT NULL,
  `Active` bit(1) NOT NULL DEFAULT b'1',
  `UserID` int(11) NOT NULL,
  `Warning` int(2) NOT NULL DEFAULT 0,
  `Permanent` int(2) NOT NULL DEFAULT 0,
  `Until` bigint(20) DEFAULT 0,
  `Until_str` text DEFAULT NULL,
  `Reason` text NOT NULL DEFAULT 'Breaking Roblogs Terms of service',
  `Date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users_data`
--

CREATE TABLE `users_data` (
  `ID` int(11) NOT NULL,
  `Username` varchar(30) NOT NULL,
  `Display_Name` text DEFAULT NULL,
  `Password` text NOT NULL,
  `About` text NOT NULL,
  `Join_Date` date NOT NULL DEFAULT current_timestamp(),
  `Banned` bit(1) NOT NULL DEFAULT b'0',
  `No_Messages` bit(1) NOT NULL DEFAULT b'0',
  `FilterMessages` int(1) NOT NULL DEFAULT 1,
  `Last_Seen` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users_friends`
--

CREATE TABLE `users_friends` (
  `UserID` int(11) NOT NULL,
  `FriendID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci COMMENT='friends';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users_images`
--

CREATE TABLE `users_images` (
  `ID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `AssetID` bigint(20) DEFAULT NULL,
  `Type` varchar(100) DEFAULT NULL,
  `Name` varchar(500) DEFAULT NULL,
  `Description` text DEFAULT NULL,
  `Moderated` int(1) NOT NULL DEFAULT 0,
  `Date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users_messages`
--

CREATE TABLE `users_messages` (
  `ID` bigint(20) NOT NULL,
  `ToID` int(11) NOT NULL,
  `FromID` int(11) NOT NULL,
  `Subject` varchar(78) NOT NULL,
  `Content` text NOT NULL,
  `Date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users_pending_friends`
--

CREATE TABLE `users_pending_friends` (
  `UserID` int(11) NOT NULL,
  `RequestID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users_settings`
--

CREATE TABLE `users_settings` (
  `ID` int(11) NOT NULL,
  `AllowMessages` int(1) NOT NULL DEFAULT 1,
  `FriendRequests` int(1) NOT NULL DEFAULT 1,
  `CensorText` int(1) NOT NULL DEFAULT 1,
  `PublicContact` text NOT NULL DEFAULT '1',
  `Email` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users_socialmedia`
--

CREATE TABLE `users_socialmedia` (
  `UserID` int(11) NOT NULL,
  `Site` varchar(20) NOT NULL,
  `Link` varchar(100) NOT NULL,
  `Public` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users_status`
--

CREATE TABLE `users_status` (
  `UserID` int(11) NOT NULL,
  `Message` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users_wall`
--

CREATE TABLE `users_wall` (
  `ID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `Message` text NOT NULL,
  `Date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `assets_comments`
--
ALTER TABLE `assets_comments`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `catalog_data`
--
ALTER TABLE `catalog_data`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `categories_roblox`
--
ALTER TABLE `categories_roblox`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `datapacks_data`
--
ALTER TABLE `datapacks_data`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `decals_data`
--
ALTER TABLE `decals_data`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `forums_posts`
--
ALTER TABLE `forums_posts`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `forums_replies`
--
ALTER TABLE `forums_replies`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `forums_threads_groups`
--
ALTER TABLE `forums_threads_groups`
  ADD PRIMARY KEY (`ForumID`);

--
-- Indices de la tabla `games_data`
--
ALTER TABLE `games_data`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `games_versions`
--
ALTER TABLE `games_versions`
  ADD PRIMARY KEY (`Tag_ID`);

--
-- Indices de la tabla `groups_data`
--
ALTER TABLE `groups_data`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `models_categories`
--
ALTER TABLE `models_categories`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `models_data`
--
ALTER TABLE `models_data`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `users_banned`
--
ALTER TABLE `users_banned`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `users_data`
--
ALTER TABLE `users_data`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `users_images`
--
ALTER TABLE `users_images`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `users_messages`
--
ALTER TABLE `users_messages`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `users_wall`
--
ALTER TABLE `users_wall`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `assets_comments`
--
ALTER TABLE `assets_comments`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `catalog_data`
--
ALTER TABLE `catalog_data`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `categories`
--
ALTER TABLE `categories`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `categories_roblox`
--
ALTER TABLE `categories_roblox`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `datapacks_data`
--
ALTER TABLE `datapacks_data`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `decals_data`
--
ALTER TABLE `decals_data`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `forums_posts`
--
ALTER TABLE `forums_posts`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `forums_replies`
--
ALTER TABLE `forums_replies`
  MODIFY `ID` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `forums_threads_groups`
--
ALTER TABLE `forums_threads_groups`
  MODIFY `ForumID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `games_data`
--
ALTER TABLE `games_data`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `games_versions`
--
ALTER TABLE `games_versions`
  MODIFY `Tag_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `groups_data`
--
ALTER TABLE `groups_data`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `models_categories`
--
ALTER TABLE `models_categories`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `models_data`
--
ALTER TABLE `models_data`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `users_banned`
--
ALTER TABLE `users_banned`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `users_data`
--
ALTER TABLE `users_data`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `users_images`
--
ALTER TABLE `users_images`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `users_messages`
--
ALTER TABLE `users_messages`
  MODIFY `ID` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `users_wall`
--
ALTER TABLE `users_wall`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
