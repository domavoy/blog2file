<?php
require_once('../config.php');
require_once('../libs/libs.php');
require_once('../task/task.php');
require_once('../lang/lang.php');
require_once("../tmpl/header.php");
require_once("./head.php");
?>




<div class="pageContent faq">

<h1>Админка</h1>
<ul style="list-style-type: none; list-style-image: none; list-style-position: outside; padding-left: 0px;">
	<li>
		<a href="state.php">Демон</a>&nbsp;&nbsp;
		<a href="tasks.php">Tasks</a>&nbsp;&nbsp;
		<a href="userslist.php">Пользователи</a>&nbsp;&nbsp;
		<a href="feedbacklist.php">Feedback</a>&nbsp;&nbsp;
		<a href="inviteslist.php">Инвайты</a>
	</li>
	<li>
		<a href="dumper_local.php">Dumper-local</a>&nbsp;&nbsp;
		<a href="dumper.php">Dumper-production</a>
	</li>
	<li>
		<a href="phpinfo.php">PhpInfo</a>&nbsp;&nbsp;
		<a href="script.sql">Script.sql</a>
	</li>
	<li>
		<a href="ttp://control.majordomo.ru/">Majordomo - control</a>&nbsp;&nbsp;
		<a href="http://control.majordomo.ru/webftp/index.php">Majordomo - FTP</a>&nbsp;&nbsp;
		<a href="http://mysql.majordomo.ru/?server=13">Majordomo - mySql</a>&nbsp;&nbsp;
	</li>
</ul>

<?php
require_once("../tmpl/footer.php");
?>