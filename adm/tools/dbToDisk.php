<?php
require_once('config.php');
require_once('blogs/blogs.php');
require_once('files/files.php');
require_once('lib/htmlHelper.php');
require_once('lib/exception.php');
require_once('kernel/cache.php');

require_once('../task/task.php');
require_once('libs/exception.php');
/* 
class LjFileMapper()
 	1. const ANALYZER_YEAR = 1;
 		filename: katechkina/2009/index.php  = mapYear('http://katechkina.livejournal.com/2009/');
 		content: info
 	2. const PARSER_MONTH = 3;
 		filename: katechkina/2009/12/index.php = mapYearMonth('http://katechkina.livejournal.com/2008/12/?format=...');
 		content: info
 	3. const PARSER_POST = 4;
 		filename: katechkina/404698.html = mapPost('ttp://katechkina.livejournal.com/404698.html?form...');
 		content: info

class FileHelper
	if file exists -> replace
	1. createFile($root, $address, $contents); 

		
class DbTask
	getAvalableBlogs - list of blogs in database array(livejournal, .. );
	getBlogData($blogType) - return array of BlogData (taskType, address, info)
	// will be LjBlogFetcher, ....
*/

abstract class BlogFileMapper{
  private $name;
  private $type; 
  public function __construct($name){
    $this->name = $name;
  }
  public function mapYear($yearAddress);
  public function mapYearMonth($yearMonthAddress);
  public function mapPost($postAddress);
}

class DbToDisk{
  private $name;
  private $blog;

  public function __construct($type, $name){
    $this->name = $name;
    $this->blog = BlogFactory::getByName($type, $name);
  }
}


class ImageHandler{
  public static function getImage($imgUrl){
    try{
      $file = fopen ($imgUrl, "r");
      fclose ($file);
      $imgSizeInfo = @getimagesize($imgUrl);
      if($imgSizeInfo['mime'] == 'image/gif'){
        $imageType = 'gif';
      } else if ($imgSizeInfo['mime'] == 'image/jpeg'){
        $imageType = 'jpg';
      } else if ($imgSizeInfo['mime'] == 'image/png'){
        $imageType = 'png';
      }
    }
    catch(Exception $e){
      $imgUrl = Options::BROKEN_IMG_URL;
      $imgSizeInfo = array(20,20);
      $imageType = 'png';
    }
    return array('url' => $imgUrl, 'type' => $imageType, 'x' => $imgSizeInfo[0] * 0.26, 'y' => $imgSizeInfo[1] * 0.26);
  }

  public static function getImageContents($url){
    $ch = curl_init ($url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
    $rawdata=curl_exec ($ch);
    curl_close ($ch);
    return $rawdata;
  }
}
?>