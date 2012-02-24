<?php
class FileTask{
  //TODO: REF: set all private variables. add getters, setter. also update impacted code
  //TODO: REF: delete updateXX methods. Set variables and add $task->save() function
  //TODO: REF: add FileTaskState class instead TaskState.
  var $id;
  var $root;
  var $fileType;
  var $fileName;
  var $options;
  var $status;

  const LOAD_ID = 			'select * from b2f_task_file where id=:id';
  const LOAD_ROOT = 		'select * from b2f_task_file where root=:root';
  const UPDATE_FILENAME =	'update b2f_task_file set fileName=:fileName where id=:id';
  const UPDATE_STATUS = 	'update b2f_task_file set status=:status where id=:id';
  const CREATE = 			'insert into b2f_task_file values(null,:root,:fileType,:fileName,:options,:status)';
  const GET_LIST = 			'select id from b2f_task_file where status = :status limit 0,:mylimit';
  const GET_STATUS =        'select status FROM b2f_task_file WHERE root =:root';

  public function __toString(){
    return 'FileTask content: id\root\name\type\status: '.$this->id.'\\'. 
      $this->root.'\\'.
      $this->fileType.'\\'.
      $this->fileName.'\\'.
      $this->status.', Options: '.$this->options;
  }
  /**
   * Load Task from database using taskID
   * @param $id Integer taskId
   * @return void
   */
  public function loadId($id){
    $this->id = $id;
    try{
      $db = Database::getConnection();
      $prepQuery = $db->prepare(self::LOAD_ID);
      $prepQuery->bindValue(':id',$id,PDO::PARAM_INT);
      $prepQuery->execute();

      if($prepQuery->rowCount() == 1){
        $prepQuery->setFetchMode(PDO::FETCH_ASSOC);
        $taskDataArray = $prepQuery->fetch();
        $this->root = $taskDataArray['root'];
        $this->fileType = $taskDataArray['fileType'];
        $this->fileName = $taskDataArray['fileName'];
        $this->options = unserialize($taskDataArray['options']);
        $this->status = $taskDataArray['status'];
      }else{
        // TODO: REF: maybe only in debug mode. Need to get only firts task, and delete dublicated task..
        Log::error('File task: found '.$prepQuery->rowCount().' tasks with the same id = '.$id.'. Check database');
        throw new TaskNotFoundException($this->id);
      }
    }catch(PDOException $e){
      Log::error('File task: failed to load with id '.$id.', due database exception: '.$e);
      throw new TaskNotFoundException($this->id);
    }
  }

  /**
   * Load Task from database using taskRoot
   * @param $root
   * @return unknown_type
   */
  public function loadRoot($root){
    try{
      $db = Database::getConnection();
      $prepQuery = $db->prepare(self::LOAD_ROOT);
      $prepQuery->bindValue(':root',$root,PDO::PARAM_INT);
      $prepQuery->execute();

      $prepQuery->setFetchMode(PDO::FETCH_ASSOC);
      $taskDataArray = $prepQuery->fetchAll();
      if(count($taskDataArray) == 1){
        $this->id = $taskDataArray[0]['id'];
        $this->root = $taskDataArray[0]['root'];
        $this->fileType = $taskDataArray[0]['fileType'];
        $this->fileName = $taskDataArray[0]['fileName'];
        $this->options = unserialize($taskDataArray[0]['options']);
        $this->status = $taskDataArray[0]['status'];
      }else{
        // TODO: REF: maybe only in debug mode. Need to get only firts task, and delete dublicated task..
        Log::error('File task: found '.$prepQuery->rowCount().' tasks with the same root = '.$root.'. Check database');
        throw new TaskNotFoundException($this->root);
      }
    }catch(PDOException $e){
      Log::error('File task: failed to load with root '.$root.', due database exception: '.$e);
      throw new TaskNotFoundException($this->root);
    }
  }

  public function updateFileName($fileName){
    try{
      $db = Database::getConnection();
      $prepQuery = $db->prepare(self::UPDATE_FILENAME);
      $prepQuery->bindValue(':id',$this->id,PDO::PARAM_INT);
      $prepQuery->bindValue(':fileName',$fileName,PDO::PARAM_STR);
      $prepQuery->execute();
    }catch(PDOException $e){
      Log::error('File task: failed to update fileName due database exception: '.$e);
    }
  }

  public function updateStatus($taskState){
    try{
      $db = Database::getConnection();
      $prepQuery = $db->prepare(self::UPDATE_STATUS);
      $prepQuery->bindValue(':id',$this->id,PDO::PARAM_INT);
      $prepQuery->bindValue(':status',$taskState,PDO::PARAM_INT);
      $prepQuery->execute();
    }catch(PDOException $e){
      Log::error('File task: failed to update status due database exception: '.$e);
    }
  }


  /**
   * Generate file for parser task
   * @param $mainParasreTaskId tatsk id, returned by createParserTask function
   * @param $fileType
   * @return unknown_type
   */
  public static function createFileTask($root, FileOptions $fileOptions){
    $fileType = $fileOptions->fileType;

    // checking the same task in database (user may reload page)
    try{
      $db = Database::getConnection();
      $prepQuery = $db->prepare('select id from b2f_task_file where root = :root');
      $prepQuery->bindValue(':root',$root,PDO::PARAM_INT);
      $prepQuery->execute();

      if($prepQuery->rowCount() == 1){
        $prepQuery->setFetchMode(PDO::FETCH_ASSOC);
        Log::warn('File task: found other task with the same root = '.$root.'. Reusing...');
        $d = $prepQuery->fetch();
        return $d['id'];
      }
    }catch(PDOException $e){
      Log::error('File task: failed to check task in database with root '.$root.', due database exception: '.$e);
    }

    $lastId = null;
    try{
      // insert task to database
      $prepQuery = $db->prepare(self::CREATE);
      $prepQuery->bindValue(':root',$root,PDO::PARAM_INT);
      $prepQuery->bindValue(':fileType',$fileType,PDO::PARAM_INT);
      $prepQuery->bindValue(':fileName','',PDO::PARAM_STR);
      $prepQuery->bindValue(':options',serialize($fileOptions),PDO::PARAM_STR);
      $prepQuery->bindValue(':status',TaskState::IDLE,PDO::PARAM_INT);
      $prepQuery->execute();
      // get task id
      $lastId = $db->lastInsertId();
    }catch(PDOException $e){
      Log::error('File task: failed to insert task to database with root '.$root.', due database exception: '.$e);
      throw new TaskNotFoundException($this->id);
    }
    return $lastId;
  }

  public static function getList($count){
    $tasks = array();
    try{
      $db = Database::getConnection();
      $prepQuery = $db->prepare(self::GET_LIST);
      $prepQuery->bindValue(':status',TaskState::IDLE,PDO::PARAM_INT);
      $prepQuery->bindValue(':mylimit',$count,PDO::PARAM_INT);
      $prepQuery->execute();

      $prepQuery->setFetchMode(PDO::FETCH_ASSOC);
      $queryData = $prepQuery->fetchAll();
      $taskList = array();
      $yearsInfoArray = array();
      foreach($queryData as $data){
        $task = new FileTask();
        $task->loadId($data['id']);
        $tasks[] = $task;
      }
    }catch(PDOException $e){
      Log::error('File task: failed to get tasks list, due database exception: '.$e);
    }
    return $tasks;
  }

  public function isPassed(){
    if(TaskState::PASS == $this->status){
      return true;
    }else{
      return false;
    }
  }

  public function getFileName(){
    return $this->fileName;
  }
}

?>