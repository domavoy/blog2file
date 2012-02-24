<?php
class LjCommunityParser extends LjCoreParser{

   public function __construct($username) {
      LjCoreParser::__construct($username);
   }

   public static function parseUserName($address) {
      $address.="\n";
      $httpPrefix='(?:http:\\\\www.|http:\/\/www.|http:\/\/|http:\\\|www.|)';
      $reqexp = '/'.$httpPrefix.'community.livejournal\.com\/(.*)(\\n|\/)/iU';
      preg_match_all($reqexp, $address, $nameAray, PREG_SET_ORDER);
      if (sizeof($nameAray) == 0) {
         return false;
      }
      return $nameAray[0][1];
   }

   public static function isCommunityUserName($userName){
      $ljAddress = 'http://' . $userName . '.livejournal.com/';
      $postPageText = HtmlHelper :: getHtmlPage($ljAddress);
      if(strstr($postPageText, 'http://community.livejournal.com/'.$userName)){
         return true;
      }else{
         return false;
      }
   }
    
   public static function parsePostAddress($address){
      $httpPrefix='(?:http:\\\\www.|http:\/\/www.|http:\/\/|http:\\\|www.|)';
      $reqexp = '/'.$httpPrefix.'community.livejournal\.com\/([\w\d_]+)\/([\d]+).html/Ui';
      preg_match_all($reqexp, $address, $nameAray, PREG_SET_ORDER);
      if ($nameAray[0][1] == '') {
         return false;
      }
      return $nameAray[0][2];
   }

   public static function isCommunityAddress($address){
      $httpPrefix='(?:http:\\\\www.|http:\/\/www.|http:\/\/|http:\\\|www.|)';
      $reqexp = '/'.$httpPrefix.'community.livejournal\.com\/(.*)/Ui';
      return preg_match($reqexp, $address);
   }

   public function getTitle(){
      return 'Livejournal community';
   }

   protected function constructRegexpAddress(){
      return '/http\:\/\/community.livejournal\.com\/'.$this->userName.'\/';
   }


   public function constructBasicAddress(){
      return 'http://community.livejournal.com/'.$this->userName.'/';
   }
}
?>