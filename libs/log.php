<?php
/**
 * Daemon log class.
 * Insert all action into file
 * @author mdorof
 */
class Log {
  public static function info($msg){
    Log::writelog('INFO',$msg);
  }

  public static function error($msg){
    Log::writelog('ERROR',$msg);
  }

  public static function warn($msg){
    Log::writelog('WARN',$msg);
  }

  public static function debug($msg){
    Log::writelog('DEBUG',$msg);
  }

  public static function debug_print($msg, $data){
    Log::writelog('DEBUG',$msg.print_r($data, true));
  }

  public static function user($msg){
    Log::writeQueryLog('USER',$msg);
  }

  public static function writelog($type, $msg){
    $userName = CurSession::getUserName();
    if($userName == Options::DAEMON_USER){
      $fh = fopen(Options::daemonLogFile, 'a');
    }else{
      $fh = fopen(Options::daemonUsersFile, 'a');
    }
    fwrite($fh, CurSession::getUserName().','.date("Y-m-d G:i:s").','.memory_get_usage().','.$type.','.$msg."\n");
    fclose($fh);
  }

  public static function map($msg){
    $fh = fopen(Options::mapFile, 'a');
    fwrite($fh, CurSession::getUserName().','.date("Y-m-d G:i:s").','.memory_get_usage().',MAP,'.$msg."\n");
    fclose($fh);
  }
  
  public static function task($msg){
    $fh = fopen(Options::tasksFile, 'a');
    fwrite($fh, CurSession::getUserName().','.date("Y-m-d G:i:s").','.memory_get_usage().',MAP,'.$msg."\n");
    fclose($fh);
  }
}
?>