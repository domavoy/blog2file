<?
require("FaceMySQL.php");
$DB = $_REQUEST['DB'];
commonHeader("$DB Options");
$DB = $_REQUEST['DB'];
echo "<b>";
blueFont ("Что Вы хотите делать с ");
redFont ("$DB");
blueFont ("?");
echo "</b><br><br>";

echo "<ul>";
echo "<li><a href='./view_db.php?DB=$DB'>Посмотреть содержимое <b>$DB</b></a></li>";
echo "<li><a href='./add_table.php?DB=$DB'>Добавить новую таблицу к <b>$DB</b> database</a></li>";
echo "<li><a href='./drop.php?DB=$DB'>Удалить <b>$DB</b> базу данных</a></li>";

echo "</ul>";

commonFooter();
?>
