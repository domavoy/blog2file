<?php
function processFileTasks(array $tasks){
  foreach($tasks as $task){
    Log::info('File task processor: start proccess task '.$task);
    try{
      // TODO: 136.set normal file name with blog/user/date...
      Lang::setLanguage($task->options->language);
      $task->fileName = Options::generatedFolder.'/'.$task->options->blogType.'_'.$task->options->blogName.'_'.mt_rand(100000,999999);
      $file = FileFactory::getByName($task->fileType,$task->fileName);
      $task->updateFileName($file->fileName);
      $blogParserArray = BlogTask::getParserData($task->root);
      if(count($blogParserArray) == 0){
        Log::warn('File task processor: no parser data found for task, with root = '.$task->root.'. Set -1 percent for file task...');
        $task->updateStatus(TaskState::FAIL);
      }else{
        $file->setIsPostNewPage($task->options->isPostNewPage);
        $file->setIsDownloadImages($task->options->isDownloadImages);
        $file->renderMainPage($task->options->blogTitle, $task->options->blogName,'');
        $blogparserObjCount = count($blogParserArray);
        foreach($blogParserArray as $blogParserObj){
          $file->renderPost($blogParserObj->title, $blogParserObj->date, $blogParserObj->text);
        }
        $file->renderEndPage();
        $file->save();
      }
    }catch(FileTypeNotFoundException $e){
      Log::error('File task processor: type not found: '.$e->getType());
      $task->updateStatus(TaskState::FAIL);
    }catch(Exception $e){
      Log::error('File task processor: failed to process, due exception: '.$e);
      $task->updateStatus(TaskState::FAIL);
    }
    $task->updateStatus(TaskState::PASS);
    unset($file);
    unset($blogParserArray);
    Log::info('File task processor: processed normally');
  }
  unset($tasks);
}
?>