<?php
//TODO: delete
class Messages{
  public static function getInviterMsg($uniq_id, $userName){
    return  <<<EOD
<html>
<body>
Здравствуйте!
<br/>
Пользователь, с адресом $userName приглашает вас, на бета тестинг сервиса Blog2File.com 
<br/>
Страница входа: <a href = "http://blog2file.com/login.php">http://blog2file.com/login.php</a>
<br/>
<br>
Чтобы принять приглашение и зарегистрироваться, нажмите на ссылку:
<a href="http://blog2file.com/register.php?id=$uniq_id" target="_blank">http://blog2file.com/register.php?id=$uniq_id</a>
<br/><br/>
С помощью нашего сервиса вы можете:
<ul>
	<li>Скачивать блоги, на платформе Livejournal в виде файла формата PDF
	<li>Ожидается поддержка других блог платформ - Blogger, Wordpress
	<li>Ожидается поддержка других форматов файлов - RTF, HTM
</ul>

<p>Сейчас проект находится в стадии бета тестинга, так что не удивляйтесь, если что-то не будет работать.<p>
Мы будем прилагать все усилия, чтобы этого не случилось :-)
<br>
Если вы нашли какую то ошибку, или есть предложения по функциональности сервиса, то вы можете оставить свой отзыв на <a href = "http://blog2file.com/feedback.php">странице связи с разработчиками</a>. Или пишите на почту: <a href="mailto:domavoy@gmail.com?subject=Blog2File%20bugs&suggestions">domavoy@gmail.com</a>
<p>
Зарегистрироваться на Blog2File.com можно только по приглашению - и оно у вас уже есть!
<br/>
Не теряйте своего шанса, регистрируйтесь.
</p>
<br/>
(с)2009 Blog2File.com
</body>
</html>
EOD;
  }

  public static function getBlogGeneratedMsg($fileName,$fileSize, $blogName){
    return  <<<EOD
<html>
<body>
Здравствуйте!
<br/>
Сервис Blog2file успешно скачал, указанный вам блог: <b>$blogName</b>
<br/>
Ссылка для скачивания: <a href = "http://blog2file.com/$fileName">http://blog2file.com/$fileName</a>
<br/>
Размер файла: $fileSize
<br/>
<br/>
<br/>
(с)2009 Blog2File.com
</body>
</html>
EOD;
  }
}
?>