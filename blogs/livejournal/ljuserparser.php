<?php
class LjUserParser extends LjCoreParser{

  public function __construct($username) {
    LjCoreParser::__construct($username);
  }

  public static function parseUserName($address) {
    $httpPrefix='(?:http:\\\\www.|http:\/\/www.|http:\/\/|http:\\\|www.|)';
    $reqexp = '/'.$httpPrefix.'(.*).livejournal\.com/Ui';
    preg_match_all($reqexp, $address, $nameAray, PREG_SET_ORDER);
    if (sizeof($nameAray) == 0) {
      return false;
    }
    if($nameAray[0][1] == 'community'){
      return false;
    }
    return $nameAray[0][1];
  }

  public static function parsePostAddress($address) {
    $httpPrefix='(?:http:\\\\www.|http:\/\/www.|http:\/\/|http:\\\|www.|)';
    $reqexp = '/'.$httpPrefix.'(.*).livejournal\.com\/([\d]+).html/Ui';
    preg_match_all($reqexp, $address, $nameAray, PREG_SET_ORDER);
    if ($nameAray[0][1] == '') {
      return false;
    }
    return $nameAray[0][2];
  }

  public function getTitle(){
    return 'Livejournal user';
  }

  protected function constructRegexpAddress(){
    return '/http\:\/\/' .$this->userName. '.livejournal\.com\/';
  }

  public function constructBasicAddress(){
    return 'http://' . $this->userName . '.livejournal.com/';
  }
}
?>