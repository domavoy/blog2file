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
  const dbConn = 'mysql:host=78.108.81.231;dbname=b34921';
  const dbConnUser = 'u34921';
  const dbConnPassword = 'password';
  const dbConn1 = 'mysql:host=localhost;dbname=lj-import';
  const dbConnUser1 = 'blog2file';
  const dbConnPassword1 = 'password';
  // daemon & folders & images
  const daemonCmd = 			'/usr/bin/php /home/u34921/blog2filecom/www/adm/daemon.php -dinclude_path=/home/u34921/blog2filecom/www/ > /home/u34921/blog2filecom/www/adm/logs/cron.txt 2>&1 &';
  const daemonLogFile =   		'/home/u34921/blog2filecom/www/adm/logs/daemon.txt';
  const daemonUsersFile = 		'/home/u34921/blog2filecom/www/adm/logs/users.txt';
  const daemonCronFile = 		'/home/u34921/blog2filecom/www/adm/logs/cron.txt';
  const loggerCoreFileFile = 	'/home/u34921/blog2filecom/www/adm/logs/core.txt';
  const daemonStateFile = 		'/home/u34921/blog2filecom/www/adm/logs/state.txt';
  const mapFile = 				'/home/u34921/blog2filecom/www/adm/logs/map.txt';
  const tasksFile = 			'/home/u34921/blog2filecom/www/adm/logs/tasks.txt';
  const SAVE_FOLDER = 			'/home/u34921/blog2filecom/www/.saved';
  const generatedFolder = 		'/home/u34921/blog2filecom/www/out';
  const BROKEN_IMG_URL = 		'/home/u34921/blog2filecom/www/static/broken_image.png';
  const IMG_EARTH = 			'/home/u34921/blog2filecom/www/static/earth.jpg';
  const IMG_LJLOGO = 			'/home/u34921/blog2filecom/www/static/lj_logo.jpg';
  const GENERATED_FOLDER_NAME = 'out';
  // daemon options
  const daemonLiveFile = 120;
  const tasksNotFoundSleepTime = 20;
  // daemon get tasks count - declare task priority
  const scheduleTaskGetCount = 3;
  const fileTaskGetCount =     3;
  const blogTaskGetCount =     50;
  // other
  const cache = true ;
  const filterMonthCount = 4;
  const ERROR_RETURN_VALUE = -1;
  const ERROR_SUCCESS_VALUE = 1;
  const INVITE_COUNT = 1;
  //update intervals
  const analyzerTaskUpdateInterval = 10000;
  // average time to get process HTML page in parser task
  const parserCycleTime=2;
  const imagesCycleFactor=3;
  const CURRENT_YEAR = 2009;
  const DAEMON_USER = 'daemon';
  const FEEDBACK_EMAIL = 'domavoy@gmail.com';//,aka.delain@gmail.com';
  // debug options
  const IS_SAVE_FILES = false;
}
?>