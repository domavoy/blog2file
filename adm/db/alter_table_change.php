<?
require("FaceMySQL.php");
$DB = $_REQUEST['DB'];
$TA = $_REQUEST['TA'];
Connect();

commonHeader("Alter the $TA table");

mysql_connect("$DBHost","$DBUser","$DBPass");
mysql_select_db("$DB");
$result=mysql_query("select * from $TA");
$fields=mysql_num_fields($result);
$rows=mysql_num_rows($result);
$i=0;
blueFont("Select the field whose properties you wish to alter...");
echo "<br><br>";

echo "<TABLE BORDER='0' CELLPADDING='2' CELLSPACING='2'><TR><td>";
echo "<FORM ACTION='./alter_table_change2.php?DB=$DB&TA=$TA' METHOD='POST' ENCTYPE='x-www-form-urlencoded'>";

echo "<select name='Field' size='1'>";
while ($i < $fields) {
$name=mysql_field_name($result,$i);
echo "<option value='$name'> $name </option>";
$i++;
}
echo "</select>";
echo "</td></tr></TABLE><br><br>";

echo "<INPUT TYPE='submit' NAME='Submit' VALUE='Submit'>";

commonFooter();
?>
