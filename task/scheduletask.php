<?php

class ScheduleTaskState{
  const CHECK_PARSER = 0;
  const CHECK_FILE =   1;
  const DONE = 2;
}

class ScheduleTask{
  var $taskId;
  var $options;
  var $email;
  var $status;

  var $starttime;
  var $endtime;

  const QUERY_IS_PASSED = 'select status from b2f_task_schedule where taskId=:taskId';
  const QUERY_UPDATE_STATUS = 'update b2f_task_schedule set status=:status, endtime=:endtime where taskId=:taskId';
  const QUERY_CREATE_TASK = 'insert into b2f_task_schedule values(:blogTaskId,:options,:email,:status,:starttime,:endtime)';
  const QUERY_GET_LIST = 'select * from b2f_task_schedule where status != :status limit 0,:mylimit';
  const QUERY_GET_ORDER_LIST = 'select * from b2f_task_schedule order by status asc, taskId desc';

  const DELETE_SCHEDULE_TASK = 'delete from b2f_task_schedule where taskId=:id';
  const DELETE_SCHEDULE_TASK_BLOG = 'delete from b2f_task_blog where root=:id';
  const DELETE_SCHEDULE_TASK_FILE = 'delete from b2f_task_file where root=:id';

  public function __construct($taskId, FileOptions $options, $email, $status, $starttime, $endtime){
    $this->taskId = $taskId;
    $this->status = $status;
    $this->email  = $email;
    $this->options = $options;
    $this->starttime = $starttime;
    $this->endtime = $endtime;
  }

  public static function isPassed($taskId){
    try{
      $db = Database::getConnection();
      $prepQuery = $db->prepare(self::QUERY_IS_PASSED);
      $prepQuery->bindValue(':taskId',$taskId,PDO::PARAM_INT);
      $prepQuery->execute();

      $prepQuery->setFetchMode(PDO::FETCH_ASSOC);
      $queryData = $prepQuery->fetchAll();
      if(count($queryData) == 1){
        if($queryData[0]['status'] == ScheduleTaskState::DONE){
          return true;
        }else{
          return false;
        }
      }
      Log::error('Schedule task: found '.$prepQuery->rowCount().' with the same root = '.$taskId.'. Check database...');
      return true;
    }catch(PDOException $e){
      Log::error('Schedule task: failed to get task status with id = '.$taskId.' due error: '.$e);
    }
    return true;
  }

  public function updateStatus($state){
    try{
      $db = Database::getConnection();
      $prepQuery = $db->prepare(self::QUERY_UPDATE_STATUS);
      $prepQuery->bindValue(':status',$state,PDO::PARAM_INT);
      $prepQuery->bindValue(':endtime',time(),PDO::PARAM_INT);
      $prepQuery->bindValue(':taskId',$this->taskId,PDO::PARAM_INT);
      $prepQuery->execute();
    }catch(PDOException $e){
      Log::error('Schedule task: failed to update state due database exception: '.$e);
    }
  }

  public static function createTask($blogTaskId, FileOptions $options, $email){
    try{
      $db = Database::getConnection();
      // insert task to database
      $prepQuery = $db->prepare(self::QUERY_CREATE_TASK);
      $prepQuery->bindValue(':blogTaskId',$blogTaskId,PDO::PARAM_INT);
      $prepQuery->bindValue(':options',serialize($options),PDO::PARAM_STR);
      $prepQuery->bindValue(':email',$email,PDO::PARAM_STR);
      $prepQuery->bindValue(':status',ScheduleTaskState::CHECK_PARSER,PDO::PARAM_INT);
      $prepQuery->bindValue(':starttime',time(),PDO::PARAM_INT);
      $prepQuery->bindValue(':endtime',time(),PDO::PARAM_INT);
      $prepQuery->execute();
    }catch(PDOException $e){
      Log::error('Schedule task: failed to create due database error: '.$e);
    }
  }

  public static function getList($count){
    try{
      $db = Database::getConnection();
      $prepQuery = $db->prepare(self::QUERY_GET_LIST);
      $prepQuery->bindValue(':status',ScheduleTaskState::DONE,PDO::PARAM_INT);
      $prepQuery->bindValue(':mylimit',$count,PDO::PARAM_INT);
      $prepQuery->execute();

      $prepQuery->setFetchMode(PDO::FETCH_ASSOC);
      $queryData = $prepQuery->fetchAll();
    }catch(PDOException $e){
      Log::error('Schedule task: failed to get list due database error: '.$e);
    }
    return self::getListQuery($queryData);
  }


  public static function getOrderList(){
    try{
      $db = Database::getConnection();
      $prepQuery = $db->prepare(self::QUERY_GET_ORDER_LIST);
      $prepQuery->execute();

      $prepQuery->setFetchMode(PDO::FETCH_ASSOC);
      $queryData = $prepQuery->fetchAll();
    }catch(PDOException $e){
      Log::error('Schedule task: failed to get list due database error: '.$e);
    }
    return self::getListQuery($queryData);
  }

  private static function getListQuery($queryData){
    $tasks = array();
    $taskList = array();
    $yearsInfoArray = array();
    foreach($queryData as $data){
      $tasks[] =  new ScheduleTask($data['taskId'], unserialize($data['options']), $data['email'], $data['status'], $data['starttime'], $data['endtime']);
    }
    return $tasks;
  }

  public static function deleteScheduleTask($id){
    $db = Database::getConnection();
    $insertPrepQuery = $db->prepare(self::DELETE_SCHEDULE_TASK);
    $insertPrepQuery->bindValue(':id', $id, PDO::PARAM_INT);
    $insertPrepQuery->execute();

    $insertPrepQuery = $db->prepare(self::DELETE_SCHEDULE_TASK_BLOG);
    $insertPrepQuery->bindValue(':id', $id, PDO::PARAM_INT);
    $insertPrepQuery->execute();

    $insertPrepQuery = $db->prepare(self::DELETE_SCHEDULE_TASK_FILE);
    $insertPrepQuery->bindValue(':id', $id, PDO::PARAM_INT);
    $insertPrepQuery->execute();
  }
}
?>