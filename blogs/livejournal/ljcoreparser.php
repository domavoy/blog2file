<?php
/**
 * Core functions and interfaces for LJ parser (user & community)
 */
abstract class LjCoreParser {

  protected $userName;

  /**
   * Constructor
   * @param $username String Lj userName
   * @return void
   */
  public function __construct($username) {
    $this->userName = $username;
  }

  abstract public function getTitle();
  abstract public function constructBasicAddress();
  abstract protected function constructRegexpAddress();

  /*-----------------------------------------------------------
   /*  Address functions
   /*---------------------------------------------------------*/

  //+ Calendar address
  public function constructCalendarAddress() {
    return $this->constructBasicAddress().'calendar/';
  }

  //+ Calendar year address
  public function constructCalendarYearAddress($year) {
    return $this->constructBasicAddress().$year.'/';
  }

  //+ Calendar Year Month address
  public function constructCalendarYearMonthAddress($year, $month) {
    return $this->constructBasicAddress().$year.'/'.$month.'/?format=light';
  }

  //+ Post address
  public function constructPostAddress($postId) {
    return $this->constructBasicAddress().$postId . '.html';
  }

  //+ Light post address
  public function constructLightPostAddress($postId) {
    return $this->constructBasicAddress().$postId.'.html?format=light&mode=reply';
  }

  //+ Tag s address
  public function constructTagsListAddress() {
    return $this->constructBasicAddress().'tag/?format=light';
  }

  // Post with comments address
  public function constructLightPostAddressWithComments($postId) {
    return $this->constructBasicAddress().$postId.'.html?format=light';
  }

  // Friends list, address
  public function constructFriendListPage() {
    return $this->constructBasicAddress().'data/foaf/';
  }

  // Userpis list address
  public function constructUserpicListPage() {
    return $this->constructBasicAddress().'data/userpics/';
  }
  /*-----------------------------------------------------------
   /*  Analyzer functions
   /*---------------------------------------------------------*/

  //+ Return tags list
  public function getTagsList($tagPageText) {
    $tagArray = array();
    preg_match_all($this->constructRegexpAddress().'tag.*["]{1}>(.*)<\/a> - (.*)[ ]{1}/Ui', $tagPageText , $tagArray, PREG_SET_ORDER);
    $tags = array();
    foreach($tagArray as $tagData){
      $tags[$tagData[1]] =  $tagData[2];
    }
    return $tags;
  }

  public function getFriendsList($friendPageText) {
    preg_match_all("/> (.*)\\n/siU", $friendPageText, $friendRawList, PREG_PATTERN_ORDER);
    sort($friendRawList[1]);
    return $friendRawList[1];
  }

  public function getUserpicsList($userpicPageText){
    preg_match_all('/<content src="(.*)"\/>/siU', $userpicPageText, $postTitleArray, PREG_PATTERN_ORDER);
    return $postTitleArray[1];
  }

  //+ Return years array
  public function getYearsInfo($calendarText) {
    if($calendarText == ""){
      return array();
    }
    $yearArray = array ();
    // parse last years, except current
    $reqexp = $this->constructRegexpAddress().'([0-9]{4})\/\"/U';
    preg_match_all($reqexp, $calendarText, $yearArray, PREG_PATTERN_ORDER);
    // parse curreny year form calendar
    $reqexp = $this->constructRegexpAddress().'([0-9]{4})\/[0-9]{2}\/[0-9]{2}\/\">[0-9]*</Ui';
    preg_match_all($reqexp, $calendarText, $yearArray1, PREG_SET_ORDER);
    // construct years list
    $monthArr = $yearArray[1];

    // if journal without entries -> return 0 years
    if(count($yearArray1) == 0){
      return array();
    }

    $monthArr[] = $yearArray1[0][1];
    sort($monthArr);

    // if no data, return array()
    if((count($monthArr) == 1) && ($monthArr[0] == '')){
      return array();
    }
    return $monthArr;
  }

  //+ return Year posts list
  public function getYearPostsInfo($year, $yearText) {
    if($yearText == ""){
      return array();
    }
    $regexpArray = array ();
    $yearPostsInfo = array ();
    // parse page to $regexpArray
    $reqexp = $this->constructRegexpAddress().'('.$year.'\/([0-9]{2})\/[0-9]{2})\/\">(.*)<\/a>.*(?:<\/div>|<\/td>)/Ui';
    preg_match_all($reqexp, $yearText, $regexpArray, PREG_SET_ORDER);
    // parse $regexpArray and fill $yearPostsInfo
    foreach ($regexpArray as $regValue) {
      if(!isset($yearPostsInfo[$regValue[2]])){
        $yearPostsInfo[$regValue[2]] = strip_tags($regValue[3]);
      }else{
        $yearPostsInfo[$regValue[2]] = $yearPostsInfo[$regValue[2]] + strip_tags($regValue[3]);
      }
    }
    // fill null values
    $motheValues = array('01','02','03','04','05','06','07','08','09','10','11','12');
    foreach($motheValues as $mvalue){
      if(!isset($yearPostsInfo[$mvalue])){
        $yearPostsInfo[$mvalue] = 0;
      }
    }

    ksort($yearPostsInfo);
    return $yearPostsInfo;
  }

  /*-----------------------------------------------------------
   /*  Parser functions
   /*---------------------------------------------------------*/

  //+ used for livejournal parser
  public function getCalendarMonthPostsByDayAndTitle($monthPageText) {
    if($monthPageText == ""){
      return array();
    }
    $dataArray = array ();
    $regexpArray = array ();
    $reqexp = $this->constructRegexpAddress().'([0-9]{4}\/[\d]{2}\/[\d]{2}\/|([0-9]*).html)(?:\'|\")>(.*)<\/a>/Ui';
    preg_match_all($reqexp, $monthPageText, $regexpArray, PREG_SET_ORDER);
    $currentDate = 'Unknown';
    foreach ($regexpArray as $regexpValue) {
      if ($regexpValue[2] == '') {
        $currentDate = $regexpValue[1];
      } else {
        $dataArray[$currentDate][$regexpValue[2]] = $regexpValue[3];
      }
    }
    return $dataArray;
  }

  //+ Parse livejournal post with Light colour scheme (?format=light at the end)
  public function getLightPostText($lightPostText) {
    if($lightPostText == ""){
      return array();
    }
    //preg_match_all('/<font face=\'Arial,Helvetica\' size=\'\+1\'>.*<\/font><br \/>.*\/div>/siU', $lightPostText, $arrayContent, PREG_SET_ORDER);
    preg_match_all("/<div style='margin-left: 30px'>(.*)\/div>/siU", $lightPostText, $arrayContent, PREG_SET_ORDER);
    return $arrayContent[0][1];
  }

  //+ Parse livejournal post with Light colour scheme, and retrieve tags list from it
  public function getLightPostTagList($lightPostText) {
    if($lightPostText == ""){
      return array();
    }
    preg_match_all($this->constructRegexpAddress().'tag\/.*>(.*)</Ui', $lightPostText, $arrayContent, PREG_PATTERN_ORDER);
    if(count($arrayContent[1]) != 0){
      return $arrayContent[1];
    }else{
      return array();
    }
  }

  public function getLightPostData($postText){
    if($postText == ""){
      return array();
    }
    preg_match_all('/<font face=(?:"|\')Arial,Helvetica(?:"|\') size=\'\+1\'>.*<\/font>/siU', $postText, $postTitleArray, PREG_PATTERN_ORDER);
    $title = strip_tags($postTitleArray[0][0]);
    $text = $this->getLightPostText($postText);
    $text = str_replace($title, '', $text);
    return array('2008/10/10', $title,$text);
  }
}
?>