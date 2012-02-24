<?php
/**
 * Contain function, for users action processing
 * login, loout, invite, register ...
 * @author mdorof
 */
class UsersHandler{

  /**
   * Sent invitation on blog2file for user
   * @param $email String our client email
   * @return String messages
   */
  public static function inviteUserByEmail($email){
    $inviteCount = CurSession::getInviteCounts();
    $userName = CurSession::getUserName();

    $msgStr = '';
    if($inviteCount == 0){
      $msgStr =  Lang::get(Lang::invite_msg_zero);
    }
    else if(Utils::checkmail($email)){
      $uniq_id = md5($_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT'].mktime());
      //Здесь укажите электронный адрес, куда будут уходить сообщения
      $mailto = $email;
      $subject = Lang::get(Lang::email_invite_subject);
      $message = Lang::get(Lang::email_invite, $uniq_id,$userName);
      // send user invitation
      if(Utils::sendmail($mailto,$subject,$message)) {
        Users::newInvitation($userName,$uniq_id, $email);
        CurSession::setInviteCounts(--$inviteCount);
        $msgStr =  Lang::get(Lang::invite_msg_success, $email);
      }else{
        $msgStr =  Lang::get(Lang::invite_msg_error, $email);
      }
    }else{
      $msgStr =  Lang::get(Lang::invite_msg_bademail, $email);
    }
    return $msgStr;
  }

  public static function sendBlogGeneratedMessage($fileName, $fileSize, $blogName, $email, $language){
    $subject = Lang::getLanguageText($language, Lang::email_generated_subject);
    $message = Lang::getLanguageText($language, Lang::email_generated, $fileName, $fileSize, $blogName);
    return Utils::sendmail($email,$subject,$message);
  }
}
?>