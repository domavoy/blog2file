<?php
require_once 'ljcoreparser.php';
require_once 'ljuserparser.php';
require_once 'ljcommunityparser.php';

class LjBlog implements BlogInterface, BlogHandler{

  private $parser;
  private $userName;

  /**
   * Constructor
   * @param $blogAddress blog, community, post address
   * @return void
   */
  public function __construct($blogAddress) {
    // if name contain only username (words, digits and '_')
    if($this->isUserName($blogAddress)){
      // is it community user name
      $this->userName =$blogAddress;
      if(LjCommunityParser::isCommunityUserName($blogAddress)){
        $this->parser = new LjCommunityParser($blogAddress);
      }else{
        $this->parser = new LjUserParser($blogAddress);
      }
    }else{
      // if address contain http://community.livejournal.com/*
      if(LjCommunityParser::isCommunityAddress($blogAddress)){
        $this->userName = LjCommunityParser::parseUserName($blogAddress);
        $this->parser = new LjCommunityParser($this->userName);
      }else{
        $this->userName = LjUserParser::parseUserName($blogAddress);
        $this->parser = new LjUserParser($this->userName);
      }
    }
  }

  public function getBlogType() {
    return BlogType :: LJ;
  }

  public function getUserName() {
    return $this->userName;
  }

  public function getTitle(){
    return $this->parser->getTitle();
  }

  public function getAddress(){
    return $this->parser->constructBasicAddress();
  }

  private function isUserName($address){
    return !preg_match('/[^\w\d_]+/i', $address);
  }

  public function getParser(){
    return $this->parser;
  }

  /*-----------------------------------------------------------
   /*  Blog parser function
   /*---------------------------------------------------------*/

  /** Return post data(number, title) by $year and $month
   * tmls: 1, regexp: 1
   * (non-PHPdoc)
   * @see blogs/BlogInterface#getMonthPostsByDate()
   */
  public function getMonthPostsByDate($year, $month) {
    $monthAddress = $this->parser->constructCalendarYearMonthAddress($year, $month);
    $monthText = HtmlHelper :: getHtmlPage($monthAddress);
    return $this->parser->getCalendarMonthPostsByDayAndTitle($monthText);
  }

  /** Return BlogParserInfo object by $postNumber
   * htmls: 1, regexp: 1
   * (non-PHPdoc)
   * @see blogs/BlogInterface#getParserInfoByDateAndPost()
   */
  public function getParserInfoByDateAndPost($postDate, $postNumber, $postTitle) {
    $blogParserInfoArray = array ();
    $postAddress = $this->parser->constructLightPostAddress($postNumber);
    $postPageText = HtmlHelper :: getHtmlPage($postAddress);
    $postLink = $this->parser->constructPostAddress($postNumber);
    $postDate =  Lang::convertLjDate($postDate);
    $postText = $this->parser->getLightPostText($postPageText);
    $tagList =  $this->parser->getLightPostTagList($postText);
    $postText = str_replace($postTitle, '', $postText);
    $blogParserInfoArray[] = new BlogParserInfo($postNumber, $postDate, $postTitle, $postLink, $postText,$tagList);
    return $blogParserInfoArray;
  }

  /*-----------------------------------------------------------
   /*  Blog analyzer functions
   /*---------------------------------------------------------*/

  /** Return array of tag data
   *  htmls: 1, regexp: 1 + tagNum;
   * (non-PHPdoc)
   * @see blogs/BlogInterface#getTagsList()
   */
  public function getTagsList() {
    $tagsArray = array ();
    // getting main calendar page
    $tagsPageAddress = $this->parser->constructTagsListAddress();
    $tagsPageText = HtmlHelper :: getHtmlPage($tagsPageAddress);
    // return years info form main calendar page
    return $this->parser->getTagsList($tagsPageText);
  }

  /** Return list of user friends
   * (non-PHPdoc)
   * @see blogs/BlogInterface#getFriendsList()
   */
  public function getFriendsList() {
    $friendPageAddress = $this->parser->constructFriendListPage();
    $friendsPageText = HtmlHelper :: getHtmlPage($friendPageAddress);
    return $this->parser->getFriendsList($friendsPageText);
  }

  /** Return list of userpics addresses
   * (non-PHPdoc)
   * @see blogs/BlogInterface#getUserpicsArray()
   */
  public function getUserpicsArray(){
    $userpicsPageAddress = $this->parser->constructUserpicListPage();
    $userpicsPageText = HtmlHelper :: getHtmlPage($userpicsPageAddress);
    return array_flip($this->parser->getUserpicsList($userpicsPageText));
  }
  /** Return array of years
   * htmls: 1, regexp: 2;
   * (non-PHPdoc)
   * @see blogs/BlogInterface#getLivejournalYearList()
   */
  public function getLivejournalYearList() {
    // getting main calendar page and retrieve years list from it
    $calendarAddress = $this->parser->constructCalendarAddress();
    $calendarText = HtmlHelper :: getHtmlPage($calendarAddress);
    $yearList = $this->parser->getYearsInfo($calendarText);
    if(count($yearList) != 0){
      // $cache = new Cache($this->getBlogType(), $this->userName);
      $lastYear = end($yearList);
      $lastYearInfo[$lastYear] = $this->parser->getYearPostsInfo($lastYear, $calendarText);
      //$cache->saveYearInfo($lastYear, $lastYearInfo);
    }
    return $yearList;
  }

  /** Return blog analyzer data
   * (non-PHPdoc)
   * @see blogs/BlogInterface#getPostInfoByYear()
   */
  public function getPostInfoByYear($year) {
    $returnArray = array ();
    $yearAddress = $this->parser->constructCalendarYearAddress($year);
    $calendarYearText = HtmlHelper :: getHtmlPage($yearAddress);
    $returnArray[$year] = $this->parser->getYearPostsInfo($year, $calendarYearText);
    // save year data in cache
    //$cache = new Cache($this->getBlogType(), $this->userName);
    //$cache->saveYearInfo($year, $returnArray);
    // return year data
    return $returnArray;
  }

  /**
   * Check post presense in address.
   * Ex. if address = 'http://community.livejournal.com/greg_house_ru/52359.html' then return true
   * @param $address web address
   * @return boolean
   */
  public static function analysePostAddress($address){
    $value = LjUserParser::parsePostAddress($address);
    if($value != false){
      return $value;
    }
    $value = LjCommunityParser::parsePostAddress($address);
    if($value != false){
      return $value;
    }
    return false;
  }

  /** Return BlogParserInfo object for post
   * (non-PHPdoc)
   * @see blogs/BlogInterface#getParserInfoByPost()
   */
  public function getParserInfoByPost($postId){
    $postAddress = $this->parser->constructLightPostAddress($postId);
    $postPageText = HtmlHelper :: getHtmlPage($postAddress );
    $postLink = $this->parser->constructPostAddress($postId);
    $postData = $this->parser->getLightPostData($postPageText);
    if($postData == ''){
      return false;
    }
    return new BlogParserInfo($postId, $postData[0], $postData[1], $postLink, $postData[2],array());
  }

  public function processCalendar($calendarText){
    $yearList = $this->parser->getYearsInfo($calendarText);
    /*
     if(count($yearList) != 0){
     $cache = new Cache($this->getBlogType(), $this->userName);
     $lastYear = end($yearList);
     $lastYearInfo[$lastYear] = $this->parser->getYearPostsInfo($lastYear, $calendarText);
     $cache->saveYearInfo($lastYear, $lastYearInfo);
     }
     */
    return $yearList;
  }

  public function processYearPage($calendarYearText, $year){
    $returnArray = array($year => $this->parser->getYearPostsInfo($year, $calendarYearText));
    return $returnArray;
  }

  public function processMonthInfo($monthText){
    return $this->parser->getCalendarMonthPostsByDayAndTitle($monthText);
  }

  public function processPostText($postPageText, $postNumber,$postDate,$postTitle){
    $blogParserInfoArray = null;
    $postLink = $this->parser->constructPostAddress($postNumber);
    $postDate = Lang::convertLjDate($postDate);
    $postText = $this->parser->getLightPostText($postPageText);
    $tagList =  $this->parser->getLightPostTagList($postText);
    $postText = str_replace($postTitle, '', $postText);
    $blogParserInfoArray[] = new BlogParserInfo($postNumber, $postDate, $postTitle, $postLink, $postText,$tagList);
    return $blogParserInfoArray;
  }

  public static function checkAddress($address){
    //return array(LjUserParser::parseUserName($address),LjCommunityParser::parseUserName($address));

    if(((LjCommunityParser::parseUserName($address) == false)
    && LjUserParser::parseUserName($address) == false)){
      return 0;
    }else{
      return 1;
    }

  }
}
?>
