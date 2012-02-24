<?
require("FaceMySQL.php");
Connect();
$DB = $_REQUEST['DB'];
$TA = $_REQUEST['TA'];
echo "<FORM ACTION='./add_db_response.php' METHOD='POST' ENCTYPE='x-www-form-urlencoded'>";
echo "<P><CENTER><TABLE BORDER='0' CELLSPACING='10' CELLPADDING='10'>";
echo "<TR><TD>";
echo "<B>";
blueFont ("Имя базы данных:");
echo "</B>";
echo "<FONT FACE='Arial'><BR>";
echo "<INPUT TYPE='text' NAME='db_name' SIZE='20'><BR><BR>";
echo "<INPUT TYPE='submit' NAME='Submit' VALUE='Отправить'>";
echo "</FONT></TD></TR></TABLE>";
?>
