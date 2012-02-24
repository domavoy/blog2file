<?php
try{
  require_once('session.php');
  // parse params
  $blogAddress = Checker::getSession('blogaddress');
  $blogType = Checker::getSession('blogtype');
  $fileType = Checker::getSession('filetype');
  $blogName = Checker::getRequest('blogName');
  $blogTitle = Checker::getRequest('blogTitle');
  $isDownloadImages = Checker::getSession('isDownloadImages');
  $isPostNewPage = Checker::getSession('checkPostNewPages');
  $monthData = Checker::getRequest('month');
  if($monthData == null){
    return;
  }

  $monthesListInfo =  Utils::convertHtmlMonthes($monthData);
  // create or replace new parser task
  $timeMessageSeconds = 0;
  if(!isset($_SESSION['currentParserTaskId'])){
    $taskId =  BlogTask::createParserTask($blogType, $blogAddress, $monthesListInfo['monthesList']);
    $timeMessageSeconds =  ($monthesListInfo['postsCount'] + BlogTask::getIdleTaskCount()) * Options::parserCycleTime;
    if($isDownloadImages == true){
      $timeMessageSeconds*=Options::imagesCycleFactor;
    }
    //$timeMessage =  date('j F, G:i',$timeMessageSeconds + time());
    $upToGenerationTime = Lang::getFormattedDate($timeMessageSeconds);
    $options = new FileOptions();
    $options->blogTitle =$blogTitle;
    $options->blogName = $blogName;
    $options->fileType = $fileType;
    $options->isDownloadImages = $isDownloadImages;
    $options->isPostNewPage = $isPostNewPage;
    $options->language = Lang::$currentLanguage;
    $options->monthes = serialize($monthData);
    $options->blogType = $blogType;
    ScheduleTask::createTask($taskId, $options, CurSession::getUserName());
    $_SESSION['currentParserTaskId'] = $taskId;
    CurSession::setParserTask($taskId);
  }else{
    Location::goToIndex();
  }
  require_once("tmpl/header.php");
  ?>

<div class="pageContent root">
  <div class="createForm" style = "padding-left: 50px">
  
<div id="generateMesageId">
<h2><span class="gray"><?=Lang::get(Lang::status_progress).$blogAddress;?></span></h2>
</div>

  <?php
  if($timeMessageSeconds != 0){?>
<div><?=Lang::get(Lang::status_wait1).$upToGenerationTime;?>.</div>
<div><?=Lang::get(Lang::status_wait2)?></div>
<div><a href="/"><?=Lang::get(Lang::status_goto)?></a></div>
  <?php
  }else{
    ?>
<div><?=Lang::get(Lang::status_error)?></div>
<div></div>
    <?php
  }
  require_once("tmpl/footer.php");
}catch(Exception $e){
  unset($_SESSION['currentParserTaskId']);
  Log::error('Exception on status page: '.$e);
  Location::goToError();
}
?>