<?
require("FaceMySQL.php");
$DB = $_REQUEST['DB'];
$TA = $_REQUEST['TA'];
Connect();

commonHeader("Alter data in the $TA table of the $DB database");

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
echo "<br><br>";

while ($i < $fields) {
$name=mysql_field_name($result,$i);
$value[$i]=addslashes($value[$i]);
if ($name != $Field) {
mysql("$DB", "UPDATE $TA set $name='$value[$i]' where $Field='$Data'");
$i++;
} else {
$i++;
}
}

mysql_connect("$DBHost","$DBUser","$DBPass");
mysql_select_db("$DB");
$result=mysql_query("select * from $TA where $Field='$Data'");
echo "<TABLE BORDER='1' CELLPADDING='2' CELLSPACING='2'><TR>";

echo "<tr>";
$count =0;
while  ($field = mysql_fetch_field($result))  {
$header[$count]=$field->name;
echo  "<th bgcolor='#00287d'><font face='Arial' color='white'>";
echo  "$field->name";
echo  "</font></th>";
$count = $count + 1;
}
echo "</tr>";


while  ($row  =  mysql_fetch_row($result))  {
                echo  "<tr>";
                for  ($i=0;  $i<mysql_num_fields($result);  $i++)  {
                                echo  "<td>";
                                echo  "$row[$i]";
                                echo  "</td>";
                }
                echo  "</tr>\n";
}


echo "</TABLE>";


commonFooter();
?>
