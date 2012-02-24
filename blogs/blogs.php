<?php

require_once 'livejournal/ljblog.php';
//require_once 'blogspot/blogspotBlog.php';

/**
 * List of supported blogs
 */
class BlogType{
  const LJ = 'livejournal';
  const BLOGSPOT = 'blogspot';
}

/**
 * BlogInterface objects factory
 */
class BlogFactory{
  /**
   * Return BlogInterface object
   * @param $blogType BlogInterface
   * @param $address String blog address
   * @return BlogInterface object
   */
  public static function getByName($blogType, $address){
    switch($blogType){
      case BlogType::LJ:
        return new LjBlog($address);
        break;
      case BlogType::BLOGSPOT:
        return new BlogspotBlog($address);
        break;
      default:
        throw new BlogTypeNotFoundException($blogType);
        break;
    }
  }

  public static function getBlogsList($address){
    return array(new LjBlog($address));
  }

  /**
   * Check page address
   * @param $address String web page address
   * @return boolean result of check
   */
  public static function checkAddressAvailability($address){
    try{
      HtmlHelper::getPage($address) ;
    }catch(HttpPageNotFoundException $e){
      return false;
    }

    $currentBlog = false;
    foreach(BlogFactory::getBlogsList($address) as  $blog){
      $currentValue = $blog->checkAddress($address);
      if($currentValue!= false){
        return true;
      }
    }
    return false;
  }
}

/**
 * Blog handler for download data via Task
 * @author mdorof
 */
interface BlogHandler{
  /**
   * Return Years list
   * @param $calendarpageText String calendar page text
   * @return array(year1, .. , yearN)
   */
  public function processCalendar($calendarpageText);
  public function processYearPage($yearPageText, $year);
  public function processMonthInfo($monthPageText);
  public function processPostText($postPageText, $number, $date, $title);
}
/**
 * Inteface for Blog object
 */
interface BlogInterface{
  public function __construct($blogAddress);
  // return blog info
  public function getBlogType();
  public function getUserName();
  public function getTitle();
  public function getAddress();
  public function getParser();

  // blog contents analyzer functions
  public static function analysePostAddress($address);
  public function getParserInfoByPost($postId);

  // analyzer
  public function getTagsList();
  public function getFriendsList();
  public function getUserpicsArray();
  public function getLivejournalYearList();
  public function getPostInfoByYear($year);
  // parser
  public function getMonthPostsByDate($year, $month);
  public function getParserInfoByDateAndPost($postDate, $postNumber, $postTitle);
}

class BlogAnalyserInfo{
  public $year;
  public $month;
  public $postCount;

  public function __construct($year, $month, $postCount){
    $this->year = $year;
    $this->month = $month;
    $this->postCount = $postCount;
  }

  public function __toString(){
    return "=>BlogAnalyserInfo($this->year, $this->month, $this->postCount)";
  }
}

class BlogProfileInfo{
  public $name;
  public $address;

  public function __construct($name, $address){
    $this->name = $name;
    $this->address = $address;
  }

  public function __toString(){
    return "=>BlogProfileInfo($this->name, $this->address)";
  }
}

/**
 * Containg information about blog record
 */
class BlogParserInfo{
  public $id;
  public $date;
  public $title;
  public $link;
  public $text;
  public $tagList;

  /**
   * Constructor
   * @param $id
   * @param $date
   * @param $title
   * @param $link
   * @param $text
   * @param $tagList array of tags
   * @return void
   */
  public function __construct($id, $date, $title, $link, $text, $tagList){
    $this->id = $id;
    $this->date = $date;
    $this->title = $title;
    $this->link = $link;
    $this->text = $text;
    $this->tagList = $tagList;
  }

  /**
   * Return BlogParserInfo object as string
   * @return unknown_type
   */
  public function __toString(){
    return "=>BlogAnalyserInfo($this->id, $this->date, $this->title, $this->link, $this->text, $this->tagList)";
  }

  /**
   * Compare BlogParserInfo objects by $obj-id field
   * Used with usort($blogParserInfoArray, 'BlogParserInfo::sort') function
   * @param $a BlogParserInfo obj1
   * @param $b BlogParserInfo obj2
   * @return compare value
   */
  public static function sort(BlogParserInfo $a, BlogParserInfo $b){
    if ($a->id == $b->id) {
      return 0;
    }
    return ($a->id < $b->id) ? -1 : 1;
  }
}

?>