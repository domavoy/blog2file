<?php
require_once('../config.php');
require_once('../blogs/blogs.php');
set_time_limit(0);
define('DIR','c:/denwer/lj-export');

// convert lj database to files
// 1. convert calendar
// 2. convert years
// 3. convert years monthes
// 4. convert posts
try{
  $db = Database::getConnection1();
  $prepQuery = $db->prepare('select type, blogName, param ,info, full from b2f_task_blog');
  $prepQuery->execute();

  $prepQuery->setFetchMode(PDO::FETCH_ASSOC);
  $queryData = $prepQuery->fetchAll();

  foreach($queryData as $info){
    $type = $info['type'];
    $blogName = $info['blogName'];
    $param = $info['param'];
    $content = $info['full'];
    $info = $info['info'];
    if($type == 4){
      $param = $info;
    }

    list($dir, $file) = processData($type, $param);
    if($dir != ''){
      $directory = DIR.'/'.$blogName.'/'.$dir;
    }else{
      $directory = DIR.'/'.$blogName;
    }
    writeInfo($directory, $file, $content);
  }
}catch(PDOException $e){
  return -1;
}










function processData($type, $param){
  $path = '';
  switch($type){
    case 0:
      $path = processCalendar($param);
      break;
    case 1:
      $path = processYear($param);
      break;
    case 3:
      $path = processYearMonth($param);
      break;
    case 4:
      $path = processPost($param);
      break;
  }
  return array($path[0],$path[1]);
}

function writeInfo($directory, $file, $content){
  @mkdir($directory, '0777', true);
  $fh = fopen( $directory.'/'.$file, 'w+');
  fwrite($fh, $content);
  fclose($fh);
}

/**
 * Process calendar data, type: 0
 * @param $param no need
 * @return String path
 */
function processCalendar($param){
  return array('calendar','index.html');
}

/**
 * Process year data, type: 1
 * @param $param s:4:"2003"; serialaized
 * @return String path
 */
function processYear($param){
  $year = unserialize($param);
  return  array($year,'index.html');
}

/**
 * Process year month data, type: 3
 * @param $param a:2:{i:0;s:4:"2009";i:1;s:2:"01";}, serialized
 * @return String path
 */
function processYearMonth($param){
  $yearMonth = unserialize($param);
  return array($yearMonth[0].'/'.$yearMonth[1],'index.html');
}

/**
 * Process post data, type: 4
 * @param $param BlogParserInfo object, serialized
 * @return String path
 */
function processPost($param){
  $blogParserInfoObj = unserialize($param);
  return array('',$blogParserInfoObj[0]->id.'.html');
}
?>