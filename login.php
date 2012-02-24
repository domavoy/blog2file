<?php
session_start();
require_once('config.php');
require_once('libs/libs.php');
require_once('task/task.php');
require_once('lang/lang.php');

$messageStr = '';
if(isset($_POST['submit'])) {
  //Проверяем данные
  $login = $_POST['login'];
  $upass = $_POST['password'];
  if($login !='' AND $upass !='') {
    $userInfo = Users::getUserInfo($login,md5($upass));
    if($userInfo != false) {
      $_SESSION['user'] = $userInfo[0]['email'];
      $_SESSION['password'] = $userInfo[0]['password'];
      $_SESSION['SID'] = md5(crypt($userInfo[0]['email'],$userInfo[0]['password']));
      Location::goToIndex();
    }
    else {
      $messageStr = Lang::get(Lang::login_msg_badpw);
    }
  }else{
    $messageStr = Lang::get(Lang::login_msg_badpw);//Lang::get(Lang::login_msg_enter_something);
  }
}
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8;charset=utf-8" />
	<title><?=Lang::get(Lang::login_form_title)?></title>
<!-- 
	<link rel="shortcut icon" href="static/favicon.ico" /> 
-->
	<link href="/static/soon.css" media="screen" rel="stylesheet" type="text/css" />
</head>

<body>
	<div id="container">
    	<h1><img id="logo" src="/static/logo.gif" alt="Blog2File logo" width="260" height="126" /></h1>
        <div><img src="static/login.gif" alt="Get Invite button" width="260" height="32" /></div>
        <form id="commentForm" method="POST" action="">
          <div class="loginInput">
  	            <input class="login" type="text" value="" name="login" id="login" />
          </div>
          <div class="passwordInput">
  	            <input class="password" type="password" value="" name="password" id="password" />
          </div>
           <div class="loginSubmitButton">
           		<input class="submit" type="submit" name="submit" value = ""/>
           </div>
        </form>
        <div class="messages"><?=$messageStr;?></div>
    </div>
</body>
</html>