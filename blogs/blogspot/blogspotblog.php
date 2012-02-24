<?php
require_once('blogspotparser.php');

class BlogspotBlog {//implements BlogInterface{
   private $parser;

   public function __construct($blogAddress, $language = Languages::RU) {
      $this->parser = new BlogspotParser($blogAddress);
   }

   public function getBlogType() {
      return BlogType :: BLOGSPOT;
   }

   public function setLanguage($language){
   }

   // USED IN ANALYZER #0
   // dummy: Blogspot doesn't supoort tags
   public function getTagsList() {
      return array ();
   }

   //--------------------------------------------------------
   // USED IN ANALYZER #1
   // htmls: 1, regexp: 2;
   // dummy: all data return by getPostInfoByYear
   public function getLivejournalYearList() {
      return array('2009');
   }

   //--------------------------------------------------------
   // USED IN ANALYZER #2
   // htmls: 1, regexp: 1;
   // return array(array('01' => 1, .. '12' => 4'))
   public function getPostInfoByYear($year) {
      if($year == '2009'){
         $returnArray = array ();
         $yearAddress = $this->parser->constructAddress();
         $calendarYearText = HtmlHelper :: getHtmlPage($yearAddress);
         return $this->parser->getYearPostsInfo($year, $calendarYearText);
      }else{
         return array();
      }
   }


   public function getMonthPostsByDate($year, $month){
   }

   public function getParserInfoByDateAndPost($postDate, $postNumber, $postTitle){
   }
    
   public function getFriendsList() {
      return array();
   }

}



?>