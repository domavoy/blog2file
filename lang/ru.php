<?php
require_once('ru_utils.php');

class LangRussian implements LanguageSupport{

  public static $data = array(
  Lang::header_language => 'Язык: ',
  Lang::header_exit => 'Выйти',
  Lang::header_invite => 'Пригласить друга',
  Lang::header_invite_count => 'У вас {0} инвайтов ',
  Lang::header_title => 'Blog2File: download and save any blogs from popular blog hostings',
  Lang::header_feedback => 'Поддержка',
  Lang::header_help => 'Помощь',
  Lang::header_about => 'О сервисе',
  Lang::header_main => 'Главная страница',
  // Coming soon page
  Lang::soon_msg_address_exists => 'Ваш адрес уже есть в нашей базе !',
  Lang::soon_msg_thanks => 'Спасибо. Мы с вами свяжемся !',
  Lang::soon_msg_enter_valid_email => 'Введите правильный email',
  Lang::soon_form_title => 'Blog2File: download and save any blogs from popular blog hostings',
  Lang::soon_form_header => 'Blog2File in beta',
  Lang::soon_form_enter_email => '<a href = "login.php">Login</a> or enter your email:',
  Lang::soon_form_send_email => 'Отправить запрос',
  // login window
  Lang::login_msg_badpw => 'Неверный логин или пароль',
  Lang::login_msg_enter_something => 'Ну ведите же что нибудь',
  Lang::login_form_title => 'Blog2File: download and save any blogs from popular blog hostings',
  Lang::login_form_header => 'Введите данные:',
  Lang::login_form_enter_email => 'E-mail:',
  Lang::login_form_enter_pasword => 'Password:',
  Lang::login_form_login_button => 'Войти',
  // register window
  Lang::register_msg_try_later => 'Повторите запрос позднее',
  Lang::register_msg_bad_email => 'Неправильный email',
  Lang::register_msg_passwords_not_match => 'Введенные пароли не совпадают',
  Lang::register_msg_user_exists => 'Пользователь с таким именем уже существует',
  Lang::register_form_title => 'Blog2File - keep your favorite blog localy',
  Lang::register_form_header => 'Регистрация:',
  Lang::register_form_your_login => 'Ваш логин: ',
  Lang::register_form_password1 => 'Пароль:',
  Lang::register_form_password2 => 'Пароль еще раз:',
  Lang::register_form_get_email => 'Получать письма о новых возможностях сервиса. Не больше одного раза в неделю',
  Lang::register_form_reigister_button => 'Зарегистрировать',
  // about
  Lang::about_title => 'О проекте',
  Lang::about_message => 'Blog2file - это сервис, с помощью которого вы можете сохранить записи нужных вам блогов, себе на компьютер.
	Из блогов, пока поддерживается только Livejournal.',
  Lang::about_uses => 'Как можно использовать этот сервис?',
  Lang::about_use1 => 'скачивать, нужные вам блоги, распечатать их, или читать с монитора все написанное.',
  Lang::about_use2 => 'выполнять бэкап записей вашего блога.',
  Lang::about_use3 => 'сделать книгу из своего, или чужого блога.',
  Lang::about_idea => 'А все началось с простенькой идеи - скачать блог себе на диск. В то время, один из наших разработчиков захотел побольше узнать от технологии Flash, и поэтому много лазил, по всяческим блогам, смотрел примеры, скачивал исходники. Ему это надоело. <p> Захотелось - нажал кнопку, и весь блог у тебя на диске в формате PDF, чтоб можно было распечатать и читать по нормальному..',
  //error page
  Lang::error_msg1 => 'Произошла непредвиденная ошибка',
  Lang::error_msg2 => 'Админы уже оповещены',

  Lang::help_header => 'Помощь',
  Lang::help_about_link => 'О сервисе',
  Lang::help_about_text => 'Blog2file - это сервис, с помощью которого вы можете сохранить записи нужных вам блогов, себе на компьютер.',

  Lang::help_principes_link => 'Принцип работы',
  Lang::help_principes_text => 'Работающая на сервере программа(демон) анализирует пользовательские
запросы, скачивает и обрабатывает по ним блоги. По окончании, высылает пользователям
пиcьма, об их успешном скачивании.',

  Lang::help_blogs_link => 'Поддерживаемые типы блогов',
  Lang::help_blogs_text => 'Пока только livejournal.',

  Lang::help_files_link => 'Поддерживаемые типы файлов',
  Lang::help_files_text => 'Пока только PDF.',

  Lang::help_invite_link => 'Приглашение друзей, на бета тестирование',
  Lang::help_invite_text => '
  Сейчас сервис находится в бета тестировании. И доступ к нему есть, пока
только по приглашениям. Вы можете пригласить вашего друга, на
тестирование на <a href="http://blog2file.com/invite.php"> странице с приглашениями</a>. <br />
<br />
Количество инвайтов, для каждого пользователя, ограничено.',
  Lang::help_support_link => 'Связь с разработчиками',
  Lang::help_support_text => 'Сообщить об ошибке или предложить какую то новую функциональность
  	вы можете на <a href="http://blog2file.com/feedback.php">специальной странице</a>.',

  Lang::invite_msg_zero => 'У вас ноль инвайтов. Мы не сможете больше никого пригласить.',
  Lang::invite_msg_success => 'Вы успешно отправили приглашение по адресу: {0}',
  Lang::invite_msg_error => 'Ошибка при отправлении письма на ящик: : {0}',
  Lang::invite_msg_bademail => 'Вы ввели неправильный e-mail: {0}',
  Lang::invite_form_header => 'Пригласить друга, на наш сервис',
  Lang::invite_form_email => 'Введите почтовый ящик друга:',
  Lang::invite_form_send => 'Отправить приглашение',

  Lang::feedback_msg_thanks1 => 'Спасибо за помощь !',
  Lang::feedback_msg_thanks2 => 'Перейти на главную',
  Lang::feedback_form_header => 'Связь с разработчиками',
  Lang::feedback_form_intro => 'Я хочу: ',
  Lang::feedback_form_option_error => 'Сообщить об ошибке',
  Lang::feedback_form_option_ech => 'Предложить новую функциональность',
  Lang::feedback_form_email => 'Получить на почту уведомление, о том эта ошибка/функциональность сделана',
  Lang::feedback_form_send => 'Отправить',
  Lang::feedback_form_or => 'или',
  Lang::feedback_form_letter => 'пишите на мыло: domavoy@gmail.com, или в аську 248013093',

  Lang::index_enter_address => 'Введите адрес Livejournal блога, или комьюнити:',
  Lang::index_options =>  'Настройки:',
  Lang::index_new_post =>  'Новый пост, с новой страницы',
  Lang::index_images =>  'Скачивать картинки (может занять много времени)',
  Lang::index_download => 'Скачать',
  Lang::index_url => '',
  lang::index_file_type => 'Тип файла: ',

  Lang::analyze_msg_many_blogs => 'К сожалению, вы не можете скачивать больше одного блога за раз. <br/> Дождитесь окончания загрузки(вам придет письмо). После этого вы сможете скачать, уже другой блог.',
  Lang::analyse_check_notfound => 'Блог, по адресу: "{0}" не найден<br/>Сервис пока поддерживает только Livejournal',
  Lang::analyse_check_gomain => 'Перейти на главную',
  Lang::analyse_no_data => 'В блоге {0} не найдено ни одной записи',

  Lang::analyze_header => 'Идет анализ блога: ',
  Lang::end_analyze_header => 'Блог: ',
  Lang::analyze_download => 'Next',
  Lang::analyze_select_monthes => 'Выберите месяца..',
  Lang::analyze_m_January => 'Январь',
  Lang::analyze_m_February =>  'Февраль',
  Lang::analyze_m_March => 'Март',
  Lang::analyze_m_April =>  'Апрель',
  Lang::analyze_m_May => 'Май',
  Lang::analyze_m_Jule => 'Июнь',
  Lang::analyze_m_Juliy => 'Июль',
  Lang::analyze_m_August => 'Август',
  Lang::analyze_m_Semptember =>  'Сентябрь',
  Lang::analyze_m_October =>  'Октябрь',
  Lang::analyze_m_November => 'Ноябрь',
  Lang::analyze_m_December =>  'Декабрь',

  Lang::status_progress => 'Идет обработка блога, и генерация файла: ',
  Lang::status_wait1 => 'Закончится примерно через ',
  Lang::status_wait2 => 'Ссылка на файл придет к вам на почтовый ящик.',
  Lang::status_goto => 'Перейти на главную',
  Lang::status_error => 'Сообщение об отправке уже отправлено . Если не получали - обратитесть к админам',

  Lang::file_generated_with => 'Сгенерировано с помощью blog2file.com',
  Lang::file_contents => 'Содержание',

  Lang::email_generated_subject => 'Blog2file.com: Блог успешно скачался',
  Lang::email_generated => '
 <html>
<body>
Здравствуйте!
<br/>
Сервис Blog2file успешно скачал, указанный вам блог: <b>{2}</b>
<br/>
Ссылка для скачивания: <a href = "http://blog2file.com/{0}">http://blog2file.com/{0}</a>
<br/>
Размер файла: {1}
<br/>
<br/>
<br/>
(с)2009 Blog2File.com
</body>
</html>',

  Lang::email_invite_subject => 'Приглашение на blog2file.com',
  Lang::email_invite =>  '
<html>
<body>
Здравствуйте!
<br/>
Команда Blog2File.com приглашает вас к бета тестированию нашего сервиса.
<br/>
<br>
Чтобы принять приглашение и зарегистрироваться, нажмите на ссылку:
<a href="http://blog2file.com/register.php?id={0}&lang=ru" target="_blank">http://blog2file.com/register.php?id={0}&lang=ru</a>
<br/><br/>
Страница входа: <a href = "http://blog2file.com/login.php">http://blog2file.com/login.php</a>
<br/><br/>

Blog2file.com - сервис, с помощью которого вы можете сохранить записи нужных вам блогов, себе на компьютер.
<br/
>Из блогов, пока поддерживается только Livejournal, формат файлов - PDF.
<br/><br/><br/>

Как можно использовать этот сервис?
<ul>
	<li>скачивать, нужные вам блоги, распечатать их, или читать с монитора все написанное.</li>
	<li>выполнять бэкап записей вашего блога.</li>
	<li>сделать книгу из своего, или чужого блога.</li>
</ul>

<p>Сейчас проект находится в стадии бета тестинга, так что не удивляйтесь, если что-то не будет работать.
<br/>Мы будем прилагать все усилия, чтобы этого не случилось :-)<p>

<br>
Если вы нашли какую то ошибку, или есть предложения по функциональности сервиса, то вы можете оставить свой отзыв на <a href = "http://blog2file.com/feedback.php">странице связи с разработчиками</a>
<br/>
<br/>
(с)2009 Blog2File.com
</body>
</html>  '
  );

  public static function convertLjdate($mobileDate){
    $date = split('/',$mobileDate);
    $month[0]='января';
    $month[1]='февраля';
    $month[2]='марта';
    $month[3]='апреля';
    $month[4]='мая';
    $month[5]='июня';
    $month[6]='июля';
    $month[7]='августа';
    $month[8]='сентября';
    $month[9]='октября';
    $month[10]='ноября';
    $month[11]='декабря';
    return $date[2].' '.$month[$date[1]-1].' '.$date[0].' года';
  }

  public static function getFormattedDate($time){
    return RussianDateUtils::createUpString($time);
  }
}
?>