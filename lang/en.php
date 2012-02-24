<?php
require_once('en_utils.php');

class LangEnglish implements LanguageSupport{

  public static $data = array(
  Lang::header_language => 'Language: ',
  Lang::header_exit => 'Logout',
  Lang::header_invite => 'Invite a friend',
  Lang::header_invite_count => '{0} Invite(s) left',
  Lang::header_title => 'Blog2File: download and save any blogs from popular blog hostings',
  Lang::header_feedback => 'Feedback',
  Lang::header_help => 'Help',
  Lang::header_about => 'About',
  Lang::header_main => 'Main page',
  // Coming soon page
  Lang::soon_msg_address_exists => 'This e-mail adress already exists in our database!',
  Lang::soon_msg_thanks => 'Thanks. We will contact you.',
  Lang::soon_msg_enter_valid_email => 'Please, input correct e-mail address.',
  Lang::soon_form_title => 'Blog2File: download and save any blogs from popular blog hostings',
  Lang::soon_form_header => 'Blog2File in beta',
  Lang::soon_form_enter_email => '<a href = "login.php">Login</a> or enter your email:',
  Lang::soon_form_send_email => 'Send a request',
  // login window
  Lang::login_msg_badpw => 'incorrect username or password',
  Lang::login_msg_enter_something => 'Lets input something!',
  Lang::login_form_title => 'Blog2File prototype - Step1: Analyzer page',
  Lang::login_form_header => 'Please, login:',
  Lang::login_form_enter_email => 'E-mail:',
  Lang::login_form_enter_pasword => 'Password:',
  Lang::login_form_login_button => 'Login',
  // register window
  Lang::register_msg_try_later => 'Plese try again later',
  Lang::register_msg_bad_email => 'Incorect e-mail address',
  Lang::register_msg_passwords_not_match => 'Paswords mismatch',
  Lang::register_msg_user_exists => 'This user already exists',
  Lang::register_form_title => 'Blog2File - keep your favorite blog localy',
  Lang::register_form_header => 'Registration:',
  Lang::register_form_your_login => 'You login name is ',
  Lang::register_form_password1 => 'Password:',
  Lang::register_form_password2 => 'Confirm password:',
  Lang::register_form_get_email => 'Please e-mail me about your new features (once a week)',
  Lang::register_form_reigister_button => 'Submit',
  // about
  Lang::about_title => 'About us',
  Lang::about_message => 'Blog2file - service, which allows you to save blog content to your local computer.
	We are supporting only LiveJournal now: users and communities.',
  Lang::about_uses => 'How you can use this service:',
  Lang::about_use1 => 'download blogs what you like, print or simply read it from your PC',
  Lang::about_use2 => 'backup yourself blog (Please note: we have no recovery yet, but we are plannig to do it later.)',
  Lang::about_use3 => 'make a book from any blog',
  Lang::about_idea => 'This project was imaged by one of our designer. He was thinking about downloading the whole blog content by one click. And it will be great to save this content to PDF, print it and read just a book. So, Blog2File service was started...',
  //error page
  Lang::error_msg1 => 'Error has occured',
  Lang::error_msg2 => 'Notification has been sent to admins already',

  Lang::help_header => 'Help',
  Lang::help_about_link => 'About service',
  Lang::help_about_text => 'Blog2file - service, which allows you to save blog posts to your local computer.',

  Lang::help_principes_link => 'How it works',
  Lang::help_principes_text => 'Program, which is worked on our server (demon) analyzes users\' requests, downloads and processes blogs.
And inform the user about successful result.',

  Lang::help_blogs_link => 'The following blog types are supported',
  Lang::help_blogs_text => 'LiveJournal',

  Lang::help_files_link => 'The following file types are supported',
  Lang::help_files_text => 'PDF.',

  Lang::help_invite_link => 'Invite your friends on beta testing',
  Lang::help_invite_text => '
  Our service is working in beta testing now. The only persons who recieved an
Invite can access it.
  You can invite your friend for testing if you would like to. Please use the invite page <a href="http://blog2file.com/invite.php"></a>. <br />
  You have to enter his e-mail address, so your friend is getting a letter with instructions of how to register in our
system.<br />
  Please note: invite count for every user is limited.',
  Lang::help_support_link => 'Contact us',
  Lang::help_support_text => 'If you have found an error or would like to offer any new functionality,
please fill free to contact us <a href="http://blog2file.com/feedback.php">here</a>',

  Lang::invite_msg_zero => 'You don\'t have Invates any more, so you cannot invite anybody else.',
  Lang::invite_msg_success => 'Your Invite has been successfuly sended to: {0}',
  Lang::invite_msg_error => 'Error sending e-mail to the following address: : {0}',
  Lang::invite_msg_bademail => 'You have provided incorrect e-mail address: {0}',
  Lang::invite_form_header => 'Invite your friend to our service:',
  Lang::invite_form_email => 'Please, input your friend e-mail:',
  Lang::invite_form_send => 'Send an Invite',

  Lang::feedback_msg_thanks1 => 'Thanks for help!',
  Lang::feedback_msg_thanks2 => 'Move to main page',
  Lang::feedback_form_header => 'Contact us',
  Lang::feedback_form_intro => 'I want: ',
  Lang::feedback_form_option_error => 'Report about error',
  Lang::feedback_form_option_ech => 'Offer a new functionality',
  Lang::feedback_form_email => 'Get a notification that such error/functionality is fixed/implemented.',
  Lang::feedback_form_send => 'Send',
  Lang::feedback_form_or => 'or',
  Lang::feedback_form_letter => 'Contact us directly by e-mail: domavoy@gmail.com, aka.delain@gmail.com or by ICQ 248013093, 273245202',


  Lang::index_enter_address => 'Please enter an address of LiveJournal blog or community:',
  Lang::index_options =>  'Properties:',
  Lang::index_new_post =>  'New post on new page',
  Lang::index_images =>  'Download picrutes also (it can take more time)',
  Lang::index_download => 'Download >>',
  Lang::index_url => '',
  lang::index_file_type => 'File type: ',
  
  Lang::analyse_check_notfound => 'Blog with address: {0} not found',
  Lang::analyse_check_gomain => 'Go to main page',  
  Lang::analyse_no_data => 'Data not found in blog: {0}',
  
  Lang::analyze_msg_many_blogs => 'Unfortunately, you cannot download more than one blog at the same time. <br/>Now downloading, please wait (you will recieve an e-mail as finish).
  When donwload will be completed, you can save one more blog if you would like to.',
  Lang::analyze_header => 'Blog analyze is in progress: ',
  Lang::end_analyze_header => 'Blog: ',
  Lang::analyze_download => 'Next >>',
  Lang::analyze_select_monthes => 'Choose month',
  Lang::analyze_m_January => 'January',
  Lang::analyze_m_February =>  'February',
  Lang::analyze_m_March => 'March',
  Lang::analyze_m_April =>  'April',
  Lang::analyze_m_May => 'May',
  Lang::analyze_m_Jule => 'June',
  Lang::analyze_m_Juliy => 'July',
  Lang::analyze_m_August => 'August',
  Lang::analyze_m_Semptember =>  'September',
  Lang::analyze_m_October =>  'October',
  Lang::analyze_m_November => 'November',
  Lang::analyze_m_December =>  'December',

  Lang::status_progress => 'Blog parsing and file generation are in progress: ',
  Lang::status_wait1 => 'Time estimate ',
  Lang::status_wait2 => 'You can get a link to file by e-mail.',
  Lang::status_goto => 'Move to main page',
  Lang::status_error => 'Sending message have sent. Please contact admins if you do not get it.',

  Lang::file_generated_with => 'Generated by blog2file.com',
  Lang::file_contents => 'Content',
  
  Lang::email_generated_subject => 'Blog2file.com: Downloads has been completed successfully.',
  Lang::email_generated => '
 <html>
<body>
Hello!
<br/>
Blog2file successfully donwloads blog: <b>{2}</b>
<br/>
Download link: <a href = "http://blog2file.com/{0}">http://blog2file.com/{0}</a>
<br/>
File size: {1}
<br/>
<br/>
<br/>
(с)2009 Blog2File.com
</body>
</html>',

  Lang::email_invite_subject => 'Invite to blog2file.com',
  Lang::email_invite =>  '
<html>
<body>
Hello!
<br/>
The following user {1} has invited you to beta-testing of the Blog2File.com service
<br/>
Login page: <a href = "http://blog2file.com/login.php">http://blog2file.com/login.php</a>
<br/>
<br>
To accept invitation and SignUp, please move by following link:
<a href="http://blog2file.com/register.php?id={0}" target="_blank">http://blog2file.com/register.php?id={0}</a>
<br/><br/>
Blog2File allows you to:
<ul>
	<li>Dowload LiveJournal blogs to PDF file
	<li>We are planning support also Blogger and Wordpress in future
	<li>We are planning to provide an ability to save blogs into RTF, HTM formats
</ul>

<p>We are on beta testing now. Please, be prepaired that something does not work properly<p>
Thank you for your comprehension.
<br>
If you have found an error or you would like to offer some functionality, please fill free to contact us: <a href = "http://blog2file.com/feedback.php">by the following page</a> or by e-mail: <a href="mailto:domavoy@gmail.com?subject=Blog2File%20bugs&suggestions">domavoy@gmail.com</a>
<p>
You can register on Blog2File.com only by Invitation, which you already have!
<br/>
Do not miss this chance. Register now!
</p>
<br/>
(c)2009 Blog2File.com
</body>
</html>  '
  );

public static function convertLjdate($mobileDate){
  $date_elements = split('/',$mobileDate);
  $myTime = mktime(0,0,0,$date_elements[1],$date_elements[2],$date_elements[0]);
  return date('d F Y',$myTime);
}

public static function getFormattedDate($time){
  return EnglishDateUtils::createUpString($time);
}
}
?>