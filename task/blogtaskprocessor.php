<?php
/**
 * Blog Tasks processing
 * @param $tasks array of BlogTask objects
 * @return void
 */
function processBlogTasks(array $tasks){
  foreach($tasks as $task){
    Log::task('Blog task processor: process '.IdConverter::getTaskName($task->type).' task with id/root/cache = '.$task->id.'/'.$task->root.''.$task->cache.'. Page = '.$task->page);
    $blog = null;
    $pageContent = null;
    try{
      // create Blog object, to get address from it
      $blog = BlogFactory::getByName($task->blogType, $task->blogName);
      $task->blogName = $blog->getAddress();
      // process HTML page
      if(!($task->type == TaskType::CALENDAR || $task->type == TaskType::PARSER_MONTHES)){
        $pageContent = HtmlHelper::getPage($task->page);
        if(Options::IS_SAVE_FILES){ Utils::mapFsContent($task->page, $pageContent); }
      }
      switch($task->type){
        case TaskType::CALENDAR:
          $pageContent = HtmlHelper::getPage($blog->getParser()->constructCalendarAddress());
          if(Options::IS_SAVE_FILES){ Utils::mapFsContent($blog->getParser()->constructCalendarAddress(), $pageContent); }
          $yearsList = $blog->processCalendar($pageContent);
          $overallYearInfo = array();
          foreach($yearsList as $year){
            $pageContent = HtmlHelper::getPage($blog->getParser()->constructCalendarYearAddress($year));
            if(Options::IS_SAVE_FILES){ Utils::mapFsContent($blog->getParser()->constructCalendarYearAddress($year), $pageContent); }
            $yearInfo = $blog->processYearPage($pageContent,$year);
            $overallYearInfo+=$yearInfo;
          }
          TaskCache::saveAnalyzer($task->blogType, $task->blogName,$overallYearInfo);
          $task->param = $yearsList;
          $task->info = $overallYearInfo;
          break;
        case TaskType::PARSER_MONTHES:
          foreach($task->getInput() as $month){
            $taskId = $task->createDoneChildTask(TaskType::PARSER_MONTH, $blog->getParser()->constructCalendarYearMonthAddress($month[0], $month[1]), $month);
            $newTask = new BlogTask();
            $newTask->loadFromId($taskId);
            //process new task
            // check mothes data in cache
            $cacheId = TaskCache::isParser($newTask->blogType, $newTask->blogName, $month[0], $month[1]);
            if($cacheId >= 0){
              // data found in cache
              Log::task('Blog task processor: PARSER_MONTHES found in cache, with id = '.$cacheId);
              $newTask->status = TaskState::PASS;
              $newTask->cache = $cacheId;
            }else{
              // data not found in cache
              Log::task('Blog task processor: PARSER_MONTHES data not found in cache. Create new tasks..');
              $pageContent = HtmlHelper::getPage($newTask->page);
              if(Options::IS_SAVE_FILES){ Utils::mapFsContent($newTask->page, $pageContent); }
              $newTask->setOutput($blog->processMonthInfo($pageContent));
              foreach($newTask->info as $date => $info){
                foreach($info as $number => $title){
                  $newTask->createChildTask(TaskType::PARSER_POST, $blog->getParser()->constructLightPostAddress($number), array($number,$date, $title));
                }
              }
            }
            $newTask->save();
          }
          break;
        case TaskType::PARSER_POST:
          $infoArray = $task->getInput();
          $task->setOutput($blog->processPostText($pageContent,$infoArray[0],$infoArray[1],$infoArray[2]));
          break;
      }
      $task->status = TaskState::PASS;
    }catch(TaskNotFoundException $e){
      Log::error('Blog task processor: exception: Task not found: '.$e->getTaskId());
      $task->setOutput('Blog task processor: exception: Task not found: '.$e->getTaskId());
      $task->status = TaskState::FAIL;
    }catch(HttpPageNotFoundException $e){
      Log::error('Blog task processor: exception: Http page not found: '.$e->getUrl());
      $task->setOutput('Blog task processor: exception: Http page not found: '.$e->getUrl());
      $task->status = TaskState::FAIL;
    }catch(BlogTypeNotFoundException $e){
      Log::error('Blog task processor: exception: Blog type not found: '.$e->getBlogType());
      $task->setOutput('Blog task processor: exception: Blog type not found: '.$e->getBlogType());
      $task->status = TaskState::FAIL;
    }catch(Exception $e){
      Log::error('Blog task processor: exception: failed to process data: '.$e);
      $task->setOutput('Failed to process data: '.$e);
      $task->status = TaskState::FAIL;
    }
    //$task->full = $pageContent;
    $task->save();
    // clean resources
    unset($task);
    unset($blog);
    unset($pageContent);
  }
  unset($tasks);
}
?>