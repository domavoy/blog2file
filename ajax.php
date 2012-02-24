<?php
require_once('config.php');
require_once('libs/libs.php');
require_once('task/task.php');
require_once('blogs/blogs.php');
require_once('lang/lang.php');

Checker::setRequestHandler('getCalendar', 'AjaxProcessor::getCalendar');

class AjaxProcessor{
  /**
   * Return Calendar data
   * @param $id task id
   * @return json string with calendar data
   */
  public static function getCalendar($id){
    try{
      $data =  BlogTask::getCalendar($id);
      if($data == false){
        AjaxProcessor::ajaxError('');
      }else{
        AjaxProcessor::ajaxSuccess($data);
      }
    }catch(Exception $e){
      Log::error('failed to retrieve blog task percent for id='.$id.' due '.$e);
      AjaxProcessor::ajaxError('Failed to analyze blog');
    }
  }

  public static function ajaxSuccess($value){
    echo json_encode(array(Options::ERROR_SUCCESS_VALUE,$value));
  }

  public static function ajaxError($msg){
    echo json_encode(array(Options::ERROR_RETURN_VALUE,$msg));
  }
}
?>