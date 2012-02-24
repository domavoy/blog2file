<?php
error_reporting(E_ALL);
require_once 'libs/libs.php';
require_once 'blogs/blogs.php';
echo '<pre>';


$address = 'http://community.livejournal.com/greg_house_ru/2008/';
$blog = new LjBlog($address);
$text = HtmlHelper::getPage($address);
print_r($blog->processYearPage($text, '2008'));

  //$address = 'http://katechkina.livejournal.com';
  //$address = 'http://community.livejournal.com/greg_house_ru';
  //$blog = new LjBlog($address);
  //echo $blog->getUserName();

  //print_r(LjBlog::checkAddress($address));
  // test TaskType::CALENDAR processor
  //$pageContent = HtmlHelper::getPage($blog->getParser()->constructCalendarAddress());
  //print_r($blog->processCalendar($pageContent));
   
  // test TaskType::YEAR processor
  //$pageContent = HtmlHelper::getPage($blog->getParser()->constructCalendarYearAddress('2008'));
  //print_r($blog->processYearPage($pageContent,'2008'));
   
   /*
  $pageContent = HtmlHelper::getPage($blog->getParser()->constructCalendarYearMonthAddress('2008', '12'));
  $info = $blog->processMonthInfo($pageContent);
  foreach($info as $date => $info){
    foreach($info as $number => $title){
      //print_r($i);
      print_r(array($number,$date, $title));
    }
  }
   */
  //$pageContent = HtmlHelper::getPage($blog->getParser()->constructLightPostAddress('404030'));
  //print_r($blog->processPostText($pageContent));
   
  //print_r($livejournalBlogAction->getParserInfoByDateAndPost('2008/12/13',404434, '���������'));

  //print_r($livejournalBlogAction->getParserInfoByMonth('2008', '12'));
  //print_r($livejournalBlogAction->getMonthPostsByDate('2009','01'));
  //
  //print_r($blog->getAnalyzerInfo());
  //print_r($blog->getAnalyzerInfoByYear('2007'));
  //
  //print_r($livejournalBlogAction->getPostInfo());
  //print_r($blog->getPostInfoByYear('2009'));
  //
  //print_r($livejournalBlogAction->getLivejournalYearList());

?>