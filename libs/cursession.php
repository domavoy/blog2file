<?php
class CurSession{

  // userName data
  public static function setUserName($userName){
    $_SESSION['userName'] = $userName;
  }

  public static function getUserName(){
    if(isset($_SESSION['userName'])){
      return $_SESSION['userName'];
    }else{
      return Options::DAEMON_USER;
    }
  }

  // invite count data
  public static function setInviteCounts($inviteCounts){
    $_SESSION['inviteCounts'] = $inviteCounts;
  }

  public static function getInviteCounts(){
    if(isset($_SESSION['inviteCounts'])){
      return $_SESSION['inviteCounts'];
    }else{
      return 0;
    }
  }

  // Download started checks
  public static function setParserTask($taskId){
    $_SESSION['parserTask'] =  $taskId;
  }

  public static function clearParserTask(){
    unset($_SESSION['rootTask']);
  }

  public static function getParserTask(){
    if(isset($_SESSION['parserTask'])){
      return $_SESSION['parserTask'];
    }
    return 0;
  }

  /**
   * Check current user fileTask state
   * @return unknown_type
   */
  public static function checkParserTask(){
    $taskId = self::getParserTask();
    if($taskId!=0){
      return !ScheduleTask::isPassed($taskId);
    }else{
      return 0;
    }
  }
}
?>