<?
require("FaceMySQL.php");

$DB = $_REQUEST['DB'];
$TA = $_REQUEST['TA'];
commonHeader("Look at $DB ");

echo "<h3>";
blueFont ("Select an  option...");
echo "</h3>";

echo "<ul>";
echo "<li><a href='./view_table.php?DB=$DB&TA=$TA'>Свойства полей таблицы <b>$TA</b></a></li>";
echo "<li><a href='./query.php?DB=$DB&TA=$TA'>Содержимое таблицы <b>$TA</b></a></li>";
echo "<li><a href='./add_data.php?DB=$DB&TA=$TA'>Добавить новые данные к таблице <b>$TA</b></a></li>";
echo "<li><a href='./update_data.php?DB=$DB&TA=$TA'>Update existing data in the <b>$TA</b> table</a></li>";
echo "<li><a href='./alter_table.php?DB=$DB&TA=$TA'>Исправить поля таблицы <b>$TA</b></a></li>";
echo "<li><a href='./drop_table.php?DB=$DB&TA=$TA'>Удалить таблицу <b>$TA</b> из базы данных</a></li>";
echo "</UL>";

commonFooter();
?>
