<?php
class WordpressBlogAnalyzer implements BlogAnalyzerInterface{

   public function getBlogType(){
      return BlogType::WORDPRESS;
   }

   public function analyse($mainPageText){
      if(strstr($mainPageText, "<meta name=\"generator\" content=\"WordPress")){
         return true;
      }
      return false;
   }

   public function getMonthLinks($blogName, $mainPageText){
      $arr = array('http://idiot.ru/?m=200901');
      //preg_match_all("/$blogName\/\?m=[\d]{6}/", $mainPageText, $arr);
      //print_r($arr);
      return $arr;
   }

   public function getAnalyzerInfo($monthPageText){
      preg_match_all("/<div class=\"post.*<a\s[^>]*href=(\"??)([^\" >]*?)\\1[^>]*>(.*)<\/a>.*<small>(.*)<\/small>/siU", $monthPageText, $analyseInfoRawArray, PREG_SET_ORDER);

      $analyseInfoArray = array();
      $size = 1;
      foreach($analyseInfoRawArray as $analyseInfoRaw){
         $analyseInfoArray[] = new BlogAnalyserInfo($size, $analyseInfoRaw[4],$analyseInfoRaw[3], $analyseInfoRaw[2]);
         ++$size;
      }
      return $analyseInfoArray;
   }

   public function getPage($monthPageText){
      return false;
   }

   public function getProfileInfo($mainPageText){
      return new BlogProfileInfo("Idiot","http://www.idiot.ru");
   }
}
?>