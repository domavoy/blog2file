<?php
//set_include_path('a:/home/blog2file.com/www/');
//set_include_path('/home/u34921/blog2filecom/www/');
require_once('config.php');
require_once('libs/libs.php');
require_once('task/task.php');
require_once('blogs/blogs.php');
require_once('files/files.php');
require_once('lang/lang.php');
set_time_limit(0);

// if daemon not started, append state file. If already started - stop current copy
try{
  if(!isDaemonRun(Options::daemonLiveFile)){
    Log::info('__________________   Starting daemon   ______________________');
  }else{
    Log::warn('Another copy is running. Destroying current....');
    exit();
  }
}catch(Exception $e){
  Log::error('Failed to open state file. Therefore current state is RUN, due error = '.$e);
}

// set daemon as running
setDaemonStartMark();
// main cycle
while(true){
  //Log::debug('Start deamon cycle');
  //echo '.';
  $fileTasks = array();
  $blogTasks = array();
  $scheduleTasks = array();
  try{
    if(getDaemonState() == DaemonState::STOP){
      Log::info('__________________   Stopping daemon   __________________');
      exit();
    }
    // process blog tasks
    $blogTasks = BlogTask::getList(Options::blogTaskGetCount);
    //og::debug('Start deamon cycle: blog tasks: '.count($blogTasks));
    //Log::debug('Process blog tasks..., count = '.count($blogTasks));
    processBlogTasks($blogTasks);
    // proccess schedule tasks
    $scheduleTasks = ScheduleTask::getList(Options::scheduleTaskGetCount);
    //Log::debug('Start deamon cycle: sh tasks: '.count($scheduleTasks));
    //Log::debug('Process schedule tasks..., count = '.count($scheduleTasks));
    processScheduleTasks($scheduleTasks);
    // process file tasks with bad priority
    $fileTasks = FileTask::getList(Options::fileTaskGetCount);
    //Log::debug('Start deamon cycle: file tasks: '.count($fileTasks));
    //Log::debug('Process file tasks..., count = '.count($fileTasks));
    processFileTasks($fileTasks);
    // if all tasks not found, sleep
    // no need to count $scheduleTasks
    if((count($blogTasks) == 0) && (count($fileTasks) == 0)){
      //Log::debug('Start deamon cycle: usleep');
      sleep(Options::tasksNotFoundSleepTime);
    }else{
      //Log::debug('Start deamon cycle: unset');
      unset($blogTasks);
      unset($fileTasks);
      unset($scheduleTasks);
    }
  }catch(Exception $e){
    setDaemonStopMark();
    Log::error('Daemon exception: '.$e);
    exit();
  }
}
?>