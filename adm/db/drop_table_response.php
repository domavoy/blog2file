<?
require("FaceMySQL.php");
$DB = $_REQUEST['DB'];
$TA = $_REQUEST['TA'];
Connect();

mysql_connect("$DBHost","$DBUser","$DBPass");
mysql("$DB","drop table $TA");

commonHeader("$TA Dropped");

blueFont("You have droped the ");
redFont ("$TA");
blueFont(" table.");

commonFooter();
?>
