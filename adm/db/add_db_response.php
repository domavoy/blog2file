<?
require("FaceMySQL.php");
Connect();
$DB = $_REQUEST['DB'];
$TA = $_REQUEST['TA'];
mysql_connect("$DBHost","$DBUser","$DBPass");
mysql_create_db("$db_name");
blueFont ("���� ������ ");
echo "<b>";
redFont ("$db_name");
echo "</b>";
blueFont (" ���������.");
echo "<br><br>";
?>
