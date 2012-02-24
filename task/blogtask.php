<?php
class BlogTask{
  //TODO: REF: Rename TaskState to BlogTaskState
  var $id;
  var $root;
  var $cache;
  var $type;
  var $blogType;
  var $blogName;
  var $param;
  var $page;
  var $info;
  var $full;
  var $status;

  //punlic functions
  const BLOGTASK_LOADID = 		'select * from b2f_task_blog where id=:id';
  const BLOGTASK_SAVE = 		'update b2f_task_blog set cache = :cache, info=:info, full=:full, status=:status, param=:param, blogName=:blogName where id=:id';
  // static controller functions
  const BLOGTASK_CREATE = 		'insert into b2f_task_blog values(null,:creation,:root,:parent,:cache,:type,:blogtype,:blogname,:param, :page,"",:full,:status)';
  const BLOGTASK_UPDATEROOT = 	'update b2f_task_blog set root=:root where id=:id';
  const BLOGTASK_GETLIST = 		'select * from b2f_task_blog where status=:status  order by type asc, creation asc limit 0,:mylimit';
  const BLOGTASK_GETPERCENT = 	'SELECT count(id) percent FROM b2f_task_blog WHERE STATUS = 1 AND root=:root
							   	 UNION ALL 
							   	 SELECT count( id ) FROM b2f_task_blog WHERE status != -1 and root =:root
							   	 UNION ALL
							   	 SELECT count( id ) FROM b2f_task_blog WHERE status = -1 and root =:root';
  const GET_IDLE_COUNT = 'SELECT count(id) idleCount FROM b2f_task_blog WHERE STATUS = :idleStatus';

  public function setOutput($info){
    $this->info = $info;
  }

  public function getInput(){
    return $this->param;
  }

  public function loadFromId($id){
    try{
      $db = Database::getConnection();
      $prepQuery = $db->prepare(self::BLOGTASK_LOADID);
      $prepQuery->bindValue(':id',$id,PDO::PARAM_INT);
      $prepQuery->execute();

      if($prepQuery->rowCount() == 1){
        $prepQuery->setFetchMode(PDO::FETCH_ASSOC);
        $taskDataArray = $prepQuery->fetch();
        $this->loadFromArray($taskDataArray);
      }else{
        // TODO: REF: maybe never. Need to get only firts task, and delete dublicated task..
        Log::error('Blog task: found '.$prepQuery->rowCount().' tasks with the same id= '.$this->id.'. Check blog task table...');
        throw new TaskNotFoundException($this->id);
      }
    }catch(PDOException $e){
      throw new TaskNotFoundException($this->id);
    }
  }

  public function loadFromArray($taskDataArray){
    $this->id = $taskDataArray['id'];
    $this->root = $taskDataArray['root'];
    $this->cache = $taskDataArray['cache'];
    $this->type = $taskDataArray['type'];
    $this->blogType = $taskDataArray['blogType'];
    $this->blogName = $taskDataArray['blogName'];
    $this->param = unserialize($taskDataArray['param']);
    $this->page = $taskDataArray['page'];
    $this->info = unserialize($taskDataArray['info']);
  }

  public function save(){
    try{
      $db = Database::getConnection();
      $prepQuery = $db->prepare(self::BLOGTASK_SAVE);
      $prepQuery->bindValue(':id',$this->id,PDO::PARAM_INT);
      $prepQuery->bindValue(':cache',$this->cache,PDO::PARAM_STR);
      $prepQuery->bindValue(':info',serialize($this->info),PDO::PARAM_STR);
      $prepQuery->bindValue(':full',serialize($this->full),PDO::PARAM_STR);
      $prepQuery->bindValue(':status',$this->status,PDO::PARAM_INT);
      $prepQuery->bindValue(':param',serialize($this->param),PDO::PARAM_STR);
      $prepQuery->bindValue(':blogName',$this->blogName,PDO::PARAM_STR);
      $prepQuery->execute();
    }catch(PDOException $e){
      throw new TaskNotFoundException($this->id);
    }
  }

  public function createChildTask($taskType, $page, $info = ''){
    return self::createBlogTask($this->root, $this->id, $taskType, $this->blogType, $this->blogName, $page, $info);
  }

  public function createDoneChildTask($taskType, $page, $info = ''){
    return self::createBlogTask($this->root, $this->id, $taskType, $this->blogType, $this->blogName, $page, $info, TaskState::PASS);
  }

  /**
   * Create new Core Task
   * @param $type TaskType type of task
   * @param $blogType BlogType type of blog
   * @param $blogName blog address
   * @param $page page address
   * @param $info task info
   * @return integer task identificator
   */
  public static function createBlogTask($root, $parent, $type, $blogType, $blogName, $page, $param = '', $status = TaskState::IDLE){
    $lastId = null;
    try{
      $db = Database::getConnection();
      // insert task to database
      $prepQuery = $db->prepare(self::BLOGTASK_CREATE);
      $prepQuery->bindValue(':creation',time(),PDO::PARAM_INT);
      $prepQuery->bindValue(':root',$root,PDO::PARAM_INT);
      $prepQuery->bindValue(':parent',$parent,PDO::PARAM_INT);
      $prepQuery->bindValue(':cache',null,PDO::PARAM_INT);
      $prepQuery->bindValue(':type',$type,PDO::PARAM_INT);
      $prepQuery->bindValue(':blogtype',$blogType,PDO::PARAM_INT);
      $prepQuery->bindValue(':blogname',$blogName,PDO::PARAM_STR);
      $prepQuery->bindValue(':param',serialize($param),PDO::PARAM_STR);
      $prepQuery->bindValue(':page',$page,PDO::PARAM_STR);
      $prepQuery->bindValue(':full','',PDO::PARAM_STR);
      $prepQuery->bindValue(':status',$status,PDO::PARAM_INT);
      $prepQuery->execute();
      // get task id
      $lastId = $db->lastInsertId();
      // set task->root = task->id
      if($root == 0){
        $prepQuery = $db->prepare(self::BLOGTASK_UPDATEROOT );
        $prepQuery->bindValue(':root',$lastId,PDO::PARAM_INT);
        $prepQuery->bindValue(':id',$lastId,PDO::PARAM_INT);
        $prepQuery->execute();
      }
    }catch(PDOException $e){
      throw new TaskNotFoundException($this->id);
    }
    return $lastId;
  }

  /**
   * Create Task to parse blog contents
   * @param $blogType BlogType type of blog
   * @param $blogName String blog address
   * @param $monthes array() array of selected monthes
   * @return integer Main task id
   */
  public static function createParserTask($blogType, $blogName, $monthes){
    return self::createBlogTask(0, 0, TaskType::PARSER_MONTHES, $blogType, $blogName, '', $monthes);
  }

  /**
   * Create Task to analyze blog
   * @param $blogType BlogType type of blog
   * @param $blogName String Blog address
   * @return integer Main Task Id
   */
  public static function createAnalyzerTask($blogType, $blogName){
    return self::createBlogTask(0, 0, TaskType::CALENDAR, $blogType, $blogName,'');
  }

  /**
   * Return $count BlogTask object from database
   * @param $count integer count of tasks
   * @return array(BlogTask)
   */
  public static function getList($count){
    $tasks = array();
    try{
      $db = Database::getConnection();
      $prepQuery = $db->prepare(self::BLOGTASK_GETLIST);
      $prepQuery->bindValue(':status',TaskState::IDLE,PDO::PARAM_INT);
      $prepQuery->bindValue(':mylimit',$count,PDO::PARAM_INT);
      $prepQuery->execute();
      $prepQuery->setFetchMode(PDO::FETCH_ASSOC);
      $queryData = $prepQuery->fetchAll();
      //Log::debug(print_r($queryData, true ));
      foreach($queryData as $data){
        $newTask = new BlogTask();
        $newTask->loadFromArray($data);
        $tasks[] = $newTask;
      }
    }catch(Exception $e){
      Log::error('Blog task: failed to get list due error: '.$e);
    }
    return $tasks;
  }

  public static function getParserPercent($taskId){
    $percent = 0;
    try{
      $db = Database::getConnection();
      $prepQuery = $db->prepare(self::BLOGTASK_GETPERCENT);
      $prepQuery->bindValue(':root',$taskId,PDO::PARAM_INT);
      $prepQuery->execute();

      $prepQuery->setFetchMode(PDO::FETCH_ASSOC);
      $queryData = $prepQuery->fetchAll();
      if(count($queryData) == 3){
        if($queryData[1]['percent'] != 0){
          $percent = $queryData[0]['percent']/$queryData[1]['percent'];
        }
        if($queryData[0]['percent'] == 0 && $queryData[1]['percent'] == 0 && $queryData[2]['percent'] > 0){
          throw new BlogTaskFailedException();
        }
      }
    }catch(PDOException $e){
    }
    return $percent;
  }

  public static function getParserData($id){
    $arr = array_merge(self::getAvailableParserData($id),self::getCachedParserData($id));
    usort($arr,'BlogParserInfo::sort');
    return $arr;
  }

  /**
   * Return array of parser data for pasrer task(by id). And insert month to cache
   * @param $id integer Task Id
   * @return array(BlogParserInfo) array of parser data from task_blog table
   */
  public static function getAvailableParserData($id){
    $yearInfo = array();
    try{
      $db = Database::getConnection();
      //TODO: REF: move to constants
      $prepQuery = $db->prepare('SELECT blogtype, blogname, type, param, info
									FROM b2f_task_blog
									WHERE (type=:monthType OR type=:postType) 
									AND root=:root AND cache IS NULL and status=1
									ORDER BY id');
      $prepQuery->bindValue(':root',$id,PDO::PARAM_INT);
      $prepQuery->bindValue(':monthType',TaskType::PARSER_MONTH,PDO::PARAM_INT);
      $prepQuery->bindValue(':postType',TaskType::PARSER_POST,PDO::PARAM_INT);
      $prepQuery->execute();

      $prepQuery->setFetchMode(PDO::FETCH_ASSOC);
      $queryData = $prepQuery->fetchAll();

      $postCollector = array();
      $cyclePostCollector = array();
      $prev = null;
      //blogtype		blogname	TYPE	param									info
      //livejournal 	katechkina 	3 		a:2:{i:0;s:4:"2008";i:1;s:2:"12";} 		a:6:{s:11:"2008/12/01/";a:2:{i:404030;s:28:"Р”?...
      //livejournal 	katechkina 	4 		a:3:{i:0;i:404030;i:1;s:11:"2008/..  	a:1:{i:0;O:14:"BlogParserInfo":6:{s:2:"id";i:40403...
      //livejournal 	katechkina 	4 		a:3:{i:0;i:404434;i:1;s:11:"2008/..		a:1:{i:0;O:14:"BlogParserInfo":6:{s:2:"id";i:40443.

      foreach($queryData as $d){
        if($d['type'] == TaskType::PARSER_MONTH){
          if($prev != null){
            TaskCache::saveParserDataInCache($prev[2], $prev[3], $prev[0], $prev[1], $postCollector);
            $cyclePostCollector+=$postCollector;
          }
          $prev = unserialize($d['param']);
          $prev[2] = $d['blogtype'];
          $prev[3] =$d['blogname'];
          $postCollector = array();
        }else if($d['type'] == TaskType::PARSER_POST){
          $postCollector = array_merge($postCollector,unserialize($d['info']));
        }
      }
      TaskCache::saveParserDataInCache($prev[2], $prev[3], $prev[0], $prev[1], $postCollector);
      $cyclePostCollector = array_merge($cyclePostCollector,$postCollector);
    }catch(PDOException $e){
      return $yearInfo;
    }
    //ksort($yearInfo);
    return $cyclePostCollector;
  }

  /**
   * Return cached data for parser task(by id)
   * @param $id -integer Parser Task id
   * @return array(BlogParserInfo) array of parser data from cache
   */
  public static function getCachedParserData($id){
    $cachedMonthes = array();
    try{
      $db = Database::getConnection();
      //TODO: REF: move to constants
      $prepQuery = $db->prepare('SELECT cache.data from b2f_task_blog blog, b2f_task_cache cache where blog.cache=cache.id and blog.root =:root and blog.type=:type and blog.status = 1 and blog.cache is not null');
      $prepQuery->bindValue(':root',$id,PDO::PARAM_INT);
      $prepQuery->bindValue(':type',TaskType::PARSER_MONTH,PDO::PARAM_INT);
      $prepQuery->execute();

      $prepQuery->setFetchMode(PDO::FETCH_ASSOC);
      $queryData = $prepQuery->fetchAll();

      foreach($queryData as $data){
        $cachedMonthes = array_merge($cachedMonthes,unserialize($data['data']));
      }
    }catch(PDOException $e){
      return $cachedMonthes;
    }
    //ksort($yearInfo);
    return $cachedMonthes;
  }

  /**
   * Return calendar data for task. Used in calendar page
   * @param $rootTaskId
   * @return Calendar data / false
   */
  public static function getCalendar($rootTaskId){
    try{
      $db = Database::getConnection();
      //TODO: REF: move to constants
      $prepQuery = $db->prepare('SELECT info, status FROM b2f_task_blog WHERE status = :status and root =:root and type=:type');
      $prepQuery->bindValue(':status',TaskState::PASS,PDO::PARAM_INT);
      $prepQuery->bindValue(':root',$rootTaskId,PDO::PARAM_INT);
      $prepQuery->bindValue(':type',TaskType::CALENDAR,PDO::PARAM_INT);
      $prepQuery->execute();

      $prepQuery->setFetchMode(PDO::FETCH_ASSOC);
      $queryData = $prepQuery->fetchAll();

      if(count($queryData) == 1){
        Log::debug('BlogTask: getCalendar: data found: '.print_r($queryData[0]['info'],true));
        if(count(unserialize($queryData[0]['info'])) == 0){
          return 1;
        }
        return unserialize($queryData[0]['info']);
      }
    }catch(PDOException $e){
      Log::error('BlogTask: getCalendar: data not foundd, due database exception: '.$e);
      return false;
    }
    Log::task('BlogTask: getCalendar: data not found');
    return false;
  }

  public static function updateCalendarData($yearInfoArray, $year, $blog){
    if(isset($yearInfoArray[$year])){
      try{
        $htmlPage = HtmlHelper::getPage($blog->getParser()->constructCalendarYearAddress($year));
      }catch(HttpPageNotFoundException $e){
        return $yearInfo;
      }
      $yearInfo = $blog->processYearPage($htmlPage,$year);
      unset($yearInfoArray[$year]);
      $yearInfoArray+=$yearInfo;
    }
    return $yearInfoArray;
  }

  public static function getIdleTaskCount(){
    try{
      $db = Database::getConnection();
      $prepQuery = $db->prepare(self::GET_IDLE_COUNT);
      $prepQuery->bindValue(':idleStatus',TaskState::IDLE,PDO::PARAM_INT);
      $prepQuery->execute();
      $prepQuery->setFetchMode(PDO::FETCH_ASSOC);
      $queryData = $prepQuery->fetchAll();
      return $queryData[0]['idleCount'];
    }catch(PDOException $e){
      Log::error('BlogTask: getIdleTaslCount error: failed to get idle task count, due database exception: '.$e);
    }
    return 0;
  }
}
?>