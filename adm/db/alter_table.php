<?
require("FaceMySQL.php");
$DB = $_REQUEST['DB'];
$TA = $_REQUEST['TA'];
commonHeader("Alter the $TA table");

echo "<h3>";
blueFont ("Select an  option...");
echo "</h3>";

echo "<ul>";
echo "<li><a href='./alter_table_add.php?DB=$DB&TA=$TA'>Add a field to the <b>$TA</b> table</a></li>";
echo "<li><a href='./alter_table_change.php?DB=$DB&TA=$TA'>Change the properties of a field in the <b>$TA</b> table</a></li>";
echo "<li><a href='./freeform.php?DB=$DB&TA=$TA'>Free-form alteration form for the <b>$TA</b> table</a></li>";
echo "<li><a href='./alter_table_remove.php?DB=$DB&TA=$TA'>Remove a field in the <b>$TA</b> table</a></li>";
echo "</UL>";

commonFooter();
?>
