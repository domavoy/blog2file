<?php
class EnglishDateUtils{

  public static function createUpString($time){
    $upGenerationString = '';

    // get monthes
    $days = floor($time/3600/24);
    $hour = floor(($time - 24*3600*$days)/3600);
    $minutes = floor(($time - 24*3600*$days - $hour*3600)/60);

    //special cases
    if($days==0 && $hour==0){
      if($minutes < 5){
        return 'some minutes';
      } else if($minutes < 12){
        return '10 minutes';
      } else if($minutes < 22){
        return '20 minutes';
      } else if($minutes < 32){
        return 'one half';
      } else if($minutes < 42){
        return '40 minutes';
      } else if($minutes < 52){
        return '50 minutes';
      }
    }
    // process hour
    if($days==0 && $hour==0 && $minutes < 10){
      return '1 hour';
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
      $upGenerationString.='10 minutes';
    } else if($minutes < 22){
      $upGenerationString.='20 minutes';
    } else if($minutes < 32){
      $upGenerationString.='30 minutes';
    } else if($minutes < 42){
      $upGenerationString.='40 minutes';
    }  else if($minutes < 59){
      $upGenerationString.='50 minutes';
    }
    return $upGenerationString;
  }

  private static function getMonth($index){
    $month = "month";
    if($index >= 2 && $index < 5){
      $month.='monthes';
    }else if($index >= 5){
      $month.='monthes';
    }
    return $month;
  }

  private static function getDay($index){
   if($index == 1){
     return 'day';
   }else{
     return 'days';
   }
  }

  private static function getHour($index){
    $month = "hour";
    if($index >= 2 && $index < 5){
      $month.='s';
    }else if($index >= 5 && $index < 21){
      $month.='s';
    } else if($index > 21){
      $month.='s';
    }
    return $month;
  }
}
?>