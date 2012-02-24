<?php
/*

$text = file_get_contents("f:\\denwer\\file.txt");
$livejournal_user='katechkina';


preg_match_all("/<div style='margin-left: 30px'>.*\/div>/siU", $text, $parseData, PREG_SET_ORDER);
echo '<pre>';
//print_r($parseData[0][0]);
print_r(getTagsList($parseData[0][0]));
echo '</pre>';
*/

require_once('../lib/HtmlHelper.php');
$source = HtmlHelper::getHtmlPage('http://kniazenok.livejournal.com/tag/');

print_r(getTagsList($source));

function getTagsList($tagPageText) {
   $tagArray = array();
   preg_match_all('/http\:\/\/kniazenok.livejournal\.com\/tag\/.*[^>]+>/Ui', $tagPageText , $tagArray, PREG_SET_ORDER);
   return $tagArray;
   $tags = array();
   foreach($tagArray as $tagData){
      preg_match_all('/title="([\d]*) .*"/Ui', $tagData[0], $value, PREG_SET_ORDER);
      $tags[$tagData[1]] =  $value[0][1];
   }
   return $tags;
}



/* parse Livejournal light post - worked
 preg_match_all("/<div style='margin-left: 30px'>.*\/div>/siU", $text, $parseData, PREG_SET_ORDER);
 echo '<pre>';
 print_r($parseData);
 echo '</pre>';
 */

/* Livejournal Calendar post count fix
 require_once('../lib/HtmlHelper.php');
 $source = HtmlHelper::getHtmlPage('http://shkarlupki.livejournal.com/calendar/');

 $year = 2007;


 //Parse livejournal year data
 preg_match_all("/2007.*<\/html>/siU", $source, $parseData, PREG_SET_ORDER);
 echo '<pre>';
 print_r($parseData);
 echo '</pre>';
 */


/* Wordpress get month links
 $text = '<li><a href=\'http://idiot.ru/?m=200901\' title=\'January 2009\'>January 2009</a></li><li><a href=\'http://idiot.ru/?m=200902\' title=\'February 2009\'>February 2009</a></li>';

 $blogName = "idiot.ru";
 echo  preg_match_all("/$blogName\/\?m=[\d]{6}/", $text, $arr);
 echo '<pre>';
 print_r($arr);
 echo '</pre>';
 */

/*	 //Wordpress get posts page links
 preg_match_all("/<div class=\"post.*<a\s[^>]*href=(\"??)([^\" >]*?)\\1[^>]*>(.*)<\/a>.*<small>(.*)<\/small>/siU", $text, $arr, PREG_SET_ORDER);
 echo '<pre>';
 print_r($arr);
 echo '</pre>';
 */

/*Wordpress get new page link
 preg_match_all("/<div class=\"alignleft\">[\s]*<a\s[^>]*href=(\"??)([^\" >]*?)\\1[^>]*>(.*)<\/a>/siU", $text, $arr, PREG_SET_ORDER);
 echo '<pre>';
 print_r($arr);
 echo '</pre>';
 */

/* WP text
 preg_match_all("/<div class=\"entry\">(.*)<p class=\"postmetadata/si", $text, $arr, PREG_SET_ORDER);
 echo '<pre>';
 print_r($arr);
 echo '</pre>';
 */


?>