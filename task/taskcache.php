<?php
class TaskCache{

  public static function isAnalyzer($blogType, $blogName){
    if(Options::cache == false){
      return -1;
    }
    try{
      $db = Database::getConnection();
      $prepQuery = $db->prepare('select id from b2f_task_cache where name = :name and user = :user and datakey = :datakey');
      $prepQuery->bindValue(':name',$blogType,PDO::PARAM_STR);
      $prepQuery->bindValue(':user',$blogName,PDO::PARAM_STR);
      $prepQuery->bindValue(':datakey',0,PDO::PARAM_INT);
      $prepQuery->execute();
      $prepQuery->setFetchMode(PDO::FETCH_ASSOC);
      $queryData = $prepQuery->fetchAll();
      if(count($queryData) == 1){
        Log::task('Cache task: found analyzer data');
        return $queryData[0]['id'];
      }else{
        Log::task('Cache task: not found analyzer data');
        return -1;
      }
    }catch(PDOException $e){
      Log::debug('Cache task: failed to check analyzer data in cache: FAIL, PDO exception');
      return -1;
    }
  }

  public static function saveAnalyzer($blogType, $blogName, $blogAnalyzerData){
    if(count($blogAnalyzerData) == 0){
      return true;
    }
    try{
      $db = Database::getConnection();
      $prepQuery = $db->prepare('delete from b2f_task_cache
      							where name = :blogId and user = :user and dataKey = :dataKey'); 
      $prepQuery->bindValue(':blogId',$blogType,PDO::PARAM_STR);
      $prepQuery->bindValue(':user',$blogName,PDO::PARAM_STR);
      $prepQuery->bindValue(':dataKey',0,PDO::PARAM_INT);
      $prepQuery->execute();

      $insertPrepQuery = $db->prepare('insert into b2f_task_cache values(null,:blogId,:user,:dataKey,:data)');
      $insertPrepQuery->bindValue(':blogId',$blogType,PDO::PARAM_INT);
      $insertPrepQuery->bindValue(':user',$blogName,PDO::PARAM_STR);
      $insertPrepQuery->bindValue(':dataKey',0,PDO::PARAM_INT);
      $insertPrepQuery->bindValue(':data',serialize($blogAnalyzerData),PDO::PARAM_STR);
      $insertPrepQuery->execute();
      return true;
    }catch(PDOException $e){
      Log::error('Cache task: failed to save analyzer task. Data = '.$blogType.'/'.$blogName);
      return false;
    }
  }

  public static function getAnalyzer($cacheId){
    if(Options::cache == false){
      return - 1;
    }
    try{
      $db = Database::getConnection();
      $prepQuery = $db->prepare('select data from b2f_task_cache where id=:id');
      $prepQuery->bindValue(':id',$cacheId,PDO::PARAM_STR);
      $prepQuery->execute();

      $prepQuery->setFetchMode(PDO::FETCH_ASSOC);
      $queryData = $prepQuery->fetchAll();

      if(count($queryData) == 1){
        return unserialize($queryData[0]['data']);
      }else{
        return -1;
      }
    }catch(PDOException $e){
      Log::error('Cache task: failed to get analyzer task. cacheId = '.$cacheId);
      return -1;
    }
  }
  /**
   * Ckecked data in cache. If data found -> return record id
   * @param $blogType
   * @param $blogName
   * @param $year
   * @param $month
   * @return unknown_type
   */
  public static function isParser($blogType, $blogName, $year, $month){
    if(Options::cache == false){
      return - 1;
    }
    try{
      $db = Database::getConnection();
      $prepQuery = $db->prepare('select id from b2f_task_cache where name = :name and user = :user and datakey = :datakey');
      $prepQuery->bindValue(':name',$blogType,PDO::PARAM_STR);
      $prepQuery->bindValue(':user',$blogName,PDO::PARAM_STR);
      $prepQuery->bindValue(':datakey',(int)$year.$month,PDO::PARAM_STR);
      $prepQuery->execute();

      $prepQuery->setFetchMode(PDO::FETCH_ASSOC);
      $queryData = $prepQuery->fetchAll();

      if(count($queryData) == 1){
        return $queryData[0]['id'];
      }else{
        return -1;
      }
    }catch(PDOException $e){
      Log::error('Cache task: failed to check parser data due database error: '.$e);
      return -1;
    }
  }

  /**
   * Save month parser data in cache. Call during month data processing
   * @param $blogType BlogType type of blog
   * @param $blogName String blog address
   * @param $year String year
   * @param $month String year
   * @param $blogParserInfoArк array(BlogParserInfo) parser data for month
   * @return void
   */
  public static function saveParserDataInCache($blogType, $blogName, $year, $month, $blogParserInfoArr){
    if(count($blogParserInfoArr) == 0){
      return true;
    }
    $dataKey = (int)$year.$month;
    try{
      $db = Database::getConnection();
      $prepQuery = $db->prepare('delete from b2f_task_cache
      							where name = :blogId and user = :user and dataKey = :dataKey'); 
      $prepQuery->bindValue(':blogId',$blogType,PDO::PARAM_STR);
      $prepQuery->bindValue(':user',$blogName,PDO::PARAM_STR);
      $prepQuery->bindValue(':dataKey',$dataKey,PDO::PARAM_INT);
      $prepQuery->execute();

      $insertPrepQuery = $db->prepare('insert into b2f_task_cache values(null,:blogId,:user,:dataKey,:data)');
      $insertPrepQuery->bindValue(':blogId',$blogType,PDO::PARAM_INT);
      $insertPrepQuery->bindValue(':user',$blogName,PDO::PARAM_STR);
      $insertPrepQuery->bindValue(':dataKey',$dataKey,PDO::PARAM_INT);
      $insertPrepQuery->bindValue(':data',serialize($blogParserInfoArr),PDO::PARAM_STR);
      $insertPrepQuery->execute();
      return true;
    }catch(PDOException $e){
      Log::error('Cache task: failed to save parser task. Data = '.$blogType.'/'.$blogName.'/'.$year.'/'.$month);
      return false;
    }
  }

}
?>