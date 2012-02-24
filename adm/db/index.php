<?
require("FaceMySQL.php");
Connect();
echo "<h3>";
blueFont ("Выберите базу данных...");
echo "</h3>";
mysql_connect("$DBHost","$DBUser","$DBPass");
$i=0;
$num=mysql_list_dbs();
$dbs=mysql_num_rows(mysql_list_dbs());
echo "<UL>";
while ($dbs > $i) {
$result=mysql_dbname($num,$i);
echo "<li><a href='./functions.php?DB=$result'>$result</a></li>";
$i++;
}
echo "</UL><BR>";
?>
