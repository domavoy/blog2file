<?php
require_once('../config.php');
require_once('../libs/libs.php');
require_once('../task/task.php');
require_once('../lang/lang.php');
require_once("../tmpl/header.php");
require_once("./head.php");

  if(isset($_REQUEST['add_invite'])){
    $id = Checker::getRequest('add_invite', false);
    Users::addInvite($id);
  }
?>

<h1>Список пользователей</h1>
<ul style="list-style-type: none; list-style-image: none; list-style-position: outside; padding-left: 0px;">
	
</ul>

<?php 
$data = Users::getUsersList();
?>

<table>
<tr>
	<th>Id</th>
	<th>Email</th>
	<th>Invite</th>
	<th>Time</th>
	<th>+</th>
</tr>
<?php 
foreach($data as $d){
  echo '<tr>';
  echo '<td>'.$d['id'].'</td>';
  echo '<td>'.$d['email'].'</td>';
  echo '<td>'.$d['inviteCount'].'</td>';
  echo '<td>'.date('Y-m-d_H:i:s',$d['t']).'</td>';
  echo '<td><a href = "?add_invite='.$d['id'].'">Add</a></td>';
  echo '</tr>';
}

?>
</table>
<?php
require_once("../tmpl/footer.php");
?>