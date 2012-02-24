<?php
require_once('../config.php');
require_once('../libs/libs.php');
require_once('../task/task.php');
require_once('../lang/lang.php');
require_once("../tmpl/header.php");
require_once("./head.php");

if(isset($_REQUEST['delete_coming_soon'])){
  $id = Checker::getRequest('delete_coming_soon');
  Users::deleteComingSoon($id);
}

$data = Users::getInvitesList();
$dataInvites1 = Users::getUsersInvitesList(true);
$dataInvites2 = Users::getUsersInvitesList(false);
?>

<h1>Кто ждет инвайты, c coming soon</h1>
<table border = "1">
<tr>
	<th>Time</th>
	<th>Email</th>
	<th>Пригласить</th>
	<th>Удалить</th>
</tr>
<?php 
foreach($data as $d){
  echo '<tr>';
  echo '<td>'.date('Y-m-d_H:i:s',$d['t']).'</td>';
  echo '<td>'.$d['email'].'</td>';
  echo '<td><a href = "/invite.php?email='.$d['email'].'">Invite</a></td>';
  echo '<td><a href = "?delete_coming_soon='.$d['email'].'">Delete</a></td>';
  echo '</tr>';
}

?>
</table>
<br/>

<h1>Их пригласили, и они зарегились</h1>
<table border = "1">
<tr>
	<th>Время</th>
	<th>Кто</th>
	<th>Кого</th>
</tr>
<?php 
foreach($dataInvites1 as  $d){
  echo '<tr>';
  echo '<td>'.date('Y-m-d_H:i:s',$d['t']).'</td>';
  echo '<td>'.$d['username'].'</td>';
  echo '<td>'.$d['invite_email'].'</td>';
  echo '</tr>';
}

?>
</table>

<h1>Их пригласили, и они ждем пока зарегятся</h1>
<table border = "1">
<tr>
	<th>Время</th>
	<th>Кто</th>
	<th>Кого</th>
</tr>
<?php 
foreach($dataInvites2 as  $d){
  echo '<tr>';
  echo '<td>'.date('Y-m-d_H:i:s',$d['t']).'</td>';
  echo '<td>'.$d['username'].'</td>';
  echo '<td>'.$d['invite_email'].'</td>';
  echo '</tr>';
}

?>
</table>

<?php
require_once("../tmpl/footer.php");
?>