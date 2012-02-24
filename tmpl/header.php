<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<title><?=Lang::get(Lang::header_title)?></title>
	
   <!-- TODO:  <link href="/favicon.ico?1244682517" rel="shortcut icon" />--> 

	<link href="/static/style.css" media="screen" rel="stylesheet" type="text/css" />
  <!--[if IE 6]><link href="/static/ie6.css" media="screen" rel="stylesheet" type="text/css" /><![endif]-->
  <!--[if IE 7]><link href="/static/ie7.css" media="screen" rel="stylesheet" type="text/css" /><![endif]-->

  <script src="/static/jquery-1.3.2.js" type="text/javascript"></script>
  <script src="/static/jquery.corners.js" type="text/javascript"></script>
  <script src="/static/jquery.cookie.js" type="text/javascript"></script>
  
  <script src="/static/application.js" type="text/javascript"></script>
<!-- Slider -->
  <link rel="stylesheet" href="static/slider/slider.css" type="text/css" media="screen" />
  <script type="text/javascript" src="static/slider/slider.js"></script>
  <!-- Utils(JSON parser) -->
  <script type="text/javascript" src="static/util.js"></script>

</head>

<body>



<div class="pageContainer">


	<div class="header">
    <div class="logo">
      <a href="/"><img src="/static/logo_index.gif" alt="Blog2File.com"/></a>
    </div>

    <div class="controls">
        <div class="logout">
          <span id="user_display_name"><?=CurSession::getUserName()?></span><strong>&nbsp;&nbsp;&nbsp;<a href="?exit=1"><?=Lang::get(Lang::header_exit)?></a></strong>  
  <br/><br/>
         <!--<strong><?=Lang::get(Lang::header_language)?></strong><a href="?lang=ru">Русский</a>&nbsp;&nbsp;<a href="?lang=en">English</a>   -->      
  
        </div>
        
      
    </div>
	</div>


<div class = "mymenu_main">
<div class = "mymenu">
  <div class = "links">
		<a href="/"><?=Lang::get(Lang::header_main)?></a> | 
        <a href="/invite.php"><?=Lang::get(Lang::header_invite)?></a> | 
       	<a href="/feedback.php"><?=Lang::get(Lang::header_feedback)?></a> | 
    	<a href="/help.php"><?=Lang::get(Lang::header_help)?></a> | 
    	<a href="/about.php"><?=Lang::get(Lang::header_about)?></a>
  </div>
</div>
</div>