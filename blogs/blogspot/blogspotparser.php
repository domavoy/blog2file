<?php
class BlogspotParser{
   private $userName;

   public function __construct($address) {
      $this->userName = $this->parseUserName($address);
   }

   //--------------------------------------------------------
   protected function parseUserName($address) {
      $httpPrefix='(?:http:\\\\www.|http:\/\/www.|http:\/\/|http:\\\|www.|)';
      $reqexp = '/'.$httpPrefix.'(.*).blogspot\.com/Ui';
      preg_match_all($reqexp, $address, $nameAray, PREG_SET_ORDER);
      if (sizeof($nameAray) == 0) {
         return "";
      }
      return $nameAray[0][1];
   }

   // construct Blogspot address
   public function constructAddress() {
      return 'http://' . $this->userName . '.blogspot.com/';
   }

   // construct Blogspot address
   public function constructPostAddress($year, $month, $day) {
      return 'http://' . $this->userName . '.blogspot.com/' + $year + '_' + $month + '_' + $day + '_archive.html';
   }

   //--------------------------------------------------------
   public function getYearPostsInfo($year, $yearText) {
      preg_match_all("/<a href=\"http:\/\/".$this->userName.".blogspot.com\/([\d_]*)_archive.html\">.*<\/a>/siU", $yearText, $parseData, PREG_PATTERN_ORDER);

      $arr = array();
      foreach($parseData[1] as $data){
         list ($year, $month, $day ) = split('_',$data);
         //$arr[$year][$month] = 1 + $arr[$year][$month];
         $arr[$year][$month] = '';
      }
      return $arr;
   }
}


?>