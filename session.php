<?php
session_start();

require_once('config.php');
require_once('libs/libs.php');
require_once('task/task.php');
require_once('lang/lang.php');

if(isset($_GET['exit'])){
  session_destroy();
  unset($_GET['exit']);
  Location::goToLogin();
}

if(isset($_SESSION['user']) && isset($_SESSION['password']) && isset($_SESSION['SID'])){
  if(md5(crypt($_SESSION['user'],$_SESSION['password'])) == $_SESSION['SID']){
    $data = Users::getUserInfo($_SESSION['user'],$_SESSION['password']);
    if($data == false){
      Location::goToComingSoon();
    }else{
      CurSession::setUserName($data[0]['email']);
      CurSession::setInviteCounts($data[0]['inviteCount']);
    }
  }
}else{
  Location::goToComingSoon();
}
?>