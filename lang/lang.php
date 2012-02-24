<?php
require_once('ru.php');
require_once('en.php');

if(isset($_GET['lang'])){
  Lang::setLanguage($_GET['lang']);
}else{
  if (isset($_COOKIE['lang'])) {
    Lang::setLanguage($_COOKIE['lang']);
  }else{
    Lang::setDefaultLanguage();
  }
}

Lang::setDefaultLanguage();

class Languages{
  const RU = 'ru';
  const EN = 'en';
}

interface LanguageSupport{
  public static function getFormattedDate($time);
  public static function convertLjDate($mobileDate);
}

class Lang{
  public static $info;
  public static $currentLanguage;

  /**
   * Return updated String for current langauge
   * @param $index
   * @return unknown_type
   */
  public static function get($index){
    if(array_key_exists($index, self::$info)){
      $str =  self::$info[$index];
      // set params
      $argCount = func_num_args();
      if($argCount > 1){
        for($i = 0; $i < $argCount-1; $i++){
          $value = func_get_arg($i+1);
          $str = str_replace('{'.$i.'}', $value, $str);
        }
      }
      return $str;
    }else{
      Log::error('Language: Failed to find index: '.$index);
      return "!!!!! Invalid index !!!!";
    }
  }

  public static function getLanguageText($language, $index){
    $str = '';
    switch($language){
      case Languages::RU:
        $str =  LangRussian::$data[$index];
        break;
      case Languages::EN:
        $str = LangEnglish::$data[$index];
        break;
      default:
        $str = LangEnglish::$data[$index];
        break;
    }
    $argCount = func_num_args();
    if($argCount > 2){
      for($i = 0; $i < $argCount-2; $i++){
        $value = func_get_arg($i+2);
        $str = str_replace('{'.$i.'}', $value, $str);
      }
    }
    return $str;
  }

  public static function setDefaultLanguage(){
    Lang::setRussian();
  }
  
  public static function setRussian(){
    self::$info = LangRussian::$data;
    self::$currentLanguage = Languages::RU;
  }

  public static function setEnglish(){
    self::$info = LangEnglish::$data;
    self::$currentLanguage = Languages::EN;
  }

  public static function getFormattedDate($time){
    if(self::$currentLanguage ==Languages::RU){
      return LangRussian::getFormattedDate($time);
    }else{
      return LangEnglish::getFormattedDate($time);
    }
  }

  public static function convertLjDate($date){
    if(self::$currentLanguage ==Languages::RU){
      return LangRussian::convertLjdate($date);
    }else{
      return LangEnglish::convertLjdate($date);
    }
  }

  public static function setLanguage($language){
    switch($language){
      case Languages::RU:
        Lang::setRussian();
        setcookie ('lang', Languages::RU, time()+60*60*24*30);
        break;
      case Languages::EN:
        Lang::setEnglish();
        setcookie ('lang', Languages::EN, time()+60*60*24*30);
        break;
      default:
        Lang::setDefaultLanguage();
        setcookie ('lang', Languages::RU, time()+60*60*24*30);
        break;
    }
  }

  // coming soon page
  const soon_msg_address_exists =     1;
  const soon_msg_thanks =             2;
  const soon_msg_enter_valid_email =  3;
  const soon_form_title =             4;
  const soon_form_header=             5;
  const soon_form_enter_email=        6;
  const soon_form_send_email=         7;
  // login page
  const login_msg_badpw =           8;
  const login_msg_enter_something = 9;
  const login_form_title = 10;
  const login_form_header = 11;
  const login_form_enter_email =12;
  const login_form_enter_pasword =13;
  const login_form_login_button =14;
  //register page
  const register_msg_try_later =15;
  const register_msg_bad_email =16;
  const register_msg_passwords_not_match =17;
  const register_msg_user_exists =18;
  const register_form_title =19;
  const register_form_header=20;
  const register_form_your_login =21;
  const register_form_password1 =22;
  const register_form_password2 =23;
  const register_form_get_email =24;
  const register_form_reigister_button =25;
  // about page
  const about_title = 26;
  const about_message = 27;
  const about_uses = 28;
  const about_use1= 29;
  const about_use2 = 30;
  const about_use3 = 31;
  const about_idea = 32;
  // error page
  const error_msg1 = 33;
  const error_msg2 = 34;
  // help page
  const help_header = 35;
  const help_about_link = 36;
  const help_about_text = 37;
  const help_principes_link = 38;
  const help_principes_text = 39;
  const help_blogs_link = 40;
  const help_blogs_text = 41;
  const help_files_link = 42;
  const help_files_text = 43;
  const help_invite_link = 44;
  const help_invite_text = 45;
  const help_support_link = 46;
  const help_support_text = 47;
  // invite page
  const invite_form_header = 48;
  const invite_form_email = 49;
  const invite_form_send = 50;

  // feedback page
  const feedback_msg_thanks1 = 51;
  const feedback_msg_thanks2 = 52;
  const feedback_form_header = 53;
  const feedback_form_option_error = 54;
  const feedback_form_option_ech = 55;
  const feedback_form_email = 56;
  const feedback_form_send = 57;
  const feedback_form_or = 58;
  const feedback_form_letter = 59;
  // index page
  const index_enter_address = 63;
  const index_options = 64;
  const index_new_post = 65;
  const index_images = 66;
  const index_download = 67;
  // analyse page
  const analyze_msg_many_blogs  =  68;
  const analyze_header =           69;
  const analyze_download = 70;
  const analyze_select_monthes = 71;
  const analyze_m_January = 72;
  const analyze_m_February = 73;
  const analyze_m_March = 74;
  const analyze_m_April  = 75;
  const analyze_m_May  = 76;
  const analyze_m_Jule = 77;
  const analyze_m_Juliy  = 78;
  const analyze_m_August  = 79;
  const analyze_m_Semptember  = 80;
  const analyze_m_October  = 81;
  const analyze_m_November  = 82;
  const analyze_m_December  = 83;
  // status page
  const status_progress  = 84;
  const status_wait1   = 85;
  const status_wait2  = 86;
  const status_goto   = 87;
  const status_error   = 88;

  const email_generated = 89;
  const email_invite= 90;

  const email_invite_subject = 91;
  const email_generated_subject =92;

  const file_generated_with =93;
  const file_contents = 94;

  const invite_msg_zero = 95;
  const invite_msg_success= 96;
  const invite_msg_error = 97;
  const invite_msg_bademail = 98;

  const header_language =99;
  const header_exit =100;
  const header_invite =101;
  const header_invite_count =102;
  const header_title =103;

  const index_url = 104;

  const header_feedback = 105;
  const header_help = 106;
  const header_about = 107;
  const header_main = 108;

  const feedback_form_intro = 109;
  const end_analyze_header = 110;

  const analyse_check_notfound = 111;
  const analyse_check_gomain = 112;
  const analyse_no_data = 113;
  
  const index_file_type = 114;
}
?>