<?php
function processScheduleTasks(array $tasks){
  foreach($tasks as $task){
    try{
      Log::task('Schedule task processor: process task with id/statuse = '.$task->taskId.'/'.IdConverter::getScheduleTaskName($task->status));
      switch($task->status){
        case ScheduleTaskState::CHECK_PARSER:
          $percent = BlogTask::getParserPercent($task->taskId);
          if($percent == 1){
            FileTask::createFileTask($task->taskId, $task->options);
            $task->updateStatus(ScheduleTaskState::CHECK_FILE);
          }
          break;
        case ScheduleTaskState::CHECK_FILE:
          $fileTask = new FileTask();
          $fileTask->loadRoot($task->taskId);
          if($fileTask->isPassed()){
            $fileName = Options::GENERATED_FOLDER_NAME.'/'.end(explode('/',$fileTask->getFileName()));
            Log::task('Schedule task processor: file name = '.$fileName);
            try{
              $filesize = Utils::bytesConvert(filesize($fileTask->getFileName()));
              Log::task('Schedule task processor: file size = '.$filesize);
            }catch(Exception $e){
              $filesize = '';
            }
            UsersHandler::sendBlogGeneratedMessage($fileName, $filesize, $task->options->blogName, $task->email, $task->options->language);
            $task->updateStatus(ScheduleTaskState::DONE);
          }
          break;
      }
    }catch(Exception $e){
      Log::error('Schedule task processor: failed to process due error: '.$e);
    }
    Log::task('Schedule task processor: processed normally');
  }
  unset($tasks);
}
?>