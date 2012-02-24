<?php
class Checker{

  public static function getRequest($variableName, $useLocation = true){
    if(isset($_REQUEST[$variableName])){
      return $_REQUEST[$variableName];
    }else{
      if($useLocation){
        Location::goToIndex();
      }else{
        return null;
      }
    }
  }

  public static function getRequestValues($variableName, $trueValue, $falseValue){
    if(isset($_REQUEST[$variableName])){
      return $trueValue;
    }else{
      return $falseValue;
    }
  }

  public static function setRequestHandler($variableName, $function){
    if(isset($_REQUEST[$variableName])){
      return call_user_func($function,$_REQUEST[$variableName]);
    }
  }

  public static function getSession($variableName){
    if(isset($_SESSION[$variableName])){
      return $_SESSION[$variableName];
    }else{
      Location::goToIndex();
    }
  }
}
?>