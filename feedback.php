<?php
try{
  require_once('session.php');

  if(isset($_REQUEST['sendFeedback'])){
    $isEmail = Checker::getRequestValues('isEmail', '1', '0');
    $subject = Checker::getRequest('subject');
    $message = str_replace("\n",'<br/>',Checker::getRequest('message'));
    $email = Options::FEEDBACK_EMAIL;

    switch($subject){
      case 'bug':
        $subject = 'Blog2File: new bug';
        break;
      case 'feature':
        $subject = 'Blog2File: new feature suggestion';
        break;
      default:
        $subject = 'Hack attempt in feedback page';
        break;
    }

    Utils::sendmail($email, $subject.' ('.$isEmail.')',$message);
    Users::insertFeedback(CurSession::getUserName(), '('.$subject.')<br/><br/>'.$message, $isEmail);
  }

  require_once("tmpl/header.php");
?>


<div class="pageContent root">
  <div class="createForm" style = "padding-left: 50px">


<?php

  if(isset($_REQUEST['sendFeedback'])){

    ?>

<h1><?=Lang::get(Lang::feedback_msg_thanks1)?></h1>
<div><a href="/"><?=Lang::get(Lang::feedback_msg_thanks2)?></a></div>
</div>


    <?php
  }
  else{
    ?>


<h1><?=Lang::get(Lang::feedback_form_header)?></h1>

<form action="feedback.php" method="POST">
<div style="margin: 0pt; padding: 0pt;">
<p><?=Lang::get(Lang::feedback_form_intro)?><select name="subject">
	<option value="bug"><?=Lang::get(Lang::feedback_form_option_error)?></option>
	<option value="feature"><?=Lang::get(Lang::feedback_form_option_ech)?></option>
</select></p>
<p><textarea name="message" style="width: 100%; height: 200px;"></textarea>
</p>
<input id="isEmail" name="isEmail" type="checkbox" value="false" />
	<label for="isEmail"><?=Lang::get(Lang::feedback_form_email)?></label>
<br/>
<input value="<?=Lang::get(Lang::feedback_form_send)?>" type="hidden" name="sendFeedback" id = "sendFeedback">
   <input class="button" value="<?=Lang::get(Lang::feedback_form_send)?>" type="submit" name="sendFeedbackSubmit" id = "sendFeedbackSubmit">
</div>
</form>

<h1><?=Lang::get(Lang::feedback_form_or)?></h1>
<div><?=Lang::get(Lang::feedback_form_letter)?></div>


    <?php
  }
  require_once("tmpl/footer.php");
}catch(Exception $e){
  Log::error('Exception on status page: '.$e);
  Location::goToError();
}
?>