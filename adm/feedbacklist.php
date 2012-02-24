<?php
require_once('../config.php');
require_once('../libs/libs.php');
require_once('../task/task.php');
require_once('../lang/lang.php');
require_once("../tmpl/header.php");
require_once("./head.php");
?>

<div style = "width: 600px;">

<h1>Список комментариев пользователей</h1>


<?php 
$data = Users::getFeedbackList();
?>

<table border = "1">
<tr>
	<th>Username</th>
	<th>Text</th>
	<th>isEmail</th>
	<th>Time</th>
</tr>
<?php 
foreach($data as $d){
  echo '<tr>';
  echo '<td>'.$d['username'].'</td>';
  echo '<td>'.$d['text'].'</td>';
  echo '<td>'.$d['isEmail'].'</td>';
  echo '<td>'.date('Y-m-d_H:i:s',$d['t']).'</td>';
  echo '</tr>';
}

?>
</table>

<?php
require_once("../tmpl/footer.php");
?>