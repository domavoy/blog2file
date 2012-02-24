<?php
require_once 'ljblog.php';

class LjBlogExt extends LjBlog{

  private $parser;
  private $userName;

  public function __construct($blogAddress) {
    LjBlog::__construct($blogAddress);
  }
   
  // htmls: postCounts + 1, regexp: postCounts + 1
  // return BlogParserInfo object => ($id, $date, $title, $link, $text)
  public function getParserInfoByMonth($year, $month) {
    $blogParserInfoArray = array ();
    $monthPostByDay = $this->getMonthPostsByDate($year, $month);
    foreach ($monthPostByDay as $postDate => $dayData) {
      foreach ($dayData as $postNumber => $postTitle) {
        $mobilePostAddress = $this->parser->constructMobilePostAddress($postNumber);
        $postPageText = HtmlHelper :: getHtmlPage($mobilePostAddress);
        $postLink = $this->parser->constructPostAddress($postNumber);
        $postDate =  Lang::convertLjDate($postDate);
        $postText = $this->parser->getMobilePostText($postPageText);
        $blogParserInfoArray[] = new BlogParserInfo($postNumber, $postDate, $postTitle, $postLink, $postText);
      }
    }
    return $blogParserInfoArray;
  }

  // htmls: postCounts + 1, regexp: postCounts + 1
  public function getParserInfoByDay($postDate, $dayData) {
    $blogParserInfoArray = array ();
    foreach ($dayData as $postNumber => $postTitle) {
      $blogParserInfoArray = array_merge($blogParserInfoArray, $this->getParserInfoByDateAndPost($postDate, $postNumber, $postTitle) );
    }
    return $blogParserInfoArray;
  }

  // htmls: postCounts + 1, regexp: postCounts + 1
  public function getMobileParserInfoByDateAndPost($postDate, $postNumber, $postTitle) {
    $blogParserInfoArray = array ();
    $mobilePostAddress = $this->parser->constructMobilePostAddress($postNumber);
    $postPageText = HtmlHelper :: getHtmlPage($mobilePostAddress);
    $postLink = $this->parser->constructPostAddress($postNumber);
    $postDate =  Lang::convertLjDate($postDate);
    $postText = $this->parser->getMobilePostText($postPageText);

    $blogParserInfoArray[] = new BlogParserInfo($postNumber, $postDate, $postTitle, $postLink, $postText);
    return $blogParserInfoArray;
  }

  // htmls: yearsNum + 1, regexp: yearsNum + 2;
  // return BlogAnalyserInfo object ($year, $month, $postCount)
  public function getAnalyzerInfo() {
    $blogParserInfoArray = array ();
    // getting main calendar page
    $calendarAddress = $this->parser->constructCalendarAddress();
    $calendarText = HtmlHelper :: getHtmlPage($calendarAddress);
    // parse each years page and fill $yearPostsArrayReturn for each year
    foreach ($this->parser->getYearsInfo($calendarText) as $year) {
      foreach ($this->getPostInfoByYear($year) as $month => $postCount) {
        $blogParserInfoArray[] = new BlogAnalyserInfo($year, $month, $postCount);
      }
    }
    return $blogParserInfoArray;
  }

  // htmls: 1, regexp: 1;
  // return BlogAnalyserInfo object ($year, $month, $postCount)
  public function getAnalyzerInfoByYear($year) {
    $blogParserInfoArray = array ();
    $yearAddress = $this->parser->constructCalendarYearAddress($year);
    $calendarYearText = HtmlHelper :: getHtmlPage($yearAddress);
    foreach ($this->parser->getYearPostsInfo($calendarYearText) as $month => $postCount) {
      $blogParserInfoArray[] = new BlogAnalyserInfo($year, $month, $postCount);
    }
    return $blogParserInfoArray;
  }

  // htmls: yearsNum + 1, regexp: yearsNum + 2;
  // return BlogAnalyserInfo object ($year, $month, $postCount)
  public function getPostInfo() {
    $blogParserInfoArray = array ();
    // getting main calendar page
    $calendarAddress = $this->parser->constructCalendarAddress();
    $calendarText = HtmlHelper :: getHtmlPage($calendarAddress);
    // parse each years page and fill $yearPostsArrayReturn for each year
    foreach ($this->parser->getYearsInfo($calendarText) as $year) {
      $blogParserInfoArray  = $blogParserInfoArray + $this->getPostInfoByYear($year);
    }
    return $blogParserInfoArray;
  }

}
?>