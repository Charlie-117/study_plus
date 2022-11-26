SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `edu` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

CREATE TABLE `eduCard` (
  `course_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `card_id` int NOT NULL,
  `card_name` varchar(1024) COLLATE utf8_unicode_ci NOT NULL,
  `card_desc` varchar(10000) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

CREATE TABLE `eduCode` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `course` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `course_desc` varchar(1024) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

CREATE TABLE `eduQuiz` (
  `course_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `quiz_id` int NOT NULL,
  `quiz_qstn_id` int NOT NULL,
  `quiz_qstn` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `opt_a` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `opt_b` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `opt_c` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `opt_d` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `quiz_ans` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

CREATE TABLE `eduQzName` (
  `course_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `quiz_id` int NOT NULL,
  `quiz_name` varchar(1024) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

CREATE TABLE `eduVid` (
  `course_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `video_id` int NOT NULL,
  `video_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `video_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

CREATE TABLE `stud` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

CREATE TABLE `studCode` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

CREATE TABLE `studQuiz` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `course_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `quiz_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

CREATE TABLE `studScore` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `course_code` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `score` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

CREATE TABLE `studVid` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `course_code` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `video_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;


ALTER TABLE `edu`
  ADD PRIMARY KEY (`email`);

ALTER TABLE `eduCard`
  ADD PRIMARY KEY (`course_code`,`card_id`);

ALTER TABLE `eduCode`
  ADD PRIMARY KEY (`code`);

ALTER TABLE `eduQuiz`
  ADD PRIMARY KEY (`course_code`,`quiz_id`,`quiz_qstn_id`);

ALTER TABLE `eduQzName`
  ADD PRIMARY KEY (`course_code`,`quiz_id`);

ALTER TABLE `eduVid`
  ADD PRIMARY KEY (`video_id`,`course_code`);

ALTER TABLE `stud`
  ADD PRIMARY KEY (`email`);

ALTER TABLE `studCode`
  ADD PRIMARY KEY (`email`,`code`);

ALTER TABLE `studScore`
  ADD PRIMARY KEY (`email`,`course_code`);
COMMIT;
