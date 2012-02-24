<?php
error_reporting(E_ALL);
/**
 * Contain all configuration parameters
 * 	Database
 * 	Daemon
 * 	Folders
 *
 */
class Options{
  // database
  const dbConn = 'mysql:host=localhost;dbname=b2f';
  const dbConnUser = 'blog2file';
  const dbConnPassword = 'password';
  const dbConn1 = 'mysql:host=localhost;dbname=lj-import';
  const dbConnUser1 = 'blog2file';
  const dbConnPassword1 = 'password';
  // daemon & folders & images
  const daemonCmd = 			'start /b a:/usr/local/php5/php -cA:/usr/local/php5/phpc.ini -fa:/home/blog2file.com/www/adm/daemon.php -dinclude_path=a:/home/blog2file.com/www/';
  const daemonLogFile =   		'a:/home/blog2file.com/www/adm/logs/daemon.txt';
  const daemonUsersFile = 		'a:/home/blog2file.com/www/adm/logs/users.txt';
  const daemonCronFile = 		'a:/home/blog2file.com/www/adm/logs/cron.txt';
  const loggerCoreFileFile = 	'a:/home/blog2file.com/www/adm/logs/core.txt';
  const daemonStateFile = 		'a:/home/blog2file.com/www/adm/logs/state.txt';
  const mapFile =				'a:/home/blog2file.com/www/adm/logs/map.txt';
  const tasksFile =				'a:/home/blog2file.com/www/adm/logs/tasks.txt';
  const SAVE_FOLDER = 			'a:/home/blog2file.com/.saved';
  const generatedFolder = 		'a:/home/blog2file.com/www/.out';
  const BROKEN_IMG_URL = 		'a:/home/blog2file.com/www/static/broken_image.png';
  const IMG_EARTH = 			'a:/home/blog2file.com/www/static/earth.jpg';
  const IMG_LJLOGO = 			'a:/home/blog2file.com/www/static/lj_logo.jpg';
  const GENERATED_FOLDER_NAME = '.out';
  // daemon options
  const daemonLiveFile = 120;
  const tasksNotFoundSleepTime =5; 
  // daemon get tasks count - declare task priority
  const scheduleTaskGetCount = 3;
  const fileTaskGetCount =     3;
  const blogTaskGetCount =     50;
  // other
  const cache = true;
  const filterMonthCount = 4;
  const ERROR_RETURN_VALUE = -1;
  const ERROR_SUCCESS_VALUE = 1;
  const INVITE_COUNT = 2;
  //update intervals
  const analyzerTaskUpdateInterval = 3000;
  // average time to get process HTML page in parser task
  const parserCycleTime=5;
  const imagesCycleFactor=3;
  const CURRENT_YEAR = 2009;
  const DAEMON_USER = 'daemon';
  const FEEDBACK_EMAIL = 'domavoy@gmail.com';
  // debug options
  const IS_SAVE_FILES = true;
}
?>