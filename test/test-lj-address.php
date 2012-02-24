<?php
echo '<pre>';

$address[] = 'http://katechkina.livejournal.com/406152.html';
$address[] = 'katechkina.livejournal.com';
$address[] = 'http://community.livejournal.com/greg_house_ru/52359.html';

foreach($address as $addr){
   print_r(array($addr, parseUserPostAddress($addr),parseCommunityPostAddress($addr)));
}


function parseUserPostAddress($address) {
   $httpPrefix='(?:http:\\\\www.|http:\/\/www.|http:\/\/|http:\\\|www.|)';
   $reqexp = '/'.$httpPrefix.'(.*).livejournal\.com\/([\d]+).html/Ui';
   preg_match_all($reqexp, $address, $nameAray, PREG_SET_ORDER);
   if ($nameAray[0][1] == '') {
      return false;
   }
   return array($nameAray[0][1],$nameAray[0][2]);
}

function parseCommunityPostAddress($address){
   $httpPrefix='(?:http:\\\\www.|http:\/\/www.|http:\/\/|http:\\\|www.|)';
   $reqexp = '/'.$httpPrefix.'community.livejournal\.com\/([\w\d_]+)\/([\d]+).html/Ui';
   preg_match_all($reqexp, $address, $nameAray, PREG_SET_ORDER);
   if ($nameAray[0][1] == '') {
      return false;
   }
   return array($nameAray[0][1],$nameAray[0][2]);
}

/*

// Livejournal: is Community
echo '<pre>';

$address[] = 'http:\\community.livejournal.com/ru_photoshop/';
$address[] = 'http:\\community.livejournal.com/ru_greg_house_ru';
$address[] = 'http:\\www.community.livejournal.com/ru_photoshop/';
$address[] = 'http://community.livejournal.com/ru_photoshop/';
$address[] = 'http://www.community.livejournal.com/ru_photoshop/';
$address[] = 'www.community.livejournal.com/ru_photoshop/';
$address[] = 'community.livejournal.com/ru_photoshop/';
$address[] = 'http:\\davydov.blogspot.com';
$address[] = 'http:\\www.davydov.blogspot.com';
$address[] = 'http://davydov.blogspot.com';
$address[] = 'http://www.davydov.blogspot.com';
$address[] = 'www.davydov.blogspot.com';
$address[] = 'davydov.blogspot.com';
$address[] = 'http:\\katechkina.livejournal.com';
$address[] = 'http:\\www.katechkina.livejournal.com';
$address[] = 'http://katechkina.livejournal.com';
$address[] = 'http://www.katechkina.livejournal.com';
$address[] = 'www.katechkina.livejournal.com';
$address[] = 'katechkina.livejournal.com';

foreach($address as $addr){
print_r(array($addr, isCommunityAddress($addr), parseUserName($addr)));
}

function isCommunityAddress($address){
$httpPrefix='(?:http:\\\\www.|http:\/\/www.|http:\/\/|http:\\\|www.|)';
$reqexp = '/'.$httpPrefix.'community.livejournal\.com\/(.*)/Ui';
return preg_match($reqexp, $address);
}

function parseUserName($address) {
$address.="\n";
$httpPrefix='(?:http:\\\\www.|http:\/\/www.|http:\/\/|http:\\\|www.|)';
$reqexp = '/'.$httpPrefix.'community.livejournal\.com\/(.*)(\\n|\/)/iU';
preg_match_all($reqexp, $address, $nameAray, PREG_SET_ORDER);
if (sizeof($nameAray) == 0) {
return "";
}
return $nameAray[0][1];
}

/*
// Livejournal community name parser
echo '<pre>';

$address[] = 'http:\\community.livejournal.com/ru_photoshop/';
$address[] = 'http:\\www.community.livejournal.com/ru_photoshop/';
$address[] = 'http://community.livejournal.com/ru_photoshop/';
$address[] = 'http://www.community.livejournal.com/ru_photoshop/';
$address[] = 'www.community.livejournal.com/ru_photoshop/';
$address[] = 'community.livejournal.com/ru_photoshop/';

foreach($address as $addr){
$httpPrefix='(?:http:\\\\www.|http:\/\/www.|http:\/\/|http:\\\|www.|)';
$reqexp = '/'.$httpPrefix.'community.livejournal\.com\/(.*)\//Ui';
preg_match_all($reqexp, $addr, $nameAray, PREG_SET_ORDER);
if (sizeof($nameAray) == 0) {
return "";
}
print_r($nameAray);
}
*/

/*
 // Blogspot aka Google Blogger username parser
 echo '<pre>';

 $address[] = 'http:\\davydov.blogspot.com';
 $address[] = 'http:\\www.davydov.blogspot.com';
 $address[] = 'http://davydov.blogspot.com';
 $address[] = 'http://www.davydov.blogspot.com';
 $address[] = 'www.davydov.blogspot.com';
 $address[] = 'davydov.blogspot.com';

 foreach($address as $addr){
 $httpPrefix='(?:http:\\\\www.|http:\/\/www.|http:\/\/|http:\\\|www.|)';
 $reqexp = '/'.$httpPrefix.'(.*).blogspot\.com(.*)/Ui';
 preg_match_all($reqexp, $addr, $nameAray, PREG_SET_ORDER);
 if (sizeof($nameAray) == 0) {
 return "";
 }
 print_r($nameAray);
 }
 */

/*
 // Livejournal user name parser
 echo '<pre>';

 $address[] = 'http:\\katechkina.livejournal.com';
 $address[] = 'http:\\www.katechkina.livejournal.com';
 $address[] = 'http://katechkina.livejournal.com';
 $address[] = 'http://www.katechkina.livejournal.com';
 $address[] = 'www.katechkina.livejournal.com';
 $address[] = 'katechkina.livejournal.com';

 foreach($address as $addr){
 $httpPrefix='(?:http:\\\\www.|http:\/\/www.|http:\/\/|http:\\\|www.|)';
 $reqexp = '/'.$httpPrefix.'(.*).livejournal\.com(.*)/Ui';
 preg_match_all($reqexp, $addr, $nameAray, PREG_SET_ORDER);
 if (sizeof($nameAray) == 0) {
 return "";
 }
 print_r($nameAray);
 }
 */
?>
