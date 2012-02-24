<?
require("FaceMySQL.php");
$DB = $_REQUEST['DB'];
$TA = $_REQUEST['TA'];
Connect();

commonHeader("Alter data in the $TA table of the $DB database");

blueFont ("Select a field which contains unique data for identification...");
echo "<br><br>";


mysql_connect("$DBHost","$DBUser","$DBPass");
mysql_select_db("$DB");
$result=mysql_query("select * from $TA");
$count=mysql_num_fields($result);
$i=0;
echo "<TABLE BORDER='0' CELLPADDING='2' CELLSPACING='2'><TR>";

echo "<tr><td>";
echo "<FORM ACTION='./update_data2.php?DB=$DB&TA=$TA' METHOD='POST' ENCTYPE='application/x-www-form-urlencoded'>";

echo "<select name='Field' size='1'>";
while ($i<$count) {
$name=mysql_field_name($result,$i);
echo "<option value='$name'> $name </option>";
$i++;
}
echo "</select>";
echo "<br><INPUT TYPE='submit' NAME='Submit' VALUE='Submit'>";
echo "</form>";
echo "</td></tr>";
echo "</TABLE>";

commonFooter();
?>
