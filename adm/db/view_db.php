<?
require("FaceMySQL.php");
$DB = $_REQUEST['DB'];
Connect();
$DB = $_REQUEST['DB'];
commonHeader("Look at $DB");

echo "<h3>";
blueFont ("База данных ");
redFont ("$DB");
blueFont (" содержит следующие таблицы");
echo "<br>";
blueFont ("Выберите нужную вам таблицу...");
echo "</h3>";

mysql_connect("$DBHost", "$DBUser", "$DBPass");
$result=mysql_listtables("$DB");
$i=0;
echo "<UL>";
while ($i < mysql_num_rows($result)) {
$tables[$i]=mysql_tablename($result,$i);
echo "<li><a href='./view_db_response.php?DB=$DB&TA=$tables[$i]'>$tables[$i]</a></li><br>";
$i++;
}
echo "</UL>";

commonFooter();
?>
