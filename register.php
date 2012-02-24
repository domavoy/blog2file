<?php
session_start();
require_once('config.php');
require_once('libs/libs.php');
require_once('task/task.php');
require_once('lang/lang.php');

// check invite
if(isset($_GET['id']) && $_GET['id'] !=''){
  $inviteId = $_GET['id'];
  if(!Users::checkInvite($inviteId)){
    Location::goToComingSoon();
  }
  $email = Users::getInviteEmail($inviteId);
}
else{
  Location::goToComingSoon();
}

// registration
$messageStr = '';
if(isset($_POST['do'])){
  $db = Database::getConnection();
  if(!isset($_POST['inviteId'])){
    Location::goToComingSoon();  
    Log::error('Register error: failed to find inviteId');
  }
  $inviteId = $_POST['inviteId'];
  $email = Users::getInviteEmail($inviteId);
  if($email === false){
    Log::error('Register error: failed to find email for inviteId = '.$inviteId);
    Location::goToComingSoon();  
  }
  $isEmail = Checker::getRequestValues('isEmail', 1, 0);

  if(!Users::ifUserExists($email)){
    //Проверка ввведенных паролей
    if($_POST['password1'] !='' AND $_POST['password2'] !='' AND $_POST['password1'] === $_POST['password2']){
      //Проверяем на валидность электронный адрес
      if(Utils::checkmail($email) !== false) {
        $pass = $_POST['password1'];
        if(Users::insertUser($email,md5($pass),$isEmail)) {
          Users::updateInvite($inviteId);
          $_SESSION['user'] = $email;
          $_SESSION['password'] = md5($pass);
          $_SESSION['SID'] = md5(crypt($email,md5($pass)));
          Location::goToIndex();
        }
        else {
          $messageStr = Lang::get(Lang::register_msg_try_later);
          unset($_POST['do']);
        }
      }
      else {
        $messageStr = Lang::get(Lang::register_msg_bad_email);
        unset($_POST['do']);
      }
    }
    else {
      $messageStr =  Lang::get(Lang::register_msg_passwords_not_match);
      unset($_POST['do']);
    }
  }
  else {
    $messageStr =  Lang::get(Lang::register_msg_user_exists);
    unset($_POST['do']);
  }
}
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8;charset=utf-8" />
	<title><?=Lang::get(Lang::register_form_title)?></title>
<!-- 
	<link rel="shortcut icon" href="static/favicon.ico" /> 
-->
	<link href="/static/soon.css" media="screen" rel="stylesheet" type="text/css" />
</head>

<body>
	<div id="container">
    	<h1><img id="logo" src="/static/logo.gif" alt="Blog2File logo" width="260" height="126" /></h1>
        <div><img src="static/register_header.gif" alt="Get Invite button" width="172" height="34" /></div>
         <div style = "padding: 0px 5px 15px 0px;">
			<?=Lang::get(Lang::register_form_your_login).$email;?> 
         </div>
        <form id="commentForm" method="POST" action="">
          <div class="registerPassword1">
  	            <input class="password1" type="password" value="" name="password1" id="password1" />
          </div>
          <div class="registerPassword2">
  	            <input class="password2" type="password" value="" name="password2" id="password2" />
                
          </div>
           <div class="registerSubmitButton">
           		<input class="submit" type="submit" name="do" value="" />
           </div>
           <input type = "hidden" name = "inviteId" value = "<?=$inviteId;?>">
        </form>
        <div class="messages"><?=$messageStr;?></div>
    </div>
</body>
</html>