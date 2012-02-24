<?php
/**
 * Database singleton helper class
 * Return Database connections for both b2f versions
 * 		getConnection - for version2 connection
 *  	getConnection1 - for version1 connection
 * @author mdorof
 *
 */
class Database{
  private static $_instance;
  private static $_instance1;

  /**
   * private constructor
   * @return void
   */
  private function __construct(){
  }

  /**
   * Return default singleton database connection
   * @return PDO database object
   */
  public static function getConnection(){
    if(!isset(self::$_instance)){
      self::$_instance = new PDO(Options::dbConn, Options::dbConnUser, Options::dbConnPassword, array(PDO::ATTR_PERSISTENT => true));
    }
    return self::$_instance;
  }

  /**
   * Return extended database connection
   * @return PDO database object
   */
  public static function getConnection1(){
    if(!isset(self::$_instance1)){
      self::$_instance1 = new PDO(Options::dbConn1, Options::dbConnUser1, Options::dbConnPassword1);
    }
    return self::$_instance1;
  }

  /**
   * Trigger error for object clone
   * @return void
   */
  public function __clone(){
    trigger_error('Failed to copy Database singleton object', E_USER_ERROR);
  }
}

?>