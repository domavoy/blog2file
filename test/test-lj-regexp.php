<?php


/* Wordpress get month links
 $text = '<li><a href=\'http://idiot.ru/?m=200901\' title=\'January 2009\'>January 2009</a></li><li><a href=\'http://idiot.ru/?m=200902\' title=\'February 2009\'>February 2009</a></li>';

 $blogName = "idiot.ru";
 echo  preg_match_all("/$blogName\/\?m=[\d]{6}/", $text, $arr);
 echo '<pre>';
 print_r($arr);
 echo '</pre>';
 */

//Livejournal titles
//preg_match_all("/<a\s[^>]*href=([\"\']??)([^\" >]*?)\\1[^>]*>(.*)<\/a>/siU", $text, $arr, PREG_SET_ORDER);

// get all title links
//preg_match_all("/http\:\/\/$livejournal_user.livejournal\.com\/[0-9]*.html/U", $text, $arr, PREG_SET_ORDER);
//preg_match_all("/<a\s[^>]*href=\"http\:\/\/$livejournal_user.livejournal\.com\/[0-9]*.html\">(.*)<\/a>/siU", $text, $arr, PREG_SET_ORDER);
//preg_match_all("http://", "http://www.ya.ru", $arr, PREG_SET_ORDER);

/* livejoournal month links
 preg_match_all('/(?:(http\:\/\/'.$livejournal_user.'.livejournal\.com\/(2008\/[0-9]{2}\/[0-9]{2})\/)\">([0-9]*)<)/Ui', $text, $arr, PREG_SET_ORDER);

 echo '<pre>';
 print_r($arr);
 echo '</pre>';
 */

// livejournal mounth report titles and links
//'/http\:\/\/'.$livejournal_user.'.livejournal\.com\/2009\/[0-9]{2}\/[0-9]{2}\/\">/Ui'
$livejournal_user='mrparker';
$year = '2009';
//preg_match_all('/<a href="http:\/\/juliy.livejournal.com\/'.$year.'\/[\d]{2}\/[\d]{2}\/\"><b>[\d\w]*<\/b><\/a><\/dt><dd class=\"viewsubjects\">[ :\d\w]*<a href=\"http:\/\/juliy.livejournal.com\/[\d]*\.html\">/Ui', $text, $arr, PREG_SET_ORDER);

// parse month and post links
preg_match_all('/http\:\/\/'.$livejournal_user.'.livejournal\.com\/('.$year.'\/[\d]{2}\/[\d]{2}\/|[0-9]*.html)(?:\'|\")>(.*)<\/a>/Ui', $text, $arr2, PREG_SET_ORDER);

echo '<pre>';
print_r($arr);
print_r($arr2);
echo '</pre>';

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