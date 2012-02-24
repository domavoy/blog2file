<?
require("FaceMySQL.php");

Connect();
$DB = $_REQUEST['DB'];
$TA = $_REQUEST['TA'];
if(isset($_REQUEST['SortField']))
{
	$SortField = $_REQUEST['SortField'];
} else {$SortField = '';}
commonHeader("Look at $DB");

blueFont ("Here are the contents of the ");
redFont  ("$TA");
blueFont (" table.");
echo "<br><br>";

mysql_connect("$DBHost","$DBUser","$DBPass");
mysql_select_db("$DB");
if ($SortField == "") {
$result=mysql_query("select * from $TA");
} else {
$result=mysql_query("select * from $TA order by $SortField");
}
$fields=mysql_num_fields($result);
echo "<TABLE BORDER='1' CELLPADDING='2' CELLSPACING='2'><TR>";

echo "<tr>";
$count =0;
while  ($field = mysql_fetch_field($result))  {
$header[$count]=$field->name;
echo  "<th bgcolor='#00287d'><font face='Arial' color='white'>";
echo  "&nbsp;$field->name";
echo  "</font></th>";
$count = $count + 1;
}
echo "</tr>";


while  ($row  =  mysql_fetch_row($result))  {
                echo  "<tr>";
                for  ($i=0;  $i<mysql_num_fields($result);  $i++)  {
                                echo  "<td>";
                                echo  "&nbsp;$row[$i]";
                                echo  "&nbsp;</td>";
                }
                echo  "</tr>\n";
}

echo "</TABLE>";

$i=0;
blueFont("Order By:");
echo "<FORM ACTION='./query.php?DB=$DB&TA=$TA' METHOD='POST' ENCTYPE='x-www-form-urlencoded'>";
echo "<select name='SortField' size='1'>";
echo "<option value=''> Natural Order </option>";
while ($i < $fields) {
$name=mysql_field_name($result,$i);
echo "<option value='$name'> $name </option>";
$i++;
}
echo "</select>&nbsp;&nbsp;&nbsp;<INPUT TYPE='submit' NAME='submit' VALUE='Re-Order'>";

commonFooter();
?>
