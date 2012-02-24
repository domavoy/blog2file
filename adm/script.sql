-- phpMyAdmin SQL Dump
-- version 2.6.1
-- http://www.phpmyadmin.net
-- 
-- Хост: localhost
-- Время создания: Авг 10 2009 г., 22:01
-- Версия сервера: 5.0.45
-- Версия PHP: 5.2.4
-- 
-- БД: `b2f`
-- 

-- --------------------------------------------------------

-- 
-- Структура таблицы `b2f_task_blog`
-- 

DROP TABLE IF EXISTS `b2f_task_blog`;
CREATE TABLE IF NOT EXISTS `b2f_task_blog` (
  `id` int(11) NOT NULL auto_increment,
  `creation` int(11) default NULL,
  `root` int(11) NOT NULL,
  `parent` int(11) NOT NULL,
  `cache` int(11) default NULL,
  `type` tinyint(20) default NULL,
  `blogType` varchar(20) default NULL,
  `blogName` varchar(60) default NULL,
  `param` text,
  `page` varchar(120) character set cp1251 collate cp1251_bulgarian_ci default NULL,
  `info` mediumtext,
  `full` mediumtext,
  `status` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `root` (`root`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 AUTO_INCREMENT=1 ;

-- 
-- Дамп данных таблицы `b2f_task_blog`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `b2f_task_cache`
-- 

DROP TABLE IF EXISTS `b2f_task_cache`;
CREATE TABLE IF NOT EXISTS `b2f_task_cache` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(300) default NULL,
  `user` varchar(100) default NULL,
  `datakey` int(30) NOT NULL default '0',
  `data` mediumtext NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 AUTO_INCREMENT=1 ;

-- 
-- Дамп данных таблицы `b2f_task_cache`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `b2f_task_file`
-- 

DROP TABLE IF EXISTS `b2f_task_file`;
CREATE TABLE IF NOT EXISTS `b2f_task_file` (
  `id` int(11) NOT NULL auto_increment,
  `root` int(11) NOT NULL,
  `fileType` tinyint(4) default NULL,
  `fileName` varchar(255) default NULL,
  `options` varchar(500) character set utf8 collate utf8_unicode_ci default NULL,
  `status` tinyint(4) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 AUTO_INCREMENT=1 ;

-- 
-- Дамп данных таблицы `b2f_task_file`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `b2f_task_schedule`
-- 

DROP TABLE IF EXISTS `b2f_task_schedule`;
CREATE TABLE IF NOT EXISTS `b2f_task_schedule` (
  `taskId` int(11) NOT NULL,
  `options` varchar(500) NOT NULL,
  `email` varchar(30) NOT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

-- 
-- Дамп данных таблицы `b2f_task_schedule`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `b2f_users`
-- 

DROP TABLE IF EXISTS `b2f_users`;
CREATE TABLE IF NOT EXISTS `b2f_users` (
  `id` int(11) NOT NULL auto_increment,
  `email` varchar(40) NOT NULL,
  `password` varchar(35) default NULL,
  `status` tinyint(4) NOT NULL,
  `inviteCount` tinyint(4) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=cp1251 AUTO_INCREMENT=2 ;

-- 
-- Дамп данных таблицы `b2f_users`
-- 

INSERT INTO `b2f_users` (`id`, `email`, `password`, `status`, `inviteCount`) VALUES (1, 'domavoy@gmail.com', '39fbe19a2794fcd2e64000002ae8b5d9', 1, 2);

-- --------------------------------------------------------

-- 
-- Структура таблицы `b2f_users_email`
-- 

DROP TABLE IF EXISTS `b2f_users_email`;
CREATE TABLE IF NOT EXISTS `b2f_users_email` (
  `email` varchar(40) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

-- 
-- Дамп данных таблицы `b2f_users_email`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `b2f_users_feedback`
-- 

DROP TABLE IF EXISTS `b2f_users_feedback`;
CREATE TABLE IF NOT EXISTS `b2f_users_feedback` (
  `username` varchar(50) NOT NULL,
  `text` text NOT NULL,
  `isEmail` tinyint(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

-- 
-- Дамп данных таблицы `b2f_users_feedback`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `b2f_users_invite`
-- 

DROP TABLE IF EXISTS `b2f_users_invite`;
CREATE TABLE IF NOT EXISTS `b2f_users_invite` (
  `username` varchar(30) default NULL,
  `invite` varchar(60) default NULL,
  `invite_email` varchar(100) NOT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;


-- --------------------------------------------------------

-- 
-- Структура таблицы `b2f_users_tasks`
-- 

DROP TABLE IF EXISTS `b2f_users_tasks`;
CREATE TABLE IF NOT EXISTS `b2f_users_tasks` (
  `userName` varchar(100) default NULL,
  `taskId` int(11) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

-- 
-- Дамп данных таблицы `b2f_users_tasks`
-- 

        