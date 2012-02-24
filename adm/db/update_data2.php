<?
require("FaceMySQL.php");
$DB = $_REQUEST['DB'];
$TA = $_REQUEST['TA'];
$Field = $_REQUEST['Field'];

Connect();

commonHeader("Alter the $TA table");

blueFont ("Select the item that you wish to alter...");
echo "<br><br>";

mysql_connect("$DBHost","$DBUser","$DBPass");
mysql_select_db("$DB");
$result=mysql_query("select $Field from $TA");
echo "<FORM ACTION='update_data3.php?DB=$DB&TA=$TA&Field=$Field' METHOD='POST' ENCTYPE='application/x-www-form-urlencoded'>";
echo "<TABLE BORDER='0' CELLPADDING='2' CELLSPACING='2'><TR><TD>";

redFont("$Field:");
echo "<br><select name='Data' size='1'>";
while  ($row  =  mysql_fetch_row($result))  {
                for  ($i=0;  $i<mysql_num_fields($result);  $i++)  {
echo "<option value='$row[$i]'> $row[$i] </option>";
                }
}
echo "</select>";
echo "</td></tr>";

echo "</TABLE>";

echo "<br><INPUT TYPE='submit' NAME='Submit' VALUE='Submit'>";

commonFooter();
?>
