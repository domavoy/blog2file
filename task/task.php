<?php
require_once 'blogtask.php';
require_once 'blogtaskprocessor.php';
require_once 'filetask.php';
require_once 'filetaskprocessor.php';
require_once 'scheduletask.php';
require_once 'scheduletaskprocessor.php';
require_once 'taskcache.php';

/* Type Task
 * Each Type supported own method for page content processing
 */
class TaskType{
  const CALENDAR = 0;
  const PARSER_MONTHES = 1;
  const PARSER_MONTH = 2;
  const PARSER_POST = 3;
  const FILE_GENERATE = 4;
}

/**
 * Task State
 */
class TaskState{
  const FAIL = -1;
  const IDLE = 0;
  const PASS = 1;
  const FILE = 2;
}

class FileOptions{
  var $isPostNewPage = true;
  var $isDownloadImages = false;
  var $blogTitle;
  var $blogName;
  var $blogType;
  var $fileType;
  var $language;
  var $monthes;

  public function __toString(){
    return
      '<b>Blog&amp;File&nbsp;</b>'.$this->blogName.','.$this->fileType.'<br/>'.
      '<b>Page&amp;Img&amp;Lang:&nbsp;</b>'.($this->isPostNewPage==true?1:0).'&nbsp;'.
      ($this->isDownloadImages==true?1:0).'&nbsp;'.$this->language;
  }
}

class DaemonState{
  const STOP = 'STOP';
  const RUN = 'RUN';
}

/**
 * Stop daemon process.
 * Open $daemonStateFile file, and write $daemonStateFile state to it
 * @param $daemonStateFile daemin state file
 * @return void
 */
function setDaemonStopMark(){
  $fh = fopen(Options::daemonStateFile, 'w');
  fwrite($fh, DaemonState::STOP);
  fclose($fh);
}

/**
 * Return current daemon state: Stop or start
 * @param $daemonStateFile - daemon state file
 * @return DaemonState
 */
function getDaemonState(){
  $retValue = DaemonState::STOP;
  try{
    $fh = fopen(Options::daemonStateFile, 'r');
    $fileContent = fgets($fh);
    if($fileContent == DaemonState::STOP){
      $retValue = DaemonState::STOP;
    }else   if($fileContent == DaemonState::RUN){
      $retValue = DaemonState::RUN;
    }
    fclose($fh);
  }catch(Exception $e){
    setDaemonStopMark(Options::daemonStateFile);
    return $retValue;
  }
  return $retValue;
}



/**
 * Daemon file functions
 */

/**
 * Check ifDaemonRun with daemon file time modification
 * @param $daemonStateFile
 * @param $sectime threshold time in seconds
 * @return unknown_type
 */
function isDaemonRun($sectime){
  if(getDaemonState() == DaemonState::RUN){
    if((time() -  filemtime(Options::daemonStateFile)) > $sectime){
      return false;
    } else{
      return true;
    }
  }
  return false;
}

/**
 * Update $daemonStateFile file. Write DaemonState::RUN message to file.
 * @param $daemonStateFile string daemon state file
 * @return void
 */
function setDaemonStartMark(){
  $fh = fopen(Options::daemonStateFile, 'w');
  fwrite($fh, DaemonState::RUN);
  fclose($fh);
}
?>