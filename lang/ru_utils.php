<?php
require_once('en_utils.php');

class RussianDateUtils{

  public static function createUpString($time){
    $upGenerationString = '';

    // get monthes
    $days = floor($time/3600/24);
    $hour = floor(($time - 24*3600*$days)/3600);
    $minutes = floor(($time - 24*3600*$days - $hour*3600)/60);

    //special cases
    if($days==0 && $hour==0){
      if($minutes < 5){
        return 'несколько минут';
      } else if($minutes < 12){
        return '10 минут';
      } else if($minutes < 22){
        return '20 минут';
      } else if($minutes < 32){
        return 'полчаса';
      } else if($minutes < 42){
        return '40 минут';
      } else if($minutes < 52){
        return '50 минут';
      }
    }
    // process hour
    if($days==0 && $hour==0 && $minutes < 10){
      return 'час';
    }

    if($days != 0){
      $stringIndex = $days.'';
      $firstDigit = $stringIndex[0];
      $lastDigit = $stringIndex[strlen($days."")-1];
      if($firstDigit=='0'){
        $days =  $lastDigit;
      }
      $upGenerationString.=$days.' '.self::getDay($days).' ';
    }
    // process hours
    if($hour != 0){
      $upGenerationString.=$hour.' '.self::getHour($hour).' ';
    }
    // process minutes
    if($minutes > 5 && $minutes < 12){
      $upGenerationString.='10 минут';
    } else if($minutes < 22){
      $upGenerationString.='20 минут';
    } else if($minutes < 32){
      $upGenerationString.='30 минут';
    } else if($minutes < 42){
      $upGenerationString.='40 минут';
    }  else if($minutes < 59){
      $upGenerationString.='50 минут';
    }
    return $upGenerationString;
  }

  public static function getMonthTest(){
    for($i = 1 ; $i <= 60; $i++){
      // echo 'Через '.$i.' '.self::getMinute ($i).'<br>';
    }
    echo '<br>';
    for($i = 1 ; $i <= 24; $i++){
      //  echo 'Через '.$i.' '.self::getHour ($i).'<br>';
    }
    echo '<br>';
    for($i = 1 ; $i <= 12; $i++){
      //echo 'Через '.$i.' '.self::getMonth ($i).'<br>';
    }
    echo '<br>';
    for($i = 1 ; $i <= 999; $i++){
      echo 'Через '.$i.' '.self::getDay($i).'<br>';
    }
  }

  private static function getMonth($index){
    $month = "месяц";
    if($index >= 2 && $index < 5){
      $month.='а';
    }else if($index >= 5){
      $month.='ев';
    }
    return $month;
  }

  private static function getDay($index){
    $stringIndex = $index.'';
    $firstDigit = $stringIndex[0];
    $lastDigit = $stringIndex[strlen($index."")-1];
    if($lastDigit == 1 && $index != 11){
      return 'день';
    }else if($firstDigit != 1 && $lastDigit >= 2  && $lastDigit < 5 ){
      return 'дня';
    }else{
      return 'дней';
    }
  }

  private static function getHour($index){
    $month = "час";
    if($index >= 2 && $index < 5){
      $month.='а';
    }else if($index >= 5 && $index < 21){
      $month.='ов';
    } else if($index > 21){
      $month.='а';
    }
    return $month;
  }
}
?>