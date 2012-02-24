<?php
require_once('config.php');
require_once('libs/libs.php');
require_once('task/task.php');
require_once('lang/lang.php');

Lang::setEnglish();

$messageStr = '';
if(isset($_POST['email']) && $_POST['email'] !=''){
  $email = $_POST['email'];
  if(Utils::checkmail($email)) {
    if(Users::isInSoonPage($email)){
      $messageStr = Lang::get(Lang::soon_msg_thanks);
    }else{
      Users::insertToSoon($email);
      $messageStr = Lang::get(Lang::soon_msg_thanks);
    }
  }else{
    $messageStr = Lang::get(Lang::soon_msg_enter_valid_email);
  }
}
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8;charset=utf-8" />
	<title>Blog2File: download and save any blogs from popular blog hostings</title>
<!--
	<link rel="shortcut icon" href="static/favicon.ico" />
-->
	<link href="/static/soon.css" media="screen" rel="stylesheet" type="text/css" />
</head>

<body>
	<div id="container">
    	<h1><img id="logo" src="/static/logo.gif" alt="Blog2File logo" width="260" height="126" /></h1>
        <div><img src="static/getinvite.gif" alt="Get Invite button" width="260" height="32" /></div>
        <div class="comingsoon">
        	<form class="cmxform" id="commentForm" method="POST" action="">
	            <input class="email" type="text" value="Email Address" name="email" id="email"
	            onfocus="if(this.value=='Email Address'){this.value='';this.style.color='#666';}"/>
                <input class="submit" type="submit" name="submit" value="" />
            </form>
        </div>
        <div class="messages"><?=$messageStr;?></div>
    </div>
</body>
</html>