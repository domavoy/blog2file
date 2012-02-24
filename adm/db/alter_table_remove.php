<?
require("FaceMySQL.php");
$DB = $_REQUEST['DB'];
$TA = $_REQUEST['TA'];
Connect();

commonHeader("Remove a field from the $TA table");

blueFont("Select the field that you want removed from the ");
redFont ("$TA");
blueFont(" table...");
echo "<br><br>";
echo "<FORM ACTION='./alter_table_remove2.php?DB=$DB&TA=$TA' METHOD='POST' ENCTYPE='x-www-form-urlencoded'>";

mysql_connect("$DBHost","$DBUser","$DBPass");
mysql_select_db("$DB");
$result=mysql_query("select * from $TA");
$fields=mysql_num_fields($result);
$i=0;

echo "<select name='Field' size='1'>";
while ($i < $fields) {
$name=mysql_field_name($result,$i);
echo "<option value='$name'> $name </option>";
$i++;
}
echo "</select>";

echo "</TABLE><br><br>";

echo "<INPUT TYPE='submit' NAME='Submit' VALUE='Submit'>";

commonFooter();
?>
