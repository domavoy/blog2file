<?php
require_once('session.php');
$message = Checker::setRequestHandler('email','UsersHandler::inviteUserByEmail');
require_once('tmpl/header.php');
?>

<div class="pageContent root">
  <div class="createForm" style = "padding-left: 50px">
  
  <h1><?=Lang::get(Lang::invite_form_header)?></h1>
  <h4><?=Lang::get(Lang::header_invite_count,CurSession::getInviteCounts())?></h4>
  <br/>
  <form name="1" action="" method="post">
  <h3><?=Lang::get(Lang::invite_form_email)?></h3>
  <input class="text" name="email" type="text" value="" size = "15">
  <br/><br/>
  <input class="button" style = "text-align:center" name="requestSentInvite" type="submit" value="<?=Lang::get(Lang::invite_form_send)?>"> 
  <div><?=$message?></div>
<?php
require_once('tmpl/footer.php');
?>