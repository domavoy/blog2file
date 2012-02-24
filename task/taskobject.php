<?php
abstract class taskObject{
  var $id;
  abstract static function createTask();
  abstract static function getList();
  
  abstract function getData();
}
?>