<?php
require_once('../config.php');
require_once('../libs/libs.php');
require_once('../task/task.php');
require_once('../lang/lang.php');
require_once("../tmpl/header.php");
require_once("./head.php");

if(isset($_REQUEST['delete_task'])){
  $id = Checker::getRequest('delete_task');
  ScheduleTask::deleteScheduleTask($id);
}
  
$tasks = ScheduleTask::getOrderList();
?>

<div style = "width: 600px;">

<h1>Список тасков</h1>

<table border = "1">
<tr>
	<th>Email</th>
	<th>Options</th>
	<th>Monthes</th>
	<th>Time</th>
	<th>Status</th>
	<th>-</th>
</tr>
<?php 

function printMonthes($monthes){
  $text = '';
  $month = Utils::convertHtmlMonthes($monthes);
  $monthes = $month['monthesList'];
  foreach($monthes as $month){
    $text.=$month[0].' '.$month[1].'<br>';
  }
  return $text;
}

foreach($tasks as $d){
  echo '<tr>';
  echo '<td>'.$d->email.'</td>';
  echo '<td>'.$d->options.'</td>';
  echo '<td>'.printMonthes(unserialize($d->options->monthes)).'</td>';
  echo '<td>'.date('Y-m-d_H:i:s',$d->starttime).'<br/>'.date('Y-m-d_H:i:s',$d->endtime).'</td>';
  echo '<td>'.IdConverter::getScheduleTaskName($d->status).'</td>';
  echo '<td><a href = "?delete_task='.$d->taskId.'">Delete</a></td>';
  echo '</tr>';
}

?>
</table>
<?php
require_once("../tmpl/footer.php");
?>