<?
require("FaceMySQL.php");

Connect();
$DB = $_REQUEST['DB'];
$TA = $_REQUEST['TA'];
commonHeader("Add data to the $TA table of the $DB database");

mysql_connect("$DBHost","$DBUser","$DBPass");
mysql_select_db("$DB");
$result=mysql_query("select * from $TA");
$fields=mysql_num_fields($result);
$rows=mysql_num_rows($result);
$i=0;
$table=mysql_field_table($result,$i);
blueFont ("The ");
redFont ("$table");
bluefont (" table has the following fileds:");
echo "<br>";
blueFont("Type your new data into the box(es), and then SUBMIT!");
echo "<br><br>";

echo "<TABLE BORDER='0' CELLPADDING='10' CELLSPACING='10'><TR>";
echo "<FORM ACTION='./add_data_response.php?DB=$DB&TA=$TA' METHOD='POST' ENCTYPE='x-www-form-urlencoded'>";

while ($i < $fields):
$name=mysql_field_name($result,$i);
$type=mysql_field_type($result,$i);
if ($type == 'blob') {
echo "<tr><td>";
blueFont("$name");
echo "</td>";
echo "<td><textarea name='value[$i]' rows='10' cols='50' wrap>";
echo "</textarea></td></tr>";
$i++;
} else {
echo "<tr><td>";
blueFont("$name");
echo "</td>";
echo "<td><input type='text' name='value[$i]' size='50'></td></tr>";
$i++;
	}
endwhile;

echo "<tr><td><INPUT TYPE='submit' NAME='Submit' VALUE='Submit'></td></tr>";

echo "</TABLE>";

commonFooter();
?>
