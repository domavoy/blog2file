<?
require("FaceMySQL.php");
$DB = $_REQUEST['DB'];
$TA = $_REQUEST['TA'];
Connect();

commonHeader("Add data to the $TA table of the $DB database");

mysql_connect("$DBHost","$DBUser","$DBPass");
mysql_select_db("$DB");
$result=mysql_query("select * from $TA where $Field='$Data'");
$fields=mysql_num_fields($result);
$rows=mysql_num_rows($result);
$row = mysql_fetch_row($result);
$i=0;
$table=mysql_field_table($result,$i);
blueFont ("The ");
redFont ("$table");
bluefont (" table has the following fileds:");
echo "<br>";
blueFont("Type your new data into the box(es), and then SUBMIT!");
echo "<br><br>";

echo "<TABLE BORDER='0' CELLPADDING='10' CELLSPACING='10'><TR>";
echo "<FORM ACTION='./update_data_response.php?DB=$DB&TA=$TA&Field=$Field&Data=$Data' METHOD='POST' ENCTYPE='x-www-form-urlencoded'>";

while ($i < $fields):
$type=mysql_field_type($result,$i);
$name=mysql_field_name($result,$i);
if ($name == $Field) :
$i++;
else :
if ($type == 'blob') {
echo "<tr><td>";
blueFont("$name");
echo "</td>";
$row[$i]=stripslashes($row[$i]);
echo "<td><textarea name='value[$i]' rows='10' cols='80' wrap>$row[$i]";
echo "</textarea></td></tr>";
$i++;
} else {
echo "<tr><td>";
blueFont("$name");
echo "</td>";
echo "<td><input type='text' name='value[$i]' size='50' value='$row[$i]'></td></tr>";
$i++;
	}
endif;
endwhile;

echo "<tr><td><INPUT TYPE='submit' NAME='Submit' VALUE='Submit'></td></tr>";

echo "</TABLE>";

commonFooter();
?>
