<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Blog2File prototype - Step1: Analyzer page</title>
  <!-- Progress bar -->
  <script type="text/javascript" src="static/prototype.js"></script>
  <script type="text/javascript" src="static/progress/jsProgressBarHandler.js"></script>
  <!-- Slider -->
  <link rel="stylesheet" href="static/slider/slider.css" type="text/css" media="screen" />
  <script type="text/javascript" src="static/jquery-1.2.6.pack.js"></script>
  <script type="text/javascript" src="static/slider/slider.js"></script>
  <!-- Utils(JSON parser) -->
  <script type="text/javascript" src="static/util.js"></script>
  <link rel="stylesheet" href="static/main.css" type="text/css">
</head>
<body bgcolor="#ffffff">
<h1>Blog2File</h1>
<hr/>

<script> 
var str = '["out\/407636.pdf","25mb"]'.parseJSON(); 
var $j = jQuery.noConflict();

alert(str[0]);
alert(str[1]);			
</script>

</body>
</html>