<?php

class Utils{
  /**
   * Convert UTF8 codepage to Windows1251 Cyrylic
   * Used in FPDF(fpdf doesn't support Unicode)
   * @param $str String Unicode string
   * @return String Windows-1251 string
   */
  public static function utf8ToWin($str) {
    $str = str_replace('&#8220;','"',$str);
    $str = str_replace('&#8221;','"',$str);
    $str = str_replace('&#8230;','”',$str);
    return  iconv("UTF-8", "cp1251//IGNORE", $str);
  }

  /**
   * Convert byte number to others
   * @param $bytes
   * @return unknown_type
   */
  public static function bytesConvert($bytes)
  {
    $symbol = array('b', 'Kb', 'Mb', 'Gb', 'Tb');
    $exp = 0;
    $converted_value = 0;
    if( $bytes > 0 )
    {
      $exp = floor( log($bytes)/log(1024) );
      $converted_value = ( $bytes/pow(1024,floor($exp)) );
    }
    return sprintf( '%.2f '.$symbol[$exp], $converted_value );
  }

  /**
   * Set timer, to calculate script time
   * @param $shift
   * @return time in seconds
   */
  public static function timer($shift = false)
  {
    static $first = 0;
    static $last;
    $now = preg_replace('#^0(.*) (.*)$#', '$2$1', microtime());
    if (!$first) $first = $now;
    $res = $shift ? $now - $last : $now - $first;
    $last = $now;
    return $res;
  }

  public static function checkmail($email) {
    // First, we check that there's one @ symbol,
    // and that the lengths are right.
    if (!ereg("^[^@]{1,64}@[^@]{1,255}$", $email)) {
      // Email invalid because wrong number of characters
      // in one section or wrong number of @ symbols.
      return false;
    }
    // Split it into sections to make life easier
    $email_array = explode("@", $email);
    $local_array = explode(".", $email_array[0]);
    for ($i = 0; $i < sizeof($local_array); $i++) {
      if
      (!ereg("^(([A-Za-z0-9!#$%&'*+/=?^_`{|}~-][A-Za-z0-9!#$%&
↪'*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$",
      $local_array[$i])) {
        return false;
      }
    }
    // Check if domain is IP. If not,
    // it should be valid domain name
    if (!ereg("^\[?[0-9\.]+\]?$", $email_array[1])) {
      $domain_array = explode(".", $email_array[1]);
      if (sizeof($domain_array) < 2) {
        return false; // Not enough parts to domain
      }
      for ($i = 0; $i < sizeof($domain_array); $i++) {
        if
        (!ereg("^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|
↪([A-Za-z0-9]+))$",
        $domain_array[$i])) {
          return false;
        }
      }
    }
    return true;

  }

  /**
   * Sebd mail and write status to logs
   * @param $mail
   * @param $subject
   * @param $message
   * @return unknown_type
   */
  public static function sendmail($mail,$subject,$message) {
    // set headers
    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
    // Откуда пришло
    $headers .= 'From: Blog2File.com' . "\r\n";
    //sent email
    if(mail($mail,$subject,$message, $headers) == false) {
      Log::error('Failed to sent email with subject "'.$subject.'",  to user '.$mail);
      return false;
    }else{
      Log::info('Email with subject "'.$subject.'" succesfully sent to user '.$mail);
      return true;
    }
  }

  /**
   * Convetr checkboxes array to normal array with monthes data
   * @param $monthesArray checkbox array
   * @return array(array(year, month, postCount),.....)
   */
  public static function convertHtmlMonthes(array $monthesArray){
    $yearPostsCount = 0;
    $monthesList = array();
    foreach($monthesArray as $yearMonth => $state){
      try{
        list($year, $month, $monthPostsCount) = split('_',$yearMonth);
        $yearPostsCount+=$monthPostsCount;
      }catch(Exception $e){
        // if checkbox format is bad, skip this checkbox data
        continue;
      }
      $monthesList[] = array($year,$month);
    }
    return array('monthesList' => $monthesList, 'postsCount' => $yearPostsCount);
  }

  /**
   * Zipped fileName and send ZIP file to user
   * @param $fileName path to file
   * @param $zipName ZIP file name
   * @return void
   */
  public static function createZipFlow($fileName, $zipName){
    try{
      if(!file_exists($fileName)){
        return;
      }
      $zip = new ZipArchive;
      $zip->open($zipName, ZIPARCHIVE::CREATE | ZIPARCHIVE::OVERWRITE);
      $zip->addFromString(basename($fileName),file_get_contents($fileName));
      $zip->close();

      header("Pragma: public");
      header("Expires: 0");
      header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
      header("Cache-Control: private",false);
      header("Content-Type: application/zip");
      header("Content-Disposition: attachment; filename=".basename($zipName).";" );
      header("Content-Transfer-Encoding: binary");
      header("Content-Length: ".filesize($zipName));
      readfile($zipName);

    }
    catch(Exception $e){
    }
  }

  /**
   * Save url with contents to file system
   * @param $url url address
   * @param $content file contents
   * @return void
   */
  public static function mapFsContent($url, $content){
    try{
      if($url[strlen($url)-1] == '/'){
        $url.='index.php';
      }
      $data = parse_url($url);
      $fsPath = Options::SAVE_FOLDER.'/'.$data['host'].'/www'.$data['path'];
      $path = $data['path'];
      if($path[strlen($path)-1] == "/"){
        $fsPath.="index.php";
      }
      $info = pathinfo($fsPath);
      try{
        Log::map('MAP DIR: '.$info['dirname']);
        mkdir($info['dirname'], '0777', true);
      }catch(Exception $e){}
      Log::map('MAP FILE: '.$fsPath);
      $fh = fopen($fsPath, 'w+');
      fwrite($fh, $content);
      fclose($fh);
    }catch(Exception $e){
      Log::map('MAP ERROR: '.$e);
    }
  }
}

/**
 * Redirect on several pages
 */
class Location{
  public static function goToIndex(){
    Location::header('/index.php');
  }

  public static function goToLogin(){
    Location::header('/login.php');
  }

  public static function goToComingSoon(){
    Location::header('/soon.php');
  }

  public static function goToRegistration(){
    Location::header('/register.php');
  }

  public static function goToError(){
    Location::header('/error.php');
  }

  public static function header($link){
    Header("Location: ".$link);
  }
}

/**
 * Convert BlogTask type Ids, to user friendly names. Used in logs
 */
class IdConverter{
  public static function getTaskName($taskId){
    switch($taskId){
      case 0:
        return 'CALENDAR';
        break;
      case 1:
        return 'PARSER_MONTHES';
        break;
      case 2:
        return 'PARSER_MONTH';
        break;
      case 3:
        return 'PARSER_POST';
        break;
      case 4:
        return 'FILE_GENERATE';
        break;
      default:
        break;
    }
  }

  /**
   * Return Shedule Task statis by Id. Used in logs
   * @param $taskId
   * @return unknown_type
   */
  public static function getScheduleTaskName($taskId){
    switch($taskId){
      case ScheduleTaskState::CHECK_PARSER:
        return 'RUN';
        break;
      case ScheduleTaskState::CHECK_FILE:
        return 'FILE';
        break;
      case ScheduleTaskState::DONE:
        return 'DONE';
        break;
      default:
        break;
    }
  }
}
?>