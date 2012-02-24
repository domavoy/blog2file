<?
require("FaceMySQL.php");
$DB = $_REQUEST['DB'];
$TA = $_REQUEST['TA'];
Connect();

commonHeader("$DB Dropped");

mysql_connect("$DBHost","$DBUser","$DBPass");
mysql_drop_db("$DB");
blueFont ("The database ");
redFont ("$DB");
blueFont (" was dropped.");

commonFooter();
?>
