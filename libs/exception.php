<?php
class MyException extends Exception {
  public function __construct($message, $errorLevel = 0, $errorFile = '', $errorLine = 0) {
    parent :: __construct($message, $errorLevel);
    $this->file = $errorFile;
    $this->line = $errorLine;
  }
}
set_error_handler(create_function('$c, $m, $f, $l', 'throw new MyException($m, $c, $f, $l);exit();'), E_ALL);
//set_error_handler(create_function('$c, $m, $f, $l', 'echo "exception";'), E_ALL);


class TaskNotFoundException extends Exception{

  var $taskId;

  public function __construct($taskId){
    $this->taskId = $taskId;
  }

  public function getTaskId(){
    return $this->taskId;
  }
}

class HttpPageNotFoundException extends Exception{

  var $url;

  public function __construct($url){
    $this->url = $url;
  }

  public function getUrl(){
    return $this->url;
  }
}

class BlogTypeNotFoundException extends Exception{

  var $blogType;

  public function __construct($blogType){
    $this->blogType = $blogType;
  }

  public function getBlogType(){
    return $this->blogType;
  }
}

class FileTypeNotFoundException extends Exception{

  var $type;

  public function __construct($type){
    $this->type = $type;
  }

  public function getType(){
    return $this->type;
  }
}

class BlogTaskFailedException extends Exception{
}

class TaskInfoNotFoundException extends Exception{
}

class FPDFException extends Exception{

  var $msg;

  public function __construct($msg){
    $this->msg = $msg;
  }

  public function getMsg(){
    return $this->msg;
  }
}


?>