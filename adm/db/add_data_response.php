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
$count=0;
$table=mysql_field_table($result,$i);
blueFont("You have inserted the following into the ");
redFont ("$TA");
blueFont(" table of the ");
redFont ("$DB");
blueFont(" database...");
echo "<br><br><center>";

echo "</center><table border='1' cellpadding='2' cellspacing='2'><tr>";
echo "<th bgcolor='#00287d'><font face='Arial' color='white'>Fields</font></th>";
echo "<th bgcolor='#00287d'><font face='Arial' color='white'>Data</font></th>";
echo "</tr><tr>";

while ($i < $fields) {
$name=mysql_field_name($result,$i);
echo "<td>";
redFont("$name");
echo "</td>";
echo "<td>";
blueFont("$value[$i]");
echo "</td></tr>";
$i++;
}
echo "</table>";

/* combine the field elements */
$i=0;
$count=$fields;
while ($i < $fields) {
$name=mysql_field_name($result,$i);
if ($i==($count-1)) {
$field="$field,$name";
} elseif ($i==0) {
$field="$name";
} else {
$field="$field,$name";
}
$i++;
}


/* combine the data elements */
$i=0;
while ($i < $fields) {
$name=mysql_field_name($result,$i);
$value[$i]=addslashes($value[$i]);
if ($i==0) {
$newValue="'$value[$i]'";
} else {
$newValue="$newValue,'$value[$i]'";
}
$i++;
}


mysql_connect("$DBHost","$DBUser","$DBPass");
mysql("$DB", "INSERT INTO $TA ($field) VALUES ($newValue)");
echo "$DB";
echo "<BR>";
echo $TA;
echo "<BR>";
echo $field;
echo "<BR>";
echo $newValue;
echo "<BR>";
echo $iname="a";
echo $imail="b";
echo $itext="c";
mysql("$DB","INSERT INTO guest (name,mail,text) VALUES('$iname','$imail','$itext')");
echo "<TABLE BORDER='0' CELLPADDING='10' CELLSPACING='10'><TR>";
while ($i < $fields) {
$name=mysql_field_name($result,$i);

echo "<tr><td>";
blueFont("$name");
echo "</td>";
echo "<td><input type='text' name='$name' size='50'></td></tr>";
$i++;
}


echo "</TABLE>";

commonFooter();
?>
