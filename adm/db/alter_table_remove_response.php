<?
require("FaceMySQL.php");
$DB = $_REQUEST['DB'];
$TA = $_REQUEST['TA'];
Connect();

mysql_connect("$DBHost","$DBUser","$DBPass");
mysql("$DB","ALTER TABLE $TA
drop
$Field");

commonHeader("$Field was deleted from the $TA table");

mysql_select_db("$DB");
$result=mysql_query("select * from $TA");
$fields=mysql_num_fields($result);
$rows=mysql_num_rows($result);
$i=0;
$table=mysql_field_table($result,$i);
blueFont ("The ");
redFont ("$table");
bluefont (" table has been altered.");
echo "<br>";
blueFont ("The $TA table now has the following fields: ");
echo "<br><br>";

echo "<TABLE BORDER='1' CELLPADDING='2' CELLSPACING='2'><TR>";
echo "<th bgcolor='#00287d'><font face='Arial' color='white'>Field Name</font></th>";
echo "<th bgcolor='#00287d'><font face='Arial' color='white'>Field Type</font></th>";
echo "<th bgcolor='#00287d'><font face='Arial' color='white'>Maximum Length</font></th>";
echo "<th bgcolor='#00287d'><font face='Arial' color='white'>Flags</font></th></tr>";
while ($i < $fields) {
$type=mysql_field_type($result,$i);
$name=mysql_field_name($result,$i);
$len=mysql_field_len($result,$i);
$flags=mysql_field_flags($result,$i);

echo "<tr>";
echo "<td> $name </td>";
echo "<td> $type </td>";
echo "<td> $len </td>";
echo "<td> $flags </td></tr>";
$i++;
}
echo "</TABLE>";


commonFooter();
?>
