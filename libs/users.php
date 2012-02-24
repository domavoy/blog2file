<?php
class InviteStatus{
  const notActivated = 0;
  const activated = 1;
}

class Users{
  // users
  const CHECK_USER = 'SELECT * FROM b2f_users WHERE email=:email and password=:pass and status != 0';
  const IF_USER_EXISTS = 'SELECT id FROM b2f_users WHERE email=:email';
  const INSERT_USER = 'insert into b2f_users values(:id, :email,:password,:state,:inviteCount, :isEmail, :time)';
  // invite
  const INSERT_INVITE = 'insert into b2f_users_invite values(:uid, :invite, :invite_email, :status, :time)';
  const UPDATE_INVITE_EMAIL = 'update b2f_users set inviteCount = inviteCount - 1 where email=:email';
  const DELETE_FROM_SOON = 'delete from b2f_users_email where email=:email';
  const CHECK_INVITE = 'SELECT * FROM b2f_users_invite WHERE invite=:invite and status = :status';
  const DELETE_INVITE = 'update b2f_users_invite set status = :status where invite = :invite';
  // coming soon
  const IS_SOON_EMAIL = 'SELECT * FROM b2f_users_email WHERE email=:email';
  const INSERT_SOON_EMAIL = 'insert into b2f_users_email values(:email, :time)';

  const INSERT_TASK_TO_USER = 'insert into b2f_users_tasks values(:userName, :taskid)';
  const SELECT_USER_TASKS = 'SELECT t.taskId
  									f.options
  									f.status FROM b2f_users_tasks t
  									              b2f_task_file f
  									where t.userName=:userName and t.taskId=f.root';
  const INSERT_FEEDBACK = 'insert into b2f_users_feedback values(:email, :text, :isEmail, :time)';
  const GET_USERS_LIST = 'SELECT *  FROM b2f_users';
  const GET_INVITES_LIST = 'SELECT * FROM b2f_users_email';
  const GET_FEEDBACK_LIST = 'SELECT * FROM b2f_users_feedback order by t desc';
  const GET_USERS_INVITE_LIST = 'SELECT * FROM b2f_users_invite where status=:status order by t asc';
  const USER_ADD_INVITE = 'update b2f_users set inviteCount = inviteCount + 1 where id=:id';

  const SET_TASK_TO_USER = 'insert into b2f_users_tasks values(:userName, :taskId)';

  public static function getUserTasks($userName){
    $tasksList = array();
    $db = Database::getConnection();
    $selectQuery = $db->prepare(self::SELECT_USER_TASKS);
    $selectQuery->bindValue(':userName',  $userName, PDO::PARAM_STR);
    $selectQuery->setFetchMode(PDO::FETCH_ASSOC);
    $selectQuery->execute();
    foreach($selectQuery->fetchAll() as $data){
      $tasksList[] = array($data['t.taskId'], unserialize($data['f.options']), $data['f.status']);
    }
    return $tasksList;
  }

  public static function getUserInfo($email, $password){
    $db = Database::getConnection();
    $selectQuery = $db->prepare(Users::CHECK_USER);
    $selectQuery->bindValue(':email', $email, PDO::PARAM_STR);
    $selectQuery->bindValue(':pass', $password, PDO::PARAM_STR);
    $selectQuery->execute();
    $selectQuery->setFetchMode(PDO::FETCH_ASSOC);
    $data = $selectQuery->fetchAll();
    if(count($data) == 1){
      return $data;
    }else{
      return false;
    }
  }

  public static function ifUserExists($email){
    $db = Database::getConnection();
    $selectQuery = $db->prepare(Users::IF_USER_EXISTS);
    $selectQuery->bindValue(':email',  $email, PDO::PARAM_STR);
    $selectQuery->execute();
    if(count($selectQuery->fetchAll()) == 0){
      return false;
    }
    return true;
  }

  //TODO: REF: rename to addUser
  public static function insertUser($email, $password, $isEmail){
    $db = Database::getConnection();
    $insertPrepQuery = $db->prepare(Users::INSERT_USER);
    $insertPrepQuery->bindValue(':id', null, PDO::PARAM_INT);
    $insertPrepQuery->bindValue(':email', $email, PDO::PARAM_STR);
    $insertPrepQuery->bindValue(':password', $password, PDO::PARAM_STR);
    $insertPrepQuery->bindValue(':state', 1, PDO::PARAM_INT);
    $insertPrepQuery->bindValue(':inviteCount', Options::INVITE_COUNT, PDO::PARAM_INT);
    $insertPrepQuery->bindValue(':isEmail', $isEmail, PDO::PARAM_INT);
    $insertPrepQuery->bindValue(':time', time(), PDO::PARAM_INT);
    return $insertPrepQuery->execute();
  }


  //TODO: REF: rename to createNewInvitation
  public static function newInvitation($uid, $uniqId, $email){
    $db = Database::getConnection();
    // insert new invite to table
    $insertPrepQuery = $db->prepare(Users::INSERT_INVITE);
    $insertPrepQuery->bindValue(':uid', $uid, PDO::PARAM_STR);
    $insertPrepQuery->bindValue(':invite', $uniqId, PDO::PARAM_STR);
    $insertPrepQuery->bindValue(':invite_email', $email, PDO::PARAM_STR);
    $insertPrepQuery->bindValue(':status', InviteStatus::notActivated, PDO::PARAM_INT);
    $insertPrepQuery->bindValue(':time', time(), PDO::PARAM_INT);
    $insertPrepQuery->execute();
    // decrease user invite count
    $updatePrepQuery = $db->prepare(Users::UPDATE_INVITE_EMAIL);
    $updatePrepQuery->bindValue(':email', $uid, PDO::PARAM_STR);
    $updatePrepQuery->execute();
    // update coming soon data
    $updatePrepQuery = $db->prepare(self::DELETE_FROM_SOON);
    $updatePrepQuery->bindValue(':email', $email, PDO::PARAM_STR);
    $updatePrepQuery->execute();
  }

  public static function checkInvite($inviteId){
    $db = Database::getConnection();
    // check invite in database
    $selectQuery = $db->prepare(Users::CHECK_INVITE);
    $selectQuery->bindValue(':invite',  $inviteId, PDO::PARAM_STR);
    $selectQuery->bindValue(':status',  InviteStatus::notActivated, PDO::PARAM_INT);
    $selectQuery->setFetchMode(PDO::FETCH_ASSOC);
    $selectQuery->execute();
    // if invite not found, go to get invite page
    if(count($selectQuery->fetchAll()) != 1) {
      return false;
    }
    return true;
  }

  public static function getInviteEmail($inviteId){
    $db = Database::getConnection();
    // check invite in database
    $selectQuery = $db->prepare(Users::CHECK_INVITE);
    $selectQuery->bindValue(':invite',  $inviteId, PDO::PARAM_STR);
    $selectQuery->bindValue(':status',  InviteStatus::notActivated, PDO::PARAM_INT);
    $selectQuery->setFetchMode(PDO::FETCH_ASSOC);
    $selectQuery->execute();
    $data = $selectQuery->fetchAll();
    // if invite not found, go to get invite page
    if(count($data) != 1) {
      return false;
    }
    return $data[0]['invite_email'];
  }

  /**
   * Update user invite status. Sented invite -> activeted
   * @param $inviteId
   * @return unknown_type
   */
  public static function updateInvite($inviteId){
    $db = Database::getConnection();
    $deleteInviteQuery= $db->prepare(Users::DELETE_INVITE);
    $deleteInviteQuery->bindValue(':status', InviteStatus::activated, PDO::PARAM_INT);
    $deleteInviteQuery->bindValue(':invite', $inviteId, PDO::PARAM_STR);
    $deleteInviteQuery->execute();
  }

  /**
   * Id user email exists on coming soon page
   * @param $email
   * @return unknown_type
   */
  public static function isInSoonPage($email){
    $db = Database::getConnection();
    $selectQuery = $db->prepare(Users::IS_SOON_EMAIL);
    $selectQuery->bindValue(':email',  $email, PDO::PARAM_STR);
    $selectQuery->setFetchMode(PDO::FETCH_ASSOC);
    $selectQuery->execute();
    if(count($selectQuery->fetchAll()) >= 1) {
      return true;
    }
    return false;
  }

  /**
   * Insert data from coming soon page
   * @param $email user email
   * @return void
   */
  public static function insertToSoon($email){
    $db = Database::getConnection();
    $insertPrepQuery = $db->prepare(Users::INSERT_SOON_EMAIL);
    $insertPrepQuery->bindValue(':email', $email, PDO::PARAM_STR);
    $insertPrepQuery->bindValue(':time', time(), PDO::PARAM_INT);
    $insertPrepQuery->execute();
  }

  /**
   * Insetr user feedback
   * @param $user user name
   * @param $text feedback text
   * @param $isEmail is sent email, after problem resolution
   * @return void
   */
  public static function insertFeedback($user, $text, $isEmail){
    $db = Database::getConnection();
    $insertPrepQuery = $db->prepare(Users::INSERT_FEEDBACK);
    $insertPrepQuery->bindValue(':email', $user, PDO::PARAM_STR);
    $insertPrepQuery->bindValue(':text', $text, PDO::PARAM_STR);
    $insertPrepQuery->bindValue(':isEmail', $isEmail, PDO::PARAM_STR);
    $insertPrepQuery->bindValue(':time', time(), PDO::PARAM_INT);
    $insertPrepQuery->execute();
  }

  /**
   * Return users list
   * @return list
   */
  public static function getUsersList(){
    try{
      $db = Database::getConnection();
      $selectQuery = $db->prepare(self::GET_USERS_LIST);
      $selectQuery->execute();
      $selectQuery->setFetchMode(PDO::FETCH_ASSOC);
      return $selectQuery->fetchAll();
    }catch(Exception $e){
      return false;
    }
  }

  /**
   * Return users, on coming soon page
   * @return list
   */
  public static function getInvitesList(){
    try{
      $db = Database::getConnection();
      $selectQuery = $db->prepare(self::GET_INVITES_LIST);
      $selectQuery->execute();
      $selectQuery->setFetchMode(PDO::FETCH_ASSOC);
      return $selectQuery->fetchAll();
    }catch(Exception $e){
      return false;
    }
  }

  /**
   * Return feedback list
   * @return list
   */
  public static function getFeedbackList(){
    try{
      $db = Database::getConnection();
      $selectQuery = $db->prepare(self::GET_FEEDBACK_LIST);
      $selectQuery->execute();
      $selectQuery->setFetchMode(PDO::FETCH_ASSOC);
      return $selectQuery->fetchAll();
    }catch(Exception $e){
      return false;
    }
  }

  /**
   * Return user -> invite user
   * @param $isInvited if true show registered invited, if false return not registered users
   * @return users
   */
  public static function getUsersInvitesList($isInvited){
    try{
      $db = Database::getConnection();
      $selectQuery = $db->prepare(self::GET_USERS_INVITE_LIST);
      $selectQuery->bindValue(':status', ($isInvited==true)?1:0, PDO::PARAM_INT);
      $selectQuery->execute();
      $selectQuery->setFetchMode(PDO::FETCH_ASSOC);
      return $selectQuery->fetchAll();
    }catch(Exception $e){
      return false;
    }
  }

  /**
   * Add 1 invite to user
   * @param $id user id
   * @return void
   */
  public static function addInvite($id){
    $db = Database::getConnection();
    $insertPrepQuery = $db->prepare(self::USER_ADD_INVITE);
    $insertPrepQuery->bindValue(':id', $id, PDO::PARAM_STR);
    $insertPrepQuery->execute();
  }

  public static function deleteComingSoon($id){
    $db = Database::getConnection();
    $updatePrepQuery = $db->prepare(self::DELETE_FROM_SOON);
    $updatePrepQuery->bindValue(':email', $id, PDO::PARAM_STR);
    $updatePrepQuery->execute();
  }

  public static function setTaskToUser($userName, $taskId){
    $db = Database::getConnection();
    $insertPrepQuery = $db->prepare(Users::SET_TASK_TO_USER );
    $insertPrepQuery->bindValue(':userName', $userName, PDO::PARAM_STR);
    $insertPrepQuery->bindValue(':taskId', $taskId, PDO::PARAM_INT);
    $insertPrepQuery->execute();
  }
}
?>